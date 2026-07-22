<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('inc.head')
    <body class="login">
        <main class="container">                         
            <div class="d-flex justify-content-center align-items-center vh-100">                
                <div class="w-50 p-5 rounded-5"> 
                    <h1 class="mb-3">Login</h1> 
                    <form method="POST" action="{{ route('authenticate') }}">
                        @csrf
                        <div class="row g-3">                             
                            <div class="mb-2">
                                <label for="USUARIO" class="form-label">Usuario</label>
                                <input type="USUARIO" class="form-control" id="USUARIO">
                                <div id="usuarioHelp" class="form-text">We'll never share your email with anyone else.</div>
                            </div>
                            <div class="mb-2">
                                <label for="SENHA" class="form-label">Senha</label>
                                <input type="password" class="form-control" id="SENHA">
                                <div id="senhaHelp" class="form-text">We'll never share your email with anyone else.</div>
                            </div>
                        </div>

                        <hr class="my-4">
                        <button class="w-100 btn btn-lg" type="submit">Logar</button>
                    </form> 
                </div> 
            </div>
        </main>

        <script>
                
        </script>
    </body>
</html>
