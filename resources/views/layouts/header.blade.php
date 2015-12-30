<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><img src="{{ asset('images/logo.png') }}"></a>
        </div>

        @if (Auth::check())
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Activities <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ asset('home') }}"><span class="glyphicon glyphicon-list-alt"></span> View all Activities</a></li>
                        <li><a href="{{ asset('activities/create') }}"><span class="glyphicon glyphicon-pencil"></span> Add new Activity</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Volunteers <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#"><span class="glyphicon glyphicon-list-alt"></span> View all Volunteers</a></li>
                        <li class="dropdown-submenu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown</a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Action</a></li>
                            </ul>
                        </li>
                        <li><a href="#"><span class="glyphicon glyphicon-pencil"></span> Manage Ranking</a></li>
                    </ul>
                </li>
                <li><a href="#">Seniors</a></li>
                @if (Auth::user()->is_admin)
                    <li><a href="#">Admin</a></li>
                @endif
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class=" dropdown">
                    <a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Welcome {{ Auth::user()->name }} <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ asset('profile') }}"><span class="glyphicon glyphicon-user"></span> My Profile</a></li>
                        <li><a href="{{ asset('profile/password') }}"><span class="glyphicon glyphicon-lock"></span> Change Password</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="{{ asset('auth/logout') }}"><span class="glyphicon glyphicon-off"></span> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        @endif
    </div>
</nav>
