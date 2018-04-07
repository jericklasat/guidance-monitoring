@extends('layouts.app')
@section('on_page_css')
    <style type="text/css">
        body {
            background-color: #DADADA;
        }
        body > .grid {
            height: 100%;
        }
        .image {
            margin-top: -100px;
        }
        .column {
            max-width: 450px;
        }
        .login-header > .content {
            color:#3b4180;
        }
        .login-btn {
            background: #3b4180 !important;
            color: #fff !important;
        }
        .login-column {
            padding-top: 10em !important;
        }
        #top-menu {
            display: none;
        }
    </style>
@endsection
@section('content')
<div class="ui middle aligned center aligned grid">
    <div class="column login-column">
        <h2 class="ui login-header image header">
            <img src="{{ asset('img/csjp_logo.png') }}" class="image">
            <div class="content">Guidance Monitoring</div>
        </h2>
        <form class="ui large form" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}
            <div class="ui stacked segment">
                <div class="field {{ $errors->has('email') ? ' input error' : '' }}">
                    <div class="ui left icon input">
                        <i class="user icon"></i>
                        <input id="email" type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
                    </div>
                </div>
                <div class="field{{ $errors->has('password') ? ' input error' : '' }}">
                    <div class="ui left icon input">
                        <i class="lock icon"></i>
                        <input id="password" type="password" name="password" placeholder="Password" required>
                    </div>
                </div>
                <div class="field">
                    <div class="ui slider checkbox">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label>Remember Me</label>
                    </div>
                </div>
                <button type="submit" class="ui fluid large login-btn submit button">Login</button>
                <strong>{{ $errors->first('email') }}</strong>
                <strong>{{ $errors->first('password') }}</strong>
            </div>
            <div class="ui error message"></div>
        </form>
        <div class="ui message">
            Forgot Your Password? click <a class="btn btn-link" href="{{ route('password.request') }}">here</a>.
        </div>
    </div>
</div>
@endsection

@section('on_page_js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.ui.form').form({
                fields: {
                    email: {
                        identifier  : 'email',
                        rules: [
                            {
                                type   : 'empty',
                                prompt : 'Please enter your e-mail'
                            },
                            {
                                type   : 'email',
                                prompt : 'Please enter a valid e-mail'
                            }
                        ]
                    },
                    password: {
                        identifier  : 'password',
                        rules: [
                            {
                                type   : 'empty',
                                prompt : 'Please enter your password'
                            },
                            {
                                type   : 'length[6]',
                                prompt : 'Your password must be at least 6 characters'
                            }
                        ]
                    }
                }
            });
        });
    </script>
@endsection
