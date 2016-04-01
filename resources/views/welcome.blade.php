@if(session('AdminLvl') == NULL )
<?php  header( 'Location: /login' ) ;?>
@endif
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>BTC Panda - Growing Bitcoins Like Bamboos</title>

    <!-- Bootstrap Core CSS -->
    <link href="/stylish-portfolio/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/stylish-portfolio/css/stylish-portfolio.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/stylish-portfolio/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <a id="menu-toggle" href="#" class="btn btn-dark btn-lg toggle"><i class="fa fa-bars"></i></a>
    <nav id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <a id="menu-close" href="#" class="btn btn-light btn-lg pull-right toggle"><i class="fa fa-times"></i></a>
            <li class="sidebar-brand">
                <a href="#top"  onclick = $("#menu-close").click(); >Site Navigation</span></a>
            </li>
            <li>
                <a href="#top" onclick = $("#menu-close").click(); >Home</a>
            </li>
            <li>
                <a href="#about" onclick = $("#menu-close").click(); >About</a>
            </li>
            <li>
                <a href="#services" onclick = $("#menu-close").click(); >Features</a>
            </li>
            <li>
                <a href="#contact" onclick = $("#menu-close").click(); >Contact</a>
            </li>
            <li>
                <a href="/register" onclick = $("#menu-close").click(); >Register</a>
            </li>
            <li>
                <a href="/login" onclick = $("#menu-close").click(); >Login</a>
            </li>
        </ul>
    </nav>

    <!-- Header -->
    <header id="top" class="header" style="background:url(/stylish-portfolio/img/bg<?php echo rand(1,4) ?>.jpg) no-repeat center center scroll; -webkit-background-size: cover;-moz-background-size: cover;background-size: cover;-o-background-size: cover;">
        <div class="text-vertical-center">
            <h1><span style="color:white">BTC <i class="fa fa-github-alt" style="position:relative;top:2px"></i> Panda</span></h1>
            <h3><span style="color:white">Growing Bitcoins Like Bamboos</span></h3>
            <br>
            <a href="/login" class="btn btn-dark btn-lg">Login</a>
            &nbsp;
            <a href="/register" class="btn btn-dark btn-lg">Register</a>
        </div>
    </header>

    <!-- About -->
    <section id="about" class="about bg-warning">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>What is BTC Panda?</h2>                    
                    <p class="lead">BTCPanda is a Crowdfunding Structured Network where everybody has an equal chance to make money & build their wealth & dream.</p>
                    <p class="lead">Crowdfunding is a method of raising capital through the collective effort of friends, family, members, communities and individual investors. This approach taps into the collective efforts of a large pool of individuals—primarily online via social media and crowdfunding network platforms, and leverages their networks for greater reach and exposure.</p>
                    <i class="fa fa-github-alt" style="font-size:150px"></i>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </section>

    <!-- About -->
    <section id="about" class="about bg-info">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="text-vertical-center">
                    <h2>“Economic inequality”</h2>
                    <i class="fa fa-bank" style="font-size:75px"></i><i class="fa fa-bug" style="font-size:75px"></i><i class="fa fa-bank" style="font-size:75px"></i>
                    <br/><br/>
                    <p class="lead">It is also known as income inequality, wealth inequality, gap between rich and poor, gulf between rich and poor and contrast between rich and poor, refers to how economic metrics are distributed among individuals in a group, among groups in a population, or among countries.</p>
                    <p class="lead">It's generally refers to the disparity of wealth or income between different groups or within a society. Often characterized by the aphorism “the rich get richer while the poor get poorer,” the phrase often refers more specifically to the gap in income or assets between the poorest and richest segments of an individual nation.</p>
                    <p class="lead">Inequalities in income and wealth cause economic instability, a range of health and social problems, and create a roadblock to the adoption of pro-environment strategies and behaviour. Social and economic inequalities tear the social fabric, undermine social cohesion and prevent nations, communities and individuals from flourishing.</p>
                    <p class="lead">At present poor are becoming poorer and rich are becoming richer. The role of government is to tax rich and distribute that money among the poor one but instead of that governments are protecting rich more than ever.</p>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </section>

    <!-- Services -->
    <!-- The circle icons use Font Awesome's stacked icon classes. For more information, visit http://fontawesome.io/examples/ -->
    <section id="services" class="services bg-primary">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-10 col-lg-offset-1">
                    <h2>Our Features</h2>
                    <hr class="small">
                    <div class="row">
                        <div class="col-md-3 col-sm-6">
                            <div class="service-item">
                                <span class="fa-stack fa-4x">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-bitcoin fa-stack-1x text-primary"></i>
                            </span>
                                <h4>
                                    <strong>Decentralized</strong>
                                </h4>
                                <p>Bitcoin is a decentralized currency. No central entity regulates it or controls it. 
                                Not having a central entity means no entity can’t inflate bitcoin’s price or devalue it by manipulating its supply.</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="service-item">
                                <span class="fa-stack fa-4x">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-compass fa-stack-1x text-primary"></i>
                            </span>
                                <h4>
                                    <strong>Free to Transfer and Hold</strong>
                                </h4>
                                <p>Remember, Bitcoin is not a company or a business. It does not charge its customer to use the service. It is an open source technology. As such, bitcoin is completely free to transfer and hold.</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="service-item">
                                <span class="fa-stack fa-4x">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-shield fa-stack-1x text-primary"></i>
                            </span>
                                <h4>
                                    <strong>Privacy Protection</strong>
                                </h4>
                                <p>If you do not wish to be identified, you can stay anonymous while using bitcoin. Bitcoin has stronger privacy protections than something like PayPal.</p>                                
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="service-item">
                                <span class="fa-stack fa-4x">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-rocket fa-stack-1x text-primary"></i>
                            </span>
                                <h4>
                                    <strong>Fast Transfers</strong>
                                </h4>
                                <p>While traditional wire transfers can take a long time to process (sometimes even days), bitcoin transactions can take just about 10 minutes to complete.</p>
                            </div>
                        </div>
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.col-lg-10 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </section>

    <!-- Callout -->
    <aside class="callout" style="height:75%" id="register">
        <div class="text-vertical-center">
            <h1>Join The Revolution Now</h1>
            <br/>
            <a href="/register" class="btn btn-lg btn-warning"style="width:100px;margin-right:15px">Register</a>
            <a href="/login" class="btn btn-lg btn-success" style="width:100px">Log In</a>
        </div>
    </aside>

    <!-- Footer -->
    <footer style="background: url('/assets/images/agsquare.png')" id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-lg-offset-1 text-center">
                    <h4><strong>BTC Panda Inc.</strong>
                    </h4>
                    <p>3481 Melrose Place<br>Beverly Hills, CA 90210</p>
                    <ul class="list-unstyled">
                        <li><i class="fa fa-phone fa-fw"></i>(115) 334-5423</li>
                        <li><i class="fa fa-envelope-o fa-fw"></i>  <a href="mailto:name@example.com">panda@btcpanda.com</a>
                        </li>
                    </ul>
                    <br>
                    <ul class="list-inline">
                        <li>
                            <a href="#"><i class="fa fa-facebook fa-fw fa-3x"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-twitter fa-fw fa-3x"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-dribbble fa-fw fa-3x"></i></a>
                        </li>
                    </ul>
                    <hr class="small">
                    <p class="text-muted">Copyright &copy; BTC Panda 2015 All Rights Reserved</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="/stylish-portfolio/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/stylish-portfolio/js/bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script>
    // Closes the sidebar menu
    $("#menu-close").click(function(e) {
        e.preventDefault();
        $("#sidebar-wrapper").toggleClass("active");
    });

    // Opens the sidebar menu
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#sidebar-wrapper").toggleClass("active");
    });

    // Scrolls to the selected menu item on the page
    $(function() {
        $('a[href*=#]:not([href=#])').click(function() {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') || location.hostname == this.hostname) {

                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html,body').animate({
                        scrollTop: target.offset().top
                    }, 1000);
                    return false;
                }
            }
        });
    });
    </script>

</body>

</html>
