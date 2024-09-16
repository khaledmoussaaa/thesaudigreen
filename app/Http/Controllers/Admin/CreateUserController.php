<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UserRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;

class CreateUserController extends Controller
{
    // Variables
    public static $creatingUser = false;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.users');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.create-user');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        self::$creatingUser = true;
        try {
            $user = User::create($request->validated());
            // event(new Registered($user));
            // return redirect()->route('Users.index')->with('success', __('translate.userCreatedSuccess'));
        } catch (\Throwable $error) {
            dd($error->getMessage());
            return redirect()->route('Users.index')->with('error', __('translate.userCreatedError'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $uid = decrypt($id);
        $User = User::withTrashed()->find($uid);
        return view('admin.edit-user', compact('User'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        try {
            $uid = decrypt($id);
            abort_unless($user = User::withTrashed()->find($uid), 404);
            $user->update($request->validated());
            return redirect()->route('Users.index')->with('success', __('translate.userUpdatedSuccess'));
        } catch (\Throwable $th) {
            return redirect()->route('Users.index')->with('error', __('translate.userUpdatedError'));
        }
    }
}
