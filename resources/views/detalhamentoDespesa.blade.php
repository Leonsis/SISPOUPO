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

                <!-- Conteúdo do detalhamento -->
                <div class="container-fluid p-3 p-md-4">
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#" class="text-warning text-decoration-none">
                                    <i class="bi bi-house-fill me-1"></i>Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#" class="text-warning text-decoration-none">Despesas</a>
                            </li>
                            <li class="breadcrumb-item active text-light" aria-current="page">Detalhamento</li>
                        </ol>
                    </nav>

                    <!-- Botão Voltar -->
                    <div class="mb-4">
                        <a href="{{ route('despesas') }}" class="btn btn-outline-warning">
                            <i class="bi bi-arrow-left me-2"></i>
                            Voltar para Lista
                        </a>
                    </div>

                    <!-- Detalhamento da Despesa -->
                    <div class="row g-4" id="expenseDetail">
                        <!-- Coluna Principal -->
                        <div class="col-lg-8">
                            <div class="card bg-dark border-warning text-light">
                                <div class="card-header border-warning d-flex justify-content-between align-items-center">
                                    <h5 class="text-warning mb-0">
                                        <i class="bi bi-file-text-fill me-2"></i>
                                        Detalhamento da Despesa
                                    </h5>
                                    <div>
                                        <span class="badge bg-warning text-dark me-2" id="detailId"></span>
                                        <span class="badge bg-success" id="detailStatusBadge"></span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!-- Formulário de Edição -->
                                    <form action="{{ route('despesas.update', ['id' => $movimentacoes->id]) }}" method="POST" id="editFormDespesa" novalidate>
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" id="detailExpenseId">
                                        
                                        <div class="row g-3">
                                            <!-- Descrição -->
                                            <div class="col-md-12">
                                                <label class="form-label fw-semibold text-warning">
                                                    <i class="bi bi-tag-fill me-1"></i>
                                                    Descrição
                                                </label>
                                                <input type="text" class="form-control bg-dark text-light border-warning" id="detailDescription" required>
                                            </div>

                                            <!-- Tipo e Valor -->
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold text-warning">
                                                    <i class="bi bi-tags-fill me-1"></i>
                                                    Tipo
                                                </label>
                                                <select class="form-select bg-dark text-light border-warning" id="detailType">
                                                    <option value="Fixa">📌 Fixa</option>
                                                    <option value="Variável">📊 Variável</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold text-warning">
                                                    <i class="bi bi-cash-stack me-1"></i>
                                                    Valor (R$)
                                                </label>
                                                <input type="number" step="0.01" class="form-control bg-dark text-light border-warning" 
                                                       id="detailAmount" required>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold text-warning">
                                                    <i class="bi bi-check-circle me-1"></i>
                                                    Status
                                                </label>
                                                <select class="form-select bg-dark text-light border-warning" id="detailStatus">
                                                    <option value="Pago">✅ Pago</option>
                                                    <option value="Pendente">⏳ Pendente</option>
                                                    <option value="Atrasado">❌ Atrasado</option>
                                                    <option value="Não pago">🚫 Não pago</option>
                                                </select>
                                            </div>

                                            <!-- Data e Status -->
                                            <div class="col-md-6" id="divDatePagamento" style="display: none;">
                                                <label class="form-label fw-semibold text-warning">
                                                    <i class="bi bi-calendar3 me-1"></i>
                                                    Data de Pagamento
                                                </label>
                                                <input type="date" class="form-control bg-dark text-light border-warning" id="detailDate" required>
                                            </div>                                        

                                            <!-- Forma de Pagamento e Parcelas -->
                                            <div class="col-md-6" id="divPaymentMethod" style="display: none;">
                                                <label class="form-label fw-semibold text-warning">
                                                    <i class="bi bi-wallet me-1"></i>
                                                    Forma de Pagamento
                                                </label>
                                                <select class="form-select bg-dark text-light border-warning" id="detailPaymentMethod">
                                                    <option value="Dinheiro">💰 Dinheiro</option>
                                                    <option value="Pix">📱 Pix</option>
                                                    <option value="Boleto">📄 Boleto</option>
                                                    <option value="Débito">💳 Débito</option>
                                                    <option value="Crédito">💳 Crédito</option>
                                                    <option value="Transferência">🏦 Transferência</option>
                                                </select>
                                            </div>

                                            <!-- Cartão -->
                                            <div class="col-md-6" id="divCard" style="display: none;">
                                                <label class="form-label fw-semibold text-warning">
                                                    <i class="bi bi-credit-card me-1"></i>
                                                    Cartão Utilizado
                                                </label>
                                                <select class="form-select bg-dark text-light border-warning" id="detailCard">
                                                    <option value="">Selecione um cartão...</option>
                                                    <!-- Opções serão carregadas via JavaScript -->
                                                </select>
                                                <small class="text-secondary">Se aplicável para compras no crédito</small>
                                            </div>                                            

                                            <!-- Dia de Vencimento (SEMPRE VISÍVEL) -->
                                            <div class="col-md-6">
                                                <label for="expenseDueDay" class="form-label fw-semibold">
                                                    <i class="bi bi-calendar-day me-1"></i>
                                                    Dia de Vencimento
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-dark border-warning text-warning">
                                                        <i class="bi bi-calendar3"></i>
                                                    </span>
                                                    <input name="dia_vencimento" type="number" class="form-control bg-dark text-light border-warning" id="detailDueDay" placeholder="01" min="1" max="31" required>
                                                    
                                                    <span class="input-group-text bg-dark border-warning text-secondary">Dia do mês</span>
                                                </div>
                                                <div class="invalid-feedback">Por favor, informe o dia de vencimento (1 a 31).</div>                                            
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold text-warning">
                                                    <i class="bi bi-grid-3x3-gap-fill me-1"></i>
                                                    Nº Parcelas
                                                </label>
                                                <input type="number" class="form-control bg-dark text-light border-warning" id="detailInstallments" min="1" max="24">
                                                <small class="text-secondary">1 = à vista</small>
                                            </div>             
                                                                           
                                            <!-- CHECKBOX: Repetir no próximo mês? -->
                                            <div class="col-12">
                                                <div class="form-check form-switch">
                                                    <input name="despesa_repete_mes" class="form-check-input" type="checkbox" role="switch" id="repetirProximoMes" value="1">
                                                    <label class="form-check-label text-warning fw-semibold" for="repetirProximoMes">
                                                        <i class="bi bi-arrow-repeat me-2"></i>
                                                        Repetir no próximo mês?
                                                    </label>
                                                    <small class="text-secondary d-block mt-1">
                                                        Marque esta opção se a despesa se repetirá no próximo mês
                                                    </small>
                                                </div>
                                            </div>

                                            <!-- Observações -->
                                            <div class="col-md-12">
                                                <label class="form-label fw-semibold text-warning">
                                                    <i class="bi bi-chat-dots me-1"></i>
                                                    Observações
                                                </label>
                                                <textarea class="form-control bg-dark text-light border-warning" 
                                                          id="detailNotes" rows="3" 
                                                          placeholder="Adicione observações sobre esta despesa..."></textarea>
                                            </div>
                                        </div>

                                        <!-- Botões de Ação -->
                                        <div class="mt-4 d-flex gap-2 flex-wrap">
                                            <button type="submit" class="btn btn-warning">
                                                <i class="bi bi-save me-2"></i>
                                                Salvar Alterações
                                            </button>
                                            <button type="button" class="btn btn-warning" id="detailDeleteBtn">
                                                <i class="bi bi-trash me-2"></i>
                                                Excluir Despesa
                                            </button>                                            
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Coluna Lateral - Informações Adicionais -->
                        <div class="col-lg-4">
                            <!-- Resumo da Despesa -->
                            <div class="card bg-dark border-warning text-light mb-4">
                                <div class="card-header border-warning">
                                    <h6 class="text-warning mb-0">
                                        <i class="bi bi-info-circle-fill me-2"></i>
                                        Resumo
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-secondary">ID:</span>
                                        <span class="text-light" id="summaryId">#1</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-secondary">Descrição:</span>
                                        <span class="text-light" id="summaryDescription">-</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-secondary">Tipo:</span>
                                        <span class="text-light" id="summaryType">-</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-secondary">Valor:</span>
                                        <span class="text-warning fw-bold" id="summaryAmount">R$ 0,00</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2" id="divsummaryDiaVencimento"  style="display: none;">
                                        <span class="text-secondary">Dia de Vencimento:</span>
                                        <span class="text-light" id="summaryDiaVencimento">-</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-secondary">Status:</span>
                                        <span id="summaryStatus">-</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2" id="divsummaryFormaPagamento" style="display: none;">
                                        <span class="text-secondary">Forma Pag.:</span>
                                        <span class="text-light" id="summaryPayment"></span>
                                    </div>
                                    <div class="d-flex justify-content-between" id="divsummaryInstallments" style="display: none;">
                                        <span class="text-secondary">Parcelas:</span>
                                        <span class="text-light" id="summaryInstallments">-</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Cartão Vinculado -->
                            <div class="card bg-dark border-warning text-light mb-4">
                                <div class="card-header border-warning">
                                    <h6 class="text-warning mb-0">
                                        <i class="bi bi-credit-card me-2"></i>
                                        Cartão Vinculado
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div id="cardInfo">
                                        <p class="text-secondary text-center my-3">
                                            <i class="bi bi-info-circle me-1"></i>
                                            Nenhum cartão vinculado
                                        </p>
                                    </div>
                                    <div id="cardDetails" style="display: none;">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-secondary">Cartão:</span>
                                            <span class="text-light" id="cardDetailName">-</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-secondary">Limite:</span>
                                            <span class="text-light" id="cardDetailLimit">-</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="text-secondary">Vencimento:</span>
                                            <span class="text-light" id="cardDetailDue">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Parcelas Restantes -->
                            <div class="card bg-dark border-warning text-light">
                                <div class="card-header border-warning">
                                    <h6 class="text-warning mb-0">
                                        <i class="bi bi-clock-history me-2"></i>
                                        Parcelas Restantes
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div id="installmentsInfo">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-secondary">Total Parcelas:</span>
                                            <span class="text-light" id="totalInstallments">-</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-secondary">Parcelas Pagas:</span>
                                            <span class="text-light" id="paidInstallments">-</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="text-secondary">Parcelas Restantes:</span>
                                            <span class="text-warning fw-bold" id="remainingInstallments">-</span>
                                        </div>
                                        <div class="mt-3">
                                            <div class="progress" style="height: 20px; background-color: #2a2a4e;">
                                                <div class="progress-bar bg-warning" id="installmentsProgress" 
                                                     role="progressbar" style="width: 0%;" 
                                                     aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                                    0%
                                                </div>
                                            </div>
                                            <small class="text-secondary mt-1 d-block">Progresso de pagamento</small>
                                        </div>
                                    </div>
                                    <div id="noInstallmentsInfo" style="display: none;">
                                        <p class="text-secondary text-center my-3">
                                            <i class="bi bi-info-circle me-1"></i>
                                            Pagamento à vista ou sem parcelamento
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Confirmação de Exclusão -->
        <div class="modal fade" id="detailDeleteModal" tabindex="-1" aria-hidden="true">
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
                        <p>Tem certeza que deseja excluir a despesa <strong id="detailDeleteDesc"></strong>?</p>
                        <p class="text-danger small">Esta ação não pode ser desfeita.</p>
                        <input type="hidden" id="detailDeleteId">
                    </div>
                    <div class="modal-footer border-danger">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" id="detailConfirmDeleteBtn">
                            <i class="bi bi-trash-fill me-2"></i>
                            Excluir
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <style>
            /* Estilos para a página de detalhamento */
            .detail-page .breadcrumb-item a:hover {
                text-decoration: underline !important;
            }

            .detail-page .form-control:focus,
            .detail-page .form-select:focus {
                border-color: #f5b645 !important;
                box-shadow: 0 0 0 0.2rem rgba(245, 182, 69, 0.25) !important;
                background-color: #2a2a4e !important;
            }

            .detail-page .card {
                transition: all 0.3s ease;
            }

            .detail-page .card:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 25px rgba(245, 182, 69, 0.15);
            }

            .detail-page .btn-outline-warning:hover {
                background-color: rgba(245, 182, 69, 0.1) !important;
                transform: translateY(-2px);
                box-shadow: 0 4px 15px rgba(245, 182, 69, 0.2);
            }

            .detail-page .btn-outline-danger:hover {
                background-color: rgba(220, 53, 69, 0.1) !important;
                transform: translateY(-2px);
                box-shadow: 0 4px 15px rgba(220, 53, 69, 0.2);
            }

            .detail-page .form-label {
                font-size: 0.9rem;
            }

            .detail-page textarea {
                resize: vertical;
                min-height: 80px;
            }

            .detail-page .progress {
                background-color: #2a2a4e !important;
                border-radius: 10px;
                overflow: hidden;
            }

            .detail-page .progress-bar {
                transition: width 0.6s ease;
                font-weight: 600;
                font-size: 0.75rem;
                line-height: 20px;
            }

            @media (max-width: 576px) {
                .detail-page .modal-dialog {
                    margin: 0.5rem;
                }
                
                .detail-page .card-body {
                    padding: 1rem;
                }
            }

            /* Animação de loading */
            @keyframes pulse {
                0% { opacity: 1; }
                50% { opacity: 0.5; }
                100% { opacity: 1; }
            }

            .detail-page .loading {
                animation: pulse 1.5s ease-in-out infinite;
            }
        </style>
        
        <script>
            // ============================================
            // CONTROLE DE EXIBIÇÃO DOS CAMPOS
            // ============================================

            // 1. DATA DE PAGAMENTO - Só aparece se status = Pago
            $('#detailStatus').on('change', function() {
                const status = $(this).val();
                if (status === 'Pago') {
                    $('#divDatePagamento').show('slow');
                    $('#expensedetailDate').prop('required', true);
                
                    $('#divPaymentMethod').show('slow');                    
                    $('#expensePaymentMethod').prop('required', true);
                } else {
                    $('#divDatePagamento').hide('slow');
                    $('#expenseDetailDate').prop('required', false);
                    $('#expenseDetailDate').val(''); // Limpa o campo

                    $('#divPaymentMethod').hide('slow');
                    $('#expensePaymentMethod').prop('required', false);                    
                    $('#expensePaymentMethod').val(''); // Limpa o campo                   
                }
            });

            // 1. Cartão - Só aparece se método de pagamento = Crédito
            $('#detailPaymentMethod').on('change', function() {
                const status = $(this).val();
                if (status === 'Crédito') {
                
                    $('#divCard').show('slow');
                    $('#detailCard').prop('required', true);
                } else {                    

                    $('#divCard').hide('slow');
                    $('#detailCard').prop('required', false);
                    $('#detailCard').val(''); // Limpa o campo
                }
            });
            /*
            // Dados de exemplo (mesmos da página de despesas)
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
                    paid_installments: 1,
                    card_name: '',
                    notes: 'Pagamento do aluguel referente a março/2024'
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
                    paid_installments: 1,
                    card_name: '',
                    notes: 'Compras do mês - inclui produtos de limpeza'
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
                    paid_installments: 1,
                    card_name: '',
                    notes: ''
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
                    paid_installments: 1,
                    card_name: 'Nubank',
                    notes: 'Comemoração de aniversário'
                },
                { 
                    id: 9, 
                    description: 'Smart TV - 50" 4K', 
                    type: 'Variável', 
                    amount: 2999.00, 
                    date: '2024-02-15', 
                    status: 'Pendente',
                    payment_method: 'Crédito',
                    installments: 10,
                    paid_installments: 3,
                    card_name: 'Itaú',
                    notes: 'Compra parcelada em 10x sem juros'
                }
            ];

            // Dados de cartões
            let cards = [
                { id: 1, name: 'Nubank', limit: 5000.00, due_date: '2024-04-10' },
                { id: 2, name: 'Itaú', limit: 8000.00, due_date: '2024-04-15' },
                { id: 3, name: 'Bradesco', limit: 3000.00, due_date: '2024-04-20' }
            ];*/

            // ID da despesa a ser exibida (vindo da URL ou parâmetro)
            // const expenseId = 9; // Mudar para o ID desejado            
            var id = @json($movimentacoes->id);
            var descricao = @json($movimentacoes->descricao);
            var classificacao_financeira = @json($movimentacoes->classificacao_financeira);
            var valor = @json($movimentacoes->valor);
            var status_pagamento = @json($movimentacoes->status_pagamento);
            var data_pagamento = @json($movimentacoes->data_pagamento);
            var dia_vencimento = @json($movimentacoes->dia_vencimento);
            var quantidade_parcelas = @json($movimentacoes->quantidade_parcelas);
            var Observacoes = @json($movimentacoes->Observacoes);
            var forma_pagamento = @json($movimentacoes->forma_pagamento);
            var repetirProximoMes = @json($movimentacoes->despesa_repete_mes);

            // Carregar detalhes da despesa
            function loadExpenseDetail() {
                //const expense = expenses.find(e => e.id === id);
                /*
                if (!expense) {
                    showToast('Despesa não encontrada!', 'danger');
                    return;
                }*/
                
                // Preencher formulário
                document.getElementById('detailExpenseId').value = id;
                document.getElementById('detailDescription').value = descricao;
                document.getElementById('detailType').value = classificacao_financeira;
                document.getElementById('detailAmount').value = valor;
                document.getElementById('detailStatus').value = status_pagamento;
                document.getElementById('detailDate').value = data_pagamento;                
                document.getElementById('detailPaymentMethod').value = forma_pagamento;
                document.getElementById('detailDueDay').value = dia_vencimento;
                document.getElementById('detailInstallments').value = quantidade_parcelas;
                document.getElementById('repetirProximoMes').checked = repetirProximoMes;
                document.getElementById('detailNotes').value = Observacoes;

                // Preencher ID e Status Badge
                document.getElementById('detailId').textContent = "#" + id;
                const statusBadge = document.getElementById('detailStatusBadge');
                statusBadge.textContent = status_pagamento;
                statusBadge.className = 'badge ' + getStatusColor(status_pagamento);

                // Preencher resumo
                document.getElementById('summaryId').textContent = '#' + id;
                document.getElementById('summaryDescription').textContent = descricao;
                document.getElementById('summaryType').textContent = classificacao_financeira;
                document.getElementById('summaryAmount').textContent = 'R$ ' + parseFloat(valor).toFixed(2);

                // Para aparece o dia de vencimento                
                if (dia_vencimento != '') {
                    $('#divsummaryDiaVencimento').show('slow');                                                        
                } else {
                    $('#divsummaryDiaVencimento').removeClass('d-flex');
                    $('#divsummaryDiaVencimento').hide('slow');                       
                }                
                document.getElementById('summaryDiaVencimento').textContent = "Dia  " + dia_vencimento;                                
                document.getElementById('summaryStatus').innerHTML = '<span class="badge ' + getStatusColor(status_pagamento) + '">' + status_pagamento + '</span>';
                
                // Para aparece a forma de pagamento                
                if (forma_pagamento != null) {                    
                    $('#divsummaryFormaPagamento').show('slow');                                                        
                    document.getElementById('summaryPayment').textContent = forma_pagamento || '-';
                } else {
                    $('#divsummaryFormaPagamento').removeClass('d-flex');
                    $('#divsummaryFormaPagamento').hide('slow');
                }
                
                // Preencher informações de parcelas
                //const total = expense.installments || 1;
                //const paid = expense.paid_installments || 0;
                //const remaining = total - paid;

                // Para aparece a forma de pagamento                
                if (quantidade_parcelas > 0) {                    
                    $('#divsummaryInstallments').show('slow');                                                        
                    document.getElementById('summaryInstallments').textContent = quantidade_parcelas;
                } else {
                    $('#divsummaryInstallments').removeClass('d-flex');
                    $('#divsummaryInstallments').hide('slow');
                }  /*              
                document.getElementById('totalInstallments').textContent = total;
                document.getElementById('paidInstallments').textContent = paid;
                document.getElementById('remainingInstallments').textContent = remaining;*/

                // Atualizar barra de progresso
                /*const progressPercent = total > 0 ? (paid / total) * 100 : 0;
                const progressBar = document.getElementById('installmentsProgress');
                progressBar.style.width = `${progressPercent}%`;
                progressBar.textContent = `${Math.round(progressPercent)}%`;
                progressBar.setAttribute('aria-valuenow', progressPercent);

                // Mostrar/ocultar informações de parcelas
                if (total > 1) {
                    document.getElementById('installmentsInfo').style.display = 'block';
                    document.getElementById('noInstallmentsInfo').style.display = 'none';
                } else {
                    document.getElementById('installmentsInfo').style.display = 'none';
                    document.getElementById('noInstallmentsInfo').style.display = 'block';
                }

                // Preencher cartão selecionado
                if (expense.card_name) {
                    document.getElementById('detailCard').value = expense.card_name;
                    showCardDetails(expense.card_name);
                }

                // Carregar lista de cartões no select
                loadCardsSelect();

                // Configurar botão de exclusão
                document.getElementById('detailDeleteDesc').textContent = expense.description;
                document.getElementById('detailDeleteId').value = expense.id;*/
            }

            // Carregar cartões no select
            function loadCardsSelect() {
                const select = document.getElementById('detailCard');
                select.innerHTML = '<option value="">Selecione um cartão...</option>';
                
                cards.forEach(card => {
                    const option = document.createElement('option');
                    option.value = card.name;
                    option.textContent = `${card.name} (Limite: R$ ${card.limit.toFixed(2)})`;
                    select.appendChild(option);
                });
            }

            // Mostrar detalhes do cartão
            function showCardDetails(cardName) {
                const card = cards.find(c => c.name === cardName);
                
                if (card) {
                    document.getElementById('cardInfo').style.display = 'none';
                    document.getElementById('cardDetails').style.display = 'block';
                    document.getElementById('cardDetailName').textContent = card.name;
                    document.getElementById('cardDetailLimit').textContent = `R$ ${card.limit.toFixed(2)}`;
                    document.getElementById('cardDetailDue').textContent = formatDate(card.due_date);
                } else {
                    document.getElementById('cardInfo').style.display = 'block';
                    document.getElementById('cardDetails').style.display = 'none';
                }
            }

            // Obter cor do status
            function getStatusColor(status) {
                const colors = {
                    'Pago': 'bg-success',
                    'Pendente': 'bg-warning text-dark',
                    'Atrasado': 'bg-danger',
                    'Não pago': 'bg-secondary'
                };
                return colors[status] || 'bg-secondary';
            }

            // Formatar data
            function formatDate(dateStr) {
                const date = new Date(dateStr);
                return date.toLocaleDateString('pt-BR', { day: '2-digit', month: '2-digit', year: 'numeric' });
            }
            /*
            // ============================================
            // PREENCHER MODAL DE EDIÇÃO
            // ============================================
            $(document).on('click', '.edit-despesa', function() {
                const id = $(this).data('id');
                const descricao = $(this).data('descricao');
                const valor = $(this).data('valor');
                const classificacao_financeira = $(this).data('classificacao_financeira');
                const status_pagamento = $(this).data('status_pagamento');
                const forma_pagamento = $(this).data('forma_pagamento');
                const quantidade_parcelas = $(this).data('quantidade_parcelas');
                const cartao_credito_id = $(this).data('cartao_credito_id');
                const data_pagamento = $(this).data('data_pagamento');
                const data_vencimento = $(this).data('data_vencimento');
                const dia_vencimento = $(this).data('dia_vencimento');
                const Observacoes = $(this).data('Observacoes');
                const despesa_repete_mes = $(this).data('despesa_repete_mes');            
                
                
                // Define a action do formulário
                $('#editFormDespesa').attr('action', '/despesas/update-action/' + id);                                
            });*/
            /*
            // ============================================
            // VALIDAÇÃO DO FORMULÁRIO DE EDIÇÃO
            // ============================================
            $('#editFormDespesa').on('submit', function(e) {
                var id = @json($movimentacoes->id);
                console.log(id);
                debbugger;
                $('#editFormDespesa').attr('action', '/despesas/update-action/' + id);

                let isValid = true;
                let firstError = null;
                let errorMessages = [];
                
                $(this).find('.is-invalid').removeClass('is-invalid');
                $(this).find('.alert-validation').remove();
                
                // Campos obrigatórios
                const campos = [
                    { id: '#editUserName', nome: 'Nome de usuário' },
                    { id: '#editNamerUser', nome: 'Nome completo' },
                    { id: '#editUserEmail', nome: 'E-mail' },
                    { id: '#editCpfCnpj', nome: 'CPF/CNPJ' },
                    { id: '#editTelefone', nome: 'Telefone' }
                ];
                
                campos.forEach(function(campo) {
                    const valor = $(campo.id).val().trim();
                    if (valor === '') {
                        isValid = false;
                        $(campo.id).addClass('is-invalid');
                        errorMessages.push(`${campo.nome} é obrigatório.`);
                        if (!firstError) firstError = $(campo.id);
                    }
                });
                
                // CPF/CNPJ
                const cpfCnpj = $('#editCpfCnpj').val().replace(/[^a-zA-Z0-9]/g, '');
                if (cpfCnpj.length !== 11 && cpfCnpj.length !== 14) {
                    isValid = false;
                    $('#editCpfCnpj').addClass('is-invalid');
                    errorMessages.push('CPF deve ter 11 dígitos ou CNPJ 14 dígitos.');
                    if (!firstError) firstError = $('#editCpfCnpj');
                }
                
                // Telefone
                const telefone = $('#editTelefone').val().replace(/\D/g, '');
                if (telefone.length < 10) {
                    isValid = false;
                    $('#editTelefone').addClass('is-invalid');
                    errorMessages.push('Telefone inválido.');
                    if (!firstError) firstError = $('#editTelefone');
                }
                
                // Nível de Acesso
                const nivelAcesso = $('#editUserLevel').val();
                if (nivelAcesso === '') {
                    isValid = false;
                    $('#editUserLevel').addClass('is-invalid');
                    errorMessages.push('Nível de acesso é obrigatório.');
                    if (!firstError) firstError = $('#editUserLevel');
                }
                
                // Senha (apenas se preenchida)
                const password = $('#editPassword').val();
                const passwordConfirmation = $('#editPasswordConfirmation').val();
                
                if (password !== '' || passwordConfirmation !== '') {
                    if (password.length < 6) {
                        isValid = false;
                        $('#editPassword').addClass('is-invalid');
                        errorMessages.push('Senha deve ter no mínimo 6 caracteres.');
                        if (!firstError) firstError = $('#editPassword');
                    }
                    if (password !== passwordConfirmation) {
                        isValid = false;
                        $('#editPasswordConfirmation').addClass('is-invalid');
                        errorMessages.push('As senhas não coincidem.');
                        if (!firstError) firstError = $('#editPasswordConfirmation');
                    }
                }
                
                // Status
                const status = $('#editUserStatus').val();
                if (status === '') {
                    isValid = false;
                    $('#editUserStatus').addClass('is-invalid');
                    errorMessages.push('Status é obrigatório.');
                    if (!firstError) firstError = $('#editUserStatus');
                }
                
                if (!isValid) {
                    e.preventDefault();
                    
                    let alertHtml = `
                        <div class="alert alert-danger alert-validation alert-dismissible fade show" role="alert">
                            <h5><i class="bi bi-exclamation-triangle-fill me-2"></i>Erros de validação:</h5>
                            <ul class="mb-0">
                    `;
                    errorMessages.forEach(function(error) {
                        alertHtml += `<li>${error}</li>`;
                    });
                    alertHtml += `
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `;
                    
                    $('.modal-body').prepend(alertHtml);
                    
                    if (firstError) {
                        setTimeout(function() {
                            firstError.focus();
                        }, 100);
                    }
                    
                    return false;
                }
            });*/

            // ============================================
            // EXCLUIR USUÁRIO
            // ============================================
            // ============================================
            // EXCLUIR USUÁRIO
            // ============================================
            $(document).on('click', '.delete-user', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                
                $('#deleteUserId').val(id);
                $('#deleteUserName').text(name);
                $('#deleteModal').modal('show');
            });

            $('#confirmDeleteBtn').on('click', function() {
                const id = $('#deleteUserId').val();
                
                // ✅ CORRIGIDO: Use a URL correta
                const url = '/delete-action/' + id;  // Se estiver usando /delete-action/{id}
                // OU
                // const url = '/usuarios/' + id;    // Se estiver usando /usuarios/{id}
                
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#deleteModal').modal('hide');
                        showToast(response.message || 'Usuário excluído com sucesso!', 'success');
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    },
                    error: function(xhr) {
                        $('#deleteModal').modal('hide');
                        
                        let errorMessage = 'Erro ao excluir usuário!';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        
                        showToast(errorMessage, 'danger');
                        console.log('Erro:', xhr.responseText);
                    }
                });
            });

            // Salvar alterações da despesa
            /*document.getElementById('detailForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const id = parseInt(document.getElementById('detailExpenseId').value);
                const description = document.getElementById('detailDescription').value.trim();
                const type = document.getElementById('detailType').value;
                const amount = parseFloat(document.getElementById('detailAmount').value);
                const status = document.getElementById('detailStatus').value;
                const date = document.getElementById('detailDate').value;       
                const due_day = document.getElementById('detailDueDay').value;
                const payment_method = document.getElementById('detailPaymentMethod').value;
                const installments = parseInt(document.getElementById('detailInstallments').value) || 1;
                const card_name = document.getElementById('detailCard').value;
                const notes = document.getElementById('detailNotes').value.trim();

                // Validar campos obrigatórios
                if (!description || !amount || !date) {
                    showToast('Por favor, preencha todos os campos obrigatórios.', 'warning');
                    return;
                }

                // Encontrar e atualizar despesa
                const index = expenses.findIndex(e => e.id === id);
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
                        card_name: card_name || expenses[index].card_name,
                        notes: notes || expenses[index].notes
                    };
                    
                    showToast('Despesa atualizada com sucesso!', 'success');
                    loadExpenseDetail(id); // Recarregar dados
                } else {
                    showToast('Erro ao atualizar despesa.', 'danger');
                }
            });

            // Excluir despesa
            document.getElementById('detailDeleteBtn').addEventListener('click', function() {
                const modal = new bootstrap.Modal(document.getElementById('detailDeleteModal'));
                modal.show();
            });*/

            document.getElementById('detailConfirmDeleteBtn').addEventListener('click', function() {
                const id = parseInt(document.getElementById('detailDeleteId').value);
                expenses = expenses.filter(e => e.id !== id);
                showToast('Despesa excluída com sucesso!', 'success');
                bootstrap.Modal.getInstance(document.getElementById('detailDeleteModal')).hide();
                
                // Redirecionar para lista de despesas após 1 segundo
                setTimeout(() => {
                    window.location.href = '#';
                }, 1000);
            });

            // Detectar mudança no cartão
            document.getElementById('detailCard').addEventListener('change', function() {
                if (this.value) {
                    showCardDetails(this.value);
                } else {
                    document.getElementById('cardInfo').style.display = 'block';
                    document.getElementById('cardDetails').style.display = 'none';
                }
            });

            // Detectar mudança no status
            document.getElementById('detailStatus').addEventListener('change', function() {
                const statusBadge = document.getElementById('detailStatusBadge');
                statusBadge.textContent = this.value;
                statusBadge.className = `badge ${getStatusColor(this.value)}`;
                
                document.getElementById('summaryStatus').innerHTML = `<span class="badge ${getStatusColor(this.value)}">${this.value}</span>`;
            });

            // Detectar mudança no número de parcelas
            document.getElementById('detailInstallments').addEventListener('change', function() {
                const total = parseInt(this.value) || 1;
                const paid = 0;
                const remaining = total;
                
                document.getElementById('summaryInstallments').textContent = `${paid}/${total}`;
                document.getElementById('totalInstallments').textContent = total;
                document.getElementById('paidInstallments').textContent = paid;
                document.getElementById('remainingInstallments').textContent = remaining;
                
                // Atualizar barra de progresso
                const progressPercent = total > 0 ? (paid / total) * 100 : 0;
                const progressBar = document.getElementById('installmentsProgress');
                progressBar.style.width = `${progressPercent}%`;
                progressBar.textContent = `${Math.round(progressPercent)}%`;
                
                // Mostrar/ocultar informações de parcelas
                if (total > 1) {
                    document.getElementById('installmentsInfo').style.display = 'block';
                    document.getElementById('noInstallmentsInfo').style.display = 'none';
                } else {
                    document.getElementById('installmentsInfo').style.display = 'none';
                    document.getElementById('noInstallmentsInfo').style.display = 'block';
                }
            });

            // Atualizar resumo em tempo real
            document.getElementById('detailDescription').addEventListener('input', function() {
                document.getElementById('summaryDescription').textContent = this.value || '-';
            });

            document.getElementById('detailAmount').addEventListener('input', function() {
                const val = parseFloat(this.value);
                document.getElementById('summaryAmount').textContent = val ? `R$ ${val.toFixed(2)}` : 'R$ 0,00';
            });

            document.getElementById('detailDate').addEventListener('input', function() {
                document.getElementById('summaryDate').textContent = this.value ? formatDate(this.value) : '-';
            });

            document.getElementById('detailDueDay').addEventListener('input', function() {
                document.getElementById('summaryDueDay').textContent = this.value || '-';
            });

            document.getElementById('detailPaymentMethod').addEventListener('change', function() {
                document.getElementById('summaryPayment').textContent = this.value || '-';
            });

            // Detectar mudança no tipo
            document.getElementById('detailType').addEventListener('change', function() {
                document.getElementById('summaryType').textContent = this.value;
            });

            // Toast personalizado
            function showToast(message, type = 'success') {
                const toast = document.createElement('div');
                toast.className = `toast align-items-center text-white bg-${type} border-0 position-fixed top-0 end-0 m-3`;
                toast.style.zIndex = '9999';
                toast.innerHTML = `
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="bi bi-${type === 'success' ? 'check-circle-fill' : type === 'danger' ? 'exclamation-triangle-fill' : 'info-circle-fill'} me-2"></i>
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

            // Inicializar página
            loadExpenseDetail();
        </script>
        @if ($errors->any())
            <div style="background: #1a1a1a; color: #ff6b6b; padding: 15px; border-radius: 5px; margin: 10px; border: 2px solid #ff6b6b;">
                <strong style="color: #fff;">🔍 ERROS DE VALIDAÇÃO:</strong>
                <ul style="color: #fff; list-style: none; padding: 0;">
                    @foreach ($errors->all() as $error)
                        <li style="padding: 5px 0; border-bottom: 1px solid #333;">
                            ❌ {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </body>
</html>