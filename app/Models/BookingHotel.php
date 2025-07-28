<?php

namespace App\Models;

use App\Enums\Couponable;
use App\Enums\CouponType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingHotel extends Model
{
    protected $table = 'booking_hotels';

    // Define the fillable attributes
    protected $guarded = '';

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class, 'hotel_id', 'HotelId');
    }
}
