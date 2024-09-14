<?php

namespace App\Livewire\Customer;

use App\Models\GovernmentalEmployee;
use Livewire\Component;

class GovermentalEmployees extends Component
{
    // Variables
    public $search = '';

    // Mount the component with the given view request.
    public function render()
    {
        $employees = $this->fetchesEmployees();

        if ($this->search) {
            $employees = $employees->filter(function ($employee) {
                return
                    stripos($employee->user->name, $this->search) !== false ||
                    stripos($employee->user->email, $this->search) !== false ||
                    stripos($employee->user->phone, $this->search) !== false ||
                    stripos($employee->user->address, $this->search) !== false;
            });
        }

        return view('livewire.customer.govermental-employees', compact('employees'));
    }

    // Fetches users based on selected option
    public function fetchesEmployees()
    {
        return GovernmentalEmployee::where('governmental_id', auth()->id())->get();
    }
}
