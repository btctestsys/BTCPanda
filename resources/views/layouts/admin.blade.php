<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Growing Bitcoins Like Bamboos">
		<meta name="author" content="BTC Panda">
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
		<meta name="csrf_token" content="{{ csrf_token() }}" />
		<link rel="shortcut icon" href="/assets/images/favicon_1.ico">

		<title>BTC Panda - Growing Bitcoins Like Bamboos</title>

		<link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/core1.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/components.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/icons.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/pages.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/responsive.css" rel="stylesheet" type="text/css" />
    <link href="/assets/plugins/sweetalert/dist/sweetalert.css" rel="stylesheet" type="text/css">
	<link href="/assets/css/jquery.growl.css" rel="stylesheet" type="text/css" />
    <link href="/css/css.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="/assets/css/datepicker.min.css" />
	<link rel="stylesheet" href="/assets/css/datepicker3.min.css" />
    <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <script src="/assets/js/modernizr.min.js"></script>
	</head>

        <body class="fixed-left">

        <!-- Begin page -->

        @if(Agent::isMobile())
        <div id="wrapper" class="enlarged forced">
        @else
        <div id="wrapper">
        @endif
            <!-- Top Bar Start -->
            <div class="topbar">

                <!-- LOGO -->
                <div class="topbar-left">
                    <div class="text-center">
                        <a href="/home" class="logo"><img src="/img/panda.gif" height="40px" class="icon-c-logo"><span> BTC <img src="/img/panda.gif" height="40px" style="position:relative;bottom:4px">Panda</span></a>
                    </div>
                </div>

                <!-- Button mobile view to collapse sidebar menu -->
                <div class="navbar navbar-default" role="navigation">
                    <div class="container">
                        <div class="">
                            <div class="pull-left">
                                <button class="button-menu-mobile open-left">
                                    <i class="ion-navicon"></i>
                                </button>
                                <span class="clearfix"></span>
                            </div>

                            <form role="search" class="hide navbar-left app-search pull-left hidden-xs">
			                     <input type="text" placeholder="Search..." class="form-control">
			                     <a href=""><i class="fa fa-search"></i></a>
			                </form>


                            <ul class="nav navbar-nav navbar-right pull-right">
                                <li class="hide dropdown hidden-xs">
                                    <a href="#" data-target="#" class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="true">
                                        <i class="icon-bell"></i> <span class="badge badge-xs badge-danger">3</span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-lg">
                                        <li class="notifi-title"><span class="label label-default pull-right">New 3</span>Notification</li>
                                        <li class="list-group nicescroll notification-list">
                                           <!-- list item-->
                                           <a href="javascript:void(0);" class="list-group-item">
                                              <div class="media">
                                                 <div class="pull-left p-r-10">
                                                    <em class="fa fa-diamond fa-2x text-primary"></em>
                                                 </div>
                                                 <div class="media-body">
                                                    <h5 class="media-heading">A new order has been placed A new order has been placed</h5>
                                                    <p class="m-0">
                                                        <small>There are new settings available</small>
                                                    </p>
                                                 </div>
                                              </div>
                                           </a>

                                           <!-- list item-->
                                           <a href="javascript:void(0);" class="list-group-item">
                                              <div class="media">
                                                 <div class="pull-left p-r-10">
                                                    <em class="fa fa-cog fa-2x text-custom"></em>
                                                 </div>
                                                 <div class="media-body">
                                                    <h5 class="media-heading">New settings</h5>
                                                    <p class="m-0">
                                                        <small>There are new settings available</small>
                                                    </p>
                                                 </div>
                                              </div>
                                           </a>

                                           <!-- list item-->
                                           <a href="javascript:void(0);" class="list-group-item">
                                              <div class="media">
                                                 <div class="pull-left p-r-10">
                                                    <em class="fa fa-bell-o fa-2x text-danger"></em>
                                                 </div>
                                                 <div class="media-body">
                                                    <h5 class="media-heading">Updates</h5>
                                                    <p class="m-0">
                                                        <small>There are <span class="text-primary font-600">2</span> new updates available</small>
                                                    </p>
                                                 </div>
                                              </div>
                                           </a>

                                           <!-- list item-->
                                           <a href="javascript:void(0);" class="list-group-item">
                                              <div class="media">
                                                 <div class="pull-left p-r-10">
                                                    <em class="fa fa-user-plus fa-2x text-info"></em>
                                                 </div>
                                                 <div class="media-body">
                                                    <h5 class="media-heading">New user registered</h5>
                                                    <p class="m-0">
                                                        <small>You have 10 unread messages</small>
                                                    </p>
                                                 </div>
                                              </div>
                                           </a>

                                           <!-- list item-->
                                           <a href="javascript:void(0);" class="list-group-item">
                                              <div class="media">
                                                 <div class="pull-left p-r-10">
                                                    <em class="fa fa-diamond fa-2x text-primary"></em>
                                                 </div>
                                                 <div class="media-body">
                                                    <h5 class="media-heading">A new order has been placed A new order has been placed</h5>
                                                    <p class="m-0">
                                                        <small>There are new settings available</small>
                                                    </p>
                                                 </div>
                                              </div>
                                           </a>

                                           <!-- list item-->
                                            <a href="javascript:void(0);" class="list-group-item">
                                                <div class="media">
                                                    <div class="pull-left p-r-10">
                                                     <em class="fa fa-cog fa-2x text-custom"></em>
                                                    </div>
                                                    <div class="media-body">
                                                      <h5 class="media-heading">New settings</h5>
                                                      <p class="m-0">
                                                        <small>There are new settings available</small>
                                                    </p>
                                                    </div>
                                              </div>
                                           </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="list-group-item text-right">
                                                <small class="font-600">See all notifications</small>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="hidden-xs">
                                    <a href="#" id="btn-fullscreen" class="waves-effect waves-light"><i class="icon-size-fullscreen"></i></a>
                                </li>
                                <li class="hide hidden-xs">
                                    <a href="#" class="right-bar-toggle waves-effect waves-light"><i class="icon-settings"></i></a>
                                </li>
                                <li class="dropdown">
                                    <a href="" class="dropdown-toggle profile" data-toggle="dropdown" aria-expanded="true"><img src="/assets/images/avatar.jpg" alt="user-img" class="img-circle"> </a>
                                    <ul class="dropdown-menu">
                                        <li class="hide"><a href="javascript:void(0)"><i class="ti-user m-r-5"></i> Profile</a></li>
                                        @if(session('isAdmin')=='true')
                                        <li><a href="/master/users"><i class="ti-lock m-r-5"></i> Admin</a></li>
                                        @endif
                                        <li><a href="javascript:void(0)"><i class="ti-settings m-r-5"></i> Settings</a></li>
                                        <li><a href="/reset"><i class="ti-power-off m-r-5"></i> Logout</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <!--/.nav-collapse -->
                    </div>
                </div>
            </div>
            <!-- Top Bar End -->


            <!-- ========== Left Sidebar Start ========== -->

            <div class="left side-menu">
                <div class="sidebar-inner slimscrollleft">
                	<div class="user-details">
                		<div class="pull-left">
                			<img src="/assets/images/avatar.jpg" alt="" class="thumb-md img-circle">
                		</div>
                		<div class="user-info">
                			<div class="dropdown">
                				<a href="#" class="dropdown-toggle" data-toggle="dropdown_" aria-expanded="false">{{ ucwords(strtolower($user->name)) }} <span class="caret hide"></span></a>
                				<ul class="dropdown-menu">
                					<li><a href="javascript:void(0)"><i class="md md-face-unlock"></i> Profile<div class="ripple-wrapper"></div></a></li>
                					<li><a href="javascript:void(0)"><i class="md md-settings"></i> Settings</a></li>
                					<li><a href="javascript:void(0)"><i class="md md-lock"></i> Lock screen</a></li>
                					<li><a href="javascript:void(0)"><i class="md md-settings-power"></i> Logout</a></li>
                				</ul>
                			</div>
                			<p class="text-muted m-0">{{$user->level->name}}</p>
                		</div>
                	</div>
                    <!--- Divider -->
                    <div id="sidebar-menu" class="p-t-10">
                      <ul>

						 <!--- Marketing -->
                        @if(session('AdminLvl')==1)
						<li class="text-muted menu-title hide">Main</li>
						<li><a href="/master/dashboard" class="waves-effect"><i class="fa fa-dashboard"></i> <span> Dashboard </span> </a></li>
						<li><a href="/master/users" class="waves-effect"><i class="fa fa-user"></i> <span> User List </span> </a></li>
                        @endif

						 <!--- customer service -->
                        @if(session('AdminLvl')==2)
						<li class="text-muted menu-title hide">Main</li>
						<li><a href="/master/dashboard" class="waves-effect"><i class="fa fa-dashboard"></i> <span> Dashboard </span> </a></li>
						<li><a href="/master/users" class="waves-effect"><i class="fa fa-user"></i> <span> User List </span> </a></li>
						<li><a href="/master/approval/kyc" class="waves-effect"><i class="fa fa-youtube-play"></i> <span> ID & Video Testi. </span> </a></li>
                        @endif

						 <!--- admin -->
                        @if(session('AdminLvl')==3)
						<li class="text-muted menu-title hide">Main</li>
						<li><a href="/master/dashboard" class="waves-effect"><i class="fa fa-dashboard"></i> <span> Dashboard </span> </a></li>
						<li><a href="/master/users" class="waves-effect"><i class="fa fa-user"></i> <span> User List </span> </a></li>
						<li><a href="/master/ph_queue" class="waves-effect"><i class="md-list"></i> <span> PH Queue </span> </a></li>
						<li><a href="/master/bamboos" class="waves-effect"><i class="fa fa-thumb-tack"></i> <span> Pin Sales </span> </a></li>
						<li><a href="/master/bamboos_daily" class="waves-effect"><i class="fa fa-thumb-tack"></i> <span> Pin Sales Daily </span> </a></li>
						<li><a href="/master/ph" class="waves-effect"><i class="md-local-hospital"></i> <span> PH Sales </span> </a></li>
						<li><a href="/master/ph_daily" class="waves-effect"><i class="md-local-hospital"></i> <span> PH Sales Daily </span> </a></li>
						<li><a href="/master/approval/kyc" class="waves-effect"><i class="fa fa-youtube-play"></i> <span> ID & Video Testi. </span> </a></li>
						<li><a href="/master/audit_trail" class="waves-effect"><i class="fa fa-list-ol"></i> <span> Audit Trail </span> </a></li>
                        @endif

						 <!--- superadmin -->
                        @if(session('AdminLvl')==4)
						<li class="text-muted menu-title hide">Main</li>
						<li><a href="/master/dashboard" class="waves-effect"><i class="fa fa-dashboard"></i> <span> Dashboard </span> </a></li>
						<li><a href="#" class="waves-effect"><i class="fa fa-dashboard"></i> <span> Report </span></a>
							<ul class="sub-menu">
								<li >
									<a href="/master/phbycountry">
									<i class="icon-pie-chart"></i>
									Daily PH</a>
								</li>
								<li >
									<a href="/master/phbycountry">
									<i class="icon-pie-chart"></i>
									Daily Summary</a>
								</li>

							</ul>
						</li>
						<li><a href="/master/users" class="waves-effect"><i class="fa fa-user"></i> <span> User List </span> </a></li>
						<li class="text-muted menu-title hide">Reportings</li>
						<li><a href="/master/ph_queue" class="waves-effect"><i class="md-list"></i> <span> PH Queue </span> </a></li>
						<li class="text-muted menu-title hide">Approvals</li>
						<li><a href="/master/approval/earnings" class="waves-effect"><i class="fa fa-check"></i> <span> Check Earnings </span> </a></li>
						<li><a href="/master/approval/referrals" class="waves-effect"><i class="fa fa-check"></i> <span> Check Referrals </span> </a></li>
						<li><a href="/master/approval/unilevels" class="waves-effect"><i class="fa fa-check"></i> <span> Check Unilevels </span> </a></li>
						<li class="hide"><a href="/master/approval/match/all" class="waves-effect"><i class="fa fa-exchange"></i> <span> Match (All) </span> </a></li>
						<li><a href="/master/approval/match/earnings" class="waves-effect"><i class="fa fa-exchange"></i> <span> Match (Earnings) </span> </a></li>
						<li><a href="/master/approval/match/referrals" class="waves-effect"><i class="fa fa-exchange"></i> <span> Match (Referrals) </span> </a></li>
						<li><a href="/master/approval/match/unilevels" class="waves-effect"><i class="fa fa-exchange"></i> <span> Match (Unilevels) </span> </a></li>

						<li><a href="/master/bamboos" class="waves-effect"><i class="fa fa-thumb-tack"></i> <span> Pin Sales </span> </a></li>
						<li><a href="/master/bamboos_daily" class="waves-effect"><i class="fa fa-thumb-tack"></i> <span> Pin Sales Daily </span> </a></li>
						<li><a href="/master/ph" class="waves-effect"><i class="md-local-hospital"></i> <span> PH Sales </span> </a></li>
						<li><a href="/master/ph_daily" class="waves-effect"><i class="md-local-hospital"></i> <span> PH Sales Daily </span> </a></li>
						<li><a href="/master/approval/kyc" class="waves-effect"><i class="fa fa-youtube-play"></i> <span> ID & Video Testi. </span> </a></li>
						<li><a href="/master/audit_trail" class="waves-effect"><i class="fa fa-list-ol"></i> <span> Audit Trail </span> </a></li>
						      @endif


                      <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
            <!-- Start content -->
            <div class="content">
            <div class="container">

          	@yield('content')

            </div> <!-- container -->
            </div> <!-- content -->

            <footer class="footer text-right">
            2015 © BTC Panda All Rights Reserved.
            </footer>
            </div>

            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->

            <!-- Right Sidebar -->
            <div class="side-bar right-bar nicescroll">
                <h4 class="text-center">Chat</h4>
                <div class="contact-list nicescroll">
                    <ul class="list-group contacts-list">
                        <li class="list-group-item">
                            <a href="#">
                                <div class="avatar">
                                    <img src="/assets/images/users/avatar-1.jpg" alt="">
                                </div>
                                <span class="name">Chadengle</span>
                                <i class="fa fa-circle online"></i>
                            </a>
                            <span class="clearfix"></span>
                        </li>
                        <li class="list-group-item">
                            <a href="#">
                                <div class="avatar">
                                    <img src="/assets/images/users/avatar-2.jpg" alt="">
                                </div>
                                <span class="name">Tomaslau</span>
                                <i class="fa fa-circle online"></i>
                            </a>
                            <span class="clearfix"></span>
                        </li>
                        <li class="list-group-item">
                            <a href="#">
                                <div class="avatar">
                                    <img src="/assets/images/users/avatar-3.jpg" alt="">
                                </div>
                                <span class="name">Stillnotdavid</span>
                                <i class="fa fa-circle online"></i>
                            </a>
                            <span class="clearfix"></span>
                        </li>
                        <li class="list-group-item">
                            <a href="#">
                                <div class="avatar">
                                    <img src="/assets/images/users/avatar-4.jpg" alt="">
                                </div>
                                <span class="name">Kurafire</span>
                                <i class="fa fa-circle online"></i>
                            </a>
                            <span class="clearfix"></span>
                        </li>
                        <li class="list-group-item">
                            <a href="#">
                                <div class="avatar">
                                    <img src="/assets/images/users/avatar-5.jpg" alt="">
                                </div>
                                <span class="name">Shahedk</span>
                                <i class="fa fa-circle away"></i>
                            </a>
                            <span class="clearfix"></span>
                        </li>
                        <li class="list-group-item">
                            <a href="#">
                                <div class="avatar">
                                    <img src="/assets/images/users/avatar-6.jpg" alt="">
                                </div>
                                <span class="name">Adhamdannaway</span>
                                <i class="fa fa-circle away"></i>
                            </a>
                            <span class="clearfix"></span>
                        </li>
                        <li class="list-group-item">
                            <a href="#">
                                <div class="avatar">
                                    <img src="/assets/images/users/avatar-7.jpg" alt="">
                                </div>
                                <span class="name">Ok</span>
                                <i class="fa fa-circle away"></i>
                            </a>
                            <span class="clearfix"></span>
                        </li>
                        <li class="list-group-item">
                            <a href="#">
                                <div class="avatar">
                                    <img src="/assets/images/users/avatar-8.jpg" alt="">
                                </div>
                                <span class="name">Arashasghari</span>
                                <i class="fa fa-circle offline"></i>
                            </a>
                            <span class="clearfix"></span>
                        </li>
                        <li class="list-group-item">
                            <a href="#">
                                <div class="avatar">
                                    <img src="/assets/images/users/avatar-9.jpg" alt="">
                                </div>
                                <span class="name">Joshaustin</span>
                                <i class="fa fa-circle offline"></i>
                            </a>
                            <span class="clearfix"></span>
                        </li>
                        <li class="list-group-item">
                            <a href="#">
                                <div class="avatar">
                                    <img src="/assets/images/users/avatar-10.jpg" alt="">
                                </div>
                                <span class="name">Sortino</span>
                                <i class="fa fa-circle offline"></i>
                            </a>
                            <span class="clearfix"></span>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /Right-bar -->

        </div>
        <!-- END wrapper -->

        <script>
            var resizefunc = [];
        </script>

        <!-- jQuery  -->
        <script src="/assets/js/jquery.min.js"></script>
        <script src="/assets/js/bootstrap.min.js"></script>
        <script src="/assets/js/detect.js"></script>
        <script src="/assets/js/fastclick.js"></script>
        <script src="/assets/js/jquery.slimscroll.js"></script>
        <script src="/assets/js/jquery.blockUI.js"></script>
        <script src="/assets/js/waves.js"></script>
        <script src="/assets/js/wow.min.js"></script>
        <script src="/assets/js/jquery.nicescroll.js"></script>
        <script src="/assets/js/jquery.scrollTo.min.js"></script>

        <script src="/assets/plugins/peity/jquery.peity.min.js"></script>

	   <script src="/assets/js/jquery.growl.js" type="text/javascript"></script>

	   <!-- jQuery  -->
        <script src="/assets/plugins/waypoints/lib/jquery.waypoints.js"></script>
        <script src="/assets/plugins/counterup/jquery.counterup.min.js"></script>

        <!-- script src="/assets/plugins/morris/morris.min.js"></script -->
        <!-- script src="/assets/plugins/raphael/raphael-min.js"></script -->

        <script src="/assets/plugins/jquery-knob/jquery.knob.js"></script>

        <!-- script src="/assets/pages/jquery.dashboard.js"></script -->

        <script src="/assets/js/jquery.core.js"></script>
        <script src="/assets/js/jquery.app.js"></script>
		<script type="text/javascript" src="/assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
		<script type="text/javascript" src="/assets/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="/assets/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
		<script type="text/javascript" src="/assets/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js"></script>
		<script type="text/javascript" src="/assets/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js"></script>
		<script type="text/javascript" src="/assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>


		<script src="/assets/js/generic_table.js" type="text/javascript"></script>

        <!-- Sweet-Alert  -->
        <script src="/assets/plugins/sweetalert/dist/sweetalert.min.js"></script>
        <script src="/assets/pages/jquery.sweet-alert.init.js"></script>

	   <script src="/assets/js/bootstrap-datepicker.min.js"></script>

        @yield('js')

        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $('.counter').counterUp({
                    delay: 100,
                    time: 1200
                });

                $(".knob").knob();
            });

			jQuery(document).ready(function () {
			});

        </script>

        @yield('docready')

        <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-70784072-1', 'auto');
        ga('send', 'pageview');

        </script>

        </body>
</html>
