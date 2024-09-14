<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'factory',
        'model_year',
        'vin',
        'plate',
        'km',
        'place',
        'problem',
        'electronic_application_number',
        'status',
        'request_id',
    ];

    // Requests
    public function requests()
    {
        return $this->belongsTo(Requests::class, 'request_id', 'id');
    }

    // Offer Details
    public function offer_details()
    {
        return $this->hasMany(OfferDetails::class, 'car_id', 'id');
    }
}
