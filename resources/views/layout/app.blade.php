<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>@yield('title', 'Web Master Komisioning')</title>
    <link rel="icon" href="{{ asset('assets/img/favicon.ico') }}" type="image/x-icon" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">

    <style>
    .custom-form-container .custom-form-group {
        margin: 15px 0;
        font-family: Arial, sans-serif;
    }

    .custom-form-container .custom-label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
        color: #333;
    }

    .custom-form-container .custom-select-wrapper {
        position: relative;
        border: 1px solid #ccc;
        border-radius: 4px;
        background-color: #fff;
        min-height: 38px;
        padding: 5px;
        box-sizing: border-box;
        cursor: pointer;
    }

    .custom-form-container .selected-items {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        padding: 5px 0;
    }

    .custom-form-container .selected-item {
        display: flex;
        align-items: center;
        background-color: #007bff;
        color: #fff;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 14px;
    }

    .custom-form-container .remove-item {
        margin-left: 5px;
        cursor: pointer;
        font-weight: bold;
        color: #fff;
        background: none;
        border: none;
        padding: 0 5px;
    }

    .custom-form-container .remove-item:hover {
        color: #ff4444;
    }

    .custom-form-container .dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        border: 1px solid #ccc;
        background-color: #fff;
        max-height: 200px;
        overflow-y: auto;
        z-index: 1000;
        display: none;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .custom-form-container .dropdown.active {
        display: block;
    }

    .custom-form-container .dropdown div {
        padding: 8px;
        cursor: pointer;
    }

    .custom-form-container .dropdown div:hover {
        background-color: #f0f0f0;
    }

    .custom-form-container .dropdown .selected {
        background-color: #e6f3ff;
        color: #007bff;
        font-weight: bold;
    }

    .custom-form-container .invalid-feedback {
        color: #dc3545;
        font-size: 12px;
        margin-top: 5px;
    }
    </style>
    <!-- Fonts and icons -->
    <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
    WebFont.load({
        google: {
            families: ["Public Sans:300,400,500,600,700"]
        },
        custom: {
            families: ["Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands",
                "simple-line-icons"
            ],
            urls: ["{{ asset('assets/css/fonts.min.css') }}"],
        },
        active: function() {
            sessionStorage.fonts = true;
        },
    });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    @yield('styles')
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        @include('layout.sidebar')

        <!-- Main Panel -->
        <div class="main-panel">
            <!-- Header -->
            @include('layout.header')

            <!-- Content -->
            <div class="container">
                <div class="page-inner">
                    @yield('content')
                </div>
            </div>

            <!-- Footer -->
            @include('layout.footer')

            <!-- Custom Template -->
            @include('layout.customtemplate')
        </div>
    </div>

    <!-- Core JS Files -->

    <script src="{{ asset('assets/js/checkbox.js') }}"></script>
    <script src="{{ asset('assets/js/pagination.js') }}"></script>
    <script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

    <!-- Chart JS -->
    <script src="{{ asset('assets/js/plugin/chart.js/chart.min.js') }}"></script>

    <!-- jQuery Sparkline -->
    <script src="{{ asset('assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- Chart Circle -->
    <script src="{{ asset('assets/js/plugin/chart-circle/circles.min.js') }}"></script>

    <!-- Datatables -->
    <script src="{{ asset('assets/js/plugin/datatables/datatables.min.js') }}"></script>

    <!-- Bootstrap Notify -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-notify/0.2.0/js/bootstrap-notify.min.js"></script>

    <!-- jQuery Vector Maps -->
    <script src="{{ asset('assets/js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jsvectormap/world.js') }}"></script>

    <!-- Sweet Alert -->
    <script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

    <!-- Kaiadmin JS -->
    <script src="{{ asset('assets/js/kaiadmin.min.js') }}"></script>

    <!-- Kaiadmin DEMO methods -->
    <script src="{{ asset('assets/js/setting-demo.js') }}"></script>
    <script src="{{ asset('assets/js/demo.js') }}"></script>
    <script src="{{ asset('js/selectgroup_handler.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}" />

    @yield('scripts')
</body>

</html>
