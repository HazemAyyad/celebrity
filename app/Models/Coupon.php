<?php

namespace App\Models;

use App\Enums\Couponable;
use App\Enums\CouponType;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table = 'coupons';

    // Define the fillable attributes
    protected $guarded = [
        //
    ];

    public function getDiscountedPrice(float $price, Couponable $couponable): float
    {
        $valueKey = 'value_' . $couponable->value;
        $discountValue = $this->{$valueKey} ?? 0;

        if (CouponType::from($this->type) === CouponType::Percentage) {
            $price -= $price * ($discountValue / 100);
        } else {
            $price -= $discountValue;
        }

        return max(round($price, 2), 0);
    }

    public function celebrity()
    {
        return $this->belongsTo(Celebrity::class,'celebrity_id');
    }

}
