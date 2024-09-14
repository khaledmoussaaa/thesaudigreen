<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class Users extends Component
{
    // Variables
    public $search = '';
    public $selectedOption = 'all';

    // Mount the component with the given view request.
    public function render()
    {
        $users = $this->fetchesUsers($this->selectedOption);
        $counts = $this->setUsertype();

        if ($this->search) {
            $users = $users->filter(function ($user) {
                return
                    stripos($user->name, $this->search) !== false ||
                    stripos($user->email, $this->search) !== false ||
                    stripos($user->phone, $this->search) !== false ||
                    stripos($user->address, $this->search) !== false;
            });
        }

        return view('livewire.admin.users', compact('users', 'counts'));
    }

    // Fetches users based on selected option
    public function fetchesUsers($usertype)
    {
        if ($usertype == 'all') {
            return User::withTrashed()->get();
        } else if ($usertype == 'employee') {
            return User::withTrashed()->whereIn('type', ['Requests', 'Remarks'])->get();
        }

        return User::withTrashed()->where('usertype', $usertype)->get();
    }

    // Set the count of users with the given type.
    private function setUsertype()
    {
        return [
            'all' => $this->userCounts('All'),
            'admin' => $this->userCounts('Admin'),
            'employee' => $this->userCounts('Employee'),
            'customer' => $this->userCounts('Customer'),
        ];
    }

    // Get the count of users with the given type.
    private function userCounts($usertype)
    {
        return $usertype == 'All' ? User::withTrashed()->count() : User::withTrashed()->where('usertype', $usertype)->count();
    }

    // Block or Active User
    #[On('blockOrActive')]
    public function blockOrActive($id)
    {
        $uid = decrypt($id);
        $user = User::withTrashed()->findorFail($uid);
        $user['deleted_at'] ? $user->restore() : $user->delete();
    }

    // Block or Active User
    #[On('delete')]
    public function delete($id)
    {
        $uid = decrypt($id);
        User::withTrashed()->findorFail($uid)->forceDelete();
    }
}
