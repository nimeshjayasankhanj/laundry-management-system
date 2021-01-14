@include('includes/header_start')

<link href="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
<!-- Responsive datatable examples -->
<link href="{{ URL::asset('assets/plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css">

<!-- Plugins css -->
<link href="{{ URL::asset('assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet"/>
<link href="{{ URL::asset('assets/css/custom_checkbox.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/css/jquery.notify.css')}}" rel="stylesheet" type="text/css">

<meta name="csrf-token" content="{{ csrf_token() }}"/>


@include('includes/header_end')

<!-- Page title -->
<ul class="list-inline menu-left mb-0">
    <li class="list-inline-item">
        <button type="button" class="button-menu-mobile open-left waves-effect">
            <i class="ion-navicon"></i>
        </button>
    </li>
    <li class="hide-phone list-inline-item app-search">
        <h3 class="page-title">{{$title}}</h3>
    </li>
</ul>

<div class="clearfix"></div>
</nav>

</div>
<!-- Top Bar End -->

<!-- ==================
     PAGE CONTENT START
     ================== -->

<div class="page-content-wrapper">

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <div class="card m-b-20">
                    <form class="" method="post" enctype="multipart/form-data"
                    action="{{ route('saveTempProduct') }}" id="temProductId">
                    <input type="hidden" id="idOrder" value="{{$idOrder}}" name="idOrder"
                    {{csrf_field()}}
                    <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Products<span style="color: red"> *</span></label>
                                        <select class="form-control select2 tab" name="product" onchange="getAvailableQty(this.value)"
                                        id="product" >
                                    <option value="" disabled selected>Select Product
                                    </option>
                                    @if(isset($items))
                                        @foreach($items as $item)
                                            <option value="{{"$item->idproduct"}}">{{$item->product_name}} </option>
                                        @endforeach
                                    @endif
                                </select>
                                <small class="text-danger" id="productError"></small>
                            </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Available Qty</label>
            
                                        <input type="number" class="form-control" name="availableQty" id="availableQty" disabled
                                               placeholder="0.00"/>
                                        
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Qty<span style="color: red"> *</span></label>
            
                                        <input type="number" class="form-control" name="qty" id="qty"
                                               placeholder="0.00"/>
                                        <small class="text-danger" id="qtyError"></small>
                                    </div>
                                </div>
                            </div>

                        </form> 
                            <div class="row">
                                <div class="col-lg-3">
                                    <button type="submit" class="btn btn-primary"
                                    >
                                 Add Item</button>
                             </form>
                                </div>
                            </div>

                                <br>
                            <div class="table-rep-plugin">
                                <div class="table-responsive b-0" data-pattern="priority-columns">
                                    <table id=""  class="table table-striped table-bordered data-table"
                                            cellspacing="0"
                                            width="100%">
                                        <thead>
                                        <tr>
                                            <th>CATEGORY</th>
                                            <th>PRODUCT</th>
                                            <th>QTY</th>
                                            <th>DELETE</th>
                                            <th>EDIT</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                         
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                                  
                            
                            <div class="row" id="bookingButton" >

                                
                                <div class="col-lg-4">
                                 @if($paymentStatus->payment_type=='CASH')
                                    <button type="button"   data-toggle="modal"  data-target="#paymentModal" class="btn btn-primary" id="saveBookingBtn"
                                    >
                                 Save Invoice</button>
                                
                                 @else
                                    <button type="button" onclick="saveInvoice()"  class="btn btn-primary" id="saveBookingBtn"
                                    >
                                Save Invoice</button>
                                @endif
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card m-b-20">
                    <div class="card-body">
                       <div class="row">
                            <div class="col-lg-12">
                                <img src="{{ URL::asset('assets/images/Royal Laundry.png')}}" style=" display: block;
                                margin-left: auto;
                                margin-right: auto;"
                                height="70" alt="logo"> 
                            </div>
                       </div>

                       <p style="text-align: center">No 46/2,Kerawalapitiya Road,Hendala,Wattala</p>
                       <hr>
                       <div class="row" id="priceArea">

                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- container -->

</div> <!-- Page content Wrapper -->

</div> <!-- content -->



<!--paymentModal-->
<div class="modal fade" id="paymentModal" tabindex="-1"
     role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Save Invoice</h5>
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">×
                </button>
            </div>
            <div class="modal-body">
                
                <div class="form-group">
                            <label for="example-text-input" class="col-form-label">Paid Amount<span style="color: red"> *</span></label>

                            <input type="text" class="form-control" name="paymentAmount" id="paymentAmount" required
                                   placeholder="0.00"/>
                            <span id="paymentAmountError" style="color: red"></span>
                        </div>
                <button type="button" class="btn btn-primary waves-effect "
                        onclick="saveInvoice()" >
                    Save Invoice</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!--update modal-->

<div class="modal fade" id="updateCategoryModal" tabindex="-1"
     role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Edit Booking</h5>
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">×
                </button>
            </div>
            <div class="modal-body">
                <form class="" method="post" enctype="multipart/form-data"
                action="{{ route('editTempInvItem') }}" id="editTempItemId">
                {{csrf_field()}}
                

              
                    <div class="form-group">
                        <label for="example-text-input" class="col-form-label">Products<span style="color: red"> *</span></label>
                        <select class="form-control select2 tab" name="uProduct" onchange="getAvailableQty(this.value)"
                        id="uProduct" >
                    <option value="" disabled selected>Select Product
                    </option>
                    @if(isset($items))
                        @foreach($items as $item)
                            <option value="{{"$item->idproduct"}}">{{$item->product_name}} </option>
                        @endforeach
                    @endif
                </select>
                <small class="text-danger" id="uProductError"></small>
                    </div>

            <div class="form-group">
                <label for="example-text-input" class="col-form-label">Qty<span style="color: red"> *</span></label>
        
                <input type="number" class="form-control" name="uQty" id="uQty"
                       placeholder="0.00"/>
                <small class="text-danger" id="uQtyError"></small>
            </div>

                <input type="hidden" id="hiddenTempId" name="hiddenTempId">
                <button type="submit" class="btn btn-warning"
                       >
                    Update Item</button>
                </form>
            </div>
        </div>
    </div>
</div>

@include('includes/footer_start')

<!-- Plugins js -->
<script src="{{ URL::asset('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js')}}"
        type="text/javascript"></script>

<!-- Plugins Init js -->
<script src="{{ URL::asset('assets/pages/form-advanced.js')}}"></script>

<!-- Required datatable js -->
<script src="{{ URL::asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
<!-- Buttons examples -->
<script src="{{ URL::asset('assets/plugins/datatables/dataTables.buttons.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.bootstrap4.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/jszip.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/pdfmake.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/vfs_fonts.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.html5.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.print.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.colVis.min.js')}}"></script>
<!-- Responsive examples -->
<script src="{{ URL::asset('assets/plugins/datatables/dataTables.responsive.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/responsive.bootstrap4.min.js')}}"></script>

<script src="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.js')}}"></script>
<script src="{{ URL::asset('assets/pages/sweet-alert.init.js')}}"></script>

<!-- Datatable init js -->
<script src="{{ URL::asset('assets/pages/datatables.init.js')}}"></script>

<!-- Parsley js -->
<script type="text/javascript" src="{{ URL::asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/bootstrap-notify.js')}}"></script>
<script src="{{ URL::asset('assets/js/jquery.notify.min.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('form').parsley();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        tableData();
    });
    $(document).on("wheel", "input[type=number]", function (e) {
        $(this).blur();
    });
    function adMethod(dataID, tableName) {

        $.post('changeStatus', {id: dataID, table: tableName}, function (data) {

        });
    }
    $('.modal').on('hidden.bs.modal', function () {


        $("#categoryError").html('');
        $("#uCategoryError").html('');
        $("#paymentAmountError").html('');
        $("#cPriceError").html('');
        $("#cPriceError").html('');
      
    });

   

    function getAvailableQty(itemId){

        $.post('getAvailableQty',{
            itemId:itemId
        },function(data){
            console.log(data)
            if(data!=null){
                $("#availableQty").val(data);
            }
               
        })
    }

    function tableData(){

        var idOrder=$("#idOrder").val();

        $.post('tableInvoiceData',{
            idOrder:idOrder
        },function(data){
            
            if(data.tempItem==0){
                $("#saveBookingBtn").hide();
               
            }else{
                $("#saveBookingBtn").show();
               
            }
            
            $("tbody").html(data.tableData);
            $("#availableQty").val('');
            $("#priceArea").html(data.tableData2)
        })
    }
    

    //save temo booking
    $("#temProductId").on("submit", function (event) {
              
              $("#productError").html('');
              $("#qtyError").html('');

              event.preventDefault();

                  $.ajax({
                      url: '{{route('saveTempInvProduct')}}',
                      type: 'POST',
                      data: $(this).serialize(),
                      success: function (data) {
                         
                          if (data.errors != null) {
                              if(data.errors.product) {
                                  var p = document.getElementById('productError');
                                  p.innerHTML = data.errors.product[0];
                              }
                              if(data.errors.qty) {
                                  var p = document.getElementById('qtyError');
                                  p.innerHTML = data.errors.qty[0];
                              }
                          }
                          if (data.success != null) {
                              notify({
                              type: "success", //alert | success | error | warning | info
                              title: 'ITEM SAVED',
                              autoHide: true, //true | false
                              delay: 2500, //number ms
                              position: {
                                  x: "right",
                                  y: "top"
                              },
                              icon: '<img src="{{ URL::asset('assets/images/correct.png')}}" />',
                              message: data.success,
                              });
                              $("#product").val('').trigger('change');
                              $("#qty").val('');
                              $("#availableQty").val('');
                              tableData();

                          }
                      } 
                  });
              }
          );

    
          
        //set edit values
          $(document).on('click', '#uTempID', function () {
            var itemId = $(this).data("id");
            var categoryQty = $(this).data("qty");
            var category = $(this).data("category");

            $("#uProduct").val(category).trigger('change');
            $("#hiddenTempId").val(itemId);
            $("#uQty").val(categoryQty);
            });
            
            

    //delete temp booking      
    $(document).on('click', '#deleteId', function () {
        var tempId = $(this).data("id");
        
        $.post('deleteTempInv',{
            tempId:tempId
        },function(data){
            if (data.success != null) {
                              notify({
                              type: "success", //alert | success | error | warning | info
                              title: 'ITEM DELETED',
                              autoHide: true, //true | false
                              delay: 2500, //number ms
                              position: {
                                  x: "right",
                                  y: "top"
                              },
                              icon: '<img src="{{ URL::asset('assets/images/correct.png')}}" />',
                              message: data.success,
                              });
                              tableData();
                          }
        })
    });


    //edit temp booking
    $("#editTempItemId").on("submit", function (event) {
              
              $("#uProductError").html('');
              $("#uQtyError").html('');

              event.preventDefault();

                  $.ajax({
                      url: '{{route('editTempInvItem')}}',
                      type: 'POST',
                      data: $(this).serialize(),
                      success: function (data) {

                        console.log(data)
                          if (data.errors != null) {
                            if(data.errors.uProduct) {
                                  var p = document.getElementById('uProductError');
                                  p.innerHTML = data.errors.uProduct[0];
                              }
                              if(data.errors.uQty) {
                                  var p = document.getElementById('uQtyError');
                                  p.innerHTML = data.errors.uQty[0];
                              }
                             
                          }

                          if (data.success != null) {
                              notify({
                              type: "success", //alert | success | error | warning | info
                              title: 'ITEM UPDATED',
                              autoHide: true, //true | false
                              delay: 2500, //number ms
                              position: {
                                  x: "right",
                                  y: "top"
                              },
                              icon: '<img src="{{ URL::asset('assets/images/correct.png')}}" />',
                              message: data.success,
                              });

                              setTimeout(function () {
                                
                                $('#updateCategoryModal').modal('hide');
                             }, 200);
                             $("#availableQty").val('');
                            tableData();
                          }
                      } 
                  });
              }
          );

    $(document).on('click', '#uCategoryPriceID', function () {
        var categoryId = $(this).data("id");
        var category = $(this).data("category");
        var categoryPrice = $(this).data("price");

        $("#hiddenUCatId").val(categoryId);
        $("#uCategory").val(category).trigger('change');
        $("#uCPrice").val(categoryPrice);

    });


    function saveInvoice(){

        var paymentAmount=$("#paymentAmount").val();
        var idOrder=$("#idOrder").val();

        $.post('saveInvoice',{
           idOrder:idOrder,
           paymentAmount:paymentAmount
        },function(data){

            if(data.errorsAmount){
                if(data.errorsAmount){
                    var p = document.getElementById('paymentAmountError');
                    p.innerHTML = data.errorsAmount;

                }
            }

            if (data.errors != null) {

            if(data.errors.paymentAmount){
                var p = document.getElementById('paymentAmountError');
                p.innerHTML = data.errors.paymentAmount;

                }
            }
            if (data.success != null) {
                              notify({
                              type: "success", //alert | success | error | warning | info
                              title: 'INVOICE SAVED',
                              autoHide: true, //true | false
                              delay: 2500, //number ms
                              position: {
                                  x: "right",
                                  y: "top"
                              },
                              icon: '<img src="{{ URL::asset('assets/images/correct.png')}}" />',
                              message: data.success,
                              });

                             tableData();
                             window.location.href = "invoice-history";
                          }
           
        })
    }

    $(document).ready(function(){
        $( document ).on( 'focus', ':input', function(){
            $( this ).attr( 'autocomplete', 'off' );
        });
    });

</script>


@include('includes/footer_end')