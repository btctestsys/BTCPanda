<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Growing Bitcoins Like Bamboos">
		<meta name="author" content="BTC Panda">
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">

		<link rel="shortcut icon" href="/assets/images/favicon_1.ico">

		<title>BTC Panda - {{trans('main.motto')}}</title>

		<link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/core1.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/components.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/icons.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/pages.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/responsive.css" rel="stylesheet" type="text/css" />
    <link href="/assets/plugins/sweetalert/dist/sweetalert2.css" rel="stylesheet" type="text/css">

	<link rel="stylesheet" type="text/css" href="/assets/plugins/jstree/dist/themes/default/style.min.css"/>

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


<!-- Start of btcpanda Zendesk Widget script -->
<script>/*<![CDATA[*/window.zEmbed||function(e,t){var n,o,d,i,s,a=[],r=document.createElement("iframe");window.zEmbed=function(){a.push(arguments)},window.zE=window.zE||window.zEmbed,r.src="javascript:false",r.title="",r.role="presentation",(r.frameElement||r).style.cssText="display: none",d=document.getElementsByTagName("script"),d=d[d.length-1],d.parentNode.insertBefore(r,d),i=r.contentWindow,s=i.document;try{o=s}catch(c){n=document.domain,r.src='javascript:var d=document.open();d.domain="'+n+'";void(0);',o=s}o.open()._l=function(){var o=this.createElement("script");n&&(this.domain=n),o.id="js-iframe-async",o.src=e,this.t=+new Date,this.zendeskHost=t,this.zEQueue=a,this.body.appendChild(o)},o.write('<body onload="document._l();">'),o.close()}("https://assets.zendesk.com/embeddable_framework/main.js","btcpanda.zendesk.com");
/*]]>*/</script>
<!-- End of btcpanda Zendesk Widget script -->

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
                            <form role="search" class="navbar-left app-search pull-left ">
								<input type=hidden id=timer name=timer value="<?php $tenMinsFromNow = (new \DateTime())->add(new \DateInterval('PT10M')); echo $tenMinsFromNow->format('Y/m/d H:i:s');?>">
								<div class="countdown" style="">
									<font color=white>Next <span class="hidden-xs">Transaction in</span>:
									<span id="clock">
									{{--*/ $countdown =  app('App\Http\Controllers\PhController')->get_next_trans_inmin_inph() /*--}}
									@if($countdown == 0) OPEN @else {{$countdown}} minutes @endif
									</span> <span class="hidden-xs"><br><small>Please refresh to see latest waiting time.</small></span></font>
								</div>
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
													 <li><a href="/master/audit_trail?inputDate=&uname={{session('username')}}&ip=&show_entries=10&view=1"><i class="fa fa-list-ol m-r-5"></i> Audit Trail</a></li>
                                        @endif
                                        @if(!$user->otp)
                                        <!-- li><a target="_blank" href="/sms/otp"><i class="ti-lock m-r-5"></i> {{trans('main.request_otp')}}</a></li -->
                                        @endif
                                        <li><a href="/settings"><i class="ti-settings m-r-5"></i> {{trans('main.settings')}}</a></li>
                                        <li><a href="/reset"><i class="ti-power-off m-r-5"></i> {{trans('main.logout')}}</a></li>
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
                				<a href="#" title="{{$user->username}} - {{$user->email}}" class="dropdown-toggle" data-toggle="dropdown_" aria-expanded="false">{{ ucwords(strtolower($user->name)) }} <span class="caret hide"></span></a>

                			</div>
                			<p class="text-muted m-0">{{$user->level->name}}</p>
                		</div>
                	</div>
                    <!--- Divider -->
                    <div id="sidebar-menu" class="p-t-10">
                      <ul>
						@if(session('isAdmin')=='true')
						<li><a href="/master/users" class="waves-effect"><i class="fa fa-lock"></i> <span> Admin </span> </a></li>
						@endif
                      <li><a href="/dashboard" class="waves-effect"><i class="fa fa-desktop"></i> <span> {{trans('main.dashboard')}} </span> </a></li>
                      <li><a href="/bamboo" class="waves-effect"><i class="fa fa-thumb-tack"></i> <span> {{trans('main.my_pins')}} </span> </a></li>
                      <li><a href="/provide_help" class="waves-effect"><i class="fa fa-upload"></i> <span> {{trans('main.provide')}}</span> </a></li>
                      <li><a href="/get_help" class="waves-effect"><i class="fa fa-download"></i> <span> {{trans('main.get_help')}} </span> </a></li>
                      <li><a href="/referral_bonus" class="waves-effect"><i class="fa fa-bitcoin"></i> <span> {{trans('main.my_ref_bonus')}} </span> </a></li>
                      <li><a href="/unilevel_bonus" class="waves-effect"><i class="fa fa-sort-amount-asc"></i> <span> {{trans('main.my_unilevel_bonus')}} </span> </a></li>

                      <li><a href="/referral" class="waves-effect"><i class="fa fa-group"></i> <span> {{trans('main.my_referrals')}} </span> </a></li>
                      <li><a href="/unitree" class="waves-effect"><i class="fa fa-tree"></i> <span> {{trans('main.tree')}} </span> </a></li>
							 <li><a href="/downline" class="waves-effect"><i class="fa fa-tree"></i> <span> Downline </span> </a></li>
                      <li><a href="/wallet" class="waves-effect"><i class="ti-wallet"></i> <span> {{trans('main.my_wallet')}} </span> </a></li>
                      <li><a href="/settings" class="waves-effect"><i class="fa fa-gear"></i> <span> {{trans('main.settings')}} </span> </a></li>
							  @if(session('isAdmin')=='true')
							 <li><a href="/master/audit_trail?inputDate=&uname={{session('username')}}&ip=&show_entries=10&view=1"><i class="fa fa-list-ol"></i> Audit Trail</a></li>
							 @endif
                      <li class="text-muted menu-title hide">{{trans('main.home')}}</li>
                      <li class="text-muted menu-title hide">{{trans('main.my_stuff')}}</li>
                      <li class="hide"><a href="/get_help_history" class="waves-effect"><i class="md-history"></i> <span> {{trans('main.history')}} </span> </a></li>
                      <li class="text-muted menu-title hide">{{trans('main.earnings')}}</li>
                      <li class="text-muted menu-title hide">{{trans('main.help_support')}}</li>
                      <li  class="hide"><a target="_blank" href="https://btcpanda.freshdesk.com" class="waves-effect"><i class="fa fa-ticket"></i> <span> {{trans('main.create_ticket')}} </span> </a></li>

                    </ul>
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
            <div class="text-center"><a href="/lang/en">English</a> | <a href="/lang/cn">华语</a> | <a href="/lang/id">Indonesia</a> | <a href="/lang/vn">Việt Nam</a></div>
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

        <!-- jQuery  -->
		<script src="/assets/plugins/jstree/dist/jstree.min.js"></script>
		<script src="/assets/js/ui-tree.js"></script>
        <script src="/assets/plugins/waypoints/lib/jquery.waypoints.js"></script>
        <script src="/assets/plugins/counterup/jquery.counterup.min.js"></script>

        <script src="/assets/plugins/morris/morris.min.js"></script>
        <script src="/assets/plugins/raphael/raphael-min.js"></script>

        <script src="/assets/plugins/jquery-knob/jquery.knob.js"></script>

        <script src="/assets/pages/jquery.dashboard.js"></script>

        <script src="/assets/js/jquery.core.js"></script>
        <script src="/assets/js/jquery.app.js"></script>
        <!-- Sweet-Alert  -->
        <script src="/assets/plugins/sweetalert/dist/sweetalert2.min.js"></script>
        <script src="/assets/pages/jquery.sweet-alert.init.js"></script>

		  <script src="/assets/js/bootstrap-datepicker.min.js"></script>

        <!-- Countdown Timer  -->

        @yield('js')

        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $('.counter').counterUp({
                    delay: 10,
                    time: 500
                });

                $(".knob").knob();
            });

        <!-- JSTree  -->
		jQuery(document).ready(function () {
			UITree.init();
		});
        </script>



        @yield('docready')

        <!-- begin olark code -->
        <script data-cfasync="false" type='text/javascript'>/*<![CDATA[*/window.olark||(function(c){var f=window,d=document,l=f.location.protocol=="https:"?"https:":"http:",z=c.name,r="load";var nt=function(){
        f[z]=function(){
        (a.s=a.s||[]).push(arguments)};var a=f[z]._={
        },q=c.methods.length;while(q--){(function(n){f[z][n]=function(){
        f[z]("call",n,arguments)}})(c.methods[q])}a.l=c.loader;a.i=nt;a.p={
        0:+new Date};a.P=function(u){
        a.p[u]=new Date-a.p[0]};function s(){
        a.P(r);f[z](r)}f.addEventListener?f.addEventListener(r,s,false):f.attachEvent("on"+r,s);var ld=function(){function p(hd){
        hd="head";return["<",hd,"></",hd,"><",i,' onl' + 'oad="var d=',g,";d.getElementsByTagName('head')[0].",j,"(d.",h,"('script')).",k,"='",l,"//",a.l,"'",'"',"></",i,">"].join("")}var i="body",m=d[i];if(!m){
        return setTimeout(ld,100)}a.P(1);var j="appendChild",h="createElement",k="src",n=d[h]("div"),v=n[j](d[h](z)),b=d[h]("iframe"),g="document",e="domain",o;n.style.display="none";m.insertBefore(n,m.firstChild).id=z;b.frameBorder="0";b.id=z+"-loader";if(/MSIE[ ]+6/.test(navigator.userAgent)){
        b.src="javascript:false"}b.allowTransparency="true";v[j](b);try{
        b.contentWindow[g].open()}catch(w){
        c[e]=d[e];o="javascript:var d="+g+".open();d.domain='"+d.domain+"';";b[k]=o+"void(0);"}try{
        var t=b.contentWindow[g];t.write(p());t.close()}catch(x){
        b[k]=o+'d.write("'+p().replace(/"/g,String.fromCharCode(92)+'"')+'");d.close();'}a.P(2)};ld()};nt()})({
        loader: "static.olark.com/jsclient/loader0.js",name:"olark",methods:["configure","extend","declare","identify"]});
        /* custom configuration goes here (www.olark.com/documentation) */
        olark.identify('7724-437-10-4920');/*]]>*/</script><noscript><a href="https://www.olark.com/site/7724-437-10-4920/contact" title="Contact us" target="_blank">Questions? Feedback?</a> powered by <a href="http://www.olark.com?welcome" title="Olark live chat software">Olark live chat software</a></noscript>
        <!-- end olark code -->

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
