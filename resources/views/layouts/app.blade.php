<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="base-url" content="{{URL::to('/')}}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="last-url" content="{{ URL::previous() }}">
    <title>CSJP Guidance Monitoring</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .ui.menu {
            margin: 0;
        }
        .footer {
            margin-top: 4em !important;
        }
    </style>
    @yield('on_page_css')
</head>
<body>
    <div class="ui left thin vertical inverted sidebar labeled icon menu">
        <a class="item" href="{{ route('index') }}">
            <i class="home icon"></i>
            Home
        </a>
        <a class="item" href="{{ route('student_register') }}">
            <i class="add user icon"></i>
            Add Student Record
        </a>
        <a class="item" href="{{ route('student_view') }}">
            <i class="address book icon"></i>
            View Student Record
        </a>
        <a href="{{ route('add_violation') }}" class="item">
            <i class="law icon"></i>
            Add Violations
        </a>
    </div>
    <div class="pusher">
        <div class="ui menu" id="top-menu">
            <div class="header item"><img src="{{ asset('img/csjp_logo.png') }}" class="image"></div>
            <div class="active item"><a href="#" id="sidebar-toggle"><i class="sidebar icon"></i></a></div>
            @guest
            @else
                <div class="right menu">
                    <div class="ui dropdown item" tabindex="0">
                        {{ Auth::user()->name }}
                        <i class="dropdown icon"></i>
                        <div class="menu" tabindex="-1">
                            <div class="item">
                                <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endguest
        </div>
        @yield('content')
        @if(Auth::check())
            <div class="ui inverted vertical footer segment">
                <div class="ui center aligned container">
                    <img src="{{ asset('img/csjp_logo.png') }}" class="ui centered mini image">
                    <div class="ui horizontal inverted small divided link list">
                        College of Saint John Paul II Arts and Sciences &copy; 2018
                    </div>
                </div>
            </div>
        @endif
    </div>
</body>
<!-- Scripts -->

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script type="text/javascript" src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script type="text/javascript" src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/axios.min.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript">
    window.axios.defaults.headers.common = {
        'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr("content"),
        'X-Requested-With': 'XMLHttpRequest'
    };
    $(document).ready(function() {
        $('.ui.menu .ui.dropdown').dropdown({ on: 'hover' });
        $('.ui.menu a.item').on('click', function() {
            $(this).addClass('active').siblings().removeClass('active');
        })
        $('#sidebar-toggle').on('click', function (e) {
            e.preventDefault();
            $('.ui.sidebar').sidebar('toggle');
        });
    });
</script>
<script type="text/javascript" src="{{ asset('/js/http.manager.js') }}"></script>
@yield('on_page_js')
</html>
