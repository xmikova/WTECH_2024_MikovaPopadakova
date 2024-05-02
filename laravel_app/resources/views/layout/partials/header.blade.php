<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container me-auto">
            <div class="mx-auto">
                <a class="navbar-brand" href="{{ route('landing') }}">GEEKGLAMOUR</a>
            </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false">
                <span class="navbar-toggler-icon"></span>
                <span class="navbar-toggler-text">Menu</span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto ms-5">
                    <li class="nav-item me-5">
                        <a class="nav-link" href="#" id="toggleSidebar">
                            <i class="bi bi-list me-1"></i> Kategórie
                        </a>
                    </li>
                    @if (Route::has('login'))
                        <li class="nav-item me-5">
                            @auth
                                <a class="nav-link" href="{{ url('profile') }}">
                                    <i class="bi bi-person"></i> Profil
                                </a>
                            @else
                                <a class="nav-link" href="{{ route('login') }}">
                                    <i class="bi bi-person"></i> Prihlásenie
                                </a>
                        </li>
                        <li class="nav-item me-5">
                            @if (Route::has('register'))
                                        <a class="nav-link" href="{{ route('register') }}">
                                            <i class="bi bi-person-plus"></i> Registrácia
                                        </a>
                                    @endif
                                @endauth
                        </li>
                    @endif
                    <li class="nav-item me-5">
                        <a class="nav-link">
                            <i class="bi bi-cart me-1"></i> Košík
                        </a>
                    </li>
                </ul>
                <form method="get" class="d-flex" action="{{ route('products.search') }}" >
                    <input class="form-control me-3" type="search" placeholder="Zadajte hľadaný text" aria-label="Search" name="query">
                    <button class="btn btn-outline-dark" type="submit">Hľadať</button>
                </form>

            </div>
        </div>
    </nav>
</header>
