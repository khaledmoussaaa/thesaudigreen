<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\ResetPasswordRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class NewAccountController extends Controller
{
    public $getUser;
    /**
     * Display the specified resource.
     */
    public function setAccountPassword(Request $request)
    {
        return view('auth.new-account-password', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function saveNewPassword(ResetPasswordRequest $request)
    {
        $status = Password::reset($request->validated(), function (User $user, string $password) {
            $this->getUser = $user;
            $user->update(['password' => $password, 'email_verified_at' => now()]);
        });

        if ($status === Password::PASSWORD_RESET) {
            Auth::login($this->getUser);
            return redirect(RouteServiceProvider::HOME);
        }
        else{
            return back();
        }
        
    }
}
