<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>GoTogether</title>
    
    <link rel='stylesheet' href="/css/all.css" type='text/css' media='all'/>
    <link rel='stylesheet' href="/css/noty.css" type='text/css' media='all'/>
    <link rel='stylesheet' href="/css/fileinput.css" type='text/css' media='all'/>
    <link rel="stylesheet" href="/css/font-awesome.css" type='text/css' media='all'/>
    <link rel='stylesheet' href="/css/bootstrap.min.css" type='text/css' media='all'/>
    <link rel='stylesheet' href="/css/bootstrap-datepicker.css" type='text/css' media='all'/>
    <link rel='stylesheet' href="/css/bootstrap-timepicker.css" type='text/css' media='all'/>
    
    <script type='text/javascript' src="/js/all.js"></script>
    <script type='text/javascript' src="/js/noty.js"></script>
    <script type='text/javascript' src="/js/jquery.js"></script>
    <script type='text/javascript' src="/js/fileinput.js"></script>
    <script type='text/javascript' src="/js/bootstrap.min.js"></script>
    <script type='text/javascript' src="/js/bootstrap-datepicker.js"></script>
    <script type='text/javascript' src="/js/bootstrap-timepicker.js"></script>    
</head>
<body id="app-layout">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    GoTogether
                </a>
            </div>

            <ul class="nav navbar-nav">
                <li><a href="../dashboard">Dashboard</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Category<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="../dashboard/ride">Ride</a></li>
                        <li><a href="../dashboard/movie">Movie</a></li>
                        <li><a href="../dashboard/restaurant">Restaurant</a></li>
                    </ul>
                </li>
            </ul>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">

                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="position:relative; padding-left:50px;">
                                <img src="/media/avatars/{{ Auth::user()->avatar }}" style="width:32px; height:32px; position:absolute; top:10px; left:10px; border-radius:50%">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/profile') }}"><i class="fa fa-user fa-fw"></i> Profile</a></li>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <footer class="navbar navbar-default navbar-bottom">
        <div class="container">
            <p class="navbar-text">&copy; 2017 GoTogether, Inc.</p>
        </div>
    </footer>

    <script>
        @if(Session::has('success'))
            new Noty({
                type: 'success',
                layout: 'bottomLeft',
                text: '{{ Session::get('success') }}',
                timeout: 1000
            }).show();
        @endif   
        @if(Session::has('error'))
            new Noty({
                type: 'error',
                layout: 'bottomLeft',
                text: '{{ Session::get('error') }}',
                timeout: 1000
            }).show();
        @endif    
    </script>
</body>
</html>
