
  <header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top header-gradient">
      <div class="container-fluid">
        <a class="navbar-brand me-auto" href="/home">ChefOnline</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav ms-auto mb-2 mb-md-0">
            <li class="nav-item dropdown">
              <div class="dropdown">
                <button class="dropbtn">Menu</button>
                <div class="dropdown-content">
					<a href="#">Lista dos Pedidos</a>
					<a href="#">Relatorios</a>
					<a href="#">Lista Negra</a>
					<a class="dropdown-item" href="{{ route('logout') }}"
						onclick="event.preventDefault();
								 document.getElementById('logout-form').submit();">
					{{ __('Logout') }}
					</a>
					<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
						@csrf
					</form>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
