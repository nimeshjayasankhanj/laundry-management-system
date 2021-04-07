<?php

namespace App\Http\Controllers;

use App\Customer;
use App\User;
use App\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SecurityController extends Controller
{


    public function signin(Request $request)
    {
        $this->validate($request, ['nic' => 'required', 'password' => 'required|min:9']);

        $advanceEncryption=(new  \App\MyResources\AdvanceEncryption($request->get('password'),"ROYAL6566",256));

        $userData = array(
            'nic' => $request->get('nic'),
            'password' => $advanceEncryption->encrypt(),
            'status' => '1'
        );

        $user = User::where('nic', $request->get('nic'))->where('password',$advanceEncryption->encrypt())->exists();
        if ($user==true){
            $userData=User::where('nic', $request->get('nic'))->where('password',$advanceEncryption->encrypt())->first();
            if ($userData->status==1){
                session(['userid' => $userData->idUser]);
                Auth::login($userData);

                return redirect('/index');
            }else if($userData->status==0){
                return back()->with('warning', 'User has been suspended! Contact your System Administrator.');
            }

        }else{
            return back()->with('error', 'Incorrect login details! Check NIC and Password');
        }

    }

    public function logoutNow(Request $request){
//        Auth::logout();
        $request->session()->invalidate();
        return redirect('/signin');
    }


}
