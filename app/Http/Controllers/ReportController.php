<?php


namespace App\Http\Controllers;

use App\Invoice;
use App\MainCategory;
use App\MasterBooking;
use App\Product;
use App\Stock;
use App\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
        public function pendingOrdersIndex(Request $request){


            $orderID = $request['orderID'];
            $customer = $request['customer'];
            $date = $request['date'];
            
            
            $query = MasterBooking::query();
    
            
            if (!empty($orderID)) {
               
                $query = $query->where('idmaster_booking', $orderID);
            }
            if (!empty($customer)) {
    
                $query = $query->where('user_master_iduser_master', $customer);
            }
    

            if (!empty($date)) {
                $date = date('Y-m-d', strtotime($request['date']));
               
                $query = $query->whereDate('created_at', '=', $date);
            }
            
            $orders = $query->where('status', 0)->get();
       
            $customers=User::where('status',1)->where('user_role_iduser_role',2)->get();


            return view('reports.pending-orders',['title'=>'Pending Orders','orders'=>$orders,'customers'=>$customers]);
        }

        public function acceptedOrdersIndex(Request $request){

            $orderID = $request['orderID'];
            $customer = $request['customer'];
            $date = $request['date'];
            
            
            $query = MasterBooking::query();
    
            
            if (!empty($orderID)) {
               
                $query = $query->where('idmaster_booking', $orderID);
            }
            if (!empty($customer)) {
    
                $query = $query->where('user_master_iduser_master', $customer);
            }
    

            if (!empty($date)) {
                $date = date('Y-m-d', strtotime($request['date']));
               
                $query = $query->whereDate('created_at', '=', $date);
            }
            
            $orders = $query->where('status', 1)->get();
       
            $customers=User::where('status',1)->where('user_role_iduser_role',2)->get();

            return view('reports.accepted-orders',['title'=>'Accepted Orders','orders'=>$orders,'customers'=>$customers]);
        }

        public function completedOrdersIndex(Request $request){

            $orderID = $request['orderID'];
            $customer = $request['customer'];
            $date = $request['date'];
            
            
            $query = MasterBooking::query();
    
            
            if (!empty($orderID)) {
               
                $query = $query->where('idmaster_booking', $orderID);
            }
            if (!empty($customer)) {
    
                $query = $query->where('user_master_iduser_master', $customer);
            }
    

            if (!empty($date)) {
                $date = date('Y-m-d', strtotime($request['date']));
               
                $query = $query->whereDate('created_at', '=', $date);
            }
            
            $orders = $query->where('status', 2)->get();
       
            $customers=User::where('status',1)->where('user_role_iduser_role',2)->get();

            return view('reports.completed-orders',['customers'=>$customers,'title'=>'Completed Orders','orders'=>$orders]);
        }

        public function activeStockIndex(Request $request){

            $productID = $request['productID'];
            
            
            $query = Stock::query();
    
            
            if (!empty($productID)) {
               
                $query = $query->where('product_idproduct', $productID);
            }
          
            $stocks = $query->where('status', 1)->get();
       
            $products=Product::where('status',1)->get();

            return view('reports.active-stock',['products'=>$products,'title'=>'Active Stock','stocks'=>$stocks]);
        }

        public function deactiveStockIndex(Request $request){

            $productID = $request['productID'];
            
            
            $query = Stock::query();
    
            
            if (!empty($productID)) {
               
                $query = $query->where('product_idproduct', $productID);
            }
          
            $stocks = $query->where('status', 0)->get();
       
            $products=Product::where('status',1)->get();

            return view('reports.deactive-stock',['products'=>$products,'title'=>'Deactive Stock','stocks'=>$stocks]);
        }

        public function saleReportIndex(Request $request){

            $orderID = $request['orderID'];
            $customer = $request['customer'];
            $date = $request['date'];
            $idinvoice=$request['idinvoice'];
            
            $query = Invoice::query();
    
            
            if (!empty($idinvoice)) {
               
                $query = $query->where('idinvoice', $idinvoice);
            }
            if (!empty($orderID)) {
               
                $query = $query->where('master_booking_idmaster_booking', $orderID);
            }
            if (!empty($customer)) {
    
                $query = $query->where('customer', $customer);
            }
    

            if (!empty($date)) {
                $date = date('Y-m-d', strtotime($request['date']));
               
                $query = $query->whereDate('created_at', '=', $date);
            }
            
            $sales = $query->where('status', 1)->get();
       
            $customers=User::where('status',1)->where('user_role_iduser_role',2)->get();

            return view('reports.sale-report',['sales'=>$sales,'title'=>'Sale Report','customers'=>$customers]);
        }

        
        


}