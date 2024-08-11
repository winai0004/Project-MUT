
 <!doctype html>
 <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
 <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
 
     <!-- CSRF Token -->
     <meta name="csrf-token" content="{{ csrf_token() }}">
 
     <title>@yield('title')</title>
     <!-- Scripts -->
     @vite(['resources/sass/app.scss', 'resources/js/app.js'])
     
     {{-- jquery --}}
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


     <!-- Font Awesome -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
 </head>
 <body>
     <div id="app">
         <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
             <div class="container">
                 <a class="navbar-brand" href="{{ url('/') }}">
                     Clothing Shop
                 </a>
                 <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                     <span class="navbar-toggler-icon"></span>
                 </button>
 
                 <div class="collapse navbar-collapse" id="navbarSupportedContent">
                     <!-- Left Side Of Navbar -->
                     <ul class="navbar-nav me-auto">
 
                     </ul>
 
                     <!-- Right Side Of Navbar -->
                     <ul class="navbar-nav ms-auto">
                         <!-- Authentication Links -->
                         {{-- @guest
                             <li class="nav-item">
                                 <a class="nav-link" href="#">
                                     <i class="fas fa-shopping-cart"></i> ตะกร้า
                                 @if(session('cart'))
                                     <span class="badge">{{ count(session('cart')) }}</span>
                                 @endif
                                 </a>
                             </li>
                             @if (Route::has('login'))
                                 <li class="nav-item">
                                     <a class="nav-link" href="{{ route('login') }}">เข้าสู่ระบบ</a>
                                 </li>
                             @endif
 
                             @if (Route::has('register'))
                                 <li class="nav-item">
                                     <a class="nav-link" href="{{ route('register') }}">สมัครสมาชิก</a>
                                 </li>
                             @endif
                         @else
 
                             <li class="nav-item">
                                 <a class="nav-link" href="#">
                                     <i class="fas fa-shopping-cart"></i> ตะกร้า
                                     @if(session('cart'))
                                     <span class="badge">{{ count(session('cart')) }}</span>
                                     @endif
                                 </a>
                             </li>
                             <li class="nav-item dropdown">
                                 <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                     สวัสดี {{ Auth::user()->name }}
                                 </a>
 
                                 <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                     <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                      document.getElementById('logout-form').submit();">
                                         ออกจากระบบ
                                     </a>
 
                                     <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                         @csrf
                                     </form>
                                 </div>
                             </li>
                         @endguest --}}
                         @guest
                         <li class="nav-item">
                             <a class="nav-link" href="{{ route('login') }}">Login</a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" href="{{ route('register') }}">Register</a>
                         </li>
                         
                         @else
{{--  
                         <li class="nav-item">
                             <a class="nav-link" href="#">
                                 <i class="fas fa-shopping-cart"></i> ตะกร้า
                                 <a class="nav-link" href="{{ route('cart') }}">Register</a>
                             </a>
                         </li> --}}
                         <!-- Update your cart link in the navbar -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cartview') }}">
                                <i class="fas fa-shopping-cart"></i> ตะกร้า
                            </a>
                        </li>
                         <li class="nav-item dropdown">
                             <a id="navbarDropdown" class="nav-link " href="#" role="button">
                                 สวัสดี {{ Auth::user()->name }}
                             </a>

                             
                         </li>
                         <li class="nav-item">
                            <a class="nav-link" href="{{ route('signout') }}">
                                <i class=""></i> ออกจากระบบ
                            </a>
                        </li>
                         @endguest
                     </ul>
                 </div>
             </div>
         </nav>
 
         <main class="">
             @yield('content')
         </main>

         <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Clothing Shop 2024</p></div>
        </footer>
     </div>
 </body>
 </html>