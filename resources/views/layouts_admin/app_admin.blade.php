<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- data table style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" />

     <!-- jquery -->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

     
     <!-- data table -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

</head>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

::after,
::before {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

a {
    text-decoration: none;
}

li {
    list-style: none;
}

h1 {
    font-weight: 600;
    font-size: 1.5rem;
}

body {
    font-family: 'Poppins', sans-serif;
}


.main {
    min-height: 100vh;
    width: 100%;
    overflow: hidden;
    transition: all 0.35s ease-in-out;
    background-color: #fafbfe;
}

#sidebar {
    width: 250px;
    min-width: 250px;
    z-index: 1000;
    transition: all .25s ease-in-out;
    background-color: #0e2238;
    display: flex;
    flex-direction: column;
}

#sidebar.expand {
    width: 260px;
    min-width: 260px;
}

.toggle-btn {
    background-color: transparent;
    cursor: pointer;
    border: 0;
    padding: 1rem 1.5rem;
}

.toggle-btn i {
    font-size: 1.5rem;
    color: #FFF;
}

.sidebar-logo {
    margin: auto 0;
}

.sidebar-logo a {
    color: #FFF;
    font-size: 1.15rem;
    font-weight: 600;
}

.sidebar-nav {
    padding: 1rem 0;
    flex: 1 1 auto;
}

a.sidebar-link {
    padding: .625rem 1.625rem;
    color: #FFF;
    display: block;
    font-size: 0.9rem;
    white-space: nowrap;
    border-left: 3px solid transparent;
}

.sidebar-link i {
    font-size: 1.1rem;
    margin-right: .75rem;
}

a.sidebar-link:hover {
    background-color: rgba(255, 255, 255, .075);
    border-left: 3px solid #3b7ddd;
}
</style>

<body>
    <div id="appAdmin">
    <div class="wrapper d-flex">
        <aside id="sidebar">
            <div class="d-flex">
                <button class="toggle-btn" type="button">
                    <i class="lni lni-grid-alt"></i>
                </button>
                <div class="sidebar-logo mt-3">
                    <div>
                        <a href="#">Clothing Shop</a>
                    </div>
                    <div>
                       <p class="text-light"> admin {{ Auth::user()->name }}</p>
                    </div>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="{{ route('products') }}" class="sidebar-link">
                        <i class="lni lni-agenda"></i>
                        <span>Product</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('shirt')}}" class="sidebar-link">
                        <i class="lni lni-user"></i>
                        <span>Shirt Type</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('shirtcolor')}}" class="sidebar-link">
                        <i class="lni lni-user"></i>
                        <span>Shirt Color</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('shirtsize')}}" class="sidebar-link">
                        <i class="lni lni-user"></i>
                        <span>Shirt Size</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('employee')}}" class="sidebar-link">
                        <i class="lni lni-user"></i>
                        <span>Employee</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('department')}}" class="sidebar-link">
                        <i class="lni lni-user"></i>
                        <span>Department</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('permission')}}" class="sidebar-link">
                        <i class="lni lni-user"></i>
                        <span>Permission</span>
                    </a>
                </li>   
                <li class="sidebar-item">
                    <a href="{{ route('promotion')}}" class="sidebar-link">
                        <i class="lni lni-user"></i>
                        <span>Promotion</span>
                    </a>
                </li>
                {{-- <li class="sidebar-item">
                    <a href="{{ route('advert')}}" class="sidebar-link">
                        <i class="lni lni-user"></i>
                        <span>Advert</span>
                    </a>
                </li> --}}
                {{-- <li class="sidebar-item">
                    <a href="{{ route('reportsales')}}" class="sidebar-link">
                        <i class="lni lni-user"></i>
                        <span>Report Sales</span>
                    </a>
                </li>                 --}}
                <li class="sidebar-item">
                    <a href="{{ route('membershiplevel')}}" class="sidebar-link">
                        <i class="lni lni-user"></i>
                        <span>Membership Level</span>
                    </a>
                </li>
                {{-- <li class="sidebar-item">
                    <a href="{{ route('sale_products')}}" class="sidebar-link">
                        <i class="lni lni-user"></i>
                        <span>Sale Product</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('order_products')}}" class="sidebar-link">
                        <i class="lni lni-user"></i>
                        <span>Order Product</span>
                    </a>
                </li> --}}
                <li class="sidebar-item">
                    <a href="{{ route('order_shopping')}}" class="sidebar-link">
                        <i class="lni lni-user"></i>
                        <span>Order Product Detail</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('stock_items')}}" class="sidebar-link">
                        <i class="lni lni-user"></i>
                        <span>Stock</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('report')}}" class="sidebar-link">
                        <i class="lni lni-user"></i>
                        <span>Report Sale</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('reportstock')}}" class="sidebar-link">
                        <i class="lni lni-user"></i>
                        <span>Report stock</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('reportunsold')}}" class="sidebar-link">
                        <i class="lni lni-user"></i>
                        <span>Report Product unsold</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('promotionsreport')}}" class="sidebar-link">
                        <i class="lni lni-user"></i>
                        <span>Report Promotions</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('costreport')}}" class="sidebar-link">
                        <i class="lni lni-user"></i>
                        <span>Report Costprice</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('sumreport')}}" class="sidebar-link">
                        <i class="lni lni-user"></i>
                        <span>Report SummarySale</span>
                    </a>
                </li>
                {{-- <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                        <i class="lni lni-protection"></i>
                        <span>Auth</span>
                    </a> --}}
                    <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Login</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Register</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <div class="sidebar-footer">
                <li class="nav-item dropdown">

                <a class="sidebar-link" href="{{ route('signout') }}">
                    <i class="lni lni-exit"></i>
                    <span>Logout</span>
                </a>
                

                <form id="logout-form" action="{{ route('signout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                
            </div>
            
        </aside>

        <div class="main p-3">
          @yield('content')
        </div>

    </div>


       
    </div>

</body>
</html>

