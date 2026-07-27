<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('inc.head')
    <body class="dashboard">
        <!-- Wrapper principal -->
        <div class="d-flex min-vh-100" id="wrapper">
            
            <!-- Sidebar -->
            @include('inc.sidBar')

            <!-- Conteúdo principal -->
            <div id="page-content-wrapper" class="w-100">
                <!-- Navbar superior -->
                @include('inc.sidBarMobile')

                <!-- Conteúdo das despesas -->
                <div class="container-fluid p-3 p-md-4">
                    <!-- Título e botão -->
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                        <h2 class="text-warning mb-2 mb-sm-0">
                            <i class="bi bi-wallet2 me-2"></i>
                            Gerenciar Despesas
                        </h2>
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#expenseModal">
                            <i class="bi bi-plus-circle-fill me-2"></i>
                            Nova Despesa
                        </button>
                    </div>

                    <!-- 2 Grids de Gráficos -->
                    <div class="row g-3 g-md-4 mb-4">
                        <!-- Grid 1: Despesas Fixas -->
                        <div class="col-lg-6">
                            <div class="card bg-dark border-warning text-light h-100">
                                <div class="card-header border-warning d-flex justify-content-between align-items-center">
                                    <h6 class="text-warning mb-0">
                                        <i class="bi bi-house-fill me-2"></i>
                                        Despesas Fixas
                                    </h6>
                                    <span class="badge bg-warning text-dark">Mensal</span>
                                </div>
                                <div class="card-body">
                                    <div style="position: relative; height: 150px;">
                                        <canvas id="fixedChart"></canvas>
                                    </div>
                                    <div class="d-flex justify-content-between mt-3">
                                        <div>
                                            <small class="text-secondary">Mês Atual</small>
                                            <p class="text-warning mb-0 fw-bold" id="fixedCurrent">R$ 0,00</p>
                                        </div>
                                        <div>
                                            <small class="text-secondary">Mês Anterior</small>
                                            <p class="text-light mb-0" id="fixedPrevious">R$ 0,00</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Grid 2: Despesas Variáveis -->
                        <div class="col-lg-6">
                            <div class="card bg-dark border-warning text-light h-100">
                                <div class="card-header border-warning d-flex justify-content-between align-items-center">
                                    <h6 class="text-warning mb-0">
                                        <i class="bi bi-arrow-left-right me-2"></i>
                                        Despesas Variáveis
                                    </h6>
                                    <span class="badge bg-info">Variável</span>
                                </div>
                                <div class="card-body">
                                    <div style="position: relative; height: 150px;">
                                        <canvas id="variableChart"></canvas>
                                    </div>
                                    <div class="d-flex justify-content-between mt-3">
                                        <div>
                                            <small class="text-secondary">Mês Atual</small>
                                            <p class="text-warning mb-0 fw-bold" id="variableCurrent">R$ 0,00</p>
                                        </div>
                                        <div>
                                            <small class="text-secondary">Mês Anterior</small>
                                            <p class="text-light mb-0" id="variablePrevious">R$ 0,00</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabela de Despesas -->
                    <div class="card bg-dark border-warning text-light">
                        <div class="card-header border-warning">
                            <div class="row g-2 align-items-center">
                                <div class="col-md-3">
                                    <h5 class="text-warning mb-0">
                                        <i class="bi bi-list-ul me-2"></i>
                                        Lista de Despesas
                                    </h5>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-select bg-dark text-light border-warning" id="filterType">
                                        <option value="">Todos os tipos</option>
                                        <option value="Fixa">Despesas Fixas</option>
                                        <option value="Variável">Despesas Variáveis</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-select bg-dark text-light border-warning" id="filterStatus">
                                        <option value="">Todos os status</option>
                                        <option value="Pago">Pago</option>
                                        <option value="Pendente">Pendente</option>
                                        <option value="Atrasado">Atrasado</option>
                                        <option value="Cancelado">Cancelado</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-text bg-dark border-warning text-warning">
                                            <i class="bi bi-search"></i>
                                        </span>
                                        <input type="text" class="form-control bg-dark text-light border-warning" 
                                               id="searchExpense" placeholder="Buscar despesa...">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-dark table-hover mb-0" id="expensesTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Descrição</th>
                                            <th>Tipo</th>
                                            <th>Valor</th>
                                            <th>Data</th>
                                            <th>Status</th>
                                            <th>Forma Pag.</th>
                                            <th>Parcelas</th>
                                            <th>Cartão</th>
                                            <th class="text-center">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody id="expensesTableBody">
                                        <!-- Despesas serão carregadas aqui -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer border-warning">
                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                <span class="text-light" id="totalExpenses">Total: 0 despesas</span>
                                <span class="text-warning fw-bold" id="totalAmount">Total: R$ 0,00</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Cadastro/Edição -->
        <div class="modal fade" id="expenseModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content bg-dark text-light">
                    <div class="modal-header border-warning">
                        <h5 class="modal-title text-warning" id="modalTitle">
                            <i class="bi bi-plus-circle-fill me-2"></i>
                            Nova Despesa
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form id="expenseForm" novalidate>
                        <div class="modal-body">
                            <input type="hidden" id="expenseId">
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="expenseDescription" class="form-label fw-semibold">Descrição</label>
                                    <input type="text" class="form-control bg-dark text-light border-warning" 
                                           id="expenseDescription" placeholder="Ex: Aluguel" required>
                                    <div class="invalid-feedback">Por favor, informe a descrição.</div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="expenseType" class="form-label fw-semibold">
                                        Tipo de Despesa
                                        <i class="bi bi-info-circle text-warning ms-1" 
                                           data-bs-toggle="tooltip" 
                                           data-bs-html="true"
                                           title="<strong>Fixa:</strong> Mensal com valor igual ou parecido<br>
                                                  <strong>Variável:</strong> Frequente com valor variável">
                                        </i>
                                    </label>
                                    <select class="form-select bg-dark text-light border-warning" id="expenseType" required>
                                        <option value="">Selecione...</option>
                                        <option value="Fixa">Fixa (Mensal)</option>
                                        <option value="Variável">Variável (Valor muda)</option>
                                    </select>
                                    <div class="invalid-feedback">Por favor, selecione o tipo.</div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="expenseAmount" class="form-label fw-semibold">Valor (R$)</label>
                                    <input type="number" step="0.01" class="form-control bg-dark text-light border-warning" 
                                           id="expenseAmount" placeholder="0,00" required>
                                    <div class="invalid-feedback">Por favor, informe o valor.</div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="expenseDate" class="form-label fw-semibold">Data</label>
                                    <input type="date" class="form-control bg-dark text-light border-warning" 
                                           id="expenseDate" required>
                                    <div class="invalid-feedback">Por favor, informe a data.</div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="expenseStatus" class="form-label fw-semibold">Status de Pagamento</label>
                                    <select class="form-select bg-dark text-light border-warning" id="expenseStatus" required>
                                        <option value="">Selecione...</option>
                                        <option value="Pago">Pago</option>
                                        <option value="Pendente">Pendente</option>
                                        <option value="Atrasado">Atrasado</option>
                                        <option value="Cancelado">Cancelado</option>
                                    </select>
                                    <div class="invalid-feedback">Por favor, selecione o status.</div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="expensePaymentMethod" class="form-label fw-semibold">Forma de Pagamento</label>
                                    <select class="form-select bg-dark text-light border-warning" id="expensePaymentMethod">
                                        <option value="">Selecione...</option>
                                        <option value="Dinheiro">Dinheiro</option>
                                        <option value="Pix">Pix</option>
                                        <option value="Boleto">Boleto</option>
                                        <option value="Débito">Débito</option>
                                        <option value="Crédito">Crédito</option>
                                        <option value="Transferência">Transferência</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="expenseInstallments" class="form-label fw-semibold">Nº Parcelas</label>
                                    <input type="number" class="form-control bg-dark text-light border-warning" 
                                           id="expenseInstallments" placeholder="1" min="1" max="24" value="1">
                                    <small class="text-secondary">Para pagamento à vista, informe 1</small>
                                </div>
                                
                                <div class="col-md-8">
                                    <label for="expenseCardName" class="form-label fw-semibold">Nome do Cartão (se aplicável)</label>
                                    <input type="text" class="form-control bg-dark text-light border-warning" 
                                           id="expenseCardName" placeholder="Ex: Nubank, Itaú, etc.">
                                    <small class="text-secondary">Informe o cartão usado no crédito</small>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-warning">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-warning" id="saveExpenseBtn">
                                <i class="bi bi-save me-2"></i>
                                Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal de Confirmação de Exclusão -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-dark text-light">
                    <div class="modal-header border-danger">
                        <h5 class="modal-title text-danger">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            Confirmar Exclusão
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Tem certeza que deseja excluir a despesa <strong id="deleteExpenseDesc"></strong>?</p>
                        <p class="text-danger small">Esta ação não pode ser desfeita.</p>
                        <input type="hidden" id="deleteExpenseId">
                    </div>
                    <div class="modal-footer border-danger">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                            <i class="bi bi-trash-fill me-2"></i>
                            Excluir
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tooltip explicativo -->
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
            <div class="toast" role="alert" id="infoToast" style="background-color: #1a1a2e; border: 1px solid #f5b645;">
                <div class="toast-header" style="background-color: #1a1a2e; color: #f5b645; border-bottom: 1px solid #f5b645;">
                    <i class="bi bi-info-circle-fill me-2 text-warning"></i>
                    <strong class="me-auto">Tipos de Despesa</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body text-light">
                    <p><strong class="text-warning">Despesas Fixas:</strong> Pagas todos os meses, valor igual ou parecido.</p>
                    <p><strong class="text-info">Despesas Variáveis:</strong> Frequentes, mas valor muda ou não obrigatórias todo mês.</p>
                </div>
            </div>
        </div>

        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            // Dados iniciais das despesas com valores fictícios
            let expenses = [
                { 
                    id: 1, 
                    description: 'Aluguel - Apartamento Centro', 
                    type: 'Fixa', 
                    amount: 1850.00, 
                    date: '2024-03-01', 
                    status: 'Pago',
                    payment_method: 'Transferência',
                    installments: 1,
                    card_name: ''
                },
                { 
                    id: 2, 
                    description: 'Supermercado Extra', 
                    type: 'Variável', 
                    amount: 1247.30, 
                    date: '2024-03-03', 
                    status: 'Pago',
                    payment_method: 'Débito',
                    installments: 1,
                    card_name: ''
                },
                { 
                    id: 3, 
                    description: 'Internet Fibra 500MB', 
                    type: 'Fixa', 
                    amount: 149.90, 
                    date: '2024-03-05', 
                    status: 'Pago',
                    payment_method: 'Boleto',
                    installments: 1,
                    card_name: ''
                },
                { 
                    id: 4, 
                    description: 'Uber/Lyft - Transporte', 
                    type: 'Variável', 
                    amount: 89.50, 
                    date: '2024-03-08', 
                    status: 'Pendente',
                    payment_method: 'Crédito',
                    installments: 1,
                    card_name: 'Nubank'
                },
                { 
                    id: 5, 
                    description: 'Energia Elétrica - CEMIG', 
                    type: 'Fixa', 
                    amount: 234.75, 
                    date: '2024-03-10', 
                    status: 'Pago',
                    payment_method: 'Débito',
                    installments: 1,
                    card_name: ''
                },
                { 
                    id: 6, 
                    description: 'Combustível - Posto Shell', 
                    type: 'Variável', 
                    amount: 320.00, 
                    date: '2024-03-12', 
                    status: 'Pago',
                    payment_method: 'Pix',
                    installments: 1,
                    card_name: ''
                },
                { 
                    id: 7, 
                    description: 'Streaming - Netflix + Spotify', 
                    type: 'Fixa', 
                    amount: 69.90, 
                    date: '2024-03-15', 
                    status: 'Pago',
                    payment_method: 'Crédito',
                    installments: 1,
                    card_name: 'Itaú'
                },
                { 
                    id: 8, 
                    description: 'Jantar - Restaurante Italiano', 
                    type: 'Variável', 
                    amount: 187.90, 
                    date: '2024-03-18', 
                    status: 'Pendente',
                    payment_method: 'Crédito',
                    installments: 3,
                    card_name: 'Nubank'
                },
                { 
                    id: 9, 
                    description: 'Água - Sabesp', 
                    type: 'Fixa', 
                    amount: 95.00, 
                    date: '2024-03-20', 
                    status: 'Pago',
                    payment_method: 'Boleto',
                    installments: 1,
                    card_name: ''
                },
                { 
                    id: 10, 
                    description: 'Compras - Roupas Zara', 
                    type: 'Variável', 
                    amount: 425.00, 
                    date: '2024-03-22', 
                    status: 'Pago',
                    payment_method: 'Crédito',
                    installments: 2,
                    card_name: 'Itaú'
                },
                { 
                    id: 11, 
                    description: 'Plano de Saúde - Unimed', 
                    type: 'Fixa', 
                    amount: 685.00, 
                    date: '2024-03-25', 
                    status: 'Atrasado',
                    payment_method: 'Boleto',
                    installments: 1,
                    card_name: ''
                },
                { 
                    id: 12, 
                    description: 'Farmácia - Medicamentos', 
                    type: 'Variável', 
                    amount: 156.30, 
                    date: '2024-03-28', 
                    status: 'Pago',
                    payment_method: 'Débito',
                    installments: 1,
                    card_name: ''
                },
                { 
                    id: 13, 
                    description: 'Academia - Smart Fit', 
                    type: 'Fixa', 
                    amount: 119.90, 
                    date: '2024-03-01', 
                    status: 'Pago',
                    payment_method: 'Crédito',
                    installments: 1,
                    card_name: 'Nubank'
                },
                { 
                    id: 14, 
                    description: 'Manutenção Carro - Oficina', 
                    type: 'Variável', 
                    amount: 850.00, 
                    date: '2024-03-05', 
                    status: 'Pendente',
                    payment_method: 'Pix',
                    installments: 1,
                    card_name: ''
                },
                { 
                    id: 15, 
                    description: 'Condomínio - Edifício Central', 
                    type: 'Fixa', 
                    amount: 580.00, 
                    date: '2024-03-10', 
                    status: 'Pago',
                    payment_method: 'Transferência',
                    installments: 1,
                    card_name: ''
                }
            ];

            // Dados fixos do mês anterior (valores fictícios)
            const previousMonthData = {
                fixed: 2845.35,  // Soma das despesas fixas do mês anterior
                variable: 2347.80 // Soma das despesas variáveis do mês anterior
            };

            let chartInstances = {
                fixed: null,
                variable: null
            };
            
            let nextId = 16;
            let editingId = null;

            // Inicializar tooltips
            document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
                new bootstrap.Tooltip(el);
            });

            // Renderizar tabela
            function renderTable(expensesData = expenses) {
                const tbody = document.getElementById('expensesTableBody');
                const totalExpenses = document.getElementById('totalExpenses');
                const totalAmount = document.getElementById('totalAmount');
                
                if (expensesData.length === 0) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="10" class="text-center py-4 text-secondary">
                                <i class="bi bi-inbox display-4 d-block mb-2"></i>
                                Nenhuma despesa encontrada
                            </td>
                        </tr>
                    `;
                    totalExpenses.textContent = 'Total: 0 despesas';
                    totalAmount.textContent = 'Total: R$ 0,00';
                    updateCharts();
                    return;
                }

                let total = 0;
                tbody.innerHTML = expensesData.map(expense => {
                    total += expense.amount;
                    return `
                        <tr>
                            <td>#${expense.id}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="badge ${expense.type === 'Fixa' ? 'bg-warning text-dark' : 'bg-info'} me-2">
                                        ${expense.type === 'Fixa' ? '📌' : '📊'}
                                    </span>
                                    ${expense.description}
                                </div>
                            </td>
                            <td>
                                <span class="badge ${expense.type === 'Fixa' ? 'bg-warning text-dark' : 'bg-info'}">
                                    ${expense.type}
                                </span>
                            </td>
                            <td class="text-warning fw-bold">R$ ${expense.amount.toFixed(2)}</td>
                            <td>${formatDate(expense.date)}</td>
                            <td>
                                <span class="badge ${expense.status === 'Pago' ? 'bg-success' : expense.status === 'Pendente' ? 'bg-warning text-dark' : expense.status === 'Atrasado' ? 'bg-danger' : 'bg-secondary'}">
                                    ${expense.status}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-dark border border-warning text-light">
                                    ${expense.payment_method || '-'}
                                </span>
                            </td>
                            <td class="text-center">
                                ${expense.installments > 1 ? `${expense.installments}x` : '1x'}
                            </td>
                            <td>
                                ${expense.card_name ? 
                                    `<span class="badge bg-primary bg-opacity-25 text-light">
                                        <i class="bi bi-credit-card me-1"></i>
                                        ${expense.card_name}
                                    </span>` : 
                                    '<span class="text-secondary">-</span>'
                                }
                            </td>
                            <td>
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-warning edit-expense" data-id="${expense.id}" title="Editar">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger delete-expense" data-id="${expense.id}" data-desc="${expense.description}" title="Excluir">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `;
                }).join('');

                totalExpenses.textContent = `Total: ${expensesData.length} despesas`;
                totalAmount.textContent = `Total: R$ ${total.toFixed(2)}`;
                
                updateCharts();
            }

            // Formatar data
            function formatDate(dateStr) {
                const date = new Date(dateStr);
                return date.toLocaleDateString('pt-BR', { day: '2-digit', month: '2-digit', year: 'numeric' });
            }

            // Calcular despesas do mês atual
            function getCurrentMonthExpenses() {
                const now = new Date();
                const currentMonth = now.getMonth();
                const currentYear = now.getFullYear();

                return expenses.filter(e => {
                    const date = new Date(e.date);
                    return date.getMonth() === currentMonth && date.getFullYear() === currentYear;
                });
            }

            // Destruir todos os gráficos
            function destroyAllCharts() {
                Object.keys(chartInstances).forEach(key => {
                    if (chartInstances[key]) {
                        try {
                            chartInstances[key].destroy();
                        } catch (e) {
                            console.warn('Erro ao destruir gráfico:', key, e);
                        }
                        chartInstances[key] = null;
                    }
                });
            }

            // Criar gráfico individual
            function createChart(canvasId, data, labels, colors) {
                const canvas = document.getElementById(canvasId);
                if (!canvas) return null;

                const ctx = canvas.getContext('2d');
                
                return new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Valor (R$)',
                            data: data,
                            backgroundColor: colors || [
                                'rgba(245, 182, 69, 0.8)',
                                'rgba(200, 200, 200, 0.3)'
                            ],
                            borderColor: ['#f5b645', '#999999'],
                            borderWidth: 2,
                            borderRadius: 5
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    color: '#ccc',
                                    callback: function(value) {
                                        return 'R$ ' + value.toFixed(2);
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

            // Atualizar gráficos
            function updateCharts() {
                const currentExpenses = getCurrentMonthExpenses();

                // Calcular totais do mês atual por tipo
                const fixedCurrent = currentExpenses.filter(e => e.type === 'Fixa').reduce((sum, e) => sum + e.amount, 0);
                const variableCurrent = currentExpenses.filter(e => e.type === 'Variável').reduce((sum, e) => sum + e.amount, 0);

                // Atualizar textos
                document.getElementById('fixedCurrent').textContent = `R$ ${fixedCurrent.toFixed(2)}`;
                document.getElementById('fixedPrevious').textContent = `R$ ${previousMonthData.fixed.toFixed(2)}`;
                document.getElementById('variableCurrent').textContent = `R$ ${variableCurrent.toFixed(2)}`;
                document.getElementById('variablePrevious').textContent = `R$ ${previousMonthData.variable.toFixed(2)}`;

                // Destruir gráficos antigos
                destroyAllCharts();

                // Criar novos gráficos com valores fictícios
                chartInstances.fixed = createChart('fixedChart', [fixedCurrent, previousMonthData.fixed], ['Atual', 'Anterior']);
                chartInstances.variable = createChart('variableChart', [variableCurrent, previousMonthData.variable], ['Atual', 'Anterior']);
            }

            // Salvar despesa (criar/editar)
            document.getElementById('expenseForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const form = this;
                if (!form.checkValidity()) {
                    form.classList.add('was-validated');
                    return;
                }

                const id = document.getElementById('expenseId').value;
                const description = document.getElementById('expenseDescription').value.trim();
                const type = document.getElementById('expenseType').value;
                const amount = parseFloat(document.getElementById('expenseAmount').value);
                const date = document.getElementById('expenseDate').value;
                const status = document.getElementById('expenseStatus').value;
                const payment_method = document.getElementById('expensePaymentMethod').value;
                const installments = parseInt(document.getElementById('expenseInstallments').value) || 1;
                const card_name = document.getElementById('expenseCardName').value.trim();

                if (id) {
                    const index = expenses.findIndex(e => e.id === parseInt(id));
                    if (index !== -1) {
                        expenses[index] = {
                            ...expenses[index],
                            description,
                            type,
                            amount,
                            date,
                            status,
                            payment_method: payment_method || expenses[index].payment_method,
                            installments: installments || expenses[index].installments,
                            card_name: card_name || expenses[index].card_name
                        };
                        showToast('Despesa atualizada com sucesso!', 'success');
                    }
                } else {
                    const newExpense = {
                        id: nextId++,
                        description,
                        type,
                        amount,
                        date,
                        status,
                        payment_method: payment_method || 'Não informado',
                        installments: installments || 1,
                        card_name: card_name || ''
                    };
                    expenses.push(newExpense);
                    showToast('Despesa cadastrada com sucesso!', 'success');
                }

                renderTable();
                resetForm();
                bootstrap.Modal.getInstance(document.getElementById('expenseModal')).hide();
            });

            // Editar despesa
            document.addEventListener('click', function(e) {
                if (e.target.closest('.edit-expense')) {
                    const btn = e.target.closest('.edit-expense');
                    const id = parseInt(btn.dataset.id);
                    const expense = expenses.find(e => e.id === id);
                    
                    if (expense) {
                        editingId = id;
                        document.getElementById('expenseId').value = id;
                        document.getElementById('expenseDescription').value = expense.description;
                        document.getElementById('expenseType').value = expense.type;
                        document.getElementById('expenseAmount').value = expense.amount;
                        document.getElementById('expenseDate').value = expense.date;
                        document.getElementById('expenseStatus').value = expense.status;
                        document.getElementById('expensePaymentMethod').value = expense.payment_method || '';
                        document.getElementById('expenseInstallments').value = expense.installments || 1;
                        document.getElementById('expenseCardName').value = expense.card_name || '';
                        document.getElementById('modalTitle').innerHTML = '<i class="bi bi-pencil-fill me-2"></i>Editar Despesa';
                        document.getElementById('saveExpenseBtn').innerHTML = '<i class="bi bi-pencil-fill me-2"></i>Atualizar';
                        
                        const modal = new bootstrap.Modal(document.getElementById('expenseModal'));
                        modal.show();
                    }
                }
            });

            // Excluir despesa
            document.addEventListener('click', function(e) {
                if (e.target.closest('.delete-expense')) {
                    const btn = e.target.closest('.delete-expense');
                    const id = parseInt(btn.dataset.id);
                    const desc = btn.dataset.desc;
                    
                    document.getElementById('deleteExpenseId').value = id;
                    document.getElementById('deleteExpenseDesc').textContent = desc;
                    
                    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
                    modal.show();
                }
            });

            // Confirmar exclusão
            document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
                const id = parseInt(document.getElementById('deleteExpenseId').value);
                expenses = expenses.filter(e => e.id !== id);
                renderTable();
                showToast('Despesa excluída com sucesso!', 'danger');
                bootstrap.Modal.getInstance(document.getElementById('deleteModal')).hide();
            });

            // Resetar formulário
            function resetForm() {
                document.getElementById('expenseForm').reset();
                document.getElementById('expenseId').value = '';
                document.getElementById('expenseInstallments').value = 1;
                document.getElementById('modalTitle').innerHTML = '<i class="bi bi-plus-circle-fill me-2"></i>Nova Despesa';
                document.getElementById('saveExpenseBtn').innerHTML = '<i class="bi bi-save me-2"></i>Salvar';
                document.getElementById('expenseForm').classList.remove('was-validated');
            }

            // Reset ao fechar modal
            document.getElementById('expenseModal').addEventListener('hidden.bs.modal', function() {
                resetForm();
            });

            // Filtrar por tipo
            document.getElementById('filterType').addEventListener('change', function() {
                applyFilters();
            });

            // Filtrar por status
            document.getElementById('filterStatus').addEventListener('change', function() {
                applyFilters();
            });

            // Buscar despesas
            document.getElementById('searchExpense').addEventListener('input', function() {
                applyFilters();
            });

            // Aplicar todos os filtros
            function applyFilters() {
                const type = document.getElementById('filterType').value;
                const status = document.getElementById('filterStatus').value;
                const search = document.getElementById('searchExpense').value.toLowerCase().trim();
                
                let filtered = expenses;
                
                if (type !== '') {
                    filtered = filtered.filter(e => e.type === type);
                }
                
                if (status !== '') {
                    filtered = filtered.filter(e => e.status === status);
                }
                
                if (search !== '') {
                    filtered = filtered.filter(e => 
                        e.description.toLowerCase().includes(search) ||
                        e.payment_method.toLowerCase().includes(search) ||
                        e.card_name.toLowerCase().includes(search)
                    );
                }
                
                renderTable(filtered);
            }

            // Toast personalizado
            function showToast(message, type = 'success') {
                const toast = document.createElement('div');
                toast.className = `toast align-items-center text-white bg-${type} border-0 position-fixed top-0 end-0 m-3`;
                toast.style.zIndex = '9999';
                toast.innerHTML = `
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="bi bi-${type === 'success' ? 'check-circle-fill' : 'trash-fill'} me-2"></i>
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                `;
                document.body.appendChild(toast);
                
                const bsToast = new bootstrap.Toast(toast, { delay: 3000 });
                bsToast.show();
                
                toast.addEventListener('hidden.bs.toast', function() {
                    this.remove();
                });
            }

            // Toggle sidebar no mobile
            document.getElementById('toggleSidebar')?.addEventListener('click', function() {
                document.getElementById('sidebar').classList.toggle('show');
            });

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

            // Mostrar toast de informação
            const infoToast = new bootstrap.Toast(document.getElementById('infoToast'), { delay: 5000 });
            setTimeout(() => infoToast.show(), 1000);

            // Renderizar tabela inicial
            renderTable();

            // Limpar gráficos ao sair da página
            window.addEventListener('beforeunload', function() {
                destroyAllCharts();
            });
        </script>
    </body>
</html>