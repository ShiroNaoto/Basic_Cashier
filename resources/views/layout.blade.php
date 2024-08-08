<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cashier POS</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- Ekko Lightbox -->
    <link rel="stylesheet" href="{{ asset('plugins/ekko-lightbox/ekko-lightbox.css') }}">
</head>
<body class="sidebar-collapse dark-mode layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__wobble" src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo" height="60" width="60">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark">
        <ul class="navbar-nav">
            <li class="nav-item d-none d-sm-inline-block">
                <a href="/" class="nav-link">Home</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="/products" class="nav-link">Product</a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-shopping-cart"></i>
                <span class="badge badge-primary navbar-badge">{{$itemCount}}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                @if($carts->isEmpty())
                    <a href="#" class="dropdown-item">
                        <div class="media">
                            <div class="media-body">
                                <p class="text-sm">Your cart is empty</p>
                            </div>
                        </div>
                    </a>
                @else
                    @foreach($carts->sortByDesc('created_at')->take(3) as $cart)
                        <a href="/carts" class="dropdown-item">
                            <div class="media">
                                <img src="{{ asset('storage/images/' . $cart->product->image) }}" alt="Product Image" class="img-size-50 mr-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">{{ $cart->product->name }}</h3>
                                    <p class="text-sm">Quantity: {{ $cart->quantity }}</p>
                                    <p class="text-sm text-muted"><i class="fas fa-dollar-sign"></i> {{ $cart->price }}</p>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                    @endforeach
                    <a href="/carts" class="dropdown-item dropdown-footer">See all your orders</a>
                @endif
            </div>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
                <a href="/orderlist" class="nav-link">Your Orders</a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    @yield('content')

    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('dist/js/adminlte.js') }}"></script>
    <script src="{{ asset('plugins/jquery-mousewheel/jquery.mousewheel.js') }}"></script>
    <script src="{{ asset('plugins/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-mapael/jquery.mapael.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-mapael/maps/usa_states.min.js') }}"></script>
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>

    @yield('scripts')
</body>
</html>
