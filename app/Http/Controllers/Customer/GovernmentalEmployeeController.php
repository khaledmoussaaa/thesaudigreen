<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\GovernmentalEmployee\GovernmentalEmployeeRequest;
use App\Models\GovernmentalEmployee;
use App\Models\User;

class GovernmentalEmployeeController extends Controller
{
    // Variables
    public static $creatingEmployee = false;


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('customer.governmental-employees');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customer.governmental-create-employee');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GovernmentalEmployeeRequest $request)
    {
        try {
            self::$creatingEmployee = true;
            $user = User::create($request->validated());
            $employee = GovernmentalEmployee::create(['user_id' => $user->id, 'governmental_id' => auth()->id()]);
            return redirect()->route('Employees.index')->with('success', __('translate.userCreatedSuccess'));
        } catch (\Throwable $error) {
            dd($error->getMessage());
            return redirect()->route('Employees.index')->with('error', __('translate.userCreatedError'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $uid = decrypt($id);
        $employee = User::find($uid);
        return view('customer.governmental-edit-employee', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $uid = decrypt($id);
        $employee = User::find($uid);
        return view('customer.governmental-edit-employee', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GovernmentalEmployeeRequest $request, string $id)
    {
        try {
            $uid = decrypt($id);
            abort_unless($user = User::withTrashed()->find($uid), 404);
            $user->update($request->validated());
            return redirect()->route('Employees.index')->with('success', __('translate.userUpdatedSuccess'));
        } catch (\Throwable $error) {
            return redirect()->route('Employees.index')->with('error', __('translate.userUpdatedError'));
        }
    }
}
