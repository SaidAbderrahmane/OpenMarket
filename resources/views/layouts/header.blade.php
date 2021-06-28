    <!-- navbar-->
    <header class="header bg-white">
        <div class="container px-0 px-lg-3">
            <nav class="navbar navbar-expand-lg navbar-light py-3 px-lg-0"><a class="navbar-brand" href="{{ route('index') }}"><span class="font-weight-bold text-uppercase text-dark">Boutique</span></a>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <!-- Link--><a class="nav-link active" href=" {{ route('index') }} ">Home</a>
                        </li>
                        <li class="nav-item">
                            <!-- Link--><a class="nav-link" href=" {{ route('shop') }} ">Shop</a>
                        </li>
                        <li class="nav-item">
                            <!-- Link--><a class="nav-link" href=" {{ route('stores.index') }} ">Stores</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="{{ route('myorders')}}">My orders</a>
                        </li> -->
                        <!-- <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" id="pagesDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Pages</a>
                            <div class="dropdown-menu mt-3" aria-labelledby="pagesDropdown"><a class="dropdown-item border-0 transition-link" href="{{ route('index') }}">Homepage</a><a class="dropdown-item border-0 transition-link" href="shop.html">Category</a>
                        </li> -->
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item"><a class="nav-link" href=" {{ route('cart') }} "> <i class="fas fa-dolly-flatbed mr-1 text-gray"></i>Cart<small class="text-gray"> ({{ Cart::instance('shopping')->count() }})</small></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('wishlist') }}"> <i class="far fa-heart mr-1"></i><small class="text-gray"> ({{ Cart::instance('wishlist')->count() }})</small></a></li>
                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}"><i class="fas fa-user-alt mr-1 text-gray"></i>{{ __('Login') }}</a>
                        </li>
                        @endif

                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}"><i class="fas fa-user-plus mr-1 text-gray"></i>{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">

                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                                <a class="dropdown-item" href="{{ route('users.edit') }}">
                                    <i class="fas fa-user mr-1 text-gray"></i>My profile
                                </a>

                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt mr-1 text-gray"></i>{{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </nav>
        </div>
    </header>