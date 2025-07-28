<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Celebrity;
use App\Models\Country;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;


class CouponsController extends Controller
{

    public function index()
    {

        $coupons = Coupon::query()
            ->where('celebrity_id', auth('celebrity')->id())
            ->with('celebrity') // eager load
            ->get();

        return view('celebrity.coupons.index', compact('coupons'));
    }

    public function get_coupons(Request $request)
    {
      return  $coupons = Coupon::with('celebrity'); // eager load لعلاقة celebrity

        return DataTables::of($coupons)
            ->addIndexColumn()

            // ✅ Checkbox column
            ->addColumn('checkbox', fn($item) => '<input type="checkbox" class="select-row" value="' . $item->id . '" />')

            // ✅ Format created_at
            ->editColumn('created_at', fn($item) => \Carbon\Carbon::parse($item->created_at)->format('Y-m-d'))

            // ✅ Coupon type (enum)
            ->editColumn('type', fn($item) => \App\Enums\CouponType::tryFrom($item->type)?->name ?? 'Invalid')

            // ✅ Celebrity name
            ->editColumn('celebrity.name', fn($item) => $item->celebrity?->name ?? '-')

            // ✅ Active status buttons
            ->editColumn('active', function ($item) {
                $url = '';
                return $item->active
                    ? '<button type="button" url="' . $url . '" class="btn btn-sm btn-danger btn-put"><i class="fa fa-x"></i></button>'
                    : '<button type="button" url="' . $url . '" class="btn btn-sm btn-success btn-put"><i class="fa fa-check"></i></button>';
            })

            // ✅ Status badge
            ->editColumn('status', function ($item) {
                return match($item->status) {
                    'حالي'   => '<span class="badge-status badge-hali">حالي</span>',
                    'ملغي'   => '<span class="badge-status badge-multghi">ملغي</span>',
                    'منتهي'  => '<span class="badge-status badge-montahi">منتهي</span>',
                    default  => $item->status,
                };
            })

            // ✅ raw columns to allow HTML rendering
            ->rawColumns(['checkbox', 'active', 'status'])

            ->make(true);
    }





}
