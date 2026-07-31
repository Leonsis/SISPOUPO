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
                                            <th>Data do Pag.</th>
                                            <th>Status</th>
                                            <th>Forma Pag.</th>
                                            <th>Parcelas</th>
                                            <th>Cartão</th>
                                            <th class="text-center">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody id="expensesTableBody">
                                        @foreach($movimentacoes as $movimentacao)
                                            <tr data-id="{{ $movimentacao->id }}" id="row-{{ $movimentacao->id }}">
                                                <td>#{{ $movimentacao->id }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <span class="badge {{ $movimentacao->classificacao_financeira == 'Fixa' ? 'bg-warning text-dark' : 'bg-info' }} me-2">                                                            
                                                            {{ $movimentacao->classificacao_financeira == 'Fixa' ? '📌' : '📊' }}
                                                        </span>
                                                        <span class="view-mode descricao-text">{{ $movimentacao->descricao }}</span>
                                                        <input type="text" class="form-control form-control-sm bg-dark text-light border-warning edit-mode d-none" 
                                                            value="{{ $movimentacao->descricao }}" data-field="descricao">
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="view-mode tipo-text badge {{ $movimentacao->classificacao_financeira == 'Fixa' ? 'bg-warning text-dark' : 'bg-info' }}">
                                                        {{ $movimentacao->classificacao_financeira }}
                                                    </span>
                                                    <select class="form-select form-select-sm bg-dark text-light border-warning edit-mode d-none" data-field="classificacao_financeira">
                                                        <option value="Fixa" {{ $movimentacao->classificacao_financeira == 'Fixa' ? 'selected' : '' }}>Fixa</option>
                                                        <option value="Variável" {{ $movimentacao->classificacao_financeira == 'Variável' ? 'selected' : '' }}>Variável</option>
                                                    </select>
                                                </td>
                                                <td class="text-warning fw-bold">
                                                    <span class="view-mode valor-text">R$ {{ number_format($movimentacao->valor, 2, ',', '.') }}</span>
                                                    <input type="number" step="0.01" class="form-control form-control-sm bg-dark text-light border-warning edit-mode d-none" 
                                                        value="{{ $movimentacao->valor }}" data-field="valor">
                                                </td>
                                                <td>
                                                    <span class="view-mode data-text" data-original-date="{{ $movimentacao->data_pagamento }}">
                                                        {{ \Carbon\Carbon::parse($movimentacao->data_pagamento)->format('d/m/Y') }}
                                                    </span>
                                                    <input type="date" class="form-control form-control-sm bg-dark text-light border-warning edit-mode d-none" 
                                                        value="{{ $movimentacao->data_pagamento }}" data-field="data_pagamento">
                                                </td>
                                                <td>
                                                    @php
                                                        $statusMap = [
                                                            'Pago' => 'bg-success',
                                                            'Pendente' => 'bg-warning text-dark',
                                                            'Atrasado' => 'bg-danger',
                                                            'Nao Pago' => 'bg-secondary',
                                                            'NAO_PAGO' => 'bg-secondary',
                                                        ];
                                                        
                                                        $statusLabel = [
                                                            'Pago' => 'Pago',
                                                            'Pendente' => 'Pendente',
                                                            'Atrasado' => 'Atrasado',
                                                            'Nao Pago' => 'Não Pago',
                                                            'NAO_PAGO' => 'Não Pago',
                                                        ];
                                                    @endphp
                                                    <span class="view-mode status-text badge {{ $statusMap[$movimentacao->status_pagamento] ?? 'bg-secondary' }}">
                                                        {{ $statusLabel[$movimentacao->status_pagamento] ?? $movimentacao->status_pagamento }}
                                                    </span>
                                                    <select class="form-select form-select-sm bg-dark text-light border-warning edit-mode d-none" data-field="status_pagamento">
                                                        <option value="Pago" {{ $movimentacao->status_pagamento == 'Pago' ? 'selected' : '' }}>Pago</option>
                                                        <option value="Pendente" {{ $movimentacao->status_pagamento == 'Pendente' ? 'selected' : '' }}>Pendente</option>
                                                        <option value="Atrasado" {{ $movimentacao->status_pagamento == 'Atrasado' ? 'selected' : '' }}>Atrasado</option>
                                                        <option value="Nao Pago" {{ $movimentacao->status_pagamento == 'Nao Pago' ? 'selected' : '' }}>Não Pago</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <span class="view-mode forma-text badge bg-dark border border-warning text-light">
                                                        {{ $movimentacao->forma_pagamento }}
                                                    </span>
                                                    <select class="form-select form-select-sm bg-dark text-light border-warning edit-mode d-none" data-field="forma_pagamento">
                                                        <option value="Dinheiro" {{ $movimentacao->forma_pagamento == 'Dinheiro' ? 'selected' : '' }}>Dinheiro</option>
                                                        <option value="Pix" {{ $movimentacao->forma_pagamento == 'Pix' ? 'selected' : '' }}>Pix</option>
                                                        <option value="Boleto" {{ $movimentacao->forma_pagamento == 'Boleto' ? 'selected' : '' }}>Boleto</option>
                                                        <option value="Débito" {{ $movimentacao->forma_pagamento == 'Débito' ? 'selected' : '' }}>Débito</option>
                                                        <option value="Crédito" {{ $movimentacao->forma_pagamento == 'Crédito' ? 'selected' : '' }}>Crédito</option>
                                                        <option value="Transferência" {{ $movimentacao->forma_pagamento == 'Transferência' ? 'selected' : '' }}>Transferência</option>
                                                    </select>
                                                </td>
                                                <td class="text-center">
                                                    <span class="view-mode parcelas-text">{{ $movimentacao->quantidade_parcelas > 0 ? $movimentacao->quantidade_parcelas . 'x' : '-' }}</span>
                                                    <input type="number" class="form-control form-control-sm bg-dark text-light border-warning edit-mode d-none" 
                                                        value="{{ $movimentacao->quantidade_parcelas }}" data-field="quantidade_parcelas" min="0" max="24">
                                                </td>
                                                <td>
                                                    @if($movimentacao->nome_cartao)
                                                        <span class="view-mode cartao-text badge bg-primary bg-opacity-25 text-light">
                                                            <i class="bi bi-credit-card me-1"></i>
                                                            {{ $movimentacao->nome_cartao }}
                                                        </span>
                                                    @else
                                                        <span class="view-mode cartao-text text-secondary">-</span>
                                                    @endif
                                                    <select class="form-select form-select-sm bg-dark text-light border-warning edit-mode d-none" data-field="cartao_credito_id">
                                                        <option value="">Selecione...</option>
                                                        @foreach($cartoes as $cartao)
                                                            <option value="{{ $cartao->id }}" {{ $movimentacao->cartao_credito_id == $cartao->id ? 'selected' : '' }}>
                                                                {{ $cartao->nome_cartao }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-1 justify-content-center">
                                                        <button class="btn btn-sm btn-warning toggle-edit" data-id="{{ $movimentacao->id }}" title="Editar">
                                                            <i class="bi bi-pencil-fill"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-success save-edit d-none" data-id="{{ $movimentacao->id }}" title="Salvar">
                                                            <i class="bi bi-check-lg"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-secondary cancel-edit d-none" data-id="{{ $movimentacao->id }}" title="Cancelar">
                                                            <i class="bi bi-x-lg"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-danger delete-despesa" 
                                                                data-id="{{ $movimentacao->id }}" 
                                                                data-name="{{ $movimentacao->descricao }}" 
                                                                title="Excluir">
                                                            <i class="bi bi-trash-fill"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer border-warning">
                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                <span class="text-light" id="totalExpenses">Total: {{ $nTotalDespesas }} despesas</span>
                                <span class="text-warning fw-bold" id="totalAmount">Total: R$ {{ number_format($totalValor, 2, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Cadastro -->
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
                    <form action="{{ route('despesas.store') }}" method="POST" id="expenseForm" novalidate>
                        @csrf

                        <div class="modal-body">
                            <input type="hidden" id="expenseId">
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="expenseDescription" class="form-label fw-semibold">Descrição</label>
                                    <input name="descricao" type="text" class="form-control bg-dark text-light border-warning" id="expenseDescription" placeholder="Ex: Aluguel" required>
                                    <div class="invalid-feedback">Por favor, informe a descrição.</div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="expenseType" class="form-label fw-semibold">
                                        Tipo de Despesa
                                        <i class="bi bi-info-circle text-warning ms-1" data-bs-toggle="tooltip" data-bs-html="true"
                                            title="
                                                <strong>Fixa:</strong> Mensal com valor igual ou parecido<br>
                                                <strong>Variável:</strong> Frequente com valor variável
                                            ">
                                        </i>
                                    </label>
                                    <select name="classificacao_financeira" class="form-select bg-dark text-light border-warning" id="expenseType" required>
                                        <option value="">Selecione...</option>
                                        <option value="Fixa">Fixa (Mensal)</option>
                                        <option value="Variável">Variável (Valor muda)</option>
                                    </select>
                                    <div class="invalid-feedback">Por favor, selecione o tipo.</div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="expenseAmount" class="form-label fw-semibold">Valor (R$)</label>
                                    <input name="valor" type="number" step="0.01" class="form-control bg-dark text-light border-warning" id="expenseAmount" placeholder="0,00" required>
                                    <div class="invalid-feedback">Por favor, informe o valor.</div>
                                </div>
                                
                                <!-- ✅ Data do Pagamento (Só aparece se status for Pago) -->
                                <div class="col-md-6" id="divDataPagamento" style="display: none;">
                                    <label for="expenseDate" class="form-label fw-semibold">Data do pagamento</label>
                                    <input name="data_pagamento" type="date" class="form-control bg-dark text-light border-warning" id="expenseDate">
                                    <div class="invalid-feedback">Por favor, informe a data.</div>
                                    <small class="text-secondary">Preencha apenas se a despesa foi paga</small>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="expenseStatus" class="form-label fw-semibold">Status de Pagamento</label>
                                    <select name="status_pagamento" class="form-select bg-dark text-light border-warning" id="expenseStatus" required>
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
                                    <select name="forma_pagamento" class="form-select bg-dark text-light border-warning" id="expensePaymentMethod" required>
                                        <option value="">Selecione...</option>
                                        <option value="Dinheiro">Dinheiro</option>
                                        <option value="Pix">Pix</option>
                                        <option value="Boleto">Boleto</option>
                                        <option value="Débito">Débito</option>
                                        <option value="Crédito">Crédito</option>
                                        <option value="Transferência">Transferência</option>
                                    </select>
                                    <div class="invalid-feedback">Por favor, selecione a forma de pagamento.</div>
                                </div>
                                
                                <!-- ✅ Nº Parcelas (Só aparece se for Crédito, Boleto ou Pix) -->
                                <div class="col-md-4" id="divParcelas" style="display: none;">
                                    <label for="expenseInstallments" class="form-label fw-semibold">Nº Parcelas</label>
                                    <input name="quantidade_parcelas" type="number" class="form-control bg-dark text-light border-warning" id="expenseInstallments" placeholder="0" min="0" max="24" value="0">
                                    <small class="text-secondary">0 = à vista | 1+ = parcelado</small>
                                    <div class="invalid-feedback">Informe um número válido de parcelas.</div>
                                </div>
                                
                                <!-- ✅ Cartão de Crédito (Só aparece se a forma for Crédito) -->
                                <div class="col-md-8" id="divCartao" style="display: none;">
                                    <label for="expenseCardName" class="form-label fw-semibold">Cartão de Crédito</label>
                                    <select name="cartao_credito_id" class="form-select bg-dark text-light border-warning" id="expenseCardName">
                                        <option value="">Selecione um cartão...</option>
                                        @foreach($cartoes as $cartao)                                            
                                            <option value="{{ $cartao->id }}">{{ $cartao->nome_cartao }}</option>                                                
                                        @endforeach
                                    </select>
                                    <small class="text-secondary">Selecione o cartão usado no crédito</small>
                                    <div class="invalid-feedback">Por favor, selecione um cartão.</div>
                                </div>
                                
                                <!-- ✅ CHECKBOX: Repetir no próximo mês? -->
                                <div class="col-12">
                                    <div class="form-check form-switch">
                                        <input name="repetir_proximo_mes" class="form-check-input" type="checkbox" role="switch" id="repetirProximoMes" value="1">
                                        <label class="form-check-label text-warning fw-semibold" for="repetirProximoMes">
                                            <i class="bi bi-arrow-repeat me-2"></i>
                                            Repetir no próximo mês?
                                        </label>
                                        <small class="text-secondary d-block mt-1">
                                            Marque esta opção se a despesa se repetirá no próximo mês
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal-footer border-warning">
                            <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Cancelar</button>
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
                        <p>Tem certeza que deseja excluir a despesa <strong id="deleteDespesaName"></strong>?</p>
                        <p class="text-danger small">Esta ação não pode ser desfeita.</p>
                        <input type="hidden" id="deleteDespesaId">
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
        
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // ============================================
            // CHECKBOX - Repetir no próximo mês?
            // ============================================
            // O checkbox já envia value="1" quando marcado
            // Quando desmarcado, não envia valor (padrão do checkbox)
            // No controller, você deve verificar se o campo existe

            // Para garantir que o valor seja 0 quando desmarcado, adicione um hidden
            $('#repetirProximoMes').on('change', function() {
                if ($(this).is(':checked')) {
                    $(this).val('1');
                } else {
                    $(this).val('0');
                }
            });
            
            // ============================================
            // CONTROLE DE EXIBIÇÃO DOS CAMPOS
            // ============================================
            
            // 1. DATA DE PAGAMENTO - Só aparece se status = Pago
            $('#expenseStatus').on('change', function() {
                const status = $(this).val();
                if (status === 'Pago') {
                    $('#divDataPagamento').show('slow');
                    $('#expenseDate').prop('required', true);
                } else {
                    $('#divDataPagamento').hide('slow');
                    $('#expenseDate').prop('required', false);
                    $('#expenseDate').val(''); // Limpa o campo
                }
            });
            
            // 2. CARTÃO DE CRÉDITO - Só aparece se forma = Crédito
            // 3. PARCELAS - Aparece se forma = Crédito, Boleto ou Pix
            $('#expensePaymentMethod').on('change', function() {
                const forma = $(this).val();
                
                // Cartão de Crédito (só para Crédito)
                if (forma === 'Crédito') {
                    $('#divCartao').show('slow');
                    $('#expenseCardName').prop('required', true);
                } else {
                    $('#divCartao').hide('slow');
                    $('#expenseCardName').prop('required', false);
                    $('#expenseCardName').val(''); // Limpa o campo
                }
                
                // Parcelas (Crédito, Boleto ou Pix)
                if (forma === 'Crédito' || forma === 'Boleto' || forma === 'Pix') {
                    $('#divParcelas').show('slow');
                    $('#expenseInstallments').prop('required', true);
                } else {
                    $('#divParcelas').hide('slow');
                    $('#expenseInstallments').prop('required', false);
                    $('#expenseInstallments').val(0); // Reseta para 0
                }
            });
            
            // ============================================
            // VALIDAÇÃO AO ENVIAR O FORMULÁRIO
            // ============================================
            $('#expenseForm').on('submit', function(e) {
                let isValid = true;
                let errorMessages = [];
                
                // Limpa erros anteriores
                $(this).find('.is-invalid').removeClass('is-invalid');
                
                // Valida Data de Pagamento (se status for Pago)
                const status = $('#expenseStatus').val();
                if (status === 'Pago') {
                    const dataPagamento = $('#expenseDate').val();
                    if (!dataPagamento) {
                        isValid = false;
                        $('#expenseDate').addClass('is-invalid');
                        errorMessages.push('A data de pagamento é obrigatória quando o status é Pago.');
                    }
                }
                
                // Valida Cartão (se forma for Crédito)
                const forma = $('#expensePaymentMethod').val();
                if (forma === 'Crédito') {
                    const cartao = $('#expenseCardName').val();
                    if (!cartao) {
                        isValid = false;
                        $('#expenseCardName').addClass('is-invalid');
                        errorMessages.push('Selecione um cartão de crédito.');
                    }
                }
                
                // Valida Parcelas (se forma for Crédito, Boleto ou Pix)
                if (forma === 'Crédito' || forma === 'Boleto' || forma === 'Pix') {
                    const parcelas = parseInt($('#expenseInstallments').val()) || 0;
                    if (parcelas < 0) {
                        isValid = false;
                        $('#expenseInstallments').addClass('is-invalid');
                        errorMessages.push('O número de parcelas deve ser maior ou igual a 0.');
                    }
                }
                
                if (!isValid) {
                    e.preventDefault();
                    
                    // Mostra alerta com erros
                    let alertHtml = `
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h5><i class="bi bi-exclamation-triangle-fill me-2"></i>Erros de validação:</h5>
                            <ul class="mb-0">
                    `;
                    errorMessages.forEach(function(error) {
                        alertHtml += `<li>${error}</li>`;
                    });
                    alertHtml += `
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    `;
                    
                    // Remove alertas antigos
                    $('.alert-validation').remove();
                    
                    // Insere o alerta no topo do modal
                    $('.modal-body').prepend(alertHtml);
                    
                    // Scroll para o topo
                    $('.modal-body').scrollTop(0);
                    
                    return false;
                }
            });
            
            // ============================================
            // RESET AO FECHAR O MODAL
            // ============================================
            $('#expenseModal').on('hidden.bs.modal', function() {
                // Reseta os campos
                $('#expenseForm')[0].reset();
                $('#expenseForm .is-invalid').removeClass('is-invalid');
                $('.alert-validation').remove();
                
                // Esconde os campos condicionais
                $('#divDataPagamento').hide();
                $('#divCartao').hide();
                $('#divParcelas').hide();
                
                // Remove required dos campos condicionais
                $('#expenseDate').prop('required', false);
                $('#expenseCardName').prop('required', false);
                $('#expenseInstallments').prop('required', false);
            });
            
            
            // ============================================
            // DADOS DOS GRÁFICOS (do PHP para o JS)
            // ============================================
            const dadosGraficos = {
                fixa_mes_atual: {{ $vTotalFixaMesAtual ?? 0 }},
                fixa_mes_anterior: {{ $vTotalFixaMesAnterior ?? 0 }},
                variavel_mes_atual: {{ $vTotalVariavelMesAtual ?? 0 }},
                variavel_mes_anterior: {{ $vTotalVariavelMesAnterior ?? 0 }}
            };

            console.log('📊 Dados dos gráficos:', dadosGraficos);

            // ============================================
            // VARIÁVEIS GLOBAIS
            // ============================================
            let chartInstances = {
                fixed: null,
                variable: null
            };

            // ============================================
            // DESTRUIR GRÁFICOS
            // ============================================
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

            // ============================================
            // CRIAR GRÁFICO
            // ============================================
            function createChart(canvasId, data, labels, colors) {
                const canvas = document.getElementById(canvasId);
                if (!canvas) {
                    console.warn('❌ Canvas não encontrado:', canvasId);
                    return null;
                }

                console.log('✅ Criando gráfico:', canvasId, 'Dados:', data);

                const ctx = canvas.getContext('2d');
                
                try {
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
                } catch (e) {
                    console.error('❌ Erro ao criar gráfico:', e);
                    return null;
                }
            }

            // ============================================
            // ATUALIZAR GRÁFICOS
            // ============================================
            function updateCharts() {
                console.log('🔄 Atualizando gráficos...');
                
                // Pega os dados do objeto global
                const fixedCurrent = dadosGraficos.fixa_mes_atual || 0;
                const fixedPrevious = dadosGraficos.fixa_mes_anterior || 0;
                const variableCurrent = dadosGraficos.variavel_mes_atual || 0;
                const variablePrevious = dadosGraficos.variavel_mes_anterior || 0;

                console.log('📊 Valores:', {
                    fixedCurrent,
                    fixedPrevious,
                    variableCurrent,
                    variablePrevious
                });

                // Atualizar textos
                const fixedCurrentEl = document.getElementById('fixedCurrent');
                const fixedPreviousEl = document.getElementById('fixedPrevious');
                const variableCurrentEl = document.getElementById('variableCurrent');
                const variablePreviousEl = document.getElementById('variablePrevious');

                if (fixedCurrentEl) fixedCurrentEl.textContent = 'R$ ' + fixedCurrent.toFixed(2).replace('.', ',');
                if (fixedPreviousEl) fixedPreviousEl.textContent = 'R$ ' + fixedPrevious.toFixed(2).replace('.', ',');
                if (variableCurrentEl) variableCurrentEl.textContent = 'R$ ' + variableCurrent.toFixed(2).replace('.', ',');
                if (variablePreviousEl) variablePreviousEl.textContent = 'R$ ' + variablePrevious.toFixed(2).replace('.', ',');

                // Destruir gráficos antigos
                destroyAllCharts();

                // Criar novos gráficos
                chartInstances.fixed = createChart('fixedChart', [fixedCurrent, fixedPrevious], ['Atual', 'Anterior']);
                chartInstances.variable = createChart('variableChart', [variableCurrent, variablePrevious], ['Atual', 'Anterior']);
            }

            // ============================================
            // INICIAR GRÁFICOS - Executa quando a página carrega
            // ============================================
            // Função para tentar carregar os gráficos com retry
            function initChartsWithRetry(attempts = 0) {
                const maxAttempts = 5;
                const delay = 500;
                
                console.log(`🔄 Tentativa ${attempts + 1} de ${maxAttempts}...`);
                
                // Verifica se os canvas existem
                const fixedCanvas = document.getElementById('fixedChart');
                const variableCanvas = document.getElementById('variableChart');
                
                if (fixedCanvas && variableCanvas) {
                    console.log('✅ Canvas encontrados!');
                    updateCharts();
                    return;
                }
                
                if (attempts < maxAttempts) {
                    console.log(`⏳ Aguardando ${delay}ms para tentar novamente...`);
                    setTimeout(function() {
                        initChartsWithRetry(attempts + 1);
                    }, delay);
                } else {
                    console.error('❌ Canvas não encontrados após várias tentativas!');
                    // Tenta carregar mesmo assim
                    updateCharts();
                }
            }

            // Inicia quando o DOM estiver pronto
            document.addEventListener('DOMContentLoaded', function() {
                console.log('📄 DOM carregado!');
                initChartsWithRetry();
            });

            // Também inicia quando a página estiver completamente carregada
            window.addEventListener('load', function() {
                console.log('📄 Página completamente carregada!');
                setTimeout(function() {
                    updateCharts();
                }, 300);
            });

            // ============================================
            // RECRIAR GRÁFICOS AO REDIMENSIONAR A TELA
            // ============================================
            let resizeTimeout;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(function() {
                    console.log('🔄 Redimensionando...');
                    updateCharts();
                }, 500);
            });

            // ============================================
            // LIMPAR GRÁFICOS AO SAIR DA PÁGINA
            // ============================================
            window.addEventListener('beforeunload', function() {
                destroyAllCharts();
            });
        </script>

        <script>
            $(document).ready(function() {
                // ============================================
                // EDITAR - Mostrar campos de edição
                // ============================================
                $(document).on('click', '.toggle-edit', function() {
                    const row = $(this).closest('tr');
                    const id = $(this).data('id');
                    
                    $(this).addClass('d-none');
                    row.find('.delete-despesa').addClass('d-none');
                    row.find('.save-edit').removeClass('d-none');
                    row.find('.cancel-edit').removeClass('d-none');
                    row.find('.view-mode').addClass('d-none');
                    row.find('.edit-mode').removeClass('d-none');
                });

                // ============================================
                // CANCELAR - Voltar ao modo de visualização
                // ============================================
                $(document).on('click', '.cancel-edit', function() {
                    const row = $(this).closest('tr');
                    const id = $(this).data('id');
                    
                    row.find('.toggle-edit').removeClass('d-none');
                    row.find('.delete-despesa').removeClass('d-none');
                    row.find('.save-edit').addClass('d-none');
                    row.find('.cancel-edit').addClass('d-none');
                    
                    // Restaura os valores originais
                    const descricaoOriginal = row.find('.descricao-text').text().trim();
                    row.find('input[data-field="descricao"]').val(descricaoOriginal);
                    
                    const tipoOriginal = row.find('.tipo-text').text().trim();
                    row.find('select[data-field="classificacao_financeira"]').val(tipoOriginal);
                    
                    const valorOriginal = row.find('.valor-text').text().trim().replace('R$ ', '').replace('.', '').replace(',', '.');
                    row.find('input[data-field="valor"]').val(valorOriginal);
                    
                    const dataOriginal = row.find('.data-text').text().trim();
                    const dataParts = dataOriginal.split('/');
                    const dataFormatada = dataParts[2] + '-' + dataParts[1] + '-' + dataParts[0];
                    row.find('input[data-field="data_pagamento"]').val(dataFormatada);
                    
                    const statusOriginal = row.find('.status-text').text().trim();
                    row.find('select[data-field="status_pagamento"]').val(statusOriginal);
                    
                    const formaOriginal = row.find('.forma-text').text().trim();
                    row.find('select[data-field="forma_pagamento"]').val(formaOriginal);
                    
                    const parcelasOriginal = row.find('.parcelas-text').text().trim().replace('x', '').trim();
                    row.find('input[data-field="quantidade_parcelas"]').val(parcelasOriginal === '-' ? 0 : parcelasOriginal);
                    
                    const cartaoText = row.find('.cartao-text').text().trim();
                    if (cartaoText !== '-') {
                        row.find('select[data-field="cartao_credito_id"] option').each(function() {
                            if ($(this).text().trim() === cartaoText) {
                                row.find('select[data-field="cartao_credito_id"]').val($(this).val());
                            }
                        });
                    } else {
                        row.find('select[data-field="cartao_credito_id"]').val('');
                    }
                    
                    row.find('.view-mode').removeClass('d-none');
                    row.find('.edit-mode').addClass('d-none');
                });

                // ============================================
                // SALVAR - Enviar para o controller
                // ============================================
                $(document).on('click', '.save-edit', function() {
                    const row = $(this).closest('tr');
                    const id = $(this).data('id');
                    
                    // Coleta os dados
                    const descricao = row.find('input[data-field="descricao"]').val().trim();
                    const classificacao = row.find('select[data-field="classificacao_financeira"]').val();
                    const valor = row.find('input[data-field="valor"]').val();
                    
                    // ✅ Pega a data do input (já está no formato YYYY-MM-DD)
                    const data_pagamento = row.find('input[data-field="data_pagamento"]').val();
                    
                    // ✅ Pega a data original (para manter se não for alterada)
                    const dataOriginal = row.find('.data-text').data('original-date') || '';
                    
                    const status = row.find('select[data-field="status_pagamento"]').val();
                    const forma = row.find('select[data-field="forma_pagamento"]').val();
                    const parcelas = row.find('input[data-field="quantidade_parcelas"]').val();
                    const cartao = row.find('select[data-field="cartao_credito_id"]').val();
                    
                    // ✅ LÓGICA CORRIGIDA: Se a data não foi preenchida, usa a original
                    let dataEnviar = data_pagamento;
                    if (!data_pagamento || data_pagamento === '') {
                        dataEnviar = dataOriginal; // Mantém a data original
                        console.log('📝 Data não alterada, mantendo original:', dataOriginal);
                    } else {
                        console.log('📝 Data alterada:', data_pagamento);
                    }
                    
                    // Prepara os dados para enviar
                    const dados = {
                        descricao: descricao,
                        classificacao_financeira: classificacao,
                        valor: valor,
                        data_pagamento: dataEnviar, // ← Envia a data original se não foi alterada
                        status_pagamento: status,
                        forma_pagamento: forma,
                        quantidade_parcelas: parcelas || 0,
                        cartao_credito_id: cartao || null,
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        _method: 'PUT'
                    };
                    
                    console.log('📝 Dados enviados:', dados);
                    
                    // Mostra loading
                    const saveBtn = $(this);
                    saveBtn.html('<span class="spinner-border spinner-border-sm" role="status"></span>');
                    saveBtn.prop('disabled', true);
                    
                    // Envia para o controller
                    $.ajax({
                        url: '/despesas/update-action/' + id,
                        type: 'POST',
                        data: dados,
                        success: function(response) {
                            showToast('Movimentação atualizada com sucesso!', 'success');
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        },
                        error: function(xhr) {
                            saveBtn.html('<i class="bi bi-check-lg"></i>');
                            saveBtn.prop('disabled', false);
                            
                            let errorMessage = 'Erro ao atualizar!';
                            if (xhr.responseJSON && xhr.responseJSON.errors) {
                                const errors = xhr.responseJSON.errors;
                                const firstError = Object.values(errors)[0];
                                errorMessage = firstError ? firstError[0] : 'Erro de validação!';
                                console.log('📋 Erros de validação:', errors);
                            }
                            showToast(errorMessage, 'danger');
                            console.log('❌ Erro:', xhr.responseText);
                        }
                    });
                });

                // ============================================
                // EXCLUIR Despesas
                // ============================================
                $(document).on('click', '.delete-despesa', function() {
                    const id = $(this).data('id');
                    const name = $(this).data('name');
                    
                    $('#deleteDespesaId').val(id);
                    $('#deleteDespesaName').text(name);
                    $('#deleteModal').modal('show');
                });

                $('#confirmDeleteBtn').on('click', function() {
                    const id = $('#deleteDespesaId').val();
                    const url = '/despesas/delete-action/' + id;
                    
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            $('#deleteModal').modal('hide');
                            showToast(response.message || 'Despesa excluída com sucesso!', 'success');
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        },
                        error: function(xhr) {
                            $('#deleteModal').modal('hide');
                            
                            let errorMessage = 'Erro ao excluir despesa!';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            
                            showToast(errorMessage, 'danger');
                            console.log('Erro:', xhr.responseText);
                        }
                    });
                });

                // ============================================
                // FILTROS
                // ============================================
                $('#filterType, #filterStatus').on('change', function() {
                    applyFilters();
                });

                $('#searchExpense').on('keyup', function() {
                    applyFilters();
                });

                function applyFilters() {
                    const type = $('#filterType').val();
                    const status = $('#filterStatus').val();
                    const search = $('#searchExpense').val().toLowerCase().trim();
                    
                    $('#expensesTableBody tr').filter(function() {
                        let show = true;
                        const row = $(this);
                        
                        if (type !== '') {
                            const tipoCell = row.find('td:eq(2)').text().trim();
                            if (tipoCell !== type) show = false;
                        }
                        
                        if (status !== '' && show) {
                            const statusCell = row.find('td:eq(5)').text().trim();
                            if (statusCell !== status) show = false;
                        }
                        
                        if (search !== '' && show) {
                            const text = row.text().toLowerCase();
                            if (!text.includes(search)) show = false;
                        }
                        
                        row.toggle(show);
                    });
                }

                // ============================================
                // TOAST PERSONALIZADO
                // ============================================
                function showToast(message, type = 'success') {
                    const toast = document.createElement('div');
                    toast.className = `toast align-items-center text-white bg-${type} border-0 position-fixed top-0 end-0 m-3`;
                    toast.style.zIndex = '9999';
                    toast.style.minWidth = '250px';
                    toast.innerHTML = `
                        <div class="d-flex">
                            <div class="toast-body">
                                <i class="bi bi-${type === 'success' ? 'check-circle-fill' : 'exclamation-triangle-fill'} me-2"></i>
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

                // ============================================
                // RESET FORMULÁRIO AO FECHAR MODAL
                // ============================================
                $('#expenseModal').on('hidden.bs.modal', function() {
                    $('#expenseForm')[0].reset();
                    $('#expenseForm .is-invalid').removeClass('is-invalid');
                    $('#expenseForm .alert-validation').remove();
                    $('#expenseId').val('');
                    $('#modalTitle').html('<i class="bi bi-plus-circle-fill me-2"></i> Nova Despesa');
                    $('#saveExpenseBtn').html('<i class="bi bi-save me-2"></i> Salvar');
                });

                // ============================================
                // TOGGLE SIDEBAR
                // ============================================
                document.getElementById('toggleSidebar')?.addEventListener('click', function() {
                    document.getElementById('sidebar').classList.toggle('show');
                });

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

                verificarMesVirou();
            });

            // ============================================
            // VERIFICA SE O MÊS VIROU E CRIA DESPESAS REPETIDAS
            // ============================================
            function verificarMesVirou() {
                // 1. Verifica se já foi executado hoje
                const ultimaVerificacao = localStorage.getItem('ultima_verificacao_mes');
                const hoje = new Date().toDateString();
                
                if (ultimaVerificacao === hoje) {
                    console.log('📅 Verificação já realizada hoje. Aguardando próximo dia.');
                    return;
                }
                
                // 2. Busca as despesas com repetir_proximo_mes = 1
                $.ajax({
                    url: '/despesas/repetir',
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success && response.data.length > 0) {
                            console.log('📝 Despesas a serem repetidas:', response.data.length);
                            
                            // 3. Para cada despesa, cria uma nova no mês atual
                            response.data.forEach(function(despesa, index) {
                                // Cria um delay entre as requisições para não sobrecarregar
                                setTimeout(function() {
                                    criarDespesaRepetida(despesa);
                                }, index * 500);
                            });
                            
                            // 4. Salva a data da verificação
                            localStorage.setItem('ultima_verificacao_mes', hoje);
                            localStorage.setItem('ultimo_mes_verificado', new Date().getMonth());
                            
                            showToast('Despesas repetidas criadas com sucesso!', 'success');
                            
                        } else {
                            console.log('✅ Nenhuma despesa para repetir.');
                            localStorage.setItem('ultima_verificacao_mes', hoje);
                        }
                    },
                    error: function(xhr) {
                        console.error('❌ Erro ao verificar despesas:', xhr.responseText);
                    }
                });
            }

            function criarDespesaRepetida(despesa) {
                // Dados da nova despesa (mantém os mesmos dados, apenas atualiza a data)
                const dados = {
                    descricao: despesa.descricao,
                    valor: despesa.valor,
                    classificacao_financeira: despesa.classificacao_financeira,
                    status_pagamento: 'Pendente', // Nova despesa começa como pendente
                    forma_pagamento: despesa.forma_pagamento,
                    quantidade_parcelas: despesa.quantidade_parcelas || 0,
                    cartao_credito_id: despesa.cartao_credito_id || null,
                    data_pagamento: null, // Ainda não paga
                    repetir_proximo_mes: 1, // Mantém a repetição
                    _token: $('meta[name="csrf-token"]').attr('content')
                };
                
                console.log(`📝 Criando despesa repetida: ${despesa.descricao} - R$ ${despesa.valor}`);
                
                $.ajax({
                    url: '/despesas/store-action',
                    type: 'POST',
                    data: dados,
                    success: function(response) {
                        console.log(`✅ Despesa criada: ${despesa.descricao}`);
                    },
                    error: function(xhr) {
                        console.error(`❌ Erro ao criar despesa: ${despesa.descricao}`, xhr.responseText);
                    }
                });
            }
        </script>
    </body>
</html>