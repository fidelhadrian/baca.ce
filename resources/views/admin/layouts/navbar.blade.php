<nav class="app-header navbar navbar-expand bg-body"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Start Navbar Links-->
        <ul class="navbar-nav">
            <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i> </a> </li>

        </ul> <!--end::Start Navbar Links--> <!--begin::End Navbar Links-->
        <ul class="navbar-nav ms-auto">
            <!--begin::Fullscreen Toggle-->
            <li class="nav-item"> <a class="nav-link" href="#" data-lte-toggle="fullscreen"> <i
                        data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i> <i data-lte-icon="minimize"
                        class="bi bi-fullscreen-exit" style="display: none;"></i>
                </a> </li> <!--end::Fullscreen Toggle--> <!--begin::User Menu Dropdown-->
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <!--begin::User Image-->
                    <li class="user-header text-bg-primary">
                        {{-- Gambar profil pengguna jika diperlukan --}}
                        <p>
                            {{ Auth::user()->name }}
                            <small>Member since {{ Auth::user()->created_at->format('M Y') }}</small>
                        </p>
                    </li>
                    <!--end::User Image-->

                    <!--begin::Menu Footer-->
                    <li class="user-footer">
                        <!-- Link ke profile edit -->
                        <a href="{{ route('profile.edit') }}" class="btn btn-default btn-flat">
                            {{ __('Profile') }}
                        </a>

                        <!-- Form logout -->
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-default btn-flat float-end">
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </li>
                    <!--end::Menu Footer-->
                </ul>
            </li>
            <!--end::User Menu Dropdown-->
        </ul> <!--end::End Navbar Links-->
    </div> <!--end::Container-->
</nav> <!--end::Header-->
