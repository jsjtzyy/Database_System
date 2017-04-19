<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>GoTogether</title>

    <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('/css/jumbotron.css') }}" rel="stylesheet">

    <link href="{{ asset('/css/font-awesome.css') }}" rel="stylesheet">
  </head>

  <body>

    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="{{ url('/') }}">GoTogether</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          @if (Auth::guest())
            <form method="get" action="signin" class="navbar-form navbar-right">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <button type="submit" class="btn btn-success">Sign in</button>            
            </form>
            <form method="get", action="signup" class="navbar-form navbar-right">
              <button type="submit" class="btn btn-success">Sign up</button>
            </form>
          @else
            <ul class="nav navbar-nav navbar-right">
              <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="position:relative; padding-left:50px;">
                      <img src="/media/avatars/{{ Auth::user()->avatar }}" style="width:32px; height:32px; position:absolute; top:10px; left:10px; border-radius:50%">
                      {{ Auth::user()->name }} <span class="caret"></span>
                  </a>

                  <ul class="dropdown-menu dropdown-menu-right" role="menu">
                      <li><a href="/profile/{{ Auth::user()->id }}"><i class="fa fa-user fa-fw"></i> Profile</a></li>
                      <li><a href="{{ url('/logout') }}"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
                  </ul>
              </li>
            </ul>  
          @endif
          
          <form method="get", action="message/create" class="navbar-form navbar-right">
            <button type="submit" href="message/create" class="btn btn-success">Post</button>
          </form>
          <form method="get", action="dashboard" class="navbar-form navbar-right">
            <button type="submit" href="dashboard" class="btn btn-success">View Post</button>
          </form>
          
        </div><!--/.navbar-collapse -->
      </div>
    </nav>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <h1>Gotogether</h1>
        <p>This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
        <p><a class="btn btn-primary btn-lg" href="dashboard" role="button">Learn more &raquo;</a></p>
      </div>
    </div>

    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-4">
          <h2>Restaurant</h2>
          <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn btn-default" href="restaurant" role="button">View details &raquo;</a></p>
        </div>
        <div class="col-md-4">
          <h2>Movie</h2>
          <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn btn-default" href="movie" role="button">View details &raquo;</a></p>
       </div>
        <div class="col-md-4">
          <h2>Ride</h2>
          <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
          <p><a class="btn btn-default" href="dashboard/ride" role="button">View details &raquo;</a></p>
        </div>
      </div>

      <hr>

      <footer class="navbar navbar-default navbar-fixed-bottom">
        <div class="container">
            <p class="navbar-text">&copy; 2017 GoTogether, Inc.</p>
        </div>
      </footer>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type='text/javascript' src="/js/all.js"></script>
  </body>
</html>