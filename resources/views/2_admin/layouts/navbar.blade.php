<!--begin::Header-->
<nav class="app-header navbar navbar-expand bg-body"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Start Navbar Links-->
        <ul class="navbar-nav">
            <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i> </a> </li>
            <li class="nav-item d-none d-md-block"> <a href="{{ route('admin.dashboard') }}" class="nav-link">Home</a>
            </li>
        </ul> <!--end::Start Navbar Links--> <!--begin::End Navbar Links-->
        <ul class="navbar-nav ms-auto">
            <!--begin::Fullscreen Toggle-->
            <li class="nav-item"> <a class="nav-link" href="#" data-lte-toggle="fullscreen"> <i
                        data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i> <i data-lte-icon="minimize"
                        class="bi bi-fullscreen-exit" style="display: none;"></i>
                </a> </li> <!--end::Fullscreen Toggle--> <!--begin::User Menu Dropdown-->
            <li class="nav-item dropdown user-menu"> <a href="#" class="nav-link dropdown-toggle"
                    data-bs-toggle="dropdown"><span class="d-none d-md-inline">{{ Auth::user()->name }}</span> </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end"> <!--begin::User Image-->
                    <li class="user-header text-bg-primary">
                        <p>
                            {{ Auth::user()->name }}
                            <small>Member since {{ Auth::user()->created_at }}</small>
                        </p>
                    </li>
                    <li class="user-footer">
                        <div class="container"
                            style="display: flex; justify-content: space-between; align-items: center;">
                            <a href="#" class="btn btn-default btn-flat">Profile</a>
                            <form method="POST" action="{{ route('logout') }}" style="margin-bottom: 0;">
                                @csrf
                                <a href="route('logout')" class="btn btn-default btn-flat float-end"
                                    onclick="event.preventDefault();this.closest('form').submit();">Sign out</a>
                            </form>
                        </div>
                    </li>
                    <!--end::Menu Footer-->
                </ul>
            </li> <!--end::User Menu Dropdown-->
        </ul> <!--end::End Navbar Links-->
    </div> <!--end::Container-->
</nav> <!--end::Header-->
