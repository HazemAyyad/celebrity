<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Celebrity;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class MainController extends Controller
{

    public function dashboard()
    {


        return view('celebrity.index');
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
         $countries=Country::all();


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
