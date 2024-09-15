<?php

// app/Models/User.php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Http\Controllers\Customer\GovernmentalEmployeeController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'chats_id',
        'name',
        'email',
        'phone',
        'tax_number',
        'address',
        'password',
        'usertype',
        'type',
        'archive',
        'avatar',
        'connection',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed'
    ];


    // Requests Relationship
    public function requests()
    {
        return $this->hasMany(Requests::class, 'user_id');
    }

    // Chats Relationship
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // Requests Relationship
    public function employee()
    {
        return $this->hasOne(GovernmentalEmployee::class);
    }
    // Requests Relationship
    public function governmental()
    {
        return $this->hasOne(GovernmentalEmployee::class, 'governmental_id');
    }

    // Observe
    protected static function booted(): void
    {
        // Saving
        static::saving(function ($model) {

            if (Auth::check() && (request()->routeIs('logout') || request()->Is('livewire/update'))) {
                return; // Skip modifying attributes during logout
            }


            if (GovernmentalEmployeeController::$creatingEmployee) {
                $model->usertype = 'Customer';
                $model->type = 'EmployeeGovernmental';
            } else {
                $model->chats_id = in_array($model->usertype, ['Admin', 'Requests']) ? 1 : 0;
                $model->type = $model->usertype;
                $model->usertype = in_array($model->usertype, ['Requests', 'Remarks']) ? 'Employee' : (in_array($model->usertype, ['Customer', 'Company', 'Governmental', 'AdminGovernmental']) ? 'Customer' : 'Admin');
            }
        });
    }
}
