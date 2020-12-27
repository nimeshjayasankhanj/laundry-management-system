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

                <a href="{{ URL::asset('index')}}" class="logo"><img src="{{ URL::asset('assets/images/logo.png')}}"
                                                                     height="40" alt="logo"></a>

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
                        <a href="test-page" class="waves-effect"><i
                                    class="fa fa-user"></i><span>Test</span></a>
                    </li>

                   

                </ul>
            </div>
            <div class="clearfix"></div>
        </div> <!-- end sidebarinner -->
    </div>
    <!-- Left Sidebar End -->