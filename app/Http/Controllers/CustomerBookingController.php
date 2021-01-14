<?php


namespace App\Http\Controllers;

use App\BookingReg;
use App\CategoryPrice;
use App\Mail\PendingOrder;
use App\MainCategory;
use App\MasterBooking;
use App\TempBooking;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CustomerBookingController extends Controller
{
        public function makeABooking(){

          
          

            $mainCategories=MainCategory::where('status',1)->get();

            return view('booking.make-a-booking',['title'=>'Make a Booking','mainCategories'=>$mainCategories]);


        }

        public function completedCusWorksIndex(){

            $completedBooking=MasterBooking::where('status',2)->where('user_master_iduser_master',Auth::user()->iduser_master)->get();


            return view('booking-history.completed-cus-works',['title'=>'Completed Works','completedBooking'=>$completedBooking]);
     

        }


        public function pendingCusWorks(){

            $pendingBooking=MasterBooking::where('status',0)->where('user_master_iduser_master',Auth::user()->iduser_master)->get();

            return view('booking-history.pending-cus-works',['title'=>'Pending Works','pendingBooking'=>$pendingBooking]);
       
        }

        public function getCothPrice(Request $request){

            $categoryID=$request['categoryID'];

            $getPrice=CategoryPrice::where('main_category_idmain_category',$categoryID)->first();

            return response()->json($getPrice);
        }

        public function saveTempCloth(Request $request){

            $validator = \Validator::make($request->all(), [

                'category' => 'required',
                'qty' => 'required||not_in:0',
            ], [
                'category.required' => 'Category should be provided!',  
                'qty.required' => 'Qty should be provided!',  
                'qty.not_in' => 'Qty should be more than 0!',  
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' =>$validator->errors()]);
    
            }

            if(TempBooking::where('main_category_idmain_category',$request['category'])->where('user_master_iduser_master',Auth::user()->iduser_master)->exists()){
                $updateQty=TempBooking::where('main_category_idmain_category',$request['category'])->where('user_master_iduser_master',Auth::user()->iduser_master)->first();
            
                $updateQty->qty+=$request['qty'];
                $updateQty->save();
            }else{
                $save=new TempBooking();
                $save->qty=$request['qty'];
                $save->status=1;
                $save->main_category_idmain_category=$request['category'];
                $save->user_master_iduser_master=Auth::user()->iduser_master;
                $save->save();
    

            }

            $tableData='';
            $temFIles=TempBooking::where('status',1)->where('user_master_iduser_master',Auth::user()->iduser_master)->orderBy('created_at', 'desc')->get();
            $tableData2="";
            $total=0;
            if (count($temFIles)!=null){
              
                foreach ($temFIles as $temFIle) {
                   
                    $tableData .= "<tr>";
                    $category=MainCategory::find($temFIle->main_category_idmain_category);
                    $tableData .= "<td>". $category->main_category_name . "</td>";
                    $tableData .= "<td>" . $temFIle->qty . "</td>";
                    $price=CategoryPrice::where('main_category_idmain_category',$temFIle->main_category_idmain_category)->first();
                    $tableData .= "<td style='text-align: right'>" . number_format($temFIle->qty*$price->price,2) . "</td>";
                    $total+=$temFIle->qty*$price->price;
                  
                    $tableData .= "<td>";
                    $tableData .= " <p>";
                    $tableData .= "<button type='button' class='btn btn-sm btn-danger  waves-effect waves-light'
                data-toggle='modal' data-id='$temFIle->idtemp_booking' id='deleteId'>";
                    $tableData .= "<i class='fa fa-trash'></i>";
                    $tableData .= "</button>";
                    $tableData .= " </p>";
                    $tableData .= " </td>";

                    $tableData .= "<td>";
                    $tableData .= " <p>";
                    $tableData .= "<button type='button' class='btn btn-sm btn-warning  waves-effect waves-light'
                data-toggle='modal' data-id='$temFIle->idtemp_booking' data-category='$temFIle->main_category_idmain_category' data-qty='$temFIle->qty'  id='uTempID' data-target='#updateCategoryModal'>";
                    $tableData .= "<i class='fa fa-edit'></i>";
                    $tableData .= "</button>";
                    $tableData .= " </p>";
                    $tableData .= " </td>";


                    $tableData2.="<div class='col-lg-4'>";
                    $tableData2.="<p>".$category->main_category_name."</p>";
                    $tableData2.="</div>";
                    $tableData2.="<div class='col-lg-4'>";
                    $tableData2.="<p>".$temFIle->qty.' Qty'."</p>";
                    $tableData2.="</div>";
                    $tableData2.="<div class='col-lg-4'>";
                    $tableData2.="<p style='text-align: right'>".number_format($temFIle->qty*$price->price,2)."</p>";
                    $tableData2.="</div>";  
                }
            }else{
                $tableData .= "<tr>";
                $tableData .= "<td colspan='6' style='text-align: center;font-weight: bold'>" .'Sorry No Results Found.'. "</td>";
                $tableData .= "</tr>";
            }

            if($total==0){
                $tableData2.="<div class='col-lg-12'>";
                $tableData2.="<b style='text-align: center;font-weight: bold;'>".'Sorry No Results Found'."</b>";
                $tableData2.="</div>"; 
                
            }else{
                $tableData2.="<div class='col-lg-4'>";
                $tableData2.="<b>".'Total (Rs)'."</b>";
                $tableData2.="</div>"; 
                $tableData2.="<div class='col-lg-4'>";
              
                $tableData2.="</div>"; 
                $tableData2.="<div class='col-lg-4'>";
                $tableData2.="<p style='text-align: right;font-weight: bold;'>".number_format($total,2)."</p>";
                $tableData2.="</div>"; 
            }
          

         
            return response()->json(['success'=>'Booking added successfully.','tableData'=>$tableData,'tableData2'=>$tableData2]);
        }

        public function tableData(){

            $tableData='';
            $temFIles=TempBooking::where('status',1)->where('user_master_iduser_master',Auth::user()->iduser_master)->orderBy('created_at', 'desc')->get();
            $tableData2="";
            $total=0;
            if (count($temFIles)!=null){
              
                foreach ($temFIles as $temFIle) {
                   
                    $tableData .= "<tr>";
                    $category=MainCategory::find($temFIle->main_category_idmain_category);
                    $tableData .= "<td>". $category->main_category_name . "</td>";
                    $tableData .= "<td>" . $temFIle->qty . "</td>";
                    $price=CategoryPrice::where('main_category_idmain_category',$temFIle->main_category_idmain_category)->first();
                    $tableData .= "<td style='text-align: right'>" . number_format($temFIle->qty*$price->price,2) . "</td>";
                    $total+=$temFIle->qty*$price->price;
                  
                    $tableData .= "<td>";
                    $tableData .= " <p>";
                    $tableData .= "<button type='button' class='btn btn-sm btn-danger  waves-effect waves-light'
                data-toggle='modal' data-id='$temFIle->idtemp_booking' id='deleteId'>";
                    $tableData .= "<i class='fa fa-trash'></i>";
                    $tableData .= "</button>";
                    $tableData .= " </p>";
                    $tableData .= " </td>";

                    $tableData .= "<td>";
                    $tableData .= " <p>";
                    $tableData .= "<button type='button' class='btn btn-sm btn-warning  waves-effect waves-light'
                data-toggle='modal' data-id='$temFIle->idtemp_booking' data-category='$temFIle->main_category_idmain_category' data-qty='$temFIle->qty'  id='uTempID' data-target='#updateCategoryModal'>";
                    $tableData .= "<i class='fa fa-edit'></i>";
                    $tableData .= "</button>";
                    $tableData .= " </p>";
                    $tableData .= " </td>";

                    $tableData2.="<div class='col-lg-4'>";
                    $tableData2.="<p>".$category->main_category_name."</p>";
                    $tableData2.="</div>";
                    $tableData2.="<div class='col-lg-4'>";
                    $tableData2.="<p>".$temFIle->qty.' Qty'."</p>";
                    $tableData2.="</div>";
                    $tableData2.="<div class='col-lg-4'>";
                    $tableData2.="<p style='text-align: right'>".number_format($temFIle->qty*$price->price,2)."</p>";
                    $tableData2.="</div>";  
                }
            }else{
                $tableData .= "<tr>";
                $tableData .= "<td colspan='6' style='text-align: center;font-weight: bold'>" .'Sorry No Results Found.'. "</td>";
                $tableData .= "</tr>";
            }

            if($total==0){
                $tableData2.="<div class='col-lg-12'>";
                $tableData2.="<b style='text-align: center;font-weight: bold;'>".'Sorry No Results Found'."</b>";
                $tableData2.="</div>"; 
                
            }else{
                $tableData2.="<div class='col-lg-4'>";
                $tableData2.="<b>".'Total (Rs)'."</b>";
                $tableData2.="</div>"; 
                $tableData2.="<div class='col-lg-4'>";
              
                $tableData2.="</div>"; 
                $tableData2.="<div class='col-lg-4'>";
                $tableData2.="<p style='text-align: right;font-weight: bold;'>".number_format($total,2)."</p>";
                $tableData2.="</div>"; 
            }
          

            return response()->json(['total'=>$total,'tableData'=>$tableData,'tableData2'=>$tableData2,'total'=>$total]);
        }

        public function deleteTempBooking(Request $request){

            $tempId=$request['tempId'];

            $delete=TempBooking::find($tempId);
            if($delete!=null){
                $delete->delete();
            }


            $tableData='';
            $temFIles=TempBooking::where('status',1)->where('user_master_iduser_master',Auth::user()->iduser_master)->orderBy('created_at', 'desc')->get();
            $tableData2="";
            $total=0;
            if (count($temFIles)!=null){
              
                foreach ($temFIles as $temFIle) {
                   
                    $tableData .= "<tr>";
                    $category=MainCategory::find($temFIle->main_category_idmain_category);
                    $tableData .= "<td>". $category->main_category_name . "</td>";
                    $tableData .= "<td>" . $temFIle->qty . "</td>";
                    $price=CategoryPrice::where('main_category_idmain_category',$temFIle->main_category_idmain_category)->first();
                    $tableData .= "<td style='text-align: right'>" . number_format($temFIle->qty*$price->price,2) . "</td>";
                    $total+=$temFIle->qty*$price->price;
                  
                    $tableData .= "<td>";
                    $tableData .= " <p>";
                    $tableData .= "<button type='button' class='btn btn-sm btn-danger  waves-effect waves-light'
                data-toggle='modal' data-id='$temFIle->idtemp_booking' id='deleteId'>";
                    $tableData .= "<i class='fa fa-trash'></i>";
                    $tableData .= "</button>";
                    $tableData .= " </p>";
                    $tableData .= " </td>";

                    $tableData .= "<td>";
                    $tableData .= " <p>";
                    $tableData .= "<button type='button' class='btn btn-sm btn-warning  waves-effect waves-light'
                data-toggle='modal' data-id='$temFIle->idtemp_booking' data-category='$temFIle->main_category_idmain_category' data-qty='$temFIle->qty'  id='uTempID' data-target='#updateCategoryModal'>";
                    $tableData .= "<i class='fa fa-edit'></i>";
                    $tableData .= "</button>";
                    $tableData .= " </p>";
                    $tableData .= " </td>";


                    $tableData2.="<div class='col-lg-4'>";
                    $tableData2.="<p>".$category->main_category_name."</p>";
                    $tableData2.="</div>";
                    $tableData2.="<div class='col-lg-4'>";
                    $tableData2.="<p>".$temFIle->qty.' Qty'."</p>";
                    $tableData2.="</div>";
                    $tableData2.="<div class='col-lg-4'>";
                    $tableData2.="<p style='text-align: right'>".number_format($temFIle->qty*$price->price,2)."</p>";
                    $tableData2.="</div>";  
                }
            }else{
                $tableData .= "<tr>";
                $tableData .= "<td colspan='6' style='text-align: center;font-weight: bold'>" .'Sorry No Results Found.'. "</td>";
                $tableData .= "</tr>";
            }

            if($total==0){
                $tableData2.="<div class='col-lg-12'>";
                $tableData2.="<b style='text-align: center;font-weight: bold;'>".'Sorry No Results Found'."</b>";
                $tableData2.="</div>"; 
                
            }else{
                $tableData2.="<div class='col-lg-4'>";
                $tableData2.="<b>".'Total (Rs)'."</b>";
                $tableData2.="</div>"; 
                $tableData2.="<div class='col-lg-4'>";
              
                $tableData2.="</div>"; 
                $tableData2.="<div class='col-lg-4'>";
                $tableData2.="<p style='text-align: right;font-weight: bold;'>".number_format($total,2)."</p>";
                $tableData2.="</div>"; 
            }
          

          
            return response()->json(['total'=>$total,'success'=>'Booking deleted successfully.','tableData'=>$tableData,'tableData2'=>$tableData2]);
        }



        public function editTempBooking(Request $request){

            $validator = \Validator::make($request->all(), [

                'uCategory' => 'required',
                'uQty' => 'required||not_in:0',
            ], [
                'uCategory.required' => 'Category should be provided!',  
                'uQty.required' => 'Qty should be provided!',  
                'uQty.not_in' => 'Qty should be more than 0!',  
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' =>$validator->errors()]);
    
            }

           
            if(TempBooking::where('main_category_idmain_category',$request['uCategory'])->where('user_master_iduser_master',Auth::user()->iduser_master)->exists()){
                $updateQty=TempBooking::find($request['hiddenTempId']);
                $updateQty->qty+=$request['uQty'];
                $updateQty->save();
            }

            $tableData='';
            $temFIles=TempBooking::where('status',1)->where('user_master_iduser_master',Auth::user()->iduser_master)->orderBy('created_at', 'desc')->get();
            $tableData2="";
            $total=0;
            if (count($temFIles)!=null){
              
                foreach ($temFIles as $temFIle) {
                   
                    $tableData .= "<tr>";
                    $category=MainCategory::find($temFIle->main_category_idmain_category);
                    $tableData .= "<td>". $category->main_category_name . "</td>";
                    $tableData .= "<td>" . $temFIle->qty . "</td>";
                    $price=CategoryPrice::where('main_category_idmain_category',$temFIle->main_category_idmain_category)->first();
                    $tableData .= "<td style='text-align: right'>" . number_format($temFIle->qty*$price->price,2) . "</td>";
                    $total+=$temFIle->qty*$price->price;
                  
                    $tableData .= "<td>";
                    $tableData .= " <p>";
                    $tableData .= "<button type='button' class='btn btn-sm btn-danger  waves-effect waves-light'
                data-toggle='modal' data-id='$temFIle->idtemp_booking' id='deleteId'>";
                    $tableData .= "<i class='fa fa-trash'></i>";
                    $tableData .= "</button>";
                    $tableData .= " </p>";
                    $tableData .= " </td>";

                    $tableData .= "<td>";
                    $tableData .= " <p>";
                    $tableData .= "<button type='button' class='btn btn-sm btn-warning  waves-effect waves-light'
                data-toggle='modal' data-id='$temFIle->idtemp_booking' data-category='$temFIle->main_category_idmain_category' data-qty='$temFIle->qty'  id='uTempID' data-target='#updateCategoryModal'>";
                    $tableData .= "<i class='fa fa-edit'></i>";
                    $tableData .= "</button>";
                    $tableData .= " </p>";
                    $tableData .= " </td>";


                    $tableData2.="<div class='col-lg-4'>";
                    $tableData2.="<p>".$category->main_category_name."</p>";
                    $tableData2.="</div>";
                    $tableData2.="<div class='col-lg-4'>";
                    $tableData2.="<p>".$temFIle->qty.' Qty'."</p>";
                    $tableData2.="</div>";
                    $tableData2.="<div class='col-lg-4'>";
                    $tableData2.="<p style='text-align: right'>".number_format($temFIle->qty*$price->price,2)."</p>";
                    $tableData2.="</div>";  
                }
            }else{
                $tableData .= "<tr>";
                $tableData .= "<td colspan='6' style='text-align: center;font-weight: bold'>" .'Sorry No Results Found.'. "</td>";
                $tableData .= "</tr>";
            }

            if($total==0){
                $tableData2.="<div class='col-lg-12'>";
                $tableData2.="<b style='text-align: center;font-weight: bold;'>".'Sorry No Results Found'."</b>";
                $tableData2.="</div>"; 
                
            }else{
                $tableData2.="<div class='col-lg-4'>";
                $tableData2.="<b>".'Total (Rs)'."</b>";
                $tableData2.="</div>"; 
                $tableData2.="<div class='col-lg-4'>";
              
                $tableData2.="</div>"; 
                $tableData2.="<div class='col-lg-4'>";
                $tableData2.="<p style='text-align: right;font-weight: bold;'>".number_format($total,2)."</p>";
                $tableData2.="</div>"; 
            }
          

         
            return response()->json(['success'=>'Booking edit successfully.','tableData'=>$tableData,'tableData2'=>$tableData2]);
       

        }

        public function saveBooking(Request $request){

            

            $validator = \Validator::make($request->all(), [

                'payment' => 'required',
               
            ], [
                'payment.required' => 'Payment Type should be provided!',  
               
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' =>$validator->errors()]);
            }

          
            $temFIles=TempBooking::where('status',1)->where('user_master_iduser_master',Auth::user()->iduser_master)->orderBy('created_at', 'desc')->get();
            $total=0;

            foreach ($temFIles as $temFIle) {
            $price=CategoryPrice::where('main_category_idmain_category',$temFIle->main_category_idmain_category)->first();                  
            $total+=$temFIle->qty*$price->price;
            } 


            $save=new MasterBooking();
            $save->total=$total;
            $save->status=0;
            $save->user_master_iduser_master=Auth::user()->iduser_master;
            $save->payment_type=$request['payment'];
            $save->save();

            $tempBooking=TempBooking::where('status',1)->where('user_master_iduser_master',Auth::user()->iduser_master)->orderBy('created_at', 'desc')->get();
            
            foreach($tempBooking as $temp){
                $saveBooking=new BookingReg();
                $saveBooking->status=1;
                $saveBooking->qty=$temp->qty;
                $saveBooking->main_category_idmain_category=$temp->main_category_idmain_category;
                $saveBooking->master_booking_idmaster_booking= $save->idmaster_booking;
                $saveBooking->save();
    
                $temp->delete();
            }



            $tableData='';
            $temFIles=TempBooking::where('status',1)->where('user_master_iduser_master',Auth::user()->iduser_master)->orderBy('created_at', 'desc')->get();
            $tableData2="";
            $total=0;
            if (count($temFIles)!=null){
              
                foreach ($temFIles as $temFIle) {
                   
                    $tableData .= "<tr>";
                    $category=MainCategory::find($temFIle->main_category_idmain_category);
                    $tableData .= "<td>". $category->main_category_name . "</td>";
                    $tableData .= "<td>" . $temFIle->qty . "</td>";
                    $price=CategoryPrice::where('main_category_idmain_category',$temFIle->main_category_idmain_category)->first();
                    $tableData .= "<td style='text-align: right'>" . number_format($temFIle->qty*$price->price,2) . "</td>";
                    $total+=$temFIle->qty*$price->price;
                  
                    $tableData .= "<td>";
                    $tableData .= " <p>";
                    $tableData .= "<button type='button' class='btn btn-sm btn-danger  waves-effect waves-light'
                data-toggle='modal' data-id='$temFIle->idtemp_booking' id='deleteId'>";
                    $tableData .= "<i class='fa fa-trash'></i>";
                    $tableData .= "</button>";
                    $tableData .= " </p>";
                    $tableData .= " </td>";

                    $tableData .= "<td>";
                    $tableData .= " <p>";
                    $tableData .= "<button type='button' class='btn btn-sm btn-warning  waves-effect waves-light'
                data-toggle='modal' data-id='$temFIle->idtemp_booking' data-category='$temFIle->main_category_idmain_category' data-qty='$temFIle->qty'  id='uTempID' data-target='#updateCategoryModal'>";
                    $tableData .= "<i class='fa fa-edit'></i>";
                    $tableData .= "</button>";
                    $tableData .= " </p>";
                    $tableData .= " </td>";


                    $tableData2.="<div class='col-lg-4'>";
                    $tableData2.="<p>".$category->main_category_name."</p>";
                    $tableData2.="</div>";
                    $tableData2.="<div class='col-lg-4'>";
                    $tableData2.="<p>".$temFIle->qty.' Qty'."</p>";
                    $tableData2.="</div>";
                    $tableData2.="<div class='col-lg-4'>";
                    $tableData2.="<p style='text-align: right'>".number_format($temFIle->qty*$price->price,2)."</p>";
                    $tableData2.="</div>";  
                }
            }else{
                $tableData .= "<tr>";
                $tableData .= "<td colspan='6' style='text-align: center;font-weight: bold'>" .'Sorry No Results Found.'. "</td>";
                $tableData .= "</tr>";
            }

            if($total==0){
                $tableData2.="<div class='col-lg-12'>";
                $tableData2.="<b style='text-align: center;font-weight: bold;'>".'Sorry No Results Found'."</b>";
                $tableData2.="</div>"; 
                
            }else{
                $tableData2.="<div class='col-lg-4'>";
                $tableData2.="<b>".'Total (Rs)'."</b>";
                $tableData2.="</div>"; 
                $tableData2.="<div class='col-lg-4'>";
              
                $tableData2.="</div>"; 
                $tableData2.="<div class='col-lg-4'>";
                $tableData2.="<p style='text-align: right;font-weight: bold;'>".number_format($total,2)."</p>";
                $tableData2.="</div>"; 
            }
          

            $userId=Auth::user()->iduser_master;
            $sendMail=User::find($userId);
            $orderId=$save->idmaster_booking;

            Mail::to($sendMail->email)->send(new PendingOrder($orderId));
         
            return response()->json(['success'=>'Booking saved successfully.','tableData'=>$tableData,'tableData2'=>$tableData2,'total'=>$total]);
       


        }

}