@include('includes/header_start')

<!--Morris Chart CSS -->
<link rel="stylesheet" href="assets/plugins/morris/morris.css">
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
        <h3 class="page-title">Dashboard</h3>
    </li>
</ul>

<div class="clearfix"></div>
</nav>

</div>
<!-- Top Bar End -->

<!-- ==================
                         PAGE CONTENT START
                         ================== -->

<style>
    #area-chart,
    #line-chart,
    #bar-chart,
    #stacked,
    #pie-chart {
        min-height: 250px;
    }

</style>
<div class="page-content-wrapper">


    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-xl-4">
                <div class="card text-center m-b-30">
                    <div class="mb-2 card-body text-muted">
                        <h3 class="text-info" id="pendingOrderCount">{{ $Pending }}</h3>
                        Pending Orders
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="card text-center m-b-30">
                    <div class="mb-2 card-body text-muted">
                        <h3 class="text-purple">{{ $accepted }}</h3>
                        Accepted Orders
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="card text-center m-b-30">
                    <div class="mb-2 card-body text-muted">
                        <h3 class="text-primary">{{ $completed }}</h3>
                        Completed Orders
                    </div>
                </div>
            </div>
        </div>

        @if (\Illuminate\Support\Facades\Auth::user()->user_role_iduser_role != 2)
            <div class="row">
                <div class="col-lg-6 col-xl-4">
                    <div class="card text-center m-b-30">
                        <div class="mb-2 card-body text-muted">
                            <h3 class="text-info" id="pendingOrderCount">
                                {{ number_format($todayIncome, 2) }}
                            </h3>
                            Today Income
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-4">
                    <div class="card text-center m-b-30">
                        <div class="mb-2 card-body text-muted">
                            <h3 class="text-purple">
                                {{ number_format($totalIncome, 2) }}
                            </h3>
                            Total Income
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if (\Illuminate\Support\Facades\Auth::user()->user_role_iduser_role != 2)
        <div class="row">
            <div class="col-md-6 text-center">
                <div class="card m-b-30">
                    <div class="card-body">
                        <label class="label label-success">Income Chart</label>
                        <div id="bar-chart"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-offset-3 text-center">
                <div class="card m-b-30">
                    <div class="card-body">
                        <label class="label label-success">Order Details</label>
                        <div class="row">
                            <div class="col-lg-3">
                                <span>Completed Orders <div style=" background-color:rgb(103, 157, 198);padding:10px">
                                    </div></span>
                                <span>Pending Orders <div style=" background-color:rgb(11, 98, 164);padding:10px"></div>
                                </span>
                                <span>Accepted Orders <div style=" background-color:rgb(103, 157, 198);padding:10px">
                                    </div></span>

                            </div>
                            <div class="col-lg-9">
                                <div id="pie-chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

</div> <!-- Page content Wrapper -->

</div> <!-- content -->

@include('includes/footer_start')

<!--Morris Chart-->
<script src="assets/plugins/morris/morris.min.js"></script>
<script src="assets/plugins/raphael/raphael-min.js"></script>

<script src="assets/pages/dashborad.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.post('incomeChart', {

        }, function(test) {
            console.log(test)
            var data = [];

            for (let index = 0; index < test.length; index++) {
                data.push({
                    y: test[index].date,
                    a: test[index].invoice_total,

                }, )
            }

            config = {
                data: data,
                xkey: 'y',
                ykeys: ['a'],
                labels: ['Income'],
                fillOpacity: 0.6,
                hideHover: 'auto',
                behaveLikeLine: true,
                resize: true,
                pointFillColors: ['#ffffff'],
                pointStrokeColors: ['black'],
                lineColors: ['gray', 'red']
            };


            config.element = 'bar-chart';
            Morris.Bar(config);

        })

        $.post('orderDetailChart', {

        }, function(pieCart) {

            var pending = pieCart.Pending;
            var accepted = pieCart.accepted;
            var completed = pieCart.completed;


            Morris.Donut({
                element: 'pie-chart',
                data: [{
                        label: "Pending Orders",
                        value: pending
                    },
                    {
                        label: "Accepted Orders",
                        value: accepted
                    },
                    {
                        label: 'Completed Orders',
                        value: completed
                    }

                ]
            });
        })

    });

    //we store out timerIdhere
    var timeOutId = 0;
    //we define our function and STORE it in a var
    var test = 0;
    var ajaxFn = function() {

        $.ajax({
            url: 'getOrders',
            success: function(response) {
                if (response == 'True') { //YAYA
                    clearTimeout(timeOutId); //stop the timeout
                } else { //Fail check?
                    timeOutId = setTimeout(ajaxFn, 10000); //set the timeout again


                    // console.log(test); //check if this is running
                    console.log(response)
                    test = response
                    if (response == 0) {
                        var p = document.getElementById('pendingOrderCount');
                        p.innerHTML = 0;
                    } else {
                        var p = document.getElementById('pendingOrderCount');
                        p.innerHTML = response;
                    }

                    //you should see this on jsfiddle
                    // since the response there is just an empty string
                }
            }
        });
    }
    ajaxFn(); //we CALL the function we stored 
    //or you wanna wait 10 secs before your first call? 
    //use THIS line instead
    // timeOutId = setTimeout(ajaxFn, 10000);

</script>
@include('includes/footer_end')
