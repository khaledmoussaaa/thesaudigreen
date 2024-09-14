<?php

namespace App\Livewire\Admin;

use App\Models\OfferDetails;
use Livewire\Component;

use App\Models\Remarks as Remark;
use App\Models\RequestDetails;
use App\Models\Requests;
use DateTime;
use Illuminate\Cache\RateLimiting\Limit;

class Remarks extends Component
{
    public $rid;

    // Render the Livewire component.
    public function render()
    {
        $tasks = $this->remarks();
        $requests = $this->requests();
        return view('livewire.admin.remarks', compact('tasks', 'requests'));
    }

    public function viewRid($rid)
    {
        $this->rid = $rid;
    }

    // Fetch Requests
    public function requests()
    {
        $requests = RequestDetails::has('offer_details')->where('request_id', $this->rid)->get();
        return $requests;
    }

    // Fetch remarks
    public function remarks()
    {
        $remarks = Requests::has('remarks')->has('offers_prices')->orderByDesc('pinned')->where('status', 3)->get();
        return $remarks;
    }

    // Check Remark
    public function checkBoxRemark($id)
    {
        $remark = Remark::findOrFail($id);
        $remark->update(['checked' => !$remark->checked, 'checked_at' => new DateTime()]);
    }

    // Pin remarks on top
    public function pinToTop($id)
    {
        $requests = Requests::findOrFail($id);
        $requests->update(['pinned' => !$requests->pinned]);
    }

    // Check Description Remark
    public function checkBoxDescription($id)
    {
        $description = OfferDetails::find($id);
        $description->update(['checked' => !$description->checked]);
    }
}
