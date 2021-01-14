<?php


namespace App\Http\Controllers;

use App\BookingReg;
use App\Category;
use App\CategoryPrice;
use App\Invoice;
use App\ItemInvReg;
use Carbon\Carbon;
use App\ItemInvTemp;
use App\MainCategory;
use App\MasterBooking;
use App\Payment;
use App\Product;
use App\Stock;
use App\TempBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{

    public function invoiceHistoryIndex(){

        $invoiceDetails=Invoice::where('status',1)->latest()->get();

        
        return view('invoice.invoice-history',['title'=>'Invoice History','invoiceDetails'=>$invoiceDetails]);
    }

    public function tableInvoiceData(Request $request){

        $tableData='';
        $temFIles=ItemInvTemp::where('status',1)->where('user_master_iduser_master',Auth::user()->iduser_master)->orderBy('created_at', 'desc')->get();
        $tableData2="";
        $total=0;
        $tempItem=1;

       
        $availableQty=0;

        if (count($temFIles)!=null){
          
            foreach ($temFIles as $temFIle) {
               
                
                $tableData .= "<tr>";
                $product=Product::find($temFIle->product_idproduct);
                $category=Category::find($product->category_idcategory);
                $tableData .= "<td>". $category->category_name . "</td>";
                $tableData .= "<td>". $product->product_name . "</td>";
                $tableData .= "<td>" . $temFIle->qty . "</td>";
            
                $tableData .= "<td>";
                $tableData .= " <p>";
                $tableData .= "<button type='button' class='btn btn-sm btn-danger  waves-effect waves-light'
            data-toggle='modal' data-id='$temFIle->iditem_inv_temp' id='deleteId'>";
                $tableData .= "<i class='fa fa-trash'></i>";
                $tableData .= "</button>";
                $tableData .= " </p>";
                $tableData .= " </td>";

                $tableData .= "<td>";
                $tableData .= " <p>";
                $tableData .= "<button type='button' class='btn btn-sm btn-warning  waves-effect waves-light'
            data-toggle='modal' data-id='$temFIle->iditem_inv_temp' data-category='$temFIle->product_idproduct' data-qty='$temFIle->qty'  id='uTempID' data-target='#updateCategoryModal'>";
                $tableData .= "<i class='fa fa-edit'></i>";
                $tableData .= "</button>";
                $tableData .= " </p>";
                $tableData .= " </td>";


    
            }
        }else{
            $tableData .= "<tr>";
            $tableData .= "<td colspan='6' style='text-align: center;font-weight: bold'>" .'Sorry No Results Found.'. "</td>";
            $tempItem=0;
            $tableData .= "</tr>";
        }


        $paymentStatus=MasterBooking::find($request['idOrder']);
        $temFIles=BookingReg::where('status',1)->where('master_booking_idmaster_booking',$request['idOrder'])->orderBy('created_at', 'desc')->get();
           
       
        foreach($temFIles as $temFIle){

            $tableData2.="<div class='col-lg-4'>";
            $category=MainCategory::find($temFIle->main_category_idmain_category);
            $tableData2.="<p>".$category->main_category_name."</p>";
            $tableData2.="</div>";
            $tableData2.="<div class='col-lg-4'>";
            $tableData2.="<p>".$temFIle->qty.' Qty'."</p>";
            $tableData2.="</div>";
            $tableData2.="<div class='col-lg-4'>";
            $price=CategoryPrice::where('main_category_idmain_category',$temFIle->main_category_idmain_category)->first();
            $total+=$temFIle->qty*$price->price;    
            $tableData2.="<p style='text-align: right'>".number_format($temFIle->qty*$price->price,2)."</p>";
            $tableData2.="</div>";  

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

        return response()->json(['total'=>$total,'success'=>'Booking deleted successfully.','tableData'=>$tableData,'tableData2'=>$tableData2,'tempItem'=>$tempItem,]);
    
      
    }

    public function saveTempProduct(Request $request){

        $product=$request['product'];
        $qty=$request['qty'];

        $validator = \Validator::make($request->all(), [

            'product' => 'required',
            'qty' => 'required||not_in:0',
        ], [
            'product.required' => 'Product should be provided!',  
            'qty.required' => 'Qty should be provided!',  
            'qty.not_in' => 'Qty should be more than 0!',  
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' =>$validator->errors()]);

        }

        if(ItemInvTemp::where('product_idproduct',$request['product'])->where('user_master_iduser_master',Auth::user()->iduser_master)->exists()){
            $updateQty=ItemInvTemp::where('product_idproduct',$request['product'])->where('user_master_iduser_master',Auth::user()->iduser_master)->first();
        
            $updateQty->qty+=$request['qty'];
            $updateQty->save();
        }else{
        $save=new ItemInvTemp();
        $save->qty=$qty;
        $save->status=1;
        $save->product_idproduct=$product;
        $save->user_master_iduser_master=Auth::user()->iduser_master;
        $save->save();
        }
        return \response()->json(['success'=>'Item saved successfully']);
    }



    public function deleteTempInv(Request $request){

        $tempId=$request['tempId'];

        $deleteItem=ItemInvTemp::find($tempId);

        if($deleteItem!=null){
            $deleteItem->delete();
            return \response()->json(['success'=>'Item deleted successfully']);
        }

    }

    public function editTempInvItem(Request $request){

        $product=$request['uProduct'];
        $qty=$request['uQty'];

        $validator = \Validator::make($request->all(), [

            'uProduct' => 'required',
            'uQty' => 'required||not_in:0',
        ], [
            'uProduct.required' => 'Product should be provided!',  
            'uQty.required' => 'Qty should be provided!',  
            'uQty.not_in' => 'Qty should be more than 0!',  
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' =>$validator->errors()]);
        }

     

        $update=ItemInvTemp::find($request['hiddenTempId']);
        $update->qty=$qty;
        $update->status=1;
        $update->product_idproduct=$product;
        $update->user_master_iduser_master=Auth::user()->iduser_master;
        $update->save();
       
        return \response()->json(['success'=>'Item updated successfully']);
    }
    
    public function saveInvoice(Request $request){

        $paymentAmount=$request['paymentAmount'];

        $bookingDetail=MasterBooking::find($request['idOrder']);
        $systemDate = Carbon::now()->format('y/m/d');

        if($bookingDetail->payment_type=='CASH'){
            $validator = \Validator::make($request->all(), [

                'paymentAmount' => 'required',
               
            ], [
                'paymentAmount.required' => 'Payment Amount should be provided!',
               
            ]);
    
            if ($validator->fails()) {
                return response()->json(['errors' =>$validator->errors()]);
    
            }
        }

        if($paymentAmount<$bookingDetail->total){
            return response()->json(['errorsAmount' =>'Paid Amount must be eqal to total cost']);
        }
    
        $save=new Invoice();
        $save->invoice_total=$bookingDetail->total;
        $save->customer=$bookingDetail->user_master_iduser_master;
        $save->date=$systemDate;
        $save->status=1;
        if($paymentAmount!=null){
            $save->balance=$paymentAmount-$bookingDetail->total;
        }
      
        $save->payment_type=$bookingDetail->payment_type;

        if($bookingDetail->payment_type=='CASH'){
            $save->paid=$paymentAmount;
        }else{
            $save->paid=$bookingDetail->total;
        }
        $save->save();


        $booking=MasterBooking::find($request['idOrder']);
        $booking->status=2;
        $booking->save();

        $items=ItemInvTemp::where('user_master_iduser_master',Auth::user()->iduser_master)->get();
        
        foreach($items as $item){
            $saveItem=new ItemInvReg();
            $saveItem->qty=$item->qty;
            $saveItem->status=1;
            $saveItem->product_idproduct=$item->product_idproduct;
            $saveItem->invoice_idinvoice=$save->idinvoice;
            $saveItem->save();

            $stock=Stock::where('status',1)->where('product_idproduct',$item->product_idproduct)->first();

            if($stock->qty_available==1){
                $stock->qty_available=0;
                $stock->status=0;
                $stock->save();
            }else if($item->qty-$stock->qty_available==0){
                $stock->qty_available=0;
                $stock->status=0;
                $stock->save();
            }else{
                $stock->qty_available-=$item->qty;
                $stock->save(); 
            }

            $item->delete();
        }
        
        $savePayment=new Payment();
        $savePayment->base=2;
        $savePayment->id=$save->idinvoice;
        $savePayment->totalAmount=$bookingDetail->total;
        if($bookingDetail->payment_type=='CASH'){
            $savePayment->cash=$paymentAmount;
        }else{
            $savePayment->bank=$bookingDetail->total;
        }
        $savePayment->status=1;
        $savePayment->save();


        return \response()->json(['success'=>'Invoice saved successfully']);
    }


    public function getInvoiceItems(Request $request){

        $invId = $request['invId'];

        $getItemDetails = ItemInvReg::where('invoice_idinvoice', $invId)->orderBy('created_at', 'desc')->where('status', 1)->get();
        $tableData = '';

        foreach ($getItemDetails as $getItemDetail) {
            $tableData .= "<tr>";
            $tableData .= "<td>" . $getItemDetail->Product->product_name . "</td>";
            $tableData .= "<td >" . number_format($getItemDetail->qty, 2) . "</td>";
            $tableData .= "</tr>";
        }
        return response()->json(['tableData' => $tableData]);
    }

}