<?php

namespace App\Livewire\Admin;

// Uses
use Livewire\Component;

// Models
use App\Models\Requests;
use App\Models\User;

class Dashboard extends Component
{
    // Declareing and Intialaize
    public $counts = [];
    public $typesCounts = [];
    public $title= [];

    public $icons = [
        'all' => 'bi bi-card-text',
        '0' => 'bi bi-clock-history',
        '1' => 'bi bi-clipboard-check',
        '2' => 'bi bi-clipboard-x',
        '3' => 'bi bi-clipboard-pulse',
        '4' => 'bi bi-check2-square',
        '5' => 'bi bi-calendar2-check',
        'users' => 'bi bi-people',
    ];

    public $titles = [
        'all' => 'total',
        '0' => 'pending',
        '1' => 'inprocess',
        '2' => 'declined',
        '3' => 'inprogress',
        '4' => 'finished',
        '5' => 'completed',
        'users' => 'users',
    ];

    public $colors = [
        'all' => 'electricPurple',
        '0' => 'orange',
        '1' => 'lightGray',
        '2' => 'scarlet',
        '3' => 'mintCream',
        '4' => 'gray',
        '5' => 'lightBlue',
        'users' => 'goldenYellow',
    ];


    public function mount()
    {
        // Fetch counts for each status
        $this->counts = [
            'all' => $this->dashboardCounts(null),
            '0' => $this->dashboardCounts(0),
            '1' => $this->dashboardCounts(1),
            '2' => $this->dashboardCounts(2),
            '3' => $this->dashboardCounts(3),
            '4' => $this->dashboardCounts(4),
            '5' => $this->dashboardCounts(5),
            'users' => $this->userCounts(null),
        ];

        // Fetch counts for each status
        $this->typesCounts = [
            '0' => $this->typeCounts('Admin'),
            '1' => $this->typeCounts('Employee'),
            '2' => $this->typeCounts('Customer'),
        ];

        $this->title = [
            '0' => __('translate.admins'),
            '1' => __('translate.employees'),
            '2' => __('translate.clients'),
            '3' => __('translate.adminGovernmental'),
            '4' => __('translate.employeeGovernmental'),
        ];
    }

    public function render()
    {
        return view('livewire.admin.dashboard', [
            'counts' => $this->counts,
            'requests' => $this->requests(),
            'users' => $this->users(),
        ]);
    }

    // Dashboard Counts
    public function dashboardCounts($status): int
    {
        if ($status === null) {
            return Requests::count();
        }
        return Requests::where('status', $status)->count();
    }

    // User Counts
    public function userCounts(): int
    {
        return User::all()->count();
    }

    // Users
    public function users()
    {
        return User::withTrashed()->get();
    }

    // Abouts Users Type Counts
    public function typeCounts($type)
    {
        return User::where('usertype', $type)->count();
    }

    // Requests
    public function requests()
    {
        return Requests::with('user')->where('seen', 0)->limit(5)->get();
    }
}
