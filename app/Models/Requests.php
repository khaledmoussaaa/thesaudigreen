<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Requests extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'seen',
        'status',
        'pinned',
    ];

    // Users
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Reuqest Details
    public function request_details()
    {
        return $this->hasMany(RequestDetails::class, 'request_id', 'id');
    }

    // Offer Price
    public function offers_prices()
    {
        return $this->hasMany(OfferPrices::class, 'request_id', 'id');
    }

    // Latest Offer Price
    public function latestOffer()
    {
        return $this->hasOne(OfferPrices::class, 'request_id', 'id')->latest();
    }

    // Offer Price Total Price
    public function total_price()
    {
        return $this->hasOne(OfferPrices::class, 'request_id', 'id')->latest();
    }

    // Remarks
    public function remarks()
    {
        return $this->hasMany(Remarks::class, 'request_id', 'id');
    }
}
