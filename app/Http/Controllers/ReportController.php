<?php


namespace App\Http\Controllers;

use App\MainCategory;
use App\MasterBooking;
use App\Stock;
use Illuminate\Http\Request;

class ReportController extends Controller
{
        public function pendingOrdersIndex(){

            $orders=MasterBooking::where('status',0)->get();

            return view('reports.pending-orders',['title'=>'Pending Orders','orders'=>$orders]);
        }

        public function acceptedOrdersIndex(){

            $orders=MasterBooking::where('status',1)->get();

            return view('reports.accepted-orders',['title'=>'Accepted Orders','orders'=>$orders]);
        }

        public function completedOrdersIndex(){

            $orders=MasterBooking::where('status',2)->get();

            return view('reports.completed-orders',['title'=>'Completed Orders','orders'=>$orders]);
        }

        public function activeStockIndex(){

            $stocks=Stock::where('status',1)->get();

            return view('reports.active-stock',['title'=>'Active Stock','stocks'=>$stocks]);
        }

        public function deactiveStockIndex(){

            $stocks=Stock::where('status',0)->get();

            return view('reports.deactive-stock',['title'=>'Deactive Stock','stocks'=>$stocks]);
        }


        
        


}