<?php

namespace App\Models;

use App\Enums\Couponable;
use App\Enums\CouponType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table = 'coupons';

    // Define the fillable attributes
    protected $guarded = '';

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
    public function getDiscountLabel(Couponable $couponable): string
    {
        $valueKey = 'value_' . $couponable->value;
        $discountValue = $this->{$valueKey} ?? 0;

        if (!$discountValue || $discountValue <= 0) {
            return 'لا يوجد خصم';
        }

        if (CouponType::from($this->type) === CouponType::Percentage) {
            return "خصم {$discountValue}%";
        }

        return "خصم {$discountValue} شيكل";
    }
    public function getRemainingTimeAttribute(): string
    {
        if (!$this->end_date) {
            return 'بدون تاريخ انتهاء';
        }

        $now = Carbon::now();
        $expiresAt = Carbon::parse($this->end_date);

        if ($expiresAt->isPast()) {
            return 'منتهي';
        }

        return $now->diffForHumans($expiresAt, [
            'parts' => 2, // "2 days 3 hours"
            'short' => true,
            'syntax' => Carbon::DIFF_RELATIVE_TO_NOW,
        ]);
    }

    public function celebrity()
    {
        return $this->belongsTo(Celebrity::class,'celebrity_id');
    }

}
