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

    <nav class="navbar navbar-default navbar-top">
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
    <div class="container">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
          <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
          <li data-target="#carousel-example-generic" data-slide-to="1"></li>
          <li data-target="#carousel-example-generic" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
          <div class="item active">
          <a href="dashboard/ride" target="_blank">
            <img src="/media/ride.jpg"  alt="..." >
            <div class="carousel-caption">
              <div class="full-width text-center">
                Ride
              </div>
            </div>
          </div>
          </a>
          <div class="item">
          <a href='movie' target="_blank">
            <img src="/media/movie.jpg" alt="...">
            <div class="carousel-caption">
            <div class="full-width text-center">
              Movie
            </div>
            </div>
          </div>
          </a>
          <div class="item">
          <a href='restaurant' target="_blank">
            <img src="/media/restaurant.jpg" alt="...">
            <div class="carousel-caption">
            <div class="full-width text-center">
              Restaurant
            </div>
            </div>
            </a>
          </div>
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
        </div>
    </div>

    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-4">
          <h2>Restaurant</h2>
          <p>See who can eat with you together. </p>
          <p><a class="btn btn-default" href="restaurant" role="button">View details &raquo;</a></p>
        </div>
        <div class="col-md-4">
          <h2>Movie</h2>
          <p>See who can go to movies with you together. </p>
          <p><a class="btn btn-default" href="movie" role="button">View details &raquo;</a></p>
       </div>
        <div class="col-md-4">
          <h2>Ride</h2>
          <p>See who can offer a ride/request a ride.</p>
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