<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use App\Models\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;

class CustomerHome extends Component
{
    public $user;
    public $search = '';
    public $id = '';

    // Mount the component with the given view request.
    public function mount()
    {
        $this->user = Auth()->user()->id;
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
        if (Gate::allows('adminGovernmental')) {
            $requests = Requests::with('user', 'request_details')
                ->whereHas('user', function ($query) {
                    $query->whereHas('employee', function ($query) {
                        $query->where('governmental_id', auth()->id());
                    });
                });
            // Order by updated_at for adminGovernmental
            $requests->orderBy('updated_at', 'desc');
        } else {
            $requests = Requests::with('user', 'request_details')->whereHas('user', function ($query) {
                $query->where('id', $this->user);
            });
        }

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

        // Apply the latest ordering and withTrashed for both cases
        return $requests->latest()->withTrashed()->get();
    }
}
