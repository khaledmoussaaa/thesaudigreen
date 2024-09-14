<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Models\OfferPrices;
use App\Models\RequestDetails;
use App\Models\Requests;
use App\Models\User;
use Illuminate\Http\Request;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;
use Carbon\Carbon;
use IntlDateFormatter;

class PDFController extends Controller
{
    // Generate PDF for request details
    public function pdf(Request $request)
    {
        $request_id = $request->input('rid');
        $offer_id = $request->input('ofd');

        $requests = RequestDetails::whereHas('offer_details', function ($query) use ($offer_id) {
            $query->where('offer_id', $offer_id);
        })->with(['offer_details' => function ($query) use ($offer_id) {
            $query->where('offer_id', $offer_id);
        }])->get();

        $user = Requests::with('user')->where('id', $request_id)->first()->user;
        $offer = OfferPrices::find($offer_id);

        $pdf = PDF::loadView('common.pdf', compact('user', 'offer', 'requests', 'request_id'));

        if ($request->has('download')) {
            return $pdf->download('Name-' . $user->name . ' Offer Number-' . $offer->offer_number . '.pdf');
        }

        return $pdf->stream('Name-' . $user->name . ' Offer Number-' . $offer->offer_number . '.pdf');
    }

    // Index Views ('View-Offer-Prices Page)
    public function viewOfferPrice(Request $request)
    {
        $encryptRid = $request->input('rid');
        $encryptOfd = $request->input('ofd');

        $rid = decrypt($encryptRid);
        $ofd = decrypt($encryptOfd);

        return view('common.view-offer-prices', compact('rid', 'ofd'));
    }

    // Achivements PDF
    public function achivementsPdf(Request $request)
    {
        $encryptUid = $request->input('uid');
        $uid = decrypt($encryptUid);

        abort_unless($user = User::find($uid), 404);

        $requests = Requests::has('request_details.offer_details')->where('user_id', $uid)->whereIn('status', ['4', '5'])->has('total_price')->get();
        $cars = 0;

        foreach ($requests as $request) {
            $totalPrice = $request->total_price->where('status', 1)->sum('total_price');
            $cars += $request->request_details()->count();
        }


        if ($user->type == in_array($user->type, ['AdminGovernmental', 'EmployeeGovernmental'])) {
            $pdf = PDF::loadView('common.governmental-pdf', compact('user', 'requests', 'totalPrice', 'cars'));
        } else {
            $pdf = PDF::loadView('common.achievement-pdf',  compact('user', 'requests', 'totalPrice', 'cars'));
        }
        return $pdf->stream('Name-' . $user->name);
    }
}
