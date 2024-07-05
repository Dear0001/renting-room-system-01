<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Admin Dashboard" />
    <meta name="author" content="" />
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" rel="stylesheet" crossorigin="anonymous">
    <!-- Additional styles -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }
        .navbar-brand {
            font-weight: bold;
        }
        .navbar {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .sb-sidenav {
            background-color: #f8f9fa;
        }
        .sb-sidenav .nav-link {
            color: #495057;
        }
        .sb-sidenav .nav-link:hover {
            color: #007bff;
        }
        .sb-sidenav .sb-sidenav-menu-heading {
            color: #6c757d;
        }
        .sb-sidenav .nav-link .sb-nav-link-icon {
            margin-right: 10px;
        }
        .sb-sidenav-collapse-arrow {
            margin-left: auto;
        }
        .container {
            margin-top: 20px;
        }
        .card {
            margin-bottom: 20px;
        }
        .card img {
            border-bottom: 1px solid #dee2e6;
        }
        footer {
            background-color: #f8f9fa;
            padding: 20px 0;
            text-align: center;
        }
        #wrapper.toggled #sidebar-wrapper {
            margin-left: -250px;
        }
        #sidebar-wrapper {
            width: 250px;
            position: fixed;
            left: 0;
            top: 0;
            height: 100%;
            z-index: 1000;
            overflow-y: auto;
            background: #f8f9fa;
            transition: all 0.5s ease;
        }
        #page-content-wrapper {
            width: 100%;
            position: absolute;
            padding: 15px;
        }
    </style>
</head>
<body>
<nav class="sb-topnav navbar navbar-expand navbar-light bg-light">
    <a class="navbar-brand ps-3" href="#">Admin Dashboard</a>
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"><i class="fas fa-bars"></i></button>
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        <div class="input-group">
            <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
            <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
        </div>
    </form>
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="#!">Settings</a></li>
                <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                <li><hr class="dropdown-divider" /></li>
                <li><a class="dropdown-item" href="">Logout</a></li>
            </ul>
        </li>
    </ul>
</nav>
<div class="d-flex" id="wrapper">
    <!-- Sidebar-->
    <div class="bg-light border-end" id="sidebar-wrapper">
        <div class="sidebar-heading text-dark">Admin Dashboard</div>
        <div class="list-group list-group-flush">
            <a class="list-group-item list-group-item-action list-group-item-light p-3" href="index.html"><i class="fas fa-door-open me-2"></i>Room</a>
            <a class="list-group-item list-group-item-action list-group-item-light p-3" href="floors.html"><i class="fas fa-building me-2"></i>Floor</a>
            <a class="list-group-item list-group-item-action list-group-item-light p-3" href="categories.html"><i class="fas fa-list-alt me-2"></i>Category</a>
        </div>
    </div>
    <!-- Page content-->
    <div id="page-content-wrapper">
        <main>
            @yield('content')
        </main>
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; Your Website 2024</div>
                    <div>
                        <a href="#">Privacy Policy</a>
                        &middot;
                        <a href="#">Terms &amp; Conditions</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="{{ asset('js/scripts.js') }}"></script>
<script>
    document.getElementById("sidebarToggle").addEventListener("click", function() {
        document.getElementById("wrapper").classList.toggle("toggled");
    });
</script>
</body>
</html>
