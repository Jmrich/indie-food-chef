<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Indie Food Chef</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">

    <style>
        html {
            position: relative;
            min-height: 100%;
        }

        .footer {
            color: white;
            position: absolute;
            bottom: 0;
            width: 100%;
            /* Set the fixed height of the footer here */
            height: 100px;
            background-color: cornflowerblue;
        }

        body {
            /* Margin bottom by footer height */
            margin-bottom: 100px;
        }
    </style>

    <!-- Scripts -->
    @yield('scripts', '')

    <!-- Scripts -->
    <script src="https://use.fontawesome.com/576a001814.js"></script>
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>

        window.Ifc = <?php echo json_encode(\App\Ifc::frontEndVariables()); ?>
    </script>
</head>
<body>
    <div id="app">
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
                        Indie Food Chef
                    </a>
                </div>

                <user-info :user="user" inline-template>
                    <div class="collapse navbar-collapse" id="app-navbar-collapse">
                        <!-- Left Side Of Navbar -->
                        <ul class="nav navbar-nav">
                           <li><a href="{{ url('/kitchens') }}">Kitchen List</a> </li>

                            @if(userIsAChef())
                                @include('nav.chef-nav')
                            @endif
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="nav navbar-nav navbar-right">
                            <!-- Authentication Links -->
                            @if (Auth::guest())
                                <li><a href="{{ url('/login') }}">Login</a></li>
                                <li><a href="{{ url('/register') }}">Register</a></li>
                            @else
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        @{{ user.name }} <span class="caret"></span>
                                    </a>

                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="{{ url('account') }}">Account</a>
                                            <a href="{{ url('account#address') }}">Addresses</a>
                                            <a href="{{ url('orders') }}">Order History</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('/logout') }}"
                                               onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                                Logout
                                            </a>

                                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                        </ul>
                    </div>
                </user-info>
            </div>
        </nav> <!-- Navigation end -->

        <div class="container-fluid">
            @if(Session::has('message'))
                <div class="alert alert-success col-md-6 col-md-offset-3">
                    {{ Session::get('message') }}
                </div>
            @endif
            @yield('content')
        </div>

        <footer class="footer">
            <div class="container">
                <div class="col-md-4 pull-left">
                    <ul>
                        <li>First</li>
                        <li>Second</li>
                        <li>Third</li>
                        <li>Fourth</li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <p>COPYRIGHT © JMR Technology</p>
                </div>
                <div class="col-md-4 pull-right">
                    <ul>
                        <li>First</li>
                        <li>Second</li>
                        <li>Third</li>
                        <li>Fourth</li>
                    </ul>
                </div>
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="/js/app.js"></script>
    <script type="text/javascript">
        $(function() {
            var url = document.location.toString();
            if (url.match('#')) {
                $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
            }

// Change hash for page-reload
            $('.nav-tabs a').on('shown.bs.tab', function (e) {
                window.location.hash = e.target.hash;
            })
        });
    </script>
    @yield('bottomScript')
</body>
</html>
