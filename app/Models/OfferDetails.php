<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfferDetails extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'offer_id',
        'offer_number',
        'car_id',
        'description',
        'price',
        'sale',
        'quantity',
        'request_id',
        'checked',
    ];

    // OfferPrices
    public function offer_prices()
    {
        return $this->belongsTo(OfferPrices::class, 'offer_id', 'id');
    }

    // Request Details
    public function request_details()
    {
        return $this->belongsTo(RequestDetails::class, 'car_id', 'id');
    }
}
