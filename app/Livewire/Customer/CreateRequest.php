<?php

namespace App\Livewire\Customer;

use App\Models\RequestDetails;
use App\Models\Requests;
use Livewire\Component;

class CreateRequest extends Component
{
    // Declartation
    public $user;
    public $rid;
    public $request_id;
    public $rowsNumber;
    public $rows = [];
    public $checkAdd = false;

    // Mount
    public function mount($rnumber, $rid)
    {
        $this->user = auth()->id();

        // For Create Request
        $this->rowsNumber = $rnumber;
        if ($this->rowsNumber) {
            $this->intializeInputs();
        }

        // For Edit Request
        $this->rid = $rid;
        if ($this->rid && !$this->rowsNumber) {
            $this->editInputs();
        }
    }

    // Render 
    public function render()
    {
        return view('livewire.customer.create-request');
    }

    // Intialize Inputs
    public function intializeInputs()
    {
        for ($i = 0; $i < $this->rowsNumber; $i++) {
            $this->rows[] = [
                'factory' => '',
                'year' => '',
                'plate' => '',
                'vin' => '',
                'km' => '',
                'place' => '',
                'problem' => '',
                'electronic_application_number' => '',
            ];
        }
    }

    // Edit Inputs
    public function editInputs()
    {
        $request = Requests::withTrashed()->find($this->rid);
        if ($request) {
            $requestDetails = RequestDetails::where('request_id', $this->rid)->get();
            foreach ($requestDetails as $details) {
                $this->rows[] = [
                    'car_id' => $details->id ?? null,
                    'factory' => $details->factory,
                    'model_year' => $details->model_year,
                    'plate' => $details->plate,
                    'vin' => $details->vin,
                    'km' => $details->km,
                    'place' => $details->place,
                    'problem' => $details->problem,
                    'electronic_application_number' => $details->electronic_application_number,
                    'request_id' => $details->request_id,
                ];
            }
        }
    }

    // Adding New Row
    public function addRow()
    {
        $this->rows[] = [
            'factory' => '',
            'model_year' => '',
            'plate' => '',
            'vin' => '',
            'km' => '',
            'place' => '',
            'problem' => '',
            'electronic_application_number' => '',
        ];

        if ($this->rid) {
            $this->checkAdd = true;
        }
    }

    // Deleting Specific Row
    public function deleteRow($rowIndex)
    {
        if (isset($this->rows[$rowIndex])) {

            if (isset($this->rid) && isset($this->rows[$rowIndex]['car_id'])) {
                RequestDetails::find($this->rows[$rowIndex]['car_id'])->forceDelete();
                $cars = RequestDetails::where('request_id', $this->rows[$rowIndex]['request_id'])->exists();
                if (!$cars) {
                    Requests::find($this->rid)->forceDelete();
                    return redirect('/Customer/Home')->with('success', __('translate.theRequestDeleted'));
                }
            }
            unset($this->rows[$rowIndex]);
        }
    }

    // Validations Inputs 
    private function validateRows()
    {
        $rules = [];
        foreach ($this->rows as $key => $row) {
            $rules["rows.$key.factory"] = "required|string|max:255";
            $rules["rows.$key.model_year"] = "required|string|min:0";
            $rules["rows.$key.plate"] = "required|string|max:100";
            $rules["rows.$key.vin"] = "required|string|min:1";
            $rules["rows.$key.km"] = "required|string|min:1";
            $rules["rows.$key.place"] = "required|string|min:3";
            $rules["rows.$key.problem"] = "required|string|min:3";
            $rules["rows.$key.electronic_application_number"] = "sometimes|string";
        }
        $this->validate($rules);
    }

    // Save Request
    public function saveRequest()
    {
        $this->validateRows();

        try {
            //code...

            if (!$this->rid) {
                $request = Requests::create(['user_id' => $this->user]);
                $this->request_id = $request->id;
            }

            foreach ($this->rows as $row) {
                $requestDetails = [
                    'factory' => $row['factory'],
                    'model_year' => $row['model_year'],
                    'plate' => $row['plate'],
                    'vin' => $row['vin'],
                    'km' => $row['km'],
                    'place' => $row['place'],
                    'problem' => $row['problem'],
                    'electronic_application_number' => $row['electronic_application_number'],
                    'request_id' => $this->request_id ?? $this->rid,
                ];
                if ($this->rid && isset($row['car_id'])) {
                    $request_details = RequestDetails::findOrFail($row['car_id']);
                    $request_details->update($requestDetails);
                } else {
                    RequestDetails::create($requestDetails);
                }
            }
            return redirect('/Customer/Home')->with('success', $this->rid ? __('translate.requestUpdatedSuccess') : __('translate.requestCreatedSuccess'));
        } catch (\Throwable $th) {
            return redirect('/Customer/Home')->with('error', $this->rid ? __('translate.requestUpdatederror') : __('translate.requestCreatederror'));
        }
    }
}
