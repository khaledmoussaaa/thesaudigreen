<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Requests;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('admin', function (User $user) {
            return $user->usertype == 'Admin';
        });

        Gate::define('employee', function (User $user) {
            return $user->usertype == in_array($user->usertype, ['Admin', 'Employee']);
        });

        Gate::define('customer', function (User $user) {
            return $user->usertype == 'Customer';
        });

        Gate::define('user', function (User $user) {
            return $user->usertype == in_array($user->usertype, ['Employee', 'Customer']);
        });

        Gate::define('remarks', function (User $user) {
            return $user->type == 'Remarks';
        });

        Gate::define('requests', function (User $user) {
            return $user->type == 'Requests';
        });

        Gate::define('adminGovernmental', function (User $user) {
            return $user->type == 'AdminGovernmental';
        });
        
        Gate::define('employeeGovernmental', function (User $user) {
            return $user->type == 'EmployeeGovernmental';
        });
    }
}
