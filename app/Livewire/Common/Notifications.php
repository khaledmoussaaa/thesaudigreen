<?php

namespace App\Livewire\Common;

use App\Models\Requests;
use App\Models\OfferPrices;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Notifications extends Component
{
    public $type;
    public $user_id;

    public function mount($type)
    {
        $this->type = $type;
        $this->user_id = auth()->user()->governmental->governmental_id ?? auth()->user()->employee->governmental_id ?? Auth::id();
    }

    public function render()
    {
        $notifications = $this->notifications();
        return view('livewire.common.notifications', compact('notifications'));
    }

    public function notifications()
    {
        switch ($this->type) {
            case 'Admin':
                return $this->notificationsAdmin();
            case 'Customer':
                return $this->notificationsCustomer();
            default:
                return collect();
        }
    }

    // ======================Admin | Employees====================== //
    public function notificationsAdmin()
    {
        $requests = $this->requestsAdmin();
        $offerPrices = $this->offerPricesAdmin();

        return $requests->merge($offerPrices)->map(function ($item) {
            return [
                'rid' => $item->request_id ?? $item->id,
                'ofd' => $item->id ?? '',
                'ofn' => $item->offer_number ?? '',
                'date' => $item->created_at->format('D - d/m/y'),
                'time' => $item->created_at->format('h:i A'),
                'name' => $item?->user?->name ?? $item?->requests?->user?->name,
                'email' => $item?->user?->email ?? $item?->requests?->user?->name,
                'type' => $item instanceof Requests ? 'Request' : 'OfferPrice',
                'status' => $item->status ?? null,
            ];
        });
    }

    // Request Admin Notfications
    public function requestsAdmin()
    {
        return Requests::with('user')->where('seen', 0)->where('status', 0)->latest()->get(); // Visible all requests that has seen = 0 & status = 0
    }

    // Offer Prices Notifications
    public function offerPricesAdmin()
    {
        return OfferPrices::with('requests.user')->where('seen', 2)->where('status', '!=', 0)->get();
    }

    public function navigateAdmin(string $type, int $rid, int $ofd)
    {
        if ($type == 'Request') {
            return redirect()->route('View-Request', ['rid' => encrypt($rid)]);
        }
        return redirect()->route('View-OfferPrice', ['rid' => encrypt($rid), 'ofd' => encrypt($ofd)]);
    }

    // ====================== Customer ====================== //
    public function notificationsCustomer()
    {
        $requests = $this->requestsCustomer();
        $offerPrices = $this->offerPricesCustomer();

        return $requests->merge($offerPrices)->map(function ($item) {
            return [
                'rid' => $item->request_id ?? $item->id,
                'ofd' => $item->id ?? '',
                'ofn' => $item->offer_number ?? '',
                'date' => $item->created_at->format('D - d/m/y'),
                'time' => $item->created_at->format('h:i A'),
                'name' => $item?->user?->name ?? $item?->requests?->user?->name,
                'email' => $item?->user?->email ?? $item?->requests?->user?->name,
                'type' => $item instanceof Requests ? 'Request' : 'OfferPrice',
                'status' => $item->status ?? null,
            ];
        });
    }

    public function requestsCustomer()
    {
        return Requests::with('user')->where('seen', 1)->where('status', '!=', 0)->where('user_id', $this->user_id)->get();
    }

    public function offerPricesCustomer()
    {
        return OfferPrices::with('requests.user')->where('seen', 0)->where('status', 0)->whereHas('requests', function ($query) {
            $query->where('user_id', $this->user_id);
        })->get();
    }

    public function navigateCustomer(string $type, int $rid, int $ofd)
    {
        if ($type == 'Request') {
            return redirect()->route('Customer-View-Request', ['rid' => encrypt($rid)]);
        }
        return redirect()->route('View-OfferPrice', ['rid' => encrypt($rid), 'ofd' => encrypt($ofd)]);
    }
}
