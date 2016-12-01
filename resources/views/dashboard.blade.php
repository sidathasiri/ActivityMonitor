@extends("template")

@section("title")
Dashboard
@endsection

@section("styles")
<link rel="stylesheet" href="src/css/dashboard.css">
@endsection

@section("links")
<li><button class="btn btn-success navbar-btn"><span class="glyphicon glyphicon glyphicon-plus-sign
" aria-hidden="true"></span> Add new Activity</button></li>
<li><a href="{{route('index')}}"><span class="glyphicon glyphicon glyphicon-home
" aria-hidden="true"></span> Home</a></li>

@endsection

@section('dropdown')
<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Username<span class="caret"></span></a>
<ul class="dropdown-menu">
    <li><a href="#"><span class="glyphicon glyphicon glyphicon-plus-sign
" aria-hidden="true"></span> Add new activity</a></li>
    <li><a href="#"><span class="glyphicon glyphicon glyphicon-user
" aria-hidden="true"></span> Profile</a></li>
    <li role="separator" class="divider"></li>
    <li><a href="#"><span class="glyphicon glyphicon glyphicon-log-out
" aria-hidden="true"></span> Logout</a></li>
</ul>
@endsection

@section("body")
    <div class="container">
        <div class="page-header myHeader">
            <h1 id="welcomeText">Welcome <small>Username</small></h1>
        </div>
    </div>
    <div class="container">
        <div class="panel panel-danger">
            <div class="panel-heading">Pending activities</div>
            <div class="panel-body">
                Pending activities will appear here
            </div>
        </div>
    </div>

    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">Your activities</div>
            <div class="panel-body">
                Accepted activities will appear here
            </div>
        </div>
    </div>
@endsection
