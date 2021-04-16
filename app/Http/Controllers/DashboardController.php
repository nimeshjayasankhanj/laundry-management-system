<?php


namespace App\Http\Controllers;

use App\BookingReg;
use App\CategoryPrice;
use App\Invoice;
use App\Mail\PendingOrder;
use App\MainCategory;
use App\MasterBooking;
use App\TempBooking;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class DashboardController extends Controller
{
        public function index(){

            $systemDate = Carbon::now()->format('y/m/d');

            if(Auth::user()->user_role_iduser_role==1){
                $Pending=MasterBooking::where('status',0)->count('idmaster_booking');
                $accepted=MasterBooking::where('status',1)->count('idmaster_booking');
                $completed=MasterBooking::where('status',2)->count('idmaster_booking');
                $totalIncome=Invoice::where('status',1)->sum('invoice_total');
                $todayIncome=Invoice::where('status',1)->where('date',$systemDate)->sum('invoice_total');
               


            }else{
                $Pending=MasterBooking::where('user_master_iduser_master',Auth::user()->iduser_master)->where('status',0)->count('idmaster_booking');
                $accepted=MasterBooking::where('user_master_iduser_master',Auth::user()->iduser_master)->where('status',1)->count('idmaster_booking');
                $completed=MasterBooking::where('user_master_iduser_master',Auth::user()->iduser_master)->where('status',2)->count('idmaster_booking');
                $totalIncome=0;
                $todayIncome=0;
               
            }
        

            return view('index',['todayIncome'=>$todayIncome,'totalIncome'=>$totalIncome,'title'=>'Dashboard','Pending'=>$Pending,'accepted'=>$accepted,'completed'=>$completed]);


        }
        
        public function getOrders(){

            if(Auth::user()->user_role_iduser_role==1){
                $pendingOrder=MasterBooking::where('status',0)->count();
                return $pendingOrder;
            }else{
                $pendingOrder=MasterBooking::where('user_master_iduser_master',Auth::user()->iduser_master)->where('status',0)->count();
                return $pendingOrder;
            }
          
        }

        public function orderDetailChart(){

            $Pending=MasterBooking::where('status',0)->count('idmaster_booking');
            $accepted=MasterBooking::where('status',1)->count('idmaster_booking');
            $completed=MasterBooking::where('status',2)->count('idmaster_booking');

            return response()->json(['Pending'=>$Pending,'accepted'=>$accepted,'completed'=>$completed]);
        }

        public function incomeChart(){

            $income=Invoice::where('status',1)->get();

            return $income;
        }
        
        
}