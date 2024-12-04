<nav class="navbar navbar-main navbar-expand-lg mx-5 px-0 shadow-none rounded" id="navbarBlur" navbar-scroll="true">
    <div class="container-fluid py-1 px-2">
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4 d-flex justify-content-end" id="navbar">
            <div class="mb-0 font-weight-bold breadcrumb-text text-white d-flex align-items-center">
                <!-- Botón de cerrar sesión -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-sm btn-white mb-0 me-2" type="submit">Cerrar Sesión</button>
                </form>

                <!-- Imagen de perfil como botón -->
                <a href="{{ route('users.profile') }}" class="nav-link text-body p-0 d-flex align-items-center">
                    <img 
                        src="{{ asset('storage/profile_photos/default.jpg') }}" 
                        alt="Perfil del usuario"
                        class="avatar avatar-sm border-radius-lg shadow-sm"
                        style="width: 40px; height: 40px; object-fit: cover; margin-left: 10px;">
                </a>
            </div>
        </div>
    </div>
</nav>
