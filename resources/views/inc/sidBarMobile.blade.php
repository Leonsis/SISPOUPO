<?php
    use App\Models\User;
    $user = Auth::user();
?>
<!-- Navbar superior -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom border-warning px-3">
    <div class="container-fluid">
        <button class="btn d-lg-none" type="button" id="toggleSidebar">
            <i class="bi bi-list"></i>
        </button>
        
        <div class="ms-auto d-flex align-items-center gap-3">
            <span class="text-light d-none d-sm-inline">
                <i class="bi bi-person-circle me-1"></i>
                Bem-vindo, <?php echo e($user->nome_usuario); ?>
            </span>
            <div class="dropdown">
                <button class="btn btn-warning btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-bell-fill"></i>
                    <span class="badge bg-danger ms-1">3</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#">Nova mensagem</a></li>
                    <li><a class="dropdown-item" href="#">Atualização disponível</a></li>
                    <li><a class="dropdown-item" href="#">Novo pedido</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>