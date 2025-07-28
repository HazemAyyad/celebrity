<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Celebrity;
use App\Models\Country;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class MainController extends Controller
{


    public function dashboard()
    {
        $userId = auth('celebrity')->id();
        $userCouponCodes = Coupon::where('celebrity_id', $userId)->pluck('code');

        // التواريخ
        $startOfThisMonth = Carbon::now()->startOfMonth();
        $endOfThisMonth = Carbon::now()->endOfMonth();
        $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();

        // الفنادق
        $hotelTotalThisMonth = DB::table('booking_hotels')
            ->whereIn('coupon_code', $userCouponCodes)
            ->whereBetween('created_at', [$startOfThisMonth, $endOfThisMonth])
            ->sum('amount');

        $hotelTotalLastMonth = DB::table('booking_hotels')
            ->whereIn('coupon_code', $userCouponCodes)
            ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
            ->sum('amount');

        $hotelTotalAllTime = DB::table('booking_hotels')
            ->whereIn('coupon_code', $userCouponCodes)
            ->sum('amount');

        $hotelGrowth = 0;
        if ($hotelTotalLastMonth > 0) {
            $hotelGrowth = (($hotelTotalThisMonth - $hotelTotalLastMonth) / $hotelTotalLastMonth) * 100;
        } elseif ($hotelTotalThisMonth > 0) {
            $hotelGrowth = 100;
        }

        // الطيران
        $flightTotalThisMonth = DB::table('fs_bookings')
            ->whereIn('coupon_code', $userCouponCodes)
            ->whereBetween('created_at', [$startOfThisMonth, $endOfThisMonth])
            ->sum('price');

        $flightTotalLastMonth = DB::table('fs_bookings')
            ->whereIn('coupon_code', $userCouponCodes)
            ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
            ->sum('price');

        $flightTotalAllTime = DB::table('fs_bookings')
            ->whereIn('coupon_code', $userCouponCodes)
            ->sum('price');

        $flightGrowth = 0;
        if ($flightTotalLastMonth > 0) {
            $flightGrowth = (($flightTotalThisMonth - $flightTotalLastMonth) / $flightTotalLastMonth) * 100;
        } elseif ($flightTotalThisMonth > 0) {
            $flightGrowth = 100;
        }
        $now = Carbon::now();

        $labels = [];
        $hotelsData = [];
        $flightsData = [];
        $servicesData = [];

        // الأشهر من 1 إلى الشهر الحالي (مثلاً: يناير إلى يوليو)
        for ($month = 1; $month <= $now->month; $month++) {
            $date = Carbon::create($now->year, $month, 1);
            $start = $date->copy()->startOfMonth();
            $end = $date->copy()->endOfMonth();

            $labels[] = $date->translatedFormat('F'); // اسم الشهر مثل "مارس"

            $hotelsData[] = DB::table('booking_hotels')
                ->whereIn('coupon_code', $userCouponCodes)
                ->whereBetween('created_at', [$start, $end])
                ->count();

            $flightsData[] = DB::table('fs_bookings')
                ->whereIn('coupon_code', $userCouponCodes)
                ->whereBetween('created_at', [$start, $end])
                ->count();

//            $servicesData[] = DB::table('service_bookings')
//                ->whereBetween('created_at', [$start, $end])
//                ->count();
        }


        return view('celebrity.index', compact(
            'hotelTotalThisMonth', 'hotelTotalLastMonth', 'hotelTotalAllTime', 'hotelGrowth',
            'flightTotalThisMonth', 'flightTotalLastMonth', 'flightTotalAllTime', 'flightGrowth'
            ,'labels','hotelsData','flightsData'
        ));
    }

    public function myQuotation()
    {


        return view('celebrity.my-quotation');
    }
    public function profile()
    {

        $countries=Country::all();


        return view('celebrity.profile', compact('countries'));
    }
    public function edit_profile()
    {
        $countries=Country::query()->where('country_name','Saudi Arabia')->get();



        return view('celebrity.edit-profile', compact('countries'));
    }
    public function save_profile(Request $request, $id)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:celebrities,email,' . $id,
            'phone'         => 'nullable|string|max:255',
            'password'      => 'nullable|string|min:6|confirmed',
            'country_id'    => 'nullable',
            'address'       => 'nullable|string|max:255',
            'account_type'  => 'nullable|in:influencer,normal',
            'is_partner'    => 'nullable',
            'image'         => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $celebrity = Celebrity::findOrFail($id);

            // رفع الصورة
            $imagePath = $celebrity->image;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('celebrity_images', 'public');
            }

            // تحديث البيانات
            $celebrity->update([
                'name'          => $request->name,
                'email'         => $request->email,
                'phone'         => $request->phone,
                'country_id'    => $request->country_id,
                'address'       => $request->address,
                'account_type'  => $request->account_type,
                'image'         => $imagePath,
                'social_links'  => json_encode([
                    'facebook'  => $request->facebook,
                    'twitter'   => $request->twitter,
                    'instagram' => $request->instagram,
                    'snapchat'  => $request->snapchat,
                ]),
            ]);

            // إذا فيه كلمة مرور جديدة
            if ($request->filled('password')) {
                $celebrity->update([
                    'password' => bcrypt($request->password)
                ]);
            }

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'تم تعديل البروفايل بنجاح'
            ]);
        } catch (\Throwable $exception) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'حدث خطأ أثناء التحديث',
                'error' => $exception->getMessage(),
            ], 500);
        }
    }




}
