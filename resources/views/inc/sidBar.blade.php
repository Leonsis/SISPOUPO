@php
    // Nome da rota atual
    $caminho = request()->path();    
@endphp
<!-- Sidebar -->
<nav class="sidebar bg-dark border-end border-warning" id="sidebar">
    <div class="sidebar-header p-3 border-bottom border-warning">
        <h2 class="text-warning mb-0">
            <i class="bi bi-grid-1x2-fill me-2"></i>
            SisPoupo
        </h2>
    </div>
    
    <ul class="nav flex-column p-3">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active text-warning' : '' }}" href="{{ route('dashboard') }}">
                <i class="bi bi-house-fill me-2"></i>
                Início
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('usuarios') ? 'active text-light' : '' }} " href="{{ route('usuarios') }}">
                <i class="bi bi-people-fill me-2"></i>
                Usuários
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ (request()->routeIs('despesas') || $caminho === 'despesas/detalhamento') ? 'active text-light' : '' }} " href="{{ route('despesas') }}">                
                <i class="bi bi-wallet2 me-2"></i>
                Despesas
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light" href="#">
                <i class="bi bi-cart-fill me-2"></i>
                Vendas
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light" href="#">
                <i class="bi bi-graph-up-arrow me-2"></i>
                Relatórios
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('config') ? 'active text-light' : '' }} " href="{{ route('config') }}">
                <i class="bi bi-gear-fill me-2"></i>
                Configurações
            </a>
        </li>
    </ul>
    
    <!-- No sidebar -->
    <div class="sidebar-footer p-3 border-top border-warning mt-auto">
        <form method="POST" action="{{ route('logout') }}" id="logout-form">
            @csrf
            <button type="submit" class="nav-link text-danger bg-transparent border-0 w-100 text-start">
                <i class="bi bi-box-arrow-right me-2"></i>
                Sair
            </button>
        </form>
    </div>
</nav>