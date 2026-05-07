<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>HRMS Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
          rel="stylesheet">

    <style>

        body{
            overflow-x:hidden;
        }

        .sidebar{
            width:260px;
            min-height:100vh;
        }

        .sidebar .nav-link{
            color:#d1d1d1;
            border-radius:10px;
            padding:12px 15px;
        }

        .sidebar .nav-link:hover{
            background:#343a40;
            color:#fff;
        }

        .sidebar .nav-link.active{
            background:#0d6efd;
            color:#fff;
        }

    </style>

</head>

<body class="bg-light">

<div class="d-flex">

    @include('layouts.sidebar')

    <div class="flex-grow-1">

        @include('layouts.topbar')

        <div class="p-4">

            @yield('content')

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>