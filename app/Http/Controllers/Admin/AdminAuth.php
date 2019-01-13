<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\AdminResetPassword;
use Carbon\Carbon;
use App\Admin;
use Mail;
use DB;


class AdminAuth extends Controller
{
    public function login()
    {
        return view('admin.login');

    }
    public function dologin()
    {
        $rememberme = request('rememberme') == 1 ? true: false;

        if(admin()->attempt(['email' => request('email'), 'password' => request('password')], $rememberme)):

            return redirect(aurl(''));
        else:

            session()->flash('error', trans('admin.incorrect_information_login'));

            return redirect(aurl('login'));
        endif;
    }


    public function logout()
    {
        auth()->guard('admin')->logout();

        return redirect(aurl('login'));

    }


    public function forgot_password()
    {
        return view('admin.forgot_password');
    }

    public function forgot_password_post()
    {
        $admin = Admin::where('email', request('email'))->first();
        if(!empty($admin)):
            $token = app('auth.password.broker')->createToken($admin);

            $data = DB::table('password_resets')->insert([

                    'email' => $admin->email,
                    'token' => $token,
                    'created_at' => Carbon::now()
                ]);

                // return new AdminResetPassword(['data' => $admin, 'token' => $token]);

            Mail::to($admin->email)->send(new AdminResetPassword(['data' => $admin, 'token' => $token]));

            session()->flash('success', trans('admin.the_reset_link_sent'));

            return back();

        endif;
        return back();
    }

    public function reset_password($token)
    {
        $check_token = DB::table('password_resets')->where('token', $token)
                                                    ->where('created_at', '>', Carbon::now()
                                                    ->subHours(2))->first();

        if(!empty($check_token))
        {
            return view('admin.reset_password')->with('data', $check_token);

        }else{

            return redirect(aurl('forgot/password'));
        }

    }

    public function reset_password_final( $token )
    {

        $this->validate(request(),[
            'password'              => 'required|confirmed|min:6',
            'password_confirmation' => 'required'

        ],[], [
            'password'              => 'Password',
            'password_confirmation' => 'Confirm Password'

            ]);


            $check_token = DB::table('password_resets')->where('token', $token)

            ->where('created_at', '>', Carbon::now()

            ->subHours(2))->first();

            if(!empty($check_token))
            {
                $admin = Admin::where('email', $check_token->email)->update([

                    'email'     => $check_token->email,
                    'password'  => bcrypt( request('password'))
                    ]);

                    DB::table('password_resets')->where('email', $check_token->email)->delete();

                    admin()->attempt(['email' => request('email'), 'password' => request('password')], true);

                    return redirect(aurl(''));

                }else{

                    return redirect(aurl('forgot/password'));
                }
            }
        }
