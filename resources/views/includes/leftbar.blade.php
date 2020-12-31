<!-- Loader -->
<div id="preloader">
    <div id="status">
        <div class="spinner"></div>
    </div>
</div>

<!-- Begin page -->
<div id="wrapper">

    <!-- ========== Left Sidebar Start ========== -->
    <div class="left side-menu">

        <!-- LOGO -->
        <div class="topbar-left">
            <div class="">
                <!--<a href="index" class="logo text-center">Fonik</a>-->

                <a href="{{ URL::asset('index')}}" class="logo"><img src="{{ URL::asset('assets/images/Royal Laundry.png')}}"
                                                                     height="150" alt="logo"></a>

            </div>
        </div>

        <div class="sidebar-inner slimscrollleft">
            <div id="sidebar-menu">
                <ul>

                    <li class="menu-title">Main</li>

                    <li>
                        <a href="index" class="waves-effect"><i
                                    class="dripicons-device-desktop"></i><span>Dashboard </span></a>
                    </li>
                    
                    

                    <li>
                        <a href="{{route('make-a-booking')}}" class="waves-effect"><i
                                    class="dripicons-device-desktop"></i><span>Make a Booking </span></a>
                    </li>

                   
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="ion-fork ion-pizza"></i><span>Main Service<span
                                        class="pull-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                        <ul class="list-unstyled">
                            <li>
                                <a href="{{route('category-prices')}}"><span>Cloth Prices</span></a>
                            </li>
                            <li>
                                <a href="{{route('categories')}}"><span>Cloths</span></a>
                            </li>

                        </ul>
                    </li>

                    
                   

                </ul>
            </div>
            <div class="clearfix"></div>
        </div> <!-- end sidebarinner -->
    </div>
    <!-- Left Sidebar End -->