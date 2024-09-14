<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index()
    {
        if (Auth::check()) {
            $type = Auth::user()->type;
            switch ($type) {
                case 'Admin':
                    return redirect()->route('Dashboard');
                case 'Requests':
                    return redirect()->route('Requests');
                case 'Remarks':
                    return redirect()->route('Remarks');
                case 'Customer' || 'Company' || 'Governmental':
                    return redirect()->route('Home');
                default:
                    return abort(401);
            }
        }
    }
}
