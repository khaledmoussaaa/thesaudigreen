<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Crypt;
use App\Models\Requests as Request;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class Requests extends Component
{
    use WithPagination;

    // Variables
    public $selectedOption = 'all';
    public $search = '';
    public $found = false;

    // Mount the component with the given view request.
    public function mount($viewReq)
    {
        $this->selectedOption = $viewReq;
    }

    // Render the Livewire component.
    public function render()
    {
        $requests = $this->fetchRequests();
        $counts = $this->statusCounts();

        return view('livewire.admin.requests', compact('requests', 'counts'));
    }

    // Fetch requests based on selected option and search criteria.
    private function fetchRequests()
    {
        $query = Request::has('user')->with('request_details')->latest();

        if ($this->selectedOption !== 'all') {
            $query->where('status', $this->selectedOption);
        }

        if ($this->search) {
            $rid = preg_replace('/ss(\d+)/i', '$1', $this->search); // Remove "ss" and capture digits

            $query->where(function ($q) use ($rid) {
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
        } else {
            $this->found = false;
        }

        return $query->paginate(5);
    }

    // Get the count of requests with the given status.
    private function statusCounts()
    {
        return [
            'pending' => $this->status(0),
            'inprocess' => $this->status(1),
            'declined' => $this->status(2),
            'inprogress' => $this->status(3),
            'finished' => $this->status(4),
            'completed' => $this->status(5),
        ];
    }

    // Get the count of requests with the given status.
    private function status($status)
    {
        return Request::where('status', $status)->count();
    }

    // Delete the request with the given ID.
    #[On('delete')]
    public function delete($id)
    {
        if (!Gate::allows('admin')) {
            abort(401);
        }
        $rid = Crypt::decrypt($id);
        $request = Request::find($rid);
        if ($request) {
            $request->delete();
        }
    }
}
