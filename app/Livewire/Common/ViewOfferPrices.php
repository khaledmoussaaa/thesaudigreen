<?php

namespace App\Livewire\Common;

use Livewire\Component;
use App\Models\Requests;
use App\Models\OfferPrices;
use App\Models\RequestDetails;
use Illuminate\Support\Facades\Crypt;
use Livewire\Attributes\On;

class ViewOfferPrices extends Component
{
    public $request_id;
    public $offer_id;
    public $status;

    public function mount($rid, $ofd)
    {
        $this->request_id = $rid;
        $this->offer_id = $ofd;
    }

    public function render()
    {
        $offerPrice = $this->viewOfferPrice();
        return view('livewire.common.view-offer-prices', $offerPrice);
    }

    public function viewOfferPrice()
    {
        $requests = RequestDetails::whereHas('offer_details', function ($query) {
            $query->where('offer_id', $this->offer_id);
        })->with(['offer_details' => function ($query) {
            $query->where('offer_id', $this->offer_id);
        }])->get();

        $user = Requests::with('user')->findOrFail($this->request_id)->user;
        $offer = OfferPrices::findOrFail($this->offer_id);

        if ($offer && auth()->user()->usertype !== 'Customer') {
            $offer->seen == 2 && $offer->status != 0 ? $offer->update(['seen' => 1]) : '';
        } else {
            $offer->seen == 0 ? $offer->update(['seen' => 2]) : '';
        }

        return compact('user', 'offer', 'requests');
    }

    #[On('setStatus')]
    public function setStatus($id, $status, $type, $description = null)
    {
        $offerId = Crypt::decrypt($id);
        $status = Crypt::decrypt($status);

        $offer = OfferPrices::find($offerId);
        if (!$offer) {
            return;
        }

        $request = Requests::withTrashed()->find($offer->request_id);
        if (!$request) {
            return;
        }

        if (!$type) {
            $offer->seen = 2;
            $request->status = $status == 1 ? 3 : 2;
        }

        switch ($type) {
            case 'employeeApproval':
                $offer->approval = 1;
                $offer->status = $status == 1 ? 3 : 4;
                $request->status = $status == 1 ? 6 : 7;
                break;

            case 'adminApproval':
                $offer->approval = 2;
                $offer->status = $status;
                $request->status = $status == 1 ? 3 : 2;
                break;

            default:
                $offer->status = $status;
                break;
        }

        if ($status == 2 && $description) {
            $offer->description = $description;
        }

        $offer->save();
        $request->save();
    }
}
