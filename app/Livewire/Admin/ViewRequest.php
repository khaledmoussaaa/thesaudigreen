<?php

namespace App\Livewire\Admin;

use App\Models\Remarks;
use App\Models\RequestDetails;
use App\Models\Requests;
use DateTime;
use Livewire\Component;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Date;

class ViewRequest extends Component
{
    public $rid;
    public $remarkId;
    public $status;
    public $remark;
    public $edit = false;

    // Set the ID when component mounts
    public function mount($rid)
    {
        $this->rid = $rid;
    }

    // Render the component view
    public function render()
    {
        $request = $this->viewRequest();

        // Encrypt status options for buttons
        $statusButton = [
            'undo' => encrypt('0'),
            'accept' => encrypt('1'),
            'decline' => encrypt('2'),
            'finish' => encrypt('4'),
            'complete' => encrypt('5'),
        ];

        // Pass data to view
        return view('livewire.admin.view-request', compact('request', 'statusButton'));
    }

    // View the request details
    public function viewRequest()
    {
        abort_unless($viewRequest = Requests::find($this->rid), 404);
        $viewRequest->seen == 0 ? $viewRequest->update(['seen' => 1]) : '';
        return $viewRequest;
    }

    // Set status based on encrypted status received from frontend
    public function setStatus($status)
    {
        $this->status = decrypt($status);
        if ($this->status == 3 || $this->status == 0) {
            RequestDetails::where('request_id', $this->rid)->update(['status' => $this->status]);
        }
    }

    // Update request status
    public function updateStatus()
    {
        if (($request = Requests::find($this->rid) ) && $this->status != null) {
            $request->update(['status' => $this->status]);
            $request->update(['seen' => 1]);
        }
    }

    // Add remark to the request
    public function addRemark()
    {
        Remarks::create([
            'request_id' => $this->rid,
            'name' => auth()->user()->name,
            'remark' => $this->remark,
        ]);

        $this->reset(['remark']);
    }

    // Toggle remark seen/unseen
    public function toggleRemark($id)
    {
        if ($remark = Remarks::find($id)) {
            $remark->update(['checked' => !$remark->checked, 'checked_at' => new DateTime()]);
        }
    }

    // Edit Remark
    public function editRemark($id)
    {
        if ($remark = Remarks::find($id)) {
            $this->remark = $remark->remark;
            $this->remarkId = $id;
            $this->edit = true;
        }
    }

    // Update Remark
    public function updateRemark()
    {
        if ($find = Remarks::find($this->remarkId)) {
            $find->update(['remark' => $this->remark]);
            $this->reset(['remark']);
            $this->edit = false;
        }
    }

    // Delete Remark
    public function deleteRemark($id)
    {
        Remarks::destroy($id);
    }

    public function carStatus($cid)
    {
        abort_unless($status = RequestDetails::find($cid), 400);
        $status->status == 0 ? $status->update(['status' => 1]) : $status->update(['status' => 0]);
    }
}
