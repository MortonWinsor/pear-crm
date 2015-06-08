<!DOCTYPE html>
<html lang="en-GB">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Winsor - CRM</title>

    <!-- Bootstrap Core CSS -->
    {{ HTML::style('css/bootstrap.min.css') }}

    <!-- Custom CSS -->
    {{ HTML::style('css/logo-nav.css') }}

    {{ HTML::style('css/jquery-ui.min.css') }}
    {{ HTML::style('css/jquery-ui.structure.min.css') }}
    {{ HTML::style('css/jquery-ui.theme.min.css') }}

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery Version 1.11.0 -->
    {{ HTML::script('js/jquery-1.11.0.js') }}
    {{ HTML::script('js/jquery-ui.min.js') }}

    <!-- Bootstrap Core JavaScript -->
    {{ HTML::script('js/bootstrap.js') }}
<script type="text/javascript">
var bootstrapDropDown = $.fn.dropdown.noConflict() // return $.fn.button to previously assigned value
$.fn.bootstrapDropDown = bootstrapDropDown            // give $().bootstrapBtn the Bootstrap functionality

var bootstrapBtn = $.fn.button.noConflict() // return $.fn.button to previously assigned value
$.fn.bootstrapBtn = bootstrapBtn            // give $().bootstrapBtn the Bootstrap functionality

var bootstrapToolTip = $.fn.tooltip.noConflict() // return $.fn.button to previously assigned value
$.fn.bootstrapToolTip = bootstrapToolTip            // give $().bootstrapBtn the Bootstrap functionality

    $(function() {

        $('.btn').button();

    });
</script>   
</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ route('work.create') }}">
                    {{ HTML::image('images/MortonWinsor-logo.png', 'Winsor CRM', array('title' => 'Winsor CRM', 'style' => 'width: 170px;')) }}
                </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                @if(Auth::check())
                <ul class="nav navbar-nav">
                    @if(Auth::user()->role_id < 3)
                    <li>
                        <a href="{{ route('work.create') }}">New Work</a>
                    </li>
                    @endif
                    <li>
                        <a href="{{ route('work.index', array('tab' => 'in')) }}">All Work</a>
                    </li>
                    <li>
                        <a href="{{ route('work.index', array('tab' => 'part'))  }}">Waiting Parts</a>
                    </li>
                    <li>
                        <a href="{{ route('work.index', array('tab' => 'comp')) }}">Work Complete</a>
                    </li>
                    @if(Auth::user()->role_id < 3)
                    <li>
                        <a href="{{ route('work.history') }}">Work History</a>
                    </li>
                    <li>
                        <a href="{{ route('orders.index') }}">Orders</a>
                    </li>
                    <li>
                        <a href="{{ route('customer.index') }}">Customers</a>
                    </li>
                    @if(Auth::user()->role_id == 1)
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Reports <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ route('reports.index') }}">Reports</a>
                            </li>
                            <li>
                                <a href="{{ route('export') }}">Exports</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Setting <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ route('parts.index') }}">Parts</a>
                            </li>
                            <li>
                                <a href="{{ route('types.index') }}">Machine Types</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('users.index') }}">Users</a>
                    </li>
                    @endif
                    @endif
                    @if(Auth::user()->role_id == 3)
                    <li>
                        <a href="{{ route('changeuser') }}">Change User</a>
                    </li>
                    @endif
                    <li>
                        <a href="{{ route('users.logout') }}">Log Out</a>
                    </li>
                </ul>
                @endif
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container main">
        <div class="row">
            <div class="col-lg-12">
                @if(Session::has('top-message'))
                    <p>{{ Session::get('top-message') }}</p>
                @endif
                @if(Auth::check() && Auth::user()->role_id == 3)
                    <p>You are log in as {{ Auth::user()->username }}</p>
                @endif
            </div>
        </div>
         @yield('main')
<br />
<br />
    </div>
    <!-- /.container -->
</body>

</html>
