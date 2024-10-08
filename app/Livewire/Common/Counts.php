<?php

namespace App\Livewire\Common;

use App\Models\Message;
use App\Models\OfferPrices;
use App\Models\Requests;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class Counts extends Component
{
    public string $status;
    public string $count;
    public $user_id;

    // Mount Function
    public function mount($status, $count)
    {
        $this->status = $status;
        $this->count = $count;
        $this->user_id = auth()->user()->governmental->governmental_id ?? auth()->user()->employee->governmental_id ?? Auth::id();
    }

    // Render Components
    public function render()
    {
        $counts = $this->counts();
        return view('livewire.common.counts', compact('counts'));
    }

    // All Counts
    public function counts()
    {
        switch ($this->count) {
            case 'home':
                return $this->home();
            case 'chatsAdmin':
                return $this->chatsUnseenAdmin();
            case 'chatsCustomer':
                return $this->chatsUnseenCustomer();
            case 'notificationsAdmin':
                return $this->notificationCountAdmin();
            case 'notificationsCustomer':
                return $this->notificationCountCustomer();
            default:
                return 0;
        }
    }
    // Home Counts
    public function home(): int
    {
        switch ($this->status) {
            case 'all':
                return Requests::whereNotNull('status')->count();
            case 'users':
                return User::whereNotNull('usertype')->count();
            default:
                return Requests::where('status', $this->status)->count();
        }
    }

    // Chats Message Unseen Admin
    public function chatsUnseenAdmin()
    {
        $perviousCount = session('adminCounts', 0);
        $currentCounts = Message::where('user_id', '!=', 1)
            ->where('seen', 0)
            ->count();
        $currentCounts = min($currentCounts, 99);

        // if ($currentCounts !== $perviousCount) {
        //     $this->dispatch('play');
        // }

        session(['adminCounts' => $currentCounts]);
        return $currentCounts;
    }

    // Chats Message Unseen Customer
    public function chatsUnseenCustomer()
    {
        $perviousCount = session('adminCounts', 0);
        $currentCounts = Message::where('recipient_id', auth()->id())
            ->where('seen', 0)
            ->count();

        $currentCounts = min($currentCounts, 99);
        // if ($currentCounts !== $perviousCount) {
        //     $this->dispatch('play');
        // }

        session(['adminCounts' => $currentCounts]);
        return $currentCounts;
    }

    // Chats Message Unseen Customer
    public function notificationCountAdmin()
    {
        $perviousCount = session('notificationAdminCount', 0);

        $requests = Requests::where('seen', 0)->where('status', 0)->count();
        $offerPrices = OfferPrices::where('seen', 2)->where('status', '!=', 0)->count();
        $totalCount = $requests + $offerPrices;
        $currentCounts = min($totalCount, 99);
        if ($currentCounts !== $perviousCount) {
            $this->dispatch('play');
        }
        session(['notificationAdminCount' => $currentCounts]);
        return $currentCounts;
    }

    // Chats Message Unseen Customer
    public function notificationCountCustomer()
    {
        $perviousCount = session('notificationCustomerCount', 0);

        if (Gate::allows('adminGovernmental')) {
            $requests = Requests::with('user')->where('seen', 1)->where('status', '!=', 0)->whereHas('user', function ($query) {
                $query->whereHas('employee', function ($query) {
                    $query->where('governmental_id', auth()->id());
                });
            })->count();

            $offerPrices = OfferPrices::with('requests.user')->where('seen', 0)->where('status', 0)->whereHas('requests.user', function ($query) {
                $query->whereHas('employee', function ($query) {
                    $query->where('governmental_id', auth()->id());
                });
            })->count();
        } else {
            $requests = Requests::where('seen', 1)->where('status', '!=', 0)->where('user_id', $this->user_id)->count();
            $offerPrices = OfferPrices::with('requests.user')->where('seen', 0)->where('status', 0)->whereHas('requests', function ($query) {
                $query->where('user_id', auth()->id());
            })->count();
        }

        $totalCount = $requests + $offerPrices;
        $currentCounts = min($totalCount, 99);
        if ($currentCounts !== $perviousCount) {
            $this->dispatch('play');
        }
        session(['notificationCustomerCount' => $currentCounts]);

        return $currentCounts;
    }
}
