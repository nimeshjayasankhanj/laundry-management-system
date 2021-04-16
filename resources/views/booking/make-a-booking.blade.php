@include('includes/header_start')

<link href="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
    type="text/css" />
<link href="{{ URL::asset('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet"
    type="text/css" />
<!-- Responsive datatable examples -->
<link href="{{ URL::asset('assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet"
    type="text/css" />
<link href="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">

<!-- Plugins css -->
<link href="{{ URL::asset('assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}"
    rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}"
    rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css') }}"
    rel="stylesheet" />
<link href="{{ URL::asset('assets/css/custom_checkbox.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/css/jquery.notify.css') }}" rel="stylesheet" type="text/css">

<meta name="csrf-token" content="{{ csrf_token() }}" />


@include('includes/header_end')

<!-- Page title -->
<ul class="list-inline menu-left mb-0">
    <li class="list-inline-item">
        <button type="button" class="button-menu-mobile open-left waves-effect">
            <i class="ion-navicon"></i>
        </button>
    </li>
    <li class="hide-phone list-inline-item app-search">
        <h3 class="page-title">{{ $title }}</h3>
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
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-5">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input radioBtn" checked type="radio" name="radioBtn"
                                        id="inlineRadio1" onclick="getValue(this.value)" value="normal">
                                    <label class="form-check-label" for="inlineRadio1">Continue Normal Process</label>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input radioBtn" type="radio" name="radioBtn" id="inlineRadio2"
                                        value="weight" onclick="getValue(this.value)">

                                    <label class="form-check-label" for="inlineRadio2">Add Weight Process</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="card m-b-20" id="normalArea">
                    <form class="" method="post" enctype="multipart/form-data" action="{{ route('saveTempCloth') }}"
                        id="temClothId">
                        {{ csrf_field() }}
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Cloth Type<span
                                                style="color: red"> *</span></label>
                                        <select class="form-control select2 tab" name="category"
                                            onchange="getClothPrice(this.value)" id="category">
                                            <option value="" disabled selected>Select Cloth Type
                                            </option>
                                            @if (isset($mainCategories))
                                                @foreach ($mainCategories as $mainCategory)
                                                    <option value="{{ "$mainCategory->idmain_category" }}">
                                                        {{ $mainCategory->main_category_name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <small class="text-danger" id="categoryError"></small>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Price (Per Item)</label>

                                        <input type="number" class="form-control" name="cPrice" id="cPrice" disabled
                                            placeholder="0.00" />

                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Qty Used<span
                                                style="color: red"> *</span></label>

                                        <input type="number" class="form-control" name="qty" id="qty"
                                            placeholder="0.00" />
                                        <small class="text-danger" id="cPriceError"></small>
                                    </div>
                                </div>
                            </div>

                    </form>
                    <div class="row">
                        <div class="col-lg-3">
                            <button type="submit" class="btn btn-primary">
                                Add Cloth</button>

                        </div>
                    </div>

                    <br>
                    <div class="table-rep-plugin">
                        <div class="table-responsive b-0" data-pattern="priority-columns">
                            <table id="" class="table table-striped table-bordered data-table" cellspacing="0"
                                width="100%">
                                <thead>
                                    <tr>
                                        <th>CLOTH NAME</th>
                                        <th>QTY</th>
                                        <th style="text-align: right">TOTAL</th>
                                        <th>DELETE</th>
                                        <th>EDIT</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row" id="bookingPaymentButton">


                        <div class="col-lg-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="exampleRadios" id="paymentType"
                                    value="cash" checked>
                                <label class="form-check-label" for="exampleRadios1">
                                    Cash Payment
                                </label>
                            </div>

                        </div>
                        <div class="col-lg-3">

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="exampleRadios" id="paymentType"
                                    value="card">
                                <label class="form-check-label" for="exampleRadios2">
                                    Card Payment
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="bookingButton" style="margin-top: 20px">
                        @if (\Illuminate\Support\Facades\Auth::user()->user_role_iduser_role == 1)
                            <div class="col-lg-4">
                                <div class="form-group">

                                    <select class="form-control select2 category" name="customer" id="customer">
                                        <option value="" disabled selected>Select Customer
                                        </option>
                                        @if (isset($customers))
                                            @foreach ($customers as $customer)
                                                <option value="{{ "$customer->iduser_master" }}">
                                                    {{ $customer->first_name }} {{ $customer->last_name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <small class="text-danger" id="customerError"></small>
                                </div>
                            </div>
                        @endif
                        <div class="col-lg-4">

                            <button type="button" onclick="saveBooking()" class="btn btn-primary" id="saveBookingBtn">
                                Save Booking</button>

                            <button type="button" class="btn btn-primary" id="waitButton" style="display: none">
                                <i class="fa fa-circle-o-notch fa-spin"></i> Plsease Wait</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>



            <div class="card m-b-20" id="weightArea">
                <form class="" method="post" enctype="multipart/form-data" action="{{ route('saveTempCloth') }}"
                    id="temClothWId">
                    {{ csrf_field() }}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="col-form-label ">Category<span
                                            style="color: red"> *</span></label>
                                    <select class="form-control select2 category" name="category"
                                        onchange="getClothPrice(this.value)" id="category">
                                        <option value="" disabled selected>Select Category
                                        </option>
                                        @if (isset($weightCategories))
                                            @foreach ($weightCategories as $weightCategory)
                                                <option value="{{ "$weightCategory->idmain_category" }}">
                                                    {{ $weightCategory->main_category_name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <small class="text-danger" id="categoryWError"></small>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="example-text-input" class="col-form-label">Price(1 KG)</label>

                                    <input type="number" class="form-control" name="cWPrice" id="cWPrice" disabled
                                        placeholder="0.00" />

                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="example-text-input" class="col-form-label">Qty<span style="color: red">
                                            *</span></label>

                                    <input type="number" class="form-control qty" name="qty" id="qty"
                                        placeholder="0.00" />
                                    <small class="text-danger" id="cPriceWError"></small>
                                </div>
                            </div>
                        </div>

                </form>
                <div class="row">
                    <div class="col-lg-3">
                        <button type="submit" class="btn btn-primary">
                            Add Cloth</button>

                    </div>
                </div>

                <br>
                <div class="table-rep-plugin">
                    <div class="table-responsive b-0" data-pattern="priority-columns">
                        <table id="" class="table table-striped table-bordered data-table" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>CLOTH NAME</th>
                                    <th>QTY</th>
                                    <th style="text-align: right">TOTAL</th>
                                    <th>DELETE</th>
                                    <th>EDIT</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row" id="bookingPaymentWButton">


                    <div class="col-lg-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exampleRadios" id="paymentType"
                                value="cash" checked>
                            <label class="form-check-label" for="exampleRadios1">
                                Cash Payment
                            </label>
                        </div>

                    </div>
                    <div class="col-lg-3">

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exampleRadios" id="paymentType"
                                value="card">
                            <label class="form-check-label" for="exampleRadios2">
                                Card Payment
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row" id="bookingWButton" style="margin-top: 20px">
                    @if (\Illuminate\Support\Facades\Auth::user()->user_role_iduser_role == 1)
                        <div class="col-lg-4">
                            <div class="form-group">

                                <select class="form-control select2 category" name="wCustomer" id="wCustomer">
                                    <option value="" disabled selected>Select Customer
                                    </option>
                                    @if (isset($customers))
                                        @foreach ($customers as $customer)
                                            <option value="{{ "$customer->iduser_master" }}">
                                                {{ $customer->first_name }} {{ $customer->last_name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <small class="text-danger" id="wCustomerError"></small>
                            </div>
                        </div>
                    @endif
                    <div class="col-lg-4">
                        <button type="button" onclick="saveBooking()" class="btn btn-primary" id="saveBookingBtn">
                            Save Booking</button>

                        <button type="button" class="btn btn-primary" id="waitButton" style="display: none">
                            <i class="fa fa-circle-o-notch fa-spin"></i> Plsease Wait</button>
                    </div>
                </div>
            </div>
            </form>
        </div>



    </div>
    <div class="col-lg-4">
        <div class="card m-b-20">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <img src="{{ URL::asset('assets/images/Royal Laundry.png') }}" style=" display: block;
                                margin-left: auto;
                                margin-right: auto;" height="70" alt="logo">
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



<!--update modal-->

<div class="modal fade" id="updateCategoryModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Edit Booking</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                </button>
            </div>
            <div class="modal-body">
                <form class="" method="post" enctype="multipart/form-data" action="{{ route('editTempBooking') }}"
                    id="editTempBookingId">
                    {{ csrf_field() }}


                    <div class="form-group" id="CategoryView">
                        <label for="example-text-input" class="col-form-label">Cloth Types<span style="color: red">
                                *</span></label>
                        <select class="form-control select2 uCategory" name="uCategory" id="uCategory">
                            <option value="" selected>Select Cloth Type
                            </option>
                            @if (isset($mainCategories))
                                @foreach ($mainCategories as $mainCategory)
                                    <option value="{{ "$mainCategory->idmain_category" }}">
                                        {{ $mainCategory->main_category_name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>


                        <small class="text-danger" id="uCategoryError"></small>
                    </div>

                    <div class="form-group" id="CategoryWView">
                        <label for="example-text-input" class="col-form-label">Cloth Types<span style="color: red">
                                *</span></label>
                        <select class="form-control select2 uCategory" name="uCategory" id="uCategory">
                            <option value="" selected>Select Cloth Type
                            </option>
                            @if (isset($weightCategories))
                                @foreach ($weightCategories as $weightCategory)
                                    <option value="{{ "$weightCategory->idmain_category" }}">
                                        {{ $weightCategory->main_category_name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>


                        <small class="text-danger" id="uCategoryError"></small>
                    </div>

                    <div class="form-group">
                        <label for="example-text-input" class="col-form-label">Qty<span style="color: red">
                                *</span></label>

                        <input type="number" class="form-control" name="uQty" id="uQty" placeholder="0.00" />
                        <small class="text-danger" id="uQtyError"></small>
                    </div>

                    <input type="hidden" id="hiddenTempId" name="hiddenTempId">
                    <button type="submit" class="btn btn-warning">
                        Update Booking</button>
                </form>
            </div>
        </div>
    </div>
</div>

@include('includes/footer_start')

<!-- Plugins js -->
<script src="{{ URL::asset('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"
    type="text/javascript">
</script>
<script src="{{ URL::asset('assets/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js') }}"
    type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js') }}"
    type="text/javascript"></script>

<!-- Plugins Init js -->
<script src="{{ URL::asset('assets/pages/form-advanced.js') }}"></script>

<!-- Required datatable js -->
<script src="{{ URL::asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<!-- Buttons examples -->
<script src="{{ URL::asset('assets/plugins/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/jszip.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/pdfmake.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/vfs_fonts.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.html5.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.print.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.colVis.min.js') }}"></script>
<!-- Responsive examples -->
<script src="{{ URL::asset('assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>

<script src="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
<script src="{{ URL::asset('assets/pages/sweet-alert.init.js') }}"></script>

<!-- Datatable init js -->
<script src="{{ URL::asset('assets/pages/datatables.init.js') }}"></script>

<!-- Parsley js -->
<script type="text/javascript" src="{{ URL::asset('assets/plugins/parsleyjs/parsley.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/bootstrap-notify.js') }}"></script>
<script src="{{ URL::asset('assets/js/jquery.notify.min.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('form').parsley();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        getValue('normal');
        tableData();
    });
    $(document).on("wheel", "input[type=number]", function(e) {
        $(this).blur();
    });

    function adMethod(dataID, tableName) {

        $.post('changeStatus', {
            id: dataID,
            table: tableName
        }, function(data) {

        });
    }
    $('.modal').on('hidden.bs.modal', function() {


        $("#categoryError").html('');
        $("#uCategoryError").html('');

        $("#cPriceError").html('');
        $("#cPriceError").html('');
        $('input').val('');
        $(".select2").val('').trigger('change');
    });

    function getClothPrice(categoryID) {

        $.post('getCothPrice', {
            categoryID: categoryID
        }, function(data) {

            var buttonVal = $('input[name="radioBtn"]:checked').val();

            if (buttonVal != 'normal') {
                console.log(data.price)
                $("#cWPrice").val(data.price);
            } else {
                $("#cPrice").val(data.price);
            }



        })
    }

    function tableData() {

        $.post('tableData', {

        }, function(data) {

            if (data.total == 0) {

                $("#bookingButton").hide();
                $("#bookingWButton").hide();
                $("#bookingPaymentButton").hide();
                $("#bookingPaymentWButton").hide();

            } else {

                $("#bookingButton").show();
                $("#bookingWButton").show();
                $("#bookingPaymentButton").show();
                $("#bookingPaymentWButton").show();
            }

            $("tbody").html(data.tableData)
            $("#priceArea").html(data.tableData2)
        })
    }


    function getValue(value) {
       
        if (value == 'normal') {
           
            $("#weightArea").hide();
            $("#normalArea").show();
        } else {
            $("#weightArea").show();
            $("#normalArea").hide();
        }
    }

    //save temo booking
    $("#temClothId").on("submit", function(event) {

        $("#categoryError").html('');
        $("#cPriceError").html('');

        event.preventDefault();

        $.ajax({
            url: '{{ route('saveTempCloth') }}',
            type: 'POST',
            data: $(this).serialize(),
            success: function(data) {

                if (data.errors != null) {
                    if (data.errors.category) {
                        var p = document.getElementById('categoryError');
                        p.innerHTML = data.errors.category[0];
                    }
                    if (data.errors.qty) {
                        var p = document.getElementById('cPriceError');
                        p.innerHTML = data.errors.qty[0];
                    }
                }
                if (data.success != null) {
                    $('#qty').val('');
                    $(".select2").val('').trigger('change');
                    notify({
                        type: "success", //alert | success | error | warning | info
                        title: 'BOOKING SAVED',
                        autoHide: true, //true | false
                        delay: 2500, //number ms
                        position: {
                            x: "right",
                            y: "top"
                        },
                        icon: '<img src="{{ URL::asset('assets/images/correct.png') }}" />',
                        message: data.success,
                    });
                    tableData();
                }
            }
        });
    });




    $("#temClothWId").on("submit", function(event) {

        $("#categoryWError").html('');
        $("#cPriceWError").html('');

        event.preventDefault();

        $.ajax({
            url: '{{ route('saveTempCloth') }}',
            type: 'POST',
            data: $(this).serialize(),
            success: function(data) {

                if (data.errors != null) {
                    if (data.errors.category) {
                        var p = document.getElementById('categoryWError');
                        p.innerHTML = data.errors.category[0];
                    }
                    if (data.errors.qty) {
                        var p = document.getElementById('cPriceWError');
                        p.innerHTML = data.errors.qty[0];
                    }
                }
                if (data.success != null) {
                    notify({
                        type: "success", //alert | success | error | warning | info
                        title: 'BOOKING SAVED',
                        autoHide: true, //true | false
                        delay: 2500, //number ms
                        position: {
                            x: "right",
                            y: "top"
                        },
                        icon: '<img src="{{ URL::asset('assets/images/correct.png') }}" />',
                        message: data.success,
                    });
                    $(".category").val('').trigger('change');
                    $(".qty").val('');
                    tableData();
                }
            }
        });
    });

    //set edit values
    $(document).on('click', '#uTempID', function() {
        var categoryId = $(this).data("id");
        var categoryQty = $(this).data("qty");
        var category = $(this).data("category");

        if (category == 2) {
            $("#CategoryView").hide();
            $("#CategoryWView").show();
            $(".uCategory").val(category).trigger('change');
        } else {
            $("#CategoryWView").hide();
            $("#CategoryView").show();
            $(".uCategory").val(category).trigger('change');
        }

        $("#hiddenTempId").val(categoryId);
        $("#uQty").val(categoryQty);
    });



    //delete temp booking      
    $(document).on('click', '#deleteId', function() {
        var tempId = $(this).data("id");

        $.post('deleteTempBooking', {
            tempId: tempId
        }, function(data) {
            if (data.success != null) {
                notify({
                    type: "success", //alert | success | error | warning | info
                    title: 'BOOKING DELETED',
                    autoHide: true, //true | false
                    delay: 2500, //number ms
                    position: {
                        x: "right",
                        y: "top"
                    },
                    icon: '<img src="{{ URL::asset('assets/images/correct.png') }}" />',
                    message: data.success,
                });
                tableData();
            }
        })
    });


    //edit temp booking
    $("#editTempBookingId").on("submit", function(event) {

        $("#categoryError").html('');
        event.preventDefault();

        $.ajax({
            url: '{{ route('editTempBooking') }}',
            type: 'POST',
            data: $(this).serialize(),
            success: function(data) {


                if (data.errors != null) {
                    if (data.errors.uCategory) {
                        var p = document.getElementById('uCategoryError');
                        p.innerHTML = data.errors.uCategory[0];
                    }
                    if (data.errors.uQty) {
                        var p = document.getElementById('uQtyError');
                        p.innerHTML = data.errors.uQty[0];
                    }

                }

                if (data.success != null) {
                    notify({
                        type: "success", //alert | success | error | warning | info
                        title: 'BOOKING SAVED',
                        autoHide: true, //true | false
                        delay: 2500, //number ms
                        position: {
                            x: "right",
                            y: "top"
                        },
                        icon: '<img src="{{ URL::asset('assets/images/correct.png') }}" />',
                        message: data.success,
                    });

                    setTimeout(function() {

                        $('#updateCategoryModal').modal('hide');
                    }, 200);
                    tableData();
                }
            }
        });
    });

    $(document).on('click', '#uCategoryPriceID', function() {
        var categoryId = $(this).data("id");
        var category = $(this).data("category");
        var categoryPrice = $(this).data("price");

        $("#hiddenUCatId").val(categoryId);
        $("#uCategory").val(category).trigger('change');
        $("#uCPrice").val(categoryPrice);

    });


    function saveBooking() {

        var paymentType = $("#paymentType").val();

        $("#waitButton").show();
        $("#saveBookingBtn").hide();
        $("#saveBookingWBtn").hide();
        $("#customerError").html('');
        $("#wCustomerError").html('');

        var customer = $("#customer").val();
        var wCustomer = $("#wCustomer").val();
        var index = 1;
        var radioButtonValue = $(".radioBtn:checked").val();
        if (paymentType == 'cash') {
            var payment = 1;
        } else {
            var payment = 0;
        }

        $.post('saveBooking', {
            payment: payment,
            index: index,
            customer: customer,
            wCustomer: wCustomer,
            radioButtonValue: radioButtonValue
        }, function(data) {
            console.log(data)
            if (data.errors != null) {
                $("#waitButton").hide();
                $("#saveBookingBtn").show();
                $("#saveBookingWBtn").hide();
                if (data.errors.customer) {
                    var p = document.getElementById('customerError');
                    p.innerHTML = data.errors.customer[0];
                }
                if (data.errors.wCustomer) {
                    var p = document.getElementById('wCustomerError');
                    p.innerHTML = data.errors.wCustomer[0];
                }

            }

            if (data.success != null) {
                notify({
                    type: "success", //alert | success | error | warning | info
                    title: 'BOOKING SAVED',
                    autoHide: true, //true | false
                    delay: 2500, //number ms
                    position: {
                        x: "right",
                        y: "top"
                    },
                    icon: '<img src="{{ URL::asset('assets/images/correct.png') }}" />',
                    message: data.success,
                });

                $("#waitButton").hide();
                $("#saveBookingBtn").show();
                $("#saveBookingWBtn").hide();

                tableData();
            }

        })
    }

    $(document).ready(function() {
        $(document).on('focus', ':input', function() {
            $(this).attr('autocomplete', 'off');
        });
    });

</script>


@include('includes/footer_end')
