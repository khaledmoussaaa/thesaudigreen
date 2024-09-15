<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use App\Models\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;

class CustomerHome extends Component
{
    public $user_id;
    public $search = '';
    public $id = '';

    // Mount the component with the given view request.
    public function mount()
    {
        $this->user_id = auth()->user()->governmental->governmental_id ?? auth()->user()->employee->governmental_id ?? auth()->id();
    }

    // Render the livewire component.
    public function render()
    {
        $requests = $this->fetchRequests();
        return view('livewire.customer.customer-home', compact('requests'));
    }

    // Fetch requests based on selected option and search criteria.
    private function fetchRequests()
    {
        $requests = Requests::with('user', 'request_details')->where('user_id', $this->user_id);

        if ($this->search) {
            $rid = preg_replace('/ss(\d+)/i', '$1', $this->search); // Remove "ss" and capture digits

            $requests->where(function ($q) use ($rid) {
                $q->where('id', 'like', "%$rid%")
                    ->orWhereHas('user', function ($q) {
                        $q->where('name', 'like', "%{$this->search}%")
                            ->orWhere('email', 'like', "%{$this->search}%");
                    })
                    ->orWhereHas('request_details', function ($q) {
                        $q->where('factory', 'like', "%{$this->search}%")
                            ->orWhere('plate', 'like', "%{$this->search}%")
                            ->orWhere('vin', 'like', "%{$this->search}%");
                    });
            });
        }

        return $requests->latest()->withTrashed()->get();
    }
}
