<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('inc.head')
    <body class="login">
        <main class="container-fluid min-vh-100 d-flex align-items-center justify-content-center">
            <div class="row w-100 justify-content-center">
                <div class="col-11 col-sm-10 col-md-8 col-lg-5 col-xl-4 p-4 p-sm-5 rounded-5 login-card">
                    <h1 class="mb-4 text-center text-sm-start">Login</h1>
                    
                    <form method="POST" action="{{ route('authenticate') }}" novalidate>
                        @csrf
                        
                        <div class="mb-3">
                            <label for="USUARIO" class="form-label fw-semibold">Usuário</label>
                            <div class="input-group">
                                <span class="input-group-text bg-dark border-warning">
                                    <i class="bi bi-person-fill text-warning"></i>
                                </span>
                                <input type="text" class="form-control bg-dark text-light border-warning" id="USUARIO" name="nome_usuario" placeholder="Digite seu usuário" autocomplete="username" required>
                            </div>
                            <div id="usuarioHelp" class="form-text small">Digite seu nome de usuário cadastrado</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="SENHA" class="form-label fw-semibold">Senha</label>
                            <div class="input-group">
                                <span class="input-group-text bg-dark border-warning">
                                    <i class="bi bi-lock-fill text-warning"></i>
                                </span>
                                <input type="password" class="form-control bg-dark text-light border-warning" id="SENHA" name="password" placeholder="Digite sua senha" autocomplete="current-password" required >
                                <button class="btn btn-outline-warning border-warning" type="button" id="togglePassword" aria-label="Mostrar/ocultar senha" >
                                    <i class="bi bi-eye-fill"></i>
                                </button>
                            </div>
                            <div id="senhaHelp" class="form-text small">Mínimo 6 caracteres</div>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember" >
                            <label class="form-check-label text-light" for="remember">
                                Lembrar-me
                            </label>
                        </div>

                        <hr class="my-4 border-warning opacity-25">

                        <button class="w-100 btn btn-lg btn-warning fw-semibold py-2"  type="submit" >
                            <i class="bi bi-box-arrow-in-right me-2"></i>
                            Logar
                        </button>

                        <div class="text-center mt-3">
                            <a href="#" class="text-warning text-decoration-none small">
                                Esqueceu a senha?
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </main>

        <!-- Bootstrap Icons (para os ícones) -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <script>
            // Toggle password visibility
            document.getElementById('togglePassword')?.addEventListener('click', function() {
                const passwordInput = document.getElementById('SENHA');
                const icon = this.querySelector('i');
                
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.classList.remove('bi-eye-fill');
                    icon.classList.add('bi-eye-slash-fill');
                } else {
                    passwordInput.type = 'password';
                    icon.classList.remove('bi-eye-slash-fill');
                    icon.classList.add('bi-eye-fill');
                }
            });

            // Validação básica do formulário
            document.querySelector('form')?.addEventListener('submit', function(e) {
                const usuario = document.getElementById('USUARIO');
                const senha = document.getElementById('SENHA');
                
                if (!usuario.value.trim()) {
                    e.preventDefault();
                    usuario.classList.add('is-invalid');
                    usuario.focus();
                    return false;
                }
                
                if (!senha.value || senha.value.length < 6) {
                    e.preventDefault();
                    senha.classList.add('is-invalid');
                    senha.focus();
                    return false;
                }
                
                return true;
            });

            // Remove validação de erro ao digitar
            document.querySelectorAll('input').forEach(input => {
                input.addEventListener('input', function() {
                    this.classList.remove('is-invalid');
                });
            });
        </script>
    </body>
</html>