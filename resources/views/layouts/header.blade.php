<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            @if (Auth::check())
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </button>
            @endif
            <a class="navbar-brand" href="{{ asset('/') }}"><img src="{{ asset('images/logo.png') }}"></a>
        </div>

        @if (Auth::check())
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="fa fa-fw fa-calendar"></span> Activities <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ asset('home') }}"><span class="fa fa-fw fa-list-alt"></span> View Activities</a></li>
                        <li><a href="{{ asset('activities/create') }}"><span class="fa fa-fw fa-calendar-plus-o"></span> Add new Activity</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="{{ asset('activities/cancelled') }}"><span class="fa fa-fw fa-ban"></span> View cancelled Activities</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="fa fa-fw fa-heart"></span> Volunteers <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ asset('volunteers') }}"><span class="fa fa-fw fa-users"></span> View Volunteers</a></li>
                        <li><a href="{{ asset('volunteers/create') }}"><span class="fa fa-fw fa-user-plus"></span> Add new Volunteer</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="{{ asset('rank') }}"><span class="fa fa-fw fa-list-ol"></span> Manage Ranking</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="fa fa-fw fa-users"></span> Seniors <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ asset('elderly') }}"><span class="fa fa-fw fa-users"></span> View Seniors</a></li>
                        <li><a href="{{ asset('elderly/create') }}"><span class="fa fa-fw fa-user-plus"></span> Add new Senior</a></li>
                    </ul>
                </li>
                @if (Auth::user()->is_admin)
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="fa fa-fw fa-cog"></span> Staff <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ asset('staff') }}"><span class="fa fa-fw fa-users"></span> View Staff</a></li>
                        <li><a href="{{ asset('staff/create') }}"><span class="fa fa-fw fa-user-plus"></span> Add new Staff</a></li>
                    </ul>
                </li>
                @endif
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class=" dropdown">
                    <a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Welcome {{ Auth::user()->name }} <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ asset('profile') }}"><span class="fa fa-fw fa-user"></span> My Profile</a></li>
                        <li><a href="{{ asset('profile/password') }}"><span class="fa fa-fw fa-lock"></span> Change Password</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="{{ asset('auth/logout') }}"><span class="fa fa-fw fa-power-off"></span> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        @endif
    </div>
</nav>
