```html
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Laravel Sidebar</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css"
          rel="stylesheet">

    <style>

        body{
    overflow-x:hidden;
    background:#f4f5f7;
    font-family:Arial, sans-serif;
}

.sidebar{
    width:260px;
    height:100vh;
    position:fixed;
    top:0;
    left:0;
    background:#ffffff;
    border-right:1px solid #e5e7eb;
    overflow-y:auto;
}

.sidebar-logo{
    padding:20px;
    font-size:22px;
    font-weight:700;
    color:#6f42c1;
    border-bottom:1px solid #e5e7eb;
}

.sidebar .nav-link{
    color:#6f42c1;
    padding:13px 20px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    transition:0.3s;
    font-weight:500;
}

.sidebar .nav-link:hover{
    background:#f3ecff;
    color:#5a32a3;
}

.sidebar .nav-link.active{
    background:#6f42c1;
    color:#ffffff;
    border-radius:8px;
    margin:4px 10px;
}

.sidebar .nav-link.active i{
    color:#ffffff;
}

.sidebar .nav-link .menu-left{
    display:flex;
    align-items:center;
    gap:12px;
}

.sidebar .nav-link i{
    font-size:16px;
}

.submenu{
    background:#faf7ff;
}

.submenu .nav-link{
    padding-left:58px;
    font-size:14px;
    color:#7e57c2;
}

.submenu .nav-link:hover{
    background:#efe7ff;
}

.submenu .nav-link.active{
    background:#e4d4ff;
    color:#5a32a3;
    border-radius:8px;
    margin:4px 10px 4px 20px;
}

.arrow{
    transition:0.3s;
    font-size:12px;
}

.nav-link[aria-expanded="true"] .arrow{
    transform:rotate(180deg);
}

.content{
    margin-left:260px;
    padding:20px;
}

    </style>

</head>

<body>

    <!-- Sidebar Start -->
    <div class="sidebar">

        <!-- Logo -->
        <div class="sidebar-logo">
            Laravel App
        </div>

        <!-- Sidebar Menu -->
        <ul class="nav flex-column">

            <!-- Dashboard -->
            <li class="nav-item">

                <a href="#"
                   class="nav-link">

                    <div class="menu-left">

                        <i class="bi bi-speedometer2"></i>

                        <span>Dashboard</span>

                    </div>

                </a>

            </li>

            <!-- Users Menu -->
            <li class="nav-item">

                <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}"
                   data-bs-toggle="collapse"
                   href="#usersMenu"
                   role="button"
                   aria-expanded="{{ request()->routeIs('users.*') ? 'true' : 'false' }}">

                    <div class="menu-left">

                        <i class="bi bi-people"></i>

                        <span>Users</span>

                    </div>

                    <i class="bi bi-chevron-down arrow"></i>

                </a>

                <div class="collapse submenu {{ request()->routeIs('users.*') ? 'show' : '' }}"
                     id="usersMenu">

                    <a href="{{ route('users.add-user') }}"
                       class="nav-link {{ request()->routeIs('users.add-user') ? 'active' : '' }}">

                        Add User

                    </a>

                    <a href="{{ route('users.user-list') }}"
                       class="nav-link {{ request()->routeIs('users.user-list') ? 'active' : '' }}">

                        View Users

                    </a>

                    <a href="{{ route('users.download-user-data') }}"
                       class="nav-link">

                        User Reports

                    </a>

                </div>

            </li>

            <!-- Products Menu -->
            <li class="nav-item">

                <a class="nav-link"
                   data-bs-toggle="collapse"
                   href="#productsMenu"
                   role="button"
                   aria-expanded="false">

                    <div class="menu-left">

                        <i class="bi bi-box"></i>

                        <span>Products</span>

                    </div>

                    <i class="bi bi-chevron-down arrow"></i>

                </a>

                <div class="collapse submenu"
                     id="productsMenu">

                    <a href="#"
                       class="nav-link">

                        Add Product

                    </a>

                    <a href="#"
                       class="nav-link">

                        Product List

                    </a>

                    <a href="#"
                       class="nav-link">

                        Categories

                    </a>

                </div>

            </li>

            <!-- Settings Menu -->
            <li class="nav-item">

                <a class="nav-link"
                   data-bs-toggle="collapse"
                   href="#settingsMenu"
                   role="button"
                   aria-expanded="false">

                    <div class="menu-left">

                        <i class="bi bi-gear"></i>

                        <span>Settings</span>

                    </div>

                    <i class="bi bi-chevron-down arrow"></i>

                </a>

                <div class="collapse submenu"
                     id="settingsMenu">

                    <a href="{{ route('profiles.fetch-user-profile') }}"
                       class="nav-link">

                        Profile

                    </a>

                    <a href="#"
                       class="nav-link">

                        Security

                    </a>

                </div>

            </li>

            <!-- Logout -->
            <li class="nav-item mt-3">

                <a href="{{ route('login.user-logout') }}"
                   class="nav-link text-danger">

                    <div class="menu-left">

                        <i class="bi bi-box-arrow-right"></i>

                        <span>Logout</span>

                    </div>

                </a>

            </li>

        </ul>

    </div>
    <!-- Sidebar End -->


    <!-- Content Start -->
    <div class="content">

        @yield('content')

    </div>
    <!-- Content End -->


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    @stack('scripts')

</body>

</html>
