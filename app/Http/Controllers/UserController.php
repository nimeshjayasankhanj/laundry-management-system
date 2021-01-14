<?php


namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function addCustomerIndex(){

        return view('customer.add-customer',['title'=>"Add Customer"]);
    }
    public function viewCustomerIndex(){

        $customers=User::where('status',1)->where('user_role_iduser_role',2)->get();

        return view('customer.view-customers',['title'=>"View Customer",'customers'=>$customers]);
    }

    

        public function save(Request $request){

            $validator = \Validator::make($request->all(), [

                'fName' => 'required|max:115',
                'lName' => 'required|max:115',
                'email' => 'required',
                'contactNo' => 'required|max:10|min:10',
                'nicNo' => 'required',
                'password' => 'required|min:9',
                
            ], [
                'fName.required' => 'First Name should be provided!',
                'email.required' => 'Email should be provided!',
                'fName.max' => 'Last Name must be less than 115 characters.',
                'lName.required' => 'Last Name should be provided!',
                'lName.max' => 'Last Name must be less than 115 characters.',
                'contactNo.required' => 'Contact No should be provided!',
                'contactNo.max' => 'Contact No must be include 10 number.',
                'contactNo.min' => 'Contact No must be include 10 number.',
                'nicNo.required' => 'NIC should be provided!',
                'password.max' => 'Password must be include 9 number.',
                'password.required' => 'Password should be provided.',
                
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' =>$validator->errors()]);
    
            }
    
            $save=new User();
        
            $save->first_name=strtoupper($request['fName']);
            $save->last_name=strtoupper($request['lName']);
            $save->contact_no=$request['contactNo'];
            $save->email=strtolower($request['email']);
            $save->nic=$request['nicNo'];
            $advanceEncryption = (new  \App\MyResources\AdvanceEncryption($request['password'],"TASTYHUB6566", 256));
            $save->password=$advanceEncryption->encrypt();
            $save->status=1;
            $save->user_role_iduser_role=2;
            $save->save();
    
          
    
            return response()->json(['success' => 'Customer saved successfully.']);
        }




}