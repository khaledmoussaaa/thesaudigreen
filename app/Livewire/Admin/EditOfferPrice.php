<?php

namespace App\Livewire\admin;

use App\Models\OfferDetails;
use App\Models\OfferPrices;
use App\Models\RequestDetails;
use Livewire\Component;

class EditOfferPrice extends Component
{
    // Declaring Variables
    public $rid;
    public $ofd;
    public $rows = [];
    public $cars = [];
    public $totalPricesBeforeSale;
    public $totalPricesAfterSale;
    public $totalQuantity;

    // Constructor
    public function mount($rid, $ofd)
    {
        $this->rid = $rid;
        $this->ofd = $ofd;
        $this->initializeInputs();
    }

    // Render the Livewire component.
    public function render()
    {
        $this->calculateTotals();
        return view('livewire.admin.edit-offer-price', [
            'total_prices' => $this->totalPricesAfterSale,
            'total_quantity' => $this->totalQuantity,
        ]);
    }

    // Request Details With OfferDetails
    public function offerDetails()
    {
        return RequestDetails::whereHas('offer_details', function ($query) {
            $query->where('offer_id', $this->ofd);
        })->with(['offer_details' => function ($query) {
            $query->where('offer_id', $this->ofd);
        }])->get();
    }

    // Initialize Inputs
    public function initializeInputs()
    {
        $this->cars = $this->offerDetails();
        foreach ($this->cars as $car) {
            $carOfferDetails = $car->offer_details;
            foreach ($carOfferDetails as $details) {
                $this->rows[$car->id][] = [
                    'id' => $details->id,
                    'description' => $details->description,
                    'price' => $details->price,
                    'sale' => $details->sale,
                    'quantity' => $details->quantity,
                    'car_id' => $car->id
                ];
            }
        }
    }

    // Calculate Totals
    private function calculateTotals()
    {
        $this->totalPricesBeforeSale = 0;
        $this->totalPricesAfterSale = 0;
        $this->totalQuantity = 0;

        foreach ($this->cars as $car) {
            foreach ($this->rows[$car->id] as $row) {
                if ($row['quantity']) {
                    if ($row['price'] && $row['sale'] >= 0) {
                        $this->totalPricesBeforeSale += $row['price'] * $row['quantity'];
                        $this->totalPricesAfterSale += $row['price'] * (1 - $row['sale'] / 100) * $row['quantity'];
                    }
                    $this->totalQuantity += $row['quantity'];
                }
            }
        }
    }

    // Add New Row
    public function addRow($carId)
    {
        // Add a new row for the given car ID
        $this->rows[$carId][] = [
            'description' => '',
            'price' => 0,
            'sale' => 0,
            'quantity' => 1,
            'car_id' => $carId
            // You can add other necessary default values
        ];
    }

    // Delete Offer_Details
    public function delete($id, $carIndex, $rowIndex)
    {
        // Check if the row has an ID and delete from the database
        if (isset($this->rows[$carIndex][$rowIndex]['id'])) {
            $offer_details = OfferDetails::find($id);
            if ($offer_details) {
                // Remove the row from the local array
                unset($this->rows[$carIndex][$rowIndex]);
                $this->rows[$carIndex] = array_values($this->rows[$carIndex]);

                // Delete the offer details from the database
                $offer_details->delete();
            }
        } else {
            // If there's no ID, simply unset the row
            if (isset($this->rows[$carIndex][$rowIndex])) {
                unset($this->rows[$carIndex][$rowIndex]);
                $this->rows[$carIndex] = array_values($this->rows[$carIndex]);
            }
        }

        // Check if all cars have no rows left
        $hasRows = false;
        foreach ($this->rows as $carRows) {
            if (!empty($carRows)) {
                $hasRows = true;
                break; // Exit loop if any car has rows
            }
        }

        // If no rows left for any car, delete the OfferPrices
        if (!$hasRows) {
            OfferPrices::findOrFail($this->ofd)->forceDelete();
            // Optionally, redirect or provide feedback
            return redirect()->route('Offer-Prices', ['rid' => encrypt($this->rid)])->with('success', __('translate.theOfferPriceDeleted'));
        }
    }

    // Validations Inputs 
    private function validateRows()
    {
        $rules = [];
        foreach ($this->rows as $carIndex => $carRows) {
            foreach ($carRows as $rowIndex => $row) {
                $rules["rows.{$carIndex}.{$rowIndex}.description"] = 'required|string|max:255';
                $rules["rows.{$carIndex}.{$rowIndex}.price"] = 'required|numeric|min:0';
                $rules["rows.{$carIndex}.{$rowIndex}.sale"] = 'required|numeric|min:0|max:100';
                $rules["rows.{$carIndex}.{$rowIndex}.quantity"] = 'required|integer|min:1';
            }
        }
        $this->validate($rules);
    }

    // Update
    public function update()
    {
        $offerNumber = 'OFP-' . uniqid();
        while (OfferPrices::where('offer_number', $offerNumber)->exists()) {
            $offerNumber = 'OFP-' . uniqid();
        }

        try {
            $this->validateRows();
            $offer_prices = OfferPrices::find($this->ofd);
            if ($offer_prices) {
                $offerPrice = [
                    'price_before_sale' => $this->totalPricesBeforeSale,
                    'sale' => $this->totalPricesBeforeSale - $this->totalPricesAfterSale,
                    'price_after_sale' => $this->totalPricesAfterSale,
                    'vat' => $this->totalPricesAfterSale * 0.15,
                    'total_price' => ($this->totalPricesAfterSale * 0.15) + $this->totalPricesAfterSale,
                    'total_quantity' => $this->totalQuantity,
                    'seen' => 0,
                    'status' => 0,
                ];
                $offer_prices->update($offerPrice);
            }

            foreach ($this->rows as $carRows) {
                foreach ($carRows as $row) {
                    if (isset($row['id'])) {
                        $offer_details = OfferDetails::find($row['id']);
                        if ($offer_details) {
                            $offer_details->description = $row['description'];
                            $offer_details->price = $row['price'];
                            $offer_details->sale = $row['sale'];
                            $offer_details->quantity = $row['quantity'];
                            $offer_details->save();
                        }
                    } else {
                        OfferDetails::create([
                            'description' => $row['description'],
                            'price' => $row['price'],
                            'sale' => $row['sale'],
                            'quantity' => $row['quantity'],
                            'offer_id' => $this->ofd,
                            'offer_number' => $offer_prices->offer_number ?? $offerNumber,
                            'car_id' => $row['car_id']
                        ]);
                    }
                }
            }

            return redirect()->route('Offer-Prices', ['rid' => encrypt($this->rid)])->with('success', __('translate.offerUpdatedSuccess'));
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return redirect()->route('Offer-Prices', ['rid' => encrypt($this->rid)])->with('error', __('translate.offerUpdatedError'));
        }
    }
}
