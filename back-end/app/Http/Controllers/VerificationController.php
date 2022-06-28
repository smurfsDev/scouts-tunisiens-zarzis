<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function verify($user_id, Request $request) {
        if (!$request->hasValidSignature()) {
            return response()->json(["msg" => "رمز التحقق غير صحيح, الرجاء طلب رابط جديد"], 400);        }

        $user = User::findOrFail($user_id);

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            return response()->json(["msg" => "تم تأكيد البريد الإلكتروني بنجاح"], 200);
        }else{
            return response()->json(["msg" => "البريد الإلكتروني مؤكد"], 400);
        }

    }

    public function resend($email) {
        $user = User::where('email', $email)->first();
        if ($user->hasVerifiedEmail()) {
            return response()->json(["msg" => "البريد الإلكتروني مؤكد, سوف يتم اعادة توجيهك الى صفحة تسجيل الدخول,"], 400);
        }

        $user->sendEmailVerificationNotification();

        return response()->json(["msg" => "تم إعادة إرسال رابط التحقق بنجاح"], 200);
    }

}
