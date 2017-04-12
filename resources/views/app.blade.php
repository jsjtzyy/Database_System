<!DOCTYPE html>
<html class="no-js" lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <title>GoTogether</title>

        <link rel='stylesheet' href="/css/all.css" type='text/css' media='all'/>
        <link rel='stylesheet' href="/css/bootstrap.min.css" type='text/css' media='all'/>
        <link rel='stylesheet' href="/css/bootstrap-datepicker.css" type='text/css' media='all'/>
        <link rel='stylesheet' href="/css/bootstrap-timepicker.css" type='text/css' media='all'/>
        <!--
        <script type='text/javascript' src="/js/all.js"></script>
        <script type='text/javascript' src="/js/jquery.js"></script>
        <script type='text/javascript' src="/js/bootstrap.min.js"></script>
        <script type='text/javascript' src="/js/bootstrap-datepicker.js"></script>
        <script type='text/javascript' src="/js/bootstrap-timepicker.js"></script>
        -->
        
        <link rel='stylesheet' href="/public/css/all.css" type='text/css' media='all'/>
        <link rel='stylesheet' href="/public/css/bootstrap.min.css" type='text/css' media='all'/>
        <link rel='stylesheet' href="/public/css/bootstrap-datepicker.css" type='text/css' media='all'/>
        <link rel='stylesheet' href="/public/css/bootstrap-timepicker.css" type='text/css' media='all'/>
        
        <script type='text/javascript' src="/public/js/all.js"></script>
        <script type='text/javascript' src="/public/js/jquery.js"></script>
        <script type='text/javascript' src="/public/js/bootstrap.min.js"></script>
        <script type='text/javascript' src="/public/js/bootstrap-datepicker.js"></script>
        <script type='text/javascript' src="/public/js/bootstrap-timepicker.js"></script>
        
    </head>
    <body>

    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    GoTogether
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
            <section class="content">
                <div class="pad group">
                      @yield('content')
                </div>
            </section>
    </div>

    <div id="wrapper">
        <nav class="nav-container group" id="nav-footer">
            <div class="nav-wrap">
                <ul class="nav container group">
                    <li class="menu-item">
                        <a href="/">GoTogether Beta</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>

    </body>
</html>
