<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquires;
use App\Models\RequestDetails;
use Illuminate\Http\Request;

use App\Models\Requests;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AdminViewsController extends Controller
{
    // Index (Dashboard Page)
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    // =======================Requests=====================//
    // Index (Requests Page)
    public function requests(Request $request)
    {
        $view = $request->input('view');
        return $request ? view('admin.requests', compact('view')) : view('admin.requests');
    }

    // Index (View-Request Page)
    public function viewRequest(Request $request)
    {
        $encryptRid = $request->rid;
        $rid = decrypt($encryptRid);

        abort_unless(Requests::find($rid), 404);
        return view('admin.view-request', compact('rid'));
    }

    // ====================Offer-Prices=====================//
    // Index (Create-Offer-Prices Page)
    public function createOfferPrice(Request $request)
    {
        $encryptRid = $request->input('rid');

        $rid = decrypt($encryptRid);

        abort_unless(Requests::find($rid), 404);
        return view('admin.create-offer', compact('rid'));
    }

    // Index (Offer-Prices Page)
    public function offerPrices($rid)
    {
        $encryptRid = $rid;
        $rid = decrypt($encryptRid);

        abort_unless(Requests::find($rid), 404);

        return view('admin.offer-prices', compact('rid'));
    }

    // Index (Edit-Offer-Prices Page)
    public function editOfferPrice(Request $request)
    {
        $encryptRid = $request->input('rid');
        $encryptOfd = $request->input('ofd');

        $rid = decrypt($encryptRid);
        $ofd = decrypt($encryptOfd);

        // abort_unless(OfferPrices::find($ofd), 404);
        return view('admin.edit-offer-price', compact('rid', 'ofd'));
    }

    // ========================= Remarks======================//
    public function remarks()
    {
        return view('admin.remarks');
    }

    // =========================Users========================//
    // Index (Users Page)
    public function users()
    {
        return view('admin.users');
    }

    // Index (Create-Users Page)
    public function createUser()
    {
        return view('admin.create-user');
    }

    // Index (Edit-Users Page)
    public function editUser(Request $request)
    {
        $encryptUid = $request->input('uid');
        $uid = decrypt($encryptUid);

        abort_unless($user = User::find($uid), 404);
        return view('admin.edit-user', compact('uid', 'user'));
    }
    // =========================Chats========================//
    // Index (Chats Page)
    public function chats()
    {
        return view('admin.chats');
    }

    // Index (Chats) With Chats (User_ID)
    public function contact(Request $request)
    {
        $encryptUid = $request->input('uid');
        $uid = decrypt($encryptUid);

        abort_unless(User::find($uid), 404);
        return view('admin.chats', compact('uid'));
    }
    // =========================ContactUs======================//
    // Index (Contact Us Page)
    public function createInquiries(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:50|regex:/^[a-zA-Z0-9\s]+$/',
            'email' => 'nullable|email',
            'phone' => [
                'nullable',
                'string',
                'regex:/^\+?\d{1,3}[-\s]?\(?\d{1,4}\)?[-\s]?\d{1,4}[-\s]?\d{1,4}$/',
            ],
            'message' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9\s\.,?!()-]+$/',
            ],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('section', 'contact');
        }

        $inquires =
            [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'message' => $request->message,
            ];

        Inquires::create($inquires);
        return redirect()->back()->with('section', 'contact')->with('success', 'Your Form Submited Successfuly..!!');
    }

    // Index (Inquiries Page)
    public function inquiries()
    {
        $inquires = Inquires::get();
        return view('admin.inquiries', compact('inquires'));
    }

    // =========================Achievements======================//
    // Index (Achievements Page)
    public function achievements()
    {
        return view('admin.achievements');
    }

    // Index (View-Achievements Page')
    public function viewAchievement(Request $request)
    {
        $uid = decrypt($request->input('uid'));
        $user = User::find($uid);

        abort_unless($user, 404);

        $requests = Requests::where('user_id', $uid)
            ->whereIn('status', ['4', '5'])
            ->with('request_details')
            ->get();

        $totalPrice = $requests->sum(function ($request) {
            return $request->total_price->total_price;
        });

        $cars = $requests->sum(function ($request) {
            return $request->request_details->count();
        });

        return view('admin.view-achievement', compact('requests', 'user', 'totalPrice', 'cars'));
    }
}
