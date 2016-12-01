@extends("template")

@section("title")
Login
@endsection

@section("styles")
<link rel="stylesheet" href="src/css/login.css">
@endsection

@section("links")
<li><a href="{{route('login')}}">Login</a></li>
<li><a href="{{ route('register') }}">Register</a></li>
@endsection

@section("body")
<div class="container" >
    <div class="panel panel-default myPanel" >
        <div class="panel-heading" >Sign in</div>
        <div class="panel-body">
            <form class="form-horizontal">
                <div class="form-group center-form ">
                    <div class="row">
                        <div class="col-sm-2">
                            <label for="email" class="control-label">Email</label>
                        </div>

                        <div class="col-sm-6 myColumn">
                            <input type="email" class="form-control" name="email" placeholder="Email">
                        </div>
                    </div>


                </div>
                <div class="form-group center-form" >
                    <div class="row">
                        <div class="col-sm-2">
                            <label for="password" class="control-label">Password</label>
                        </div>

                        <div class="col-sm-6 myColumn">
                            <input type="password" class="form-control" name="password" placeholder="Password">
                        </div>
                    </div>


                </div>
                <div class="form-group center-form" >
                    <div class="col-sm-offset-2 col-sm-10">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox"> Remember me
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group center-form">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">Sign in</button>
                        <input type="hidden" value="{{ Session::token() }}" name="_token">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
