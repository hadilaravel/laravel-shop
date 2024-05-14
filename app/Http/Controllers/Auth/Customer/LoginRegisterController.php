<?php

namespace App\Http\Controllers\Auth\Customer;

use App\Http\Services\Message\Email\EmailService;
use App\Http\Services\Message\MessageService;
use App\Models\Otp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\Http\Services\Message\SMS\SmsService;
use App\Http\Requests\Auth\Customer\LoginRegisterRequest;
use Melipayamak\MelipayamakApi;

class LoginRegisterController extends Controller
{
    public function loginRegisterForm()
    {
        return view('customer.auth.login-register');
    }

    public function loginRegister(LoginRegisterRequest $request)
    {
        $inputs = $request->all();

        //check id is email or not
        if(filter_var($inputs['id'], FILTER_VALIDATE_EMAIL))
        {
            $type = 1; // 1 => email
            $user = User::where('email', $inputs['id'])->first();
            if(empty($user)){
                $newUser['email'] = $inputs['id'];
            }
        }

        //check id is mobile or not
        elseif(preg_match('/^(\+98|98|0)9\d{9}$/', $inputs['id'])){
            $type = 0; // 0 => mobile;


            // all mobile numbers are in on format 9** *** ***
            $inputs['id'] = ltrim($inputs['id'], '0');
            $inputs['id'] = substr($inputs['id'], 0, 2) === '98' ? substr($inputs['id'], 2) : $inputs['id'];
            $inputs['id'] = str_replace('+98', '', $inputs['id']);

            $user = User::where('mobile', $inputs['id'])->first();
            if(empty($user)){
                $newUser['mobile'] = $inputs['id'];
            }
        }

        else{
            $errorText = 'شناسه ورودی شما نه شماره موبایل است نه ایمیل';
            return redirect()->route('auth.customer.login-register-form')->withErrors(['id' => $errorText]);
        }

        if(empty($user)){
            $newUser['password'] = '98355154';
            $newUser['activation'] = 1;
            $user = User::create($newUser);
        }

        //create otp code
        $otpCode = rand(111111, 999999);
        $token = Str::random(60);
        $otpInputs = [
            'token' => $token,
            'user_id' => $user->id,
            'otp_code' => $otpCode,
            'login_id' => $inputs['id'],
            'type' => $type,
        ];

        Otp::create($otpInputs);

        //send sms or email

        if($type == 0){
            //send sms
            try{
                $username = Config::get('sms.username') ;
                $password =  Config::get('sms.password');
                $api = new MelipayamakApi($username,$password);
                $sms = $api->sms();
                $to = '0' . $user->mobile;
                $from =  Config::get('sms.otp_from');
                $text = "مجموعه آمازون \n  کد تایید : $otpCode";
                $response = $sms->send($to,$from,$text);
                $json = json_decode($response);
            }catch(Exception $e){
                echo $e->getMessage();
            }

        }
        elseif($type === 1 ){
//            send email
            $emailService = new EmailService();
            $details = [
                'title' => 'ایمیل فعال سازی',
                'body' => " کد فعال سازی شما :$otpCode "
            ];
            $emailService->setDetails($details);
            $emailService->setFrom('noreply@example.com' , 'amazon' );
            $emailService->setSubject('کد احراز هویت');
            $emailService->setTo($inputs['id']);

            $messageService = new MessageService($emailService);
            $messageService->send();
        }

        return redirect()->route('auth.customer.login-confirm-form' , $token);
    }

    public function loginConfirmForm($token)
    {
        $otp = Otp::where('token' , $token)->first();
        if(empty($otp)){
            return redirect()->route('auth.customer.login-register-form')->withErrors(['id' => 'آدرس وارد شده نامعتبر میباشد']);
        }
        return view('customer.auth.login-confirm' , compact( "token" , "otp") );
    }

    public function loginConfirm(LoginRegisterRequest $request, $token)
    {
        $inputs = $request->all();
        $otp = Otp::where('token' , $token)->where('used' , 0)->where('created_at' , '>=' , Carbon::now()->subMinute(5)->toDateTimeString())->first();
        if(empty($otp)){
            return redirect()->route('auth.customer.login-register-form')->withErrors(['id' => 'آدرس وارد شده نامعتبر است']);
        }

//        if otp not match
        if($otp->otp_code !== $inputs['otp'])
        {
            return redirect()->route('auth.customer.login-confirm-form' , $token)->withErrors(['otp' => 'کد وارد شده نامعتبر است']);
        }

//        if everything is ok :
        $otp->update(['used' => 1]);
        $user = $otp->user()->first();
        if($otp->type == 0 && empty($user->mobile_verified_at))
        {
            $user->update(['mobile_verified_at' => Carbon::now()]);
        }
        elseif($otp->type == 1 && empty($user->email_verified_at))
        {
            $user->update(['email_verified_at' => Carbon::now()]);
        }
        Auth::login($user);
        return redirect()->route('customer.home');
    }

    public function loginResendOtp($token)
    {

        $otp = Otp::where('token' , $token)->where('created_at' , '<=' , Carbon::now()->subMinute(5)->toDateTimeString())->first();

        if(empty($otp))
        {
            return redirect()->route('auth.customer.login-register-form' , $token)->withErrors(['id' => 'آدرس وارد شده نامعتبر است']);
        }

        $user = $otp->user()->first();
        //create otp code
        $otpCode = rand(111111, 999999);
        $newToken = Str::random(60);
        $otpInputs = [
            'token' => $newToken,
            'user_id' => $user->id,
            'otp_code' => $otpCode,
            'login_id' => $otp->login_id,
            'type' => $otp->type,
        ];

        Otp::create($otpInputs);

        //send sms or email

        if($otp->type == 0){
            //send sms
            try{
                $username = Config::get('sms.username') ;
                $password =  Config::get('sms.password');
                $api = new MelipayamakApi($username,$password);
                $sms = $api->sms();
                $to = '0' . $user->mobile;
                $from =  Config::get('sms.otp_from');
                $text = "مجموعه آمازون \n  کد تایید : $otpCode";
                $response = $sms->send($to,$from,$text);
                $json = json_decode($response);
            }catch(Exception $e){
                echo $e->getMessage();
            }

        }
        elseif($otp->type === 1 ){
//            send email
            $emailService = new EmailService();
            $details = [
                'title' => 'ایمیل فعال سازی',
                'body' => " کد فعال سازی شما :$otpCode "
            ];
            $emailService->setDetails($details);
            $emailService->setFrom('noreply@example.com' , 'amazon' );
            $emailService->setSubject('کد احراز هویت');
            $emailService->setTo($otp->login_id);

            $messageService = new MessageService($emailService);
            $messageService->send();
        }

        return redirect()->route('auth.customer.login-confirm-form' , $newToken)->with(['success' => 'ارسال شد']);

    }

    public function logout()
    {
         Auth::logout();
         return redirect()->route('customer.home');
    }


}
