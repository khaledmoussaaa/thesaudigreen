<?php

namespace App\Livewire\Admin;

use App\Models\OfferDetails;
use App\Models\OfferPrices;
use Livewire\Component;

use App\Models\RequestDetails;

class CreateOffer extends Component
{
    // Declareing Variables
    public $rid;
    public $rows = [];
    public $totalPricesBeforeSale;
    public $totalPricesAfterSale;
    public $totalQuantity;

    // Mount Constructor
    public function mount($rid)
    {
        $this->rid = $rid;
        $this->intializeInputs();
    }

    // Render Components
    public function render()
    {
        $this->calculateTotals();

        return view(
            'livewire.admin.create-offer',
            [
                'rows' => $this->rows,
                'totalPrices' =>  $this->totalPricesAfterSale,
                'totalQuantity' => $this->totalQuantity,
            ]
        );
    }

    // Intialize Inputs
    public function intializeInputs()
    {
        $request_details = RequestDetails::where('request_id', $this->rid)->get();
        foreach ($request_details as $details) {
            $this->rows[] = [
                'carDetails' => $details,
                'inputs' => [
                    [
                        'description' => '',
                        'price' => 0,
                        'sale' => 0,
                        'quantity' => 1,
                    ]
                ]
            ];
        }
    }

    // Adding New Row
    public function addRow($carIndex)
    {
        $this->rows[$carIndex]['inputs'][] = [
            'description' => '',
            'price' => 0,
            'sale' => 0,
            'quantity' => 1,
        ];
    }

    // Deleting Specific Row
    public function deleteRow($carIndex, $rowIndex)
    {
        if (isset($this->rows[$carIndex]['inputs'][$rowIndex])) {
            unset($this->rows[$carIndex]['inputs'][$rowIndex]);
            $this->rows[$carIndex]['inputs'] = array_values($this->rows[$carIndex]['inputs']);
        }
    }

    // Calculating Totals
    private function calculateTotals()
    {
        $this->totalPricesBeforeSale = 0;
        $this->totalPricesAfterSale = 0;
        $this->totalQuantity = 0;

        foreach ($this->rows as $car) {
            foreach ($car['inputs'] as $row) {
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

    // Validations Inputs 
    private function validateRows()
    {
        $rules = [];

        foreach ($this->rows as $carIndex => $carsRows) {
            foreach ($carsRows['inputs'] as $rowIndex => $row) {
                $rules["rows.{$carIndex}.inputs.{$rowIndex}.description"] = "required|string|max:255";
                $rules["rows.{$carIndex}.inputs.{$rowIndex}.price"] = "required|numeric|min:0";
                $rules["rows.{$carIndex}.inputs.{$rowIndex}.sale"] = "required|numeric|min:0|max:100";
                $rules["rows.{$carIndex}.inputs.{$rowIndex}.quantity"] = "required|integer|min:1";
            }
        }
        $this->validate($rules);
    }

    //Save Offer Prices
    public function intializeOffer()
    {
        try {
            $this->validateRows();

            $invoiceNumber = 'OFP-' . uniqid();
            while (OfferPrices::where('offer_number', $invoiceNumber)->exists()) {
                $invoiceNumber = 'OFP-' . uniqid();
            }

            $this->saveOffer($invoiceNumber);
            $this->intializeInputs();
            return redirect()->route('Offer-Prices', ['rid' => encrypt($this->rid)])->with('success', __('translate.offerCreatedSuccess'));
            
        } catch (\Throwable $th) {
            return redirect()->route('Offer-Prices', ['rid' => encrypt($this->rid)])->with('error', __('translate.offerCreatedError'));
        }
    }

    // Save Offer Prices
    private function saveOffer($invoiceNumber)
    {
        $vat15 = $this->totalPricesAfterSale * 0.15;

        $offer = OfferPrices::create([
            'offer_number' => $invoiceNumber,
            'request_id' => $this->rid,
            'price_before_sale' => $this->totalPricesBeforeSale,
            'sale' => $this->totalPricesBeforeSale - $this->totalPricesAfterSale,
            'price_after_sale' => $this->totalPricesAfterSale,
            'vat' => $vat15,
            'total_price' => $this->totalPricesAfterSale + $vat15,
            'total_quantity' => $this->totalQuantity,
        ]);

        foreach ($this->rows as $car) {
            foreach ($car['inputs'] as $row) {
                OfferDetails::create([
                    'offer_id' => $offer->id,
                    'offer_number' => $invoiceNumber,
                    'car_id' => $car['carDetails']->id,
                    'description' => $row['description'],
                    'price' => $row['price'],
                    'sale' => $row['sale'],
                    'quantity' => $row['quantity'],
                ]);
            }
        }
    }
}
