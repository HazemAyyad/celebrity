<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetOtpMail;
use App\Models\Celebrity;
use App\Models\CelebrityOtp;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class CelebrityAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('celebrity.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('celebrity')->attempt($credentials)) {
            $user = Auth::guard('celebrity')->user();

            // تحقق إذا الحساب مفعل بالـ OTP
            if (!$user->is_verified) {
                Auth::guard('celebrity')->logout();
                return response()->json([
                    'status' => 'otp_required',
                    'redirect' => route('celebrity.otp.form', ['user' => $user->id])
                ]);
            }

            return response()->json([
                'status' => 'success',
                'redirect' => route('celebrity.dashboard')
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'بيانات الدخول غير صحيحة'
        ], 422);
    }


    public function logout()
    {
        Auth::guard('celebrity')->logout();
        return redirect()->route('celebrity.login');
    }

    public function showRegisterForm()
    {
        return view('celebrity.auth.register');
    }

    // معالجة التسجيل
    public function register(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:celebrities,email',
            'phone'         => 'nullable|string|max:255',
            'password'      => 'required|string|min:6|confirmed',
            'country_id'    => 'nullable', // اذا عندك جدول دول
            'address'       => 'nullable|string|max:255',
            'account_type'  => 'nullable|in:influencer,normal',
            'is_partner'    => 'nullable',
            'image'         => 'nullable|image|max:2048',
            // 'social_links' -> ممكن تعالجها بشكل خاص إذا تبي تخزن JSON
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }
        DB::beginTransaction();
        try {
            // رفع صورة إذا أرفقها
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('celebrity_images', 'public');
            }

            // إنشاء المشهور
            $celebrity = Celebrity::create([
                'name'          => $request->name,
                'email'         => $request->email,
                'phone'         => $request->phone,
                'password'      => Hash::make($request->password),
                'country_id'    => $request->country_id,
                'address'       => $request->address,
                'account_type'  => $request->account_type,
                'is_partner'    => $request->boolean('is_partner'),
                'image'         => $imagePath,
                'social_links'  => json_encode([
                    'facebook'  => $request->facebook,
                    'twitter'   => $request->twitter,
                    'instagram' => $request->instagram,
                    'snapchat'  => $request->snapchat,
                ]),
            ]);
            $this->sendOtpCode($celebrity); // لا تحتاج نوع هنا
            $encryptedId = Crypt::encrypt($celebrity->id);
            DB::commit();
            // ترجع JSON بنجاح التسجيل
            return response()->json([
                'status' => 'success',
                'user_id' => $encryptedId,
                'message' => 'تم التسجيل بنجاح'
            ]);

        }catch (\Throwable $exception){
            throw $exception;
        }

    }
    protected function sendOtp($celebrity)
    {
        $otpCode = random_int(10000, 99999); // 6 أرقام

        // تخزين OTP للبريد
        CelebrityOtp::create([
            'celebrity_id' => $celebrity->id,
            'otp_code' => $otpCode,
            'type' => 'email',
            'expires_at' => Carbon::now()->addMinutes(10),
        ]);

        // تخزين OTP للموبايل (مثلاً نفس الرمز أو تقدر تولد واحد ثاني)
        CelebrityOtp::create([
            'celebrity_id' => $celebrity->id,
            'otp_code' => $otpCode,
            'type' => 'phone',
            'expires_at' => Carbon::now()->addMinutes(10),
        ]);

        // هنا ترسل الايميل والرسالة النصية مع الـ OTP
        // مثلاً ترسل ايميل:
        \Mail::to($celebrity->email)->send(new \App\Mail\OtpMail($otpCode));

        // وترسل رسالة SMS (اعتماداً على خدمة SMS تستخدمها)
        // SmsService::send($celebrity->phone, "رمز التحقق الخاص بك هو: $otpCode");
    }
    protected function sendOtpCode(Celebrity $celebrity, string $context = 'email')
    {
        $otpCode = random_int(10000, 99999);

        // حذف الأكواد السابقة غير المستخدمة (اختياري)
        CelebrityOtp::where('celebrity_id', $celebrity->id)
            ->where('type', $context)
            ->where('is_used', false)
            ->delete();

        // تخزين الكود
        CelebrityOtp::create([
            'celebrity_id' => $celebrity->id,
            'otp_code'     => $otpCode,
            'type'         => $context,
            'expires_at'   => now()->addMinutes(10),
        ]);

        // إرسال OTP
        Mail::to($celebrity->email)->send(new \App\Mail\OtpMail($otpCode));
    }

    public function showOtpForm(Request $request)
    {
        $userId = $request->query('user');
        try {
            $celebrityId = Crypt::decrypt($request->user);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            abort(403, 'الرابط غير صالح.');
        }

        $celebrity = Celebrity::findOrFail($celebrityId);
        if (!$celebrity) {
            return redirect()->route('celebrity.register')->withErrors('المستخدم غير موجود');
        }

        $otp = null;

        // في بيئة التطوير، رجّع الكود إن وجد وكان غير منتهي
        if (app()->isLocal()) {
            $otpRecord = \App\Models\CelebrityOtp::where('celebrity_id', $celebrity->id)
                ->where('is_used', false)
                ->where('expires_at', '>', now()) // فقط الأكواد غير المنتهية
                ->latest()
                ->first();

            if (!$otpRecord) {
                $otp=    'منهي'        ;
            }else{
                $otp = $otpRecord->otp_code;
            }


        }

        return view('celebrity.auth.otp', compact('celebrity', 'otp'));
    }

    public function showOtpResetForm(Request $request)
    {
        $userId = $request->query('user');
        try {
            $celebrityId = Crypt::decrypt($request->user);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            abort(403, 'الرابط غير صالح.');
        }

        $celebrity = Celebrity::findOrFail($celebrityId);
        // فقط أثناء التطوير، نعرض OTP

        if (!$celebrity) {
            return redirect()->route('celebrity.register')->withErrors('المستخدم غير موجود');
        }

        $otp = null;

        // في بيئة التطوير، رجّع الكود إن وجد وكان غير منتهي
        if (app()->isLocal()) {
            $otpRecord = CelebrityOtp::where('celebrity_id', $celebrity->id)
                ->where('is_used', false)
                ->where('expires_at', '>', now()) // فقط الأكواد غير المنتهية
                ->latest()
                ->first();

            if (!$otpRecord) {
                $otp=    'منهي'        ;
            }else{
                $otp = $otpRecord->otp_code;
            }


        }

        return view('celebrity.auth.forgot-password-otp', compact('celebrity', 'otp'));
    }



    public function verifyOtp(Request $request)
    {
        $request->validate([
            'celebrity_id' => 'required',
            'otp' => 'required|array|size:5',
            'otp.*' => 'required|numeric|digits:1',
        ]);
        $userId = $request->celebrity_id;
        try {
            $celebrityId = Crypt::decrypt($userId);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            abort(403, 'الرابط غير صالح.');
        }

         // اجمع الخانات في كود واحد
        $otpCode = implode('', $request->otp);

        $otp = CelebrityOtp::where('celebrity_id', $celebrityId)
            ->where('otp_code', $otpCode)
            ->where('is_used', false)
            ->where('expires_at', '>', now())
            ->first();

        if (!$otp) {
            return response()->json([
                'status' => 'error',
                'message' => 'رمز التحقق غير صالح أو منتهي'
            ], 422);
        }

        $otp->update(['is_used' => true]);

        $celebrity = Celebrity::find($celebrityId);
        $celebrity->email_verified_at = now();
        $celebrity->save();

        auth()->login($celebrity);

        return response()->json([
            'status' => 'success',
            'redirect_url' => route('celebrity.login'),
        ]);
    }
    public function resendOtp(Request $request)
    {
        $request->validate([
            'celebrity_id' => 'required',
        ]);

        try {
            $celebrityId = Crypt::decrypt($request->celebrity_id);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            abort(403, 'رابط غير صالح.');
        }

        $celebrity = Celebrity::find($celebrityId);

        if (!$celebrity) {
            return response()->json([
                'status' => 'error',
                'message' => 'المستخدم غير موجود',
            ], 404);
        }

        // حذف الأكواد القديمة
        CelebrityOtp::where('celebrity_id', $celebrity->id)
            ->where('is_used', false)
            ->delete();

        // توليد كود جديد
        $otpCode = random_int(10000, 99999);

        // تخزين OTP جديد
        CelebrityOtp::create([
            'celebrity_id' => $celebrity->id,
            'otp_code' => $otpCode,
            'type' => 'email',
            'expires_at' => now()->addMinutes(10),
        ]);

        // محاولة إرسال الكود بدون التسبب بخطأ في حال الفشل
        try {
            \Mail::to($celebrity->email)->send(new \App\Mail\OtpMail($otpCode));
        } catch (\Exception $e) {
            // سجل الخطأ مثلاً بدون ما توقف التنفيذ
            \Log::error('فشل إرسال OTP: ' . $e->getMessage());
        }

        return response()->json([
            'status' => 'success',
            'message' => 'تم إرسال رمز التحقق مرة أخرى',
            'new_otp' => $otpCode,
        ]);
    }







    public function showResetPasswordForm(Request $request)
    {
        try {
            $celebrityId = Crypt::decrypt($request->user);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            abort(403, 'رابط غير صالح.');
        }

        $celebrity = Celebrity::findOrFail($celebrityId);

        return view('celebrity.auth.reset-password', compact('celebrity'));
    }
    public function resetPassword(Request $request)
    {
        $request->validate([
            'celebrity_id' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);

        try {
            $celebrityId = Crypt::decrypt($request->celebrity_id);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'الرابط غير صالح.'
            ], 403);
        }

        $celebrity = Celebrity::findOrFail($celebrityId);
        $celebrity->password = Hash::make($request->password);
        $celebrity->save();

        // ✅ تسجيل الدخول تلقائيًا
        Auth::guard('celebrity')->login($celebrity);

        return response()->json([
            'status' => 'success',
            'redirect' => route('celebrity.dashboard'),
        ]);
    }
    public function showForgotForm()
    {
        return view('celebrity.auth.forgot-password');
    }
    public function sendOtpForReset(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:celebrities,email',
        ]);

        $celebrity = Celebrity::where('email', $request->email)->first();

        // هنا فقط إرسال الإيميل داخل try-catch
        try {
            $this->sendOtpCode($celebrity, 'reset');
        } catch (\Exception $e) {
            if (!App::environment('local')) {
                // في production لازم يتوقف
                throw $e;
            }
            // في local تجاهل الخطأ
            logger()->warning('فشل إرسال الإيميل في بيئة التطوير: ' . $e->getMessage());
        }

        $encryptedId = Crypt::encrypt($celebrity->id);

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'redirect' => route('celebrity.otp-reset.form', ['user' => $encryptedId])
            ]);
        }
    }

    public function verifyOtpForReset(Request $request)
    {
        $request->validate([
            'celebrity_id' => 'required',
            'otp' => 'required|array|size:5',
            'otp.*' => 'required|numeric|digits:1',
        ]);

        try {
            $celebrityId = Crypt::decrypt($request->celebrity_id);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'رابط غير صالح أو تم التلاعب به.'
            ], 422);
        }

        $otpCode = implode('', $request->otp);

        $otp = CelebrityOtp::where('celebrity_id', $celebrityId)
            ->where('otp_code', $otpCode)
            ->where('is_used', false)
            ->where('expires_at', '>', now())
            ->first();

        if (!$otp) {
            return response()->json([
                'status' => 'error',
                'message' => 'رمز التحقق غير صالح أو منتهي'
            ], 422);
        }

        $otp->update(['is_used' => true]);

        $encryptedId = Crypt::encrypt($celebrityId);

        return response()->json([
            'status' => 'success',
            'redirect_url' => route('celebrity.reset-password.form', ['user' => $encryptedId])
        ]);
    }



}
