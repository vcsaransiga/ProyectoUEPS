<x-guest-layout>
    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">
                <x-guest.sidenav-guest />
            </div>
        </div>
    </div>
    <main class="main-content mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-md-6 d-flex flex-column mx-auto">
                            <div class="card card-plain mt-8">
                                <div class="card-header pb-0 text-left bg-transparent text-center">
                                    <h3 class="font-weight-black text-dark display-6" style="color:#4a59a4!important;">
                                        Bienvenido
                                    </h3>
                                    <p class="mb-0" style="color:#4a59a4!important;">Crea una nueva cuenta<br></p>
                                    <p class="mb-0" style="color:#4a59a4!important;">O inicia sesión con tus
                                        credenciales</p>
                                </div>
                                <div class="text-center">
                                    @if (session('status'))
                                        <div class="mb-4 font-medium text-sm text-green-600">
                                            {{ session('status') }}
                                        </div>
                                    @endif
                                    @if (session('success'))
                                        <div class="alert alert-success text-sm" role="alert">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                    @error('message')
                                        <div class="alert alert-danger text-sm" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    @if (session('retry_after'))
                                        <div id="countdown" class="alert alert-danger text-sm" role="alert">
                                            Inténtalo de nuevo en <span
                                                id="seconds">{{ session('retry_after') }}</span> segundos.
                                        </div>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <form role="form" class="text-start" id="login-form" method="POST"
                                        action="{{ route('sign-in') }}">
                                        @csrf
                                        <label style="color:#4a59a4!important;">Correo Electrónico</label>
                                        <div class="mb-3">
                                            <input type="email" id="email" name="email" class="form-control"
                                                placeholder="Ingresa tu Correo Electrónico" value="{{ old('email') }}"
                                                aria-label="Email" aria-describedby="email-addon">
                                            @error('email')
                                                <span class="text-danger text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <label style="color:#4a59a4!important;">Contraseña</label>
                                        <div class="mb-3 position-relative">
                                            <!-- Input con el icono integrado -->
                                            <input type="password" id="password" name="password"
                                                class="form-control pe-5 no-native-password-icon" placeholder="Contraseña"
                                                aria-label="Password" aria-describedby="password-addon">
                                            <!-- Icono que controla la visibilidad -->
                                            <i class="fas fa-eye position-absolute end-0 top-50 translate-middle-y me-3 cursor-pointer" 
                                               id="toggleIcon"></i>
                                        </div>
                                        @if ($errors->has('message'))
                                            <div class="alert alert-danger text-sm" role="alert">
                                                {{ $errors->first('message') }}
                                            </div>
                                        @endif
                                        @error('password')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                        <div class="d-flex align-items-center">
                                            <a href="{{ route('password.request') }}"
                                                class="text-xs font-weight-bold ms-auto"
                                                style="color:#4a59a4!important;">Olvidé mi contraseña</a>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-dark w-100 mt-4 mb-3"
                                                style="background-color:#84be51!important; border-color:#84be51;">Iniciar
                                                Sesión</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                    <p class="mb-4 text-xs mx-auto" style="color:#4a59a4!important;">
                                        ¿No tienes una cuenta aún?
                                        <a href="{{ route('sign-up') }}" class="text-dark font-weight-bold"
                                            style="color:#4a59a4!important;">Registrarse Ahora </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex justify-content-center">
                            <div class="text-center">
                                <img src="../assets/img/logoVertical.png" alt="Logo UEPS">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <style>
        /* Ocultar el icono nativo del navegador */
        input[type="password"].no-native-password-icon::-ms-reveal, 
        input[type="password"].no-native-password-icon::-ms-clear,
        input[type="password"].no-native-password-icon::-webkit-clear-button,
        input[type="password"].no-native-password-icon::-webkit-password-toggle-button {
            display: none;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            // Alternar entre ver y ocultar contraseña al hacer clic en el icono
            toggleIcon.addEventListener('click', () => {
                const isPassword = passwordInput.type === 'password';
                passwordInput.type = isPassword ? 'text' : 'password';
                toggleIcon.classList.toggle('fa-eye');
                toggleIcon.classList.toggle('fa-eye-slash');
            });
        });
    </script>
</x-guest-layout>
