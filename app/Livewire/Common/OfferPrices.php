<?php

namespace App\Livewire\common;

use App\Models\OfferPrices as OfferPrice;
use App\Models\Requests;
use Illuminate\Support\Facades\Crypt;
use Livewire\Attributes\On;
use Livewire\Component;

class OfferPrices extends Component
{
    public $rid;
    public $search = '';

    // Mount the component with the given request (id).
    public function mount($rid)
    {
        $this->rid = $rid;
    }

    // Render the livewire component.
    public function render()
    {
        $offers = $this->offerPrices();

        if ($this->search) {
            $offers = $offers->filter(function ($offer) {
                return $this->searchInOffer($offer);
            });
        }

        return view('livewire.common.offer-prices', compact('offers'));
    }

    // Check if search string is present in offer's data
    protected function searchInOffer($offer)
    {
        return stripos($offer->offer_number, $this->search) !== false ||
            stripos($offer->created_at, $this->search) !== false;
    }

    // Offer Prices Fetch
    public function offerPrices()
    {
        $offer = OfferPrice::where('request_id', $this->rid)->latest()->get();
        return $offer;
    }

    // Delete the request with the given ID.
    #[On('delete')]
    public function delete($id)
    {
        $ofd = Crypt::decrypt($id);
        OfferPrice::destroy($ofd);
    }
    // SetStatus for offer
    #[On('setStatus')]
    public function setStatus($id, $status, $type, $description = null)
    {
        $offerId = Crypt::decrypt($id);
        $status = Crypt::decrypt($status);

        $offer = OfferPrice::find($offerId);
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
