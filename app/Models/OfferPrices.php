<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfferPrices extends Model
{
    use HasFactory;

    protected $fillable = [
        'offer_number',
        'request_id',
        'offer_id',
        'price_before_sale',
        'sale',
        'price_after_sale',
        'vat',
        'total_price',
        'total_quantity',
        'status',
        'seen',
        'approval',
        'description'
    ];


    // Request
    public function requests()
    {
        return $this->belongsTo(Requests::class, 'request_id', 'id');
    }

    // Offer Details
    public function offer_details()
    {
        return $this->hasMany(OfferDetails::class, 'offer_id', 'id');
    }

    // Request Details
    public function request_details()
    {
        return $this->belongsTo(RequestDetails::class, 'request_id', 'id');
    }
}
