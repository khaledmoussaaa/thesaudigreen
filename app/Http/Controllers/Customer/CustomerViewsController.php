<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;

// Illuminate
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

// Models
use App\Models\RequestDetails;
use App\Models\Requests;

class CustomerViewsController extends Controller
{
    // Index Views (Customer-Home Page)
    public function home()
    {
        return view('customer.home');
    }

    // =========================Request========================//
    // Index Views (Intialize-Request Page)
    public function intializeRequest()
    {
        return view('customer.intialaize-request');
    }

    // Index Views (Create-Request Page)
    public function createRequest(Request $request)
    {
        $request->validate([
            'rnumber' => ['required', 'numeric', 'min:1', function ($attribute, $value, $fail) {
                if ($value > 50) {
                    $fail(__('translate.carsNumber'));
                }
            }],
        ]);
        
        $rnumber = $request->input('rnumber');
        return view('customer.create-request', compact('rnumber'));
    }

    // Index Views (Edit-Request Page)
    public function editRequest(Request $request)
    {
        $encryptId = $request->input('rid');
        $rid = Crypt::decrypt($encryptId);

        return view('customer.create-request', compact('rid'));
    }

    // Index Views (View-Request Page)
    public function viewRequest(Request $request)
    {
        $encryptId = $request->input('rid');
        $rid = Crypt::decrypt($encryptId);

        abort_unless($find = Requests::withTrashed()->find($rid), 404);
        $find->update(['seen' => 2]);

        $requestDetails = RequestDetails::where('request_id', $rid)->get();

        return view('customer.view-request', compact('requestDetails', 'rid'));
    }

    // Index Views (Offer-Prices Page)
    public function offerPrices(Request $request)
    {
        $encryptId = $request->input('rid');
        $rid = Crypt::decrypt($encryptId);

        return view('customer.offer-prices', compact('rid'));
    }

    // Index Views (View-Offer-Prices Page)
    public function viewOfferPrice(Request $request)
    {
        $encryptedRid = $request->input('rid');
        $rid = Crypt::decrypt($encryptedRid);

        $encryptedFid = $request->input('ofd');
        $ofd = Crypt::decrypt($encryptedFid);

        return view('customer.view-offerPrice', compact('rid', 'ofd'));
    }

    // =========================Chats========================//
    // Index Views (Offer-Prices Page)
    public function chats()
    {
        return view('customer.chats');
    }
}
