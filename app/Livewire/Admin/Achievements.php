<?php

namespace App\Livewire\Admin;

use App\Models\Requests;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Livewire\Component;
use Livewire\WithPagination;

class Achievements extends Component
{
    use WithPagination;

    public $search = '';

    // Render the Livewire component.
    public function render()
    {
        $users = $this->userAchievements();
        return view('livewire.admin.achievements', compact('users'));
    }

    // Fetches Requests Achievements and counts distinct requests
    public function userAchievements()
    {
        return User::has('requests')->whereHas('requests', function ($query) {
            $query->whereIn('status', ['4', '5'])->has('offers_prices')->whereHas('offers_prices', function ($query) {
                $query->where('status', 1);
            });
        })->withCount(['requests' => function ($query) {
            $query->whereIn('status', ['4', '5']);
        }])->paginate(10);
    }
}
