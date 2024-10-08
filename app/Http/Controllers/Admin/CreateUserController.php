<?php

namespace App\Http\Controllers\Admin;

use App\Events\NewAccountCreate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UserRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;

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
        $requestValidated = $request->validated();
        if (!isset($requestValidated['usingPassword'])) {
            $requestValidated['password'] = Str::random(32);
        }
        try {
            $user = User::create($requestValidated);
            if (!isset($requestValidated['usingPassword'])) {
                event(new NewAccountCreate($user));
            } else {
                event(new Registered($user));
            }
            return redirect()->route('Users.index')->with('success', __('translate.userCreatedSuccess'));
        } catch (\Throwable $error) {
            dd($error->getMessage());
            return redirect()->route('Users.index')->with('error', $error->getMessage());
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
        self::$creatingUser = true;
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
