<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('inc.head')
    <body class="dashboard">
        <!-- Wrapper principal -->
        <div class="d-flex min-vh-100" id="wrapper">
            @include('inc.sidBar')
            <!-- Conteúdo principal -->
            <div id="page-content-wrapper" class="w-100">
                @include('inc.sidBarMobile')

                <!-- Conteúdo do dashboard -->
                <div class="container-fluid p-3 p-md-4">
                    <!-- Cards de métricas -->
                    <div class="row g-3 g-md-4 mb-4">
                        <div class="col-6 col-md-3">
                            <div class="card bg-dark border-warning text-light h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="text-secondary">Total Usuários</h6>
                                            <h2 class="text-warning mb-0">1,284</h2>
                                            <small class="text-success">
                                                <i class="bi bi-arrow-up"></i> 12.5%
                                            </small>
                                        </div>
                                        <div class="bg-warning bg-opacity-25 p-2 rounded">
                                            <i class="bi bi-people-fill text-warning fs-4"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-6 col-md-3">
                            <div class="card bg-dark border-warning text-light h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="text-secondary">Vendas Hoje</h6>
                                            <h2 class="text-warning mb-0">R$ 42.5k</h2>
                                            <small class="text-success">
                                                <i class="bi bi-arrow-up"></i> 8.2%
                                            </small>
                                        </div>
                                        <div class="bg-warning bg-opacity-25 p-2 rounded">
                                            <i class="bi bi-cart-fill text-warning fs-4"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-6 col-md-3">
                            <div class="card bg-dark border-warning text-light h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="text-secondary">Produtos</h6>
                                            <h2 class="text-warning mb-0">342</h2>
                                            <small class="text-danger">
                                                <i class="bi bi-arrow-down"></i> 3.1%
                                            </small>
                                        </div>
                                        <div class="bg-warning bg-opacity-25 p-2 rounded">
                                            <i class="bi bi-box-seam-fill text-warning fs-4"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-6 col-md-3">
                            <div class="card bg-dark border-warning text-light h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="text-secondary">Conversão</h6>
                                            <h2 class="text-warning mb-0">23.8%</h2>
                                            <small class="text-success">
                                                <i class="bi bi-arrow-up"></i> 4.3%
                                            </small>
                                        </div>
                                        <div class="bg-warning bg-opacity-25 p-2 rounded">
                                            <i class="bi bi-graph-up-arrow text-warning fs-4"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Gráficos -->
                    <div class="row g-3 g-md-4 mb-4">
                        <div class="col-lg-6">
                            <div class="card bg-dark border-warning text-light h-100">
                                <div class="card-header border-warning">
                                    <h5 class="text-warning mb-0">
                                        <i class="bi bi-bar-chart-fill me-2"></i>
                                        Vendas Mensais
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="salesChart" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-6">
                            <div class="card bg-dark border-warning text-light h-100">
                                <div class="card-header border-warning">
                                    <h5 class="text-warning mb-0">
                                        <i class="bi bi-pie-chart-fill me-2"></i>
                                        Distribuição de Categorias
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="categoryChart" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabelas -->
                    <div class="row g-3 g-md-4">
                        <div class="col-lg-6">
                            <div class="card bg-dark border-warning text-light">
                                <div class="card-header border-warning d-flex justify-content-between align-items-center">
                                    <h5 class="text-warning mb-0">
                                        <i class="bi bi-clock-history me-2"></i>
                                        Últimos Pedidos
                                    </h5>
                                    <button class="btn btn-sm ">Ver Todos</button>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-dark table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Pedido</th>
                                                    <th>Cliente</th>
                                                    <th>Valor</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>#12345</td>
                                                    <td>João Silva</td>
                                                    <td>R$ 2.450,00</td>
                                                    <td><span class="badge bg-success">Concluído</span></td>
                                                </tr>
                                                <tr>
                                                    <td>#12344</td>
                                                    <td>Maria Santos</td>
                                                    <td>R$ 1.280,00</td>
                                                    <td><span class="badge bg-warning text-dark">Processando</span></td>
                                                </tr>
                                                <tr>
                                                    <td>#12343</td>
                                                    <td>Pedro Costa</td>
                                                    <td>R$ 3.750,00</td>
                                                    <td><span class="badge bg-danger">Cancelado</span></td>
                                                </tr>
                                                <tr>
                                                    <td>#12342</td>
                                                    <td>Ana Oliveira</td>
                                                    <td>R$ 890,00</td>
                                                    <td><span class="badge bg-info">Enviado</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-6">
                            <div class="card bg-dark border-warning text-light">
                                <div class="card-header border-warning d-flex justify-content-between align-items-center">
                                    <h5 class="text-warning mb-0">
                                        <i class="bi bi-people me-2"></i>
                                        Últimos Usuários
                                    </h5>
                                    <button class="btn btn-sm ">Ver Todos</button>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-dark table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Nome</th>
                                                    <th>Email</th>
                                                    <th>Nível</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Carlos Lima</td>
                                                    <td>carlos@email.com</td>
                                                    <td>Admin</td>
                                                    <td><span class="badge bg-success">Ativo</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Mariana Dias</td>
                                                    <td>mariana@email.com</td>
                                                    <td>Editor</td>
                                                    <td><span class="badge bg-warning text-dark">Pendente</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Rafael Souza</td>
                                                    <td>rafael@email.com</td>
                                                    <td>User</td>
                                                    <td><span class="badge bg-secondary">Inativo</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Fernanda Rocha</td>
                                                    <td>fernanda@email.com</td>
                                                    <td>Editor</td>
                                                    <td><span class="badge bg-success">Ativo</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <!-- Chart.js para gráficos -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            // Toggle sidebar no mobile
            document.getElementById('toggleSidebar')?.addEventListener('click', function() {
                document.getElementById('sidebar').classList.toggle('show');
            });

            // Gráfico de barras - Vendas mensais
            const ctx = document.getElementById('salesChart')?.getContext('2d');
            if (ctx) {
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul'],
                        datasets: [{
                            label: 'Vendas (R$)',
                            data: [28.5, 32.1, 29.8, 41.2, 38.7, 45.3, 42.5],
                            backgroundColor: 'rgba(245, 182, 69, 0.7)',
                            borderColor: '#f5b645',
                            borderWidth: 2,
                            borderRadius: 5
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                labels: {
                                    color: '#ccc'
                                }
                            }
                        },
                        scales: {
                            y: {
                                ticks: {
                                    color: '#ccc',
                                    callback: function(value) {
                                        return 'R$ ' + value + 'k';
                                    }
                                },
                                grid: {
                                    color: 'rgba(255, 255, 255, 0.05)'
                                }
                            },
                            x: {
                                ticks: {
                                    color: '#ccc'
                                },
                                grid: {
                                    color: 'rgba(255, 255, 255, 0.05)'
                                }
                            }
                        }
                    }
                });
            }

            // Gráfico de pizza - Categorias
            const ctx2 = document.getElementById('categoryChart')?.getContext('2d');
            if (ctx2) {
                new Chart(ctx2, {
                    type: 'doughnut',
                    data: {
                        labels: ['Eletrônicos', 'Roupas', 'Alimentos', 'Livros', 'Outros'],
                        datasets: [{
                            data: [35, 25, 20, 12, 8],
                            backgroundColor: [
                                '#f5b645',
                                '#d4a037',
                                '#b38c28',
                                '#92781f',
                                '#716416'
                            ],
                            borderColor: '#1a1a2e',
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: '#ccc',
                                    padding: 15
                                }
                            }
                        }
                    }
                });
            }

            // Fechar sidebar ao clicar fora no mobile
            document.addEventListener('click', function(event) {
                const sidebar = document.getElementById('sidebar');
                const toggleBtn = document.getElementById('toggleSidebar');
                
                if (window.innerWidth < 992 && 
                    sidebar.classList.contains('show') &&
                    !sidebar.contains(event.target) &&
                    !toggleBtn.contains(event.target)) {
                    sidebar.classList.remove('show');
                }
            });
        </script>
    </body>
</html>