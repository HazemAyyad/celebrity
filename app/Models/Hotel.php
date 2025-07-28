<?php

namespace App\Models;

use App\Enums\Couponable;
use App\Enums\CouponType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Hotel extends Model
{
    protected $table = 'hotels_copy1';

    // Define the fillable attributes
    protected $guarded = '';


}
