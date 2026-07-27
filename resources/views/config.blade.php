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

                <!-- Conteúdo das configurações -->
                <div class="container-fluid p-3 p-md-4">
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                        <h2 class="text-warning mb-2 mb-sm-0">
                            <i class="bi bi-gear-fill me-2"></i>
                            Configurações
                        </h2>
                    </div>

                    <!-- Grid de Configurações -->
                    <div class="row g-4">
                        <!-- Coluna 1: Cartões de Crédito -->
                        <div class="col-lg-6">
                            <div class="card bg-dark border-warning text-light h-100">
                                <div class="card-header border-warning d-flex justify-content-between align-items-center">
                                    <h5 class="text-warning mb-0">
                                        <i class="bi bi-credit-card-fill me-2"></i>
                                        Cartões de Crédito
                                    </h5>
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#cardModal">
                                        <i class="bi bi-plus-circle-fill me-1"></i>
                                        Novo Cartão
                                    </button>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-dark table-hover mb-0" id="cardsTable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nome do Cartão</th>
                                                    <th>Limite</th>
                                                    <th>Dia do vencimento</th>
                                                    <th class="text-center">Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody id="cardsTableBody">
                                                @foreach ($cartoes as $cartao)
                                                    <tr>
                                                        <td>#{{ $cartao->id }}</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <i class="bi bi-credit-card-fill text-warning me-2"></i>
                                                                {{ $cartao->nome_cartao }}
                                                            </div>
                                                        </td>
                                                        <td class="text-warning fw-bold">R$ {{ $cartao->limite_credito }}</td>
                                                        <td>{{ $cartao->dia_vencimento }}</td>
                                                        <td>
                                                            <div class="d-flex gap-1 justify-content-center">
                                                                <button class="btn btn-sm edit-card" data-id="${card.id}" title="Editar">
                                                                    <i class="bi bi-pencil-fill"></i>
                                                                </button>
                                                                <button class="btn btn-sm btn-outline-danger delete-card" data-id="${card.id}" data-name="${card.name}" title="Excluir">
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
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-light" id="totalCards">Total: {{ $nTotalCartoes }} cartões</span>
                                        <span class="text-warning fw-bold" id="totalLimit">Limite Total: R$ {{ $totalLimite }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Coluna 2: Personalização de Cores -->
                        <div class="col-lg-6">
                            <div class="card bg-dark border-warning text-light h-100">
                                <div class="card-header border-warning">
                                    <h5 class="text-warning mb-0">
                                        <i class="bi bi-palette-fill me-2"></i>
                                        Personalização de Cores
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <form id="colorForm">
                                        <div class="mb-3">
                                            <label for="primaryColor" class="form-label fw-semibold">
                                                Cor Primária
                                                <small class="text-secondary d-block">Usada em títulos e destaques principais</small>
                                            </label>
                                            <div class="d-flex align-items-center gap-3">
                                                <input type="color" class="form-control form-control-color bg-dark border-warning" 
                                                       id="primaryColor" value="#f5b645" style="width: 60px; height: 50px; padding: 5px;">
                                                <input type="text" class="form-control bg-dark text-light border-warning" 
                                                       id="primaryColorHex" value="#f5b645" style="max-width: 150px;">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="secondaryColor" class="form-label fw-semibold">
                                                Cor Secundária
                                                <small class="text-secondary d-block">Usada em botões e elementos interativos</small>
                                            </label>
                                            <div class="d-flex align-items-center gap-3">
                                                <input type="color" class="form-control form-control-color bg-dark border-warning" 
                                                       id="secondaryColor" value="#1a1a2e" style="width: 60px; height: 50px; padding: 5px;">
                                                <input type="text" class="form-control bg-dark text-light border-warning" 
                                                       id="secondaryColorHex" value="#1a1a2e" style="max-width: 150px;">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="backgroundColor" class="form-label fw-semibold">
                                                Cor de Fundo
                                                <small class="text-secondary d-block">Cor de fundo principal do sistema</small>
                                            </label>
                                            <div class="d-flex align-items-center gap-3">
                                                <input type="color" class="form-control form-control-color bg-dark border-warning" 
                                                       id="backgroundColor" value="#0d0d1a" style="width: 60px; height: 50px; padding: 5px;">
                                                <input type="text" class="form-control bg-dark text-light border-warning" 
                                                       id="backgroundColorHex" value="#0d0d1a" style="max-width: 150px;">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="textColor" class="form-label fw-semibold">
                                                Cor do Texto
                                                <small class="text-secondary d-block">Cor padrão para textos</small>
                                            </label>
                                            <div class="d-flex align-items-center gap-3">
                                                <input type="color" class="form-control form-control-color bg-dark border-warning" 
                                                       id="textColor" value="#cccccc" style="width: 60px; height: 50px; padding: 5px;">
                                                <input type="text" class="form-control bg-dark text-light border-warning" 
                                                       id="textColorHex" value="#cccccc" style="max-width: 150px;">
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <div class="p-3 rounded-3 mb-3" id="previewBox" style="background-color: #0d0d1a; border: 2px solid #f5b645;">
                                                <h6 class="text-warning mb-2">Preview</h6>
                                                <p class="text-light" style="color: #cccccc !important;">
                                                    Exemplo de como as cores ficarão no sistema.
                                                    <span class="text-warning">Destaque em amarelo</span>
                                                </p>
                                                <button class="btn btn-warning btn-sm">Botão Exemplo</button>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-warning w-100">
                                            <i class="bi bi-save me-2"></i>
                                            Salvar Configurações de Cores
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Cadastro de Cartão -->
        <div class="modal fade" id="cardModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-dark text-light">
                    <div class="modal-header border-warning">
                        <h5 class="modal-title text-warning">
                            <i class="bi bi-credit-card-fill me-2"></i>
                            Novo Cartão de Crédito
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    
                    <form action="{{ route('cartoes.store') }}" method="POST" id="cardForm" novalidate>
                        @csrf
                        
                        <div class="modal-body">
                            <input type="hidden" id="cardId">
                            
                            <div class="mb-3">
                                <label for="cardName" class="form-label fw-semibold">Nome do Cartão</label>
                                <input name="nome_cartao" type="text" class="form-control bg-dark text-light border-warning" id="cardName" placeholder="Ex: Nubank, Itaú, etc." required>
                                <div class="invalid-feedback">Por favor, informe o nome do cartão.</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="cardLimit" class="form-label fw-semibold">Limite de Crédito (R$)</label>
                                <input name="limite_credito" type="number" step="0.01" class="form-control bg-dark text-light border-warning" id="cardLimit" placeholder="0,00" required>
                                <div class="invalid-feedback">Por favor, informe o limite do cartão.</div>
                            </div>
                            <!--
                            <div class="mb-3">
                                <label for="cardDueDate" class="form-label fw-semibold">Data de Vencimento da Fatura</label>
                                <input name="dia_vencimento" type="date" class="form-control bg-dark text-light border-warning" id="cardDueDate" required>
                                <div class="invalid-feedback">Por favor, informe a data de vencimento.</div>
                            </div>-->

                             <div class="mb-3">
                                <label for="cardDueDate" class="form-label fw-semibold">Dia do Vencimento</label>
                                <select id="cardDueDate" name="dia_vencimento" class="form-select bg-dark text-light border-warning" required>
                                    <option value="">Selecione o dia</option>
                                </select>

                                <script>
                                    const select = document.getElementById("cardDueDate");

                                    for (let i = 1; i <= 31; i++) {
                                        const option = document.createElement("option");
                                        option.value = i;
                                        option.textContent = i;
                                        select.appendChild(option);
                                    }
                                </script>
                            </div>
                            
                        </div>
                        
                        <div class="modal-footer border-warning">
                            <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-warning" id="saveCardBtn">
                                <i class="bi bi-save me-2"></i>
                                Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal de Confirmação de Exclusão de Cartão -->
        <div class="modal fade" id="deleteCardModal" tabindex="-1" aria-hidden="true">
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
                        <p>Tem certeza que deseja excluir o cartão <strong id="deleteCardName"></strong>?</p>
                        <p class="text-danger small">Esta ação não pode ser desfeita.</p>
                        <input type="hidden" id="deleteCardId">
                    </div>
                    <div class="modal-footer border-danger">
                        <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-warning" id="confirmDeleteCardBtn">
                            <i class="bi bi-trash-fill me-2"></i>
                            Excluir
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <style>
            /* Estilos para a página de configurações */
            .config-page .form-control-color {
                cursor: pointer;
                padding: 5px !important;
            }

            .config-page .form-control-color::-webkit-color-swatch-wrapper {
                padding: 0;
            }

            .config-page .form-control-color::-webkit-color-swatch {
                border: 2px solid #f5b645;
                border-radius: 5px;
            }

            .config-page .form-control-color::-moz-color-swatch {
                border: 2px solid #f5b645;
                border-radius: 5px;
            }

            .config-page #previewBox {
                transition: all 0.3s ease;
                background-color: #0d0d1a !important;
                border: 2px solid #f5b645 !important;
            }

            .config-page #previewBox .text-warning {
                color: #f5b645 !important;
            }

            .config-page #previewBox .text-light {
                color: #cccccc !important;
            }

            .config-page .card {
                transition: all 0.3s ease;
            }

            .config-page .card:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 25px rgba(245, 182, 69, 0.15);
            }

            .config-page .table tbody tr {
                transition: all 0.2s ease;
            }

            .config-page .table tbody tr:hover {
                background-color: rgba(245, 182, 69, 0.05) !important;
            }

            .config-page .btn-outline-warning:hover {
                background-color: rgba(245, 182, 69, 0.1) !important;
                transform: translateY(-2px);
                box-shadow: 0 4px 15px rgba(245, 182, 69, 0.2);
            }

            .config-page .btn-outline-danger:hover {
                background-color: rgba(220, 53, 69, 0.1) !important;
                transform: translateY(-2px);
                box-shadow: 0 4px 15px rgba(220, 53, 69, 0.2);
            }

            @media (max-width: 576px) {
                .config-page .modal-dialog {
                    margin: 0.5rem;
                }
                
                .config-page .modal-body {
                    padding: 1rem;
                }
                
                .config-page .table-responsive {
                    font-size: 0.85rem;
                }
            }
        </style>

        <script>
            // Dados iniciais dos cartões
            /*let cards = [
                { 
                    id: 1, 
                    name: 'Nubank', 
                    limit: 5000.00, 
                    due_date: '2024-04-10' 
                },
                { 
                    id: 2, 
                    name: 'Itaú', 
                    limit: 8000.00, 
                    due_date: '2024-04-15' 
                },
                { 
                    id: 3, 
                    name: 'Bradesco', 
                    limit: 3000.00, 
                    due_date: '2024-04-20' 
                },
                { 
                    id: 4, 
                    name: 'Santander', 
                    limit: 4500.00, 
                    due_date: '2024-04-25' 
                }
            ];*/

            // Configurações de cores (salvas no localStorage)
            let colorSettings = {
                primary: localStorage.getItem('primaryColor') || '#f5b645',
                secondary: localStorage.getItem('secondaryColor') || '#1a1a2e',
                background: localStorage.getItem('backgroundColor') || '#0d0d1a',
                text: localStorage.getItem('textColor') || '#cccccc'
            };

            /*let nextCardId = 5;
            let editingCardId = null;

            // Renderizar tabela de cartões
            function renderCardsTable(cardsData = cards) {
                const tbody = document.getElementById('cardsTableBody');
                const totalCards = document.getElementById('totalCards');
                const totalLimit = document.getElementById('totalLimit');
                
                if (cardsData.length === 0) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="5" class="text-center py-4 text-secondary">
                                <i class="bi bi-credit-card display-4 d-block mb-2"></i>
                                Nenhum cartão cadastrado
                            </td>
                        </tr>
                    `;
                    totalCards.textContent = 'Total: 0 cartões';
                    totalLimit.textContent = 'Limite Total: R$ 0,00';
                    return;
                }

                let total = 0;
                tbody.innerHTML = cardsData.map(card => {
                    total += card.limit;
                    return `
                        <tr>
                            <td>#${card.id}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-credit-card-fill text-warning me-2"></i>
                                    ${card.name}
                                </div>
                            </td>
                            <td class="text-warning fw-bold">R$ ${card.limit.toFixed(2)}</td>
                            <td>${formatDate(card.due_date)}</td>
                            <td>
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm edit-card" data-id="${card.id}" title="Editar">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger delete-card" data-id="${card.id}" data-name="${card.name}" title="Excluir">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `;
                }).join('');

                totalCards.textContent = `Total: ${cardsData.length} cartões`;
                totalLimit.textContent = `Limite Total: R$ ${total.toFixed(2)}`;
            }*/

            // Formatar data
            function formatDate(dateStr) {
                const date = new Date(dateStr);
                return date.toLocaleDateString('pt-BR', { day: '2-digit', month: '2-digit', year: 'numeric' });
            }

            // Salvar cartão (criar/editar)
            /*document.getElementById('cardForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const form = this;
                if (!form.checkValidity()) {
                    form.classList.add('was-validated');
                    return;
                }

                const id = document.getElementById('cardId').value;
                const name = document.getElementById('cardName').value.trim();
                const limit = parseFloat(document.getElementById('cardLimit').value);
                const due_date = document.getElementById('cardDueDate').value;

                if (id) {
                    const index = cards.findIndex(c => c.id === parseInt(id));
                    if (index !== -1) {
                        cards[index] = { ...cards[index], name, limit, due_date };
                        showToast('Cartão atualizado com sucesso!', 'success');
                    }
                } else {
                    const newCard = { id: nextCardId++, name, limit, due_date };
                    cards.push(newCard);
                    showToast('Cartão cadastrado com sucesso!', 'success');
                }

                renderCardsTable();
                resetCardForm();
                bootstrap.Modal.getInstance(document.getElementById('cardModal')).hide();
            });*/

            // Editar cartão
            document.addEventListener('click', function(e) {
                if (e.target.closest('.edit-card')) {
                    const btn = e.target.closest('.edit-card');
                    const id = parseInt(btn.dataset.id);
                    const card = cards.find(c => c.id === id);
                    
                    if (card) {
                        editingCardId = id;
                        document.getElementById('cardId').value = id;
                        document.getElementById('cardName').value = card.name;
                        document.getElementById('cardLimit').value = card.limit;
                        document.getElementById('cardDueDate').value = card.due_date;
                        document.getElementById('cardModalTitle').innerHTML = '<i class="bi bi-pencil-fill me-2"></i>Editar Cartão';
                        document.getElementById('saveCardBtn').innerHTML = '<i class="bi bi-pencil-fill me-2"></i>Atualizar';
                        
                        const modal = new bootstrap.Modal(document.getElementById('cardModal'));
                        modal.show();
                    }
                }
            });

            // Excluir cartão
            document.addEventListener('click', function(e) {
                if (e.target.closest('.delete-card')) {
                    const btn = e.target.closest('.delete-card');
                    const id = parseInt(btn.dataset.id);
                    const name = btn.dataset.name;
                    
                    document.getElementById('deleteCardId').value = id;
                    document.getElementById('deleteCardName').textContent = name;
                    
                    const modal = new bootstrap.Modal(document.getElementById('deleteCardModal'));
                    modal.show();
                }
            });

            // Confirmar exclusão de cartão
            document.getElementById('confirmDeleteCardBtn').addEventListener('click', function() {
                const id = parseInt(document.getElementById('deleteCardId').value);
                cards = cards.filter(c => c.id !== id);
                renderCardsTable();
                showToast('Cartão excluído com sucesso!', 'danger');
                bootstrap.Modal.getInstance(document.getElementById('deleteCardModal')).hide();
            });

            // Resetar formulário de cartão
            function resetCardForm() {
                document.getElementById('cardForm').reset();
                document.getElementById('cardId').value = '';
                document.getElementById('cardModalTitle').innerHTML = '<i class="bi bi-credit-card-fill me-2"></i>Novo Cartão';
                document.getElementById('saveCardBtn').innerHTML = '<i class="bi bi-save me-2"></i>Salvar';
                document.getElementById('cardForm').classList.remove('was-validated');
            }

            // Reset ao fechar modal
            document.getElementById('cardModal').addEventListener('hidden.bs.modal', function() {
                resetCardForm();
            });

            // ============== PERSONALIZAÇÃO DE CORES ==============

            // Sincronizar inputs de cor
            document.getElementById('primaryColor').addEventListener('input', function() {
                document.getElementById('primaryColorHex').value = this.value;
                applyColorPreview();
            });

            document.getElementById('primaryColorHex').addEventListener('input', function() {
                if (/^#[0-9A-F]{6}$/i.test(this.value)) {
                    document.getElementById('primaryColor').value = this.value;
                    applyColorPreview();
                }
            });

            document.getElementById('secondaryColor').addEventListener('input', function() {
                document.getElementById('secondaryColorHex').value = this.value;
                applyColorPreview();
            });

            document.getElementById('secondaryColorHex').addEventListener('input', function() {
                if (/^#[0-9A-F]{6}$/i.test(this.value)) {
                    document.getElementById('secondaryColor').value = this.value;
                    applyColorPreview();
                }
            });

            document.getElementById('backgroundColor').addEventListener('input', function() {
                document.getElementById('backgroundColorHex').value = this.value;
                applyColorPreview();
            });

            document.getElementById('backgroundColorHex').addEventListener('input', function() {
                if (/^#[0-9A-F]{6}$/i.test(this.value)) {
                    document.getElementById('backgroundColor').value = this.value;
                    applyColorPreview();
                }
            });

            document.getElementById('textColor').addEventListener('input', function() {
                document.getElementById('textColorHex').value = this.value;
                applyColorPreview();
            });

            document.getElementById('textColorHex').addEventListener('input', function() {
                if (/^#[0-9A-F]{6}$/i.test(this.value)) {
                    document.getElementById('textColor').value = this.value;
                    applyColorPreview();
                }
            });

            // Aplicar preview das cores
            function applyColorPreview() {
                const primary = document.getElementById('primaryColor').value;
                const secondary = document.getElementById('secondaryColor').value;
                const background = document.getElementById('backgroundColor').value;
                const text = document.getElementById('textColor').value;

                const preview = document.getElementById('previewBox');
                preview.style.backgroundColor = background;
                preview.style.borderColor = primary;
                
                const title = preview.querySelector('h6');
                if (title) title.style.color = primary;
                
                const paragraph = preview.querySelector('p');
                if (paragraph) {
                    paragraph.style.color = text;
                    const highlight = paragraph.querySelector('.text-warning');
                    if (highlight) highlight.style.color = primary;
                }
                
                const button = preview.querySelector('.btn');
                if (button) {
                    button.style.backgroundColor = primary;
                    button.style.color = secondary;
                    button.style.borderColor = primary;
                }
            }

            // Salvar configurações de cores
            document.getElementById('colorForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const primary = document.getElementById('primaryColor').value;
                const secondary = document.getElementById('secondaryColor').value;
                const background = document.getElementById('backgroundColor').value;
                const text = document.getElementById('textColor').value;

                // Salvar no localStorage
                localStorage.setItem('primaryColor', primary);
                localStorage.setItem('secondaryColor', secondary);
                localStorage.setItem('backgroundColor', background);
                localStorage.setItem('textColor', text);

                // Aplicar cores ao sistema
                document.documentElement.style.setProperty('--bs-warning', primary);
                document.documentElement.style.setProperty('--bs-dark', secondary);
                document.documentElement.style.setProperty('--bs-body-bg', background);
                document.documentElement.style.setProperty('--bs-body-color', text);

                // Aplicar cores aos elementos
                applyColorsToSystem(primary, secondary, background, text);

                showToast('Configurações de cores salvas com sucesso!', 'success');
            });

            // Aplicar cores a todo o sistema
            function applyColorsToSystem(primary, secondary, background, text) {
                // Atualizar variáveis CSS
                document.documentElement.style.setProperty('--primary-color', primary);
                document.documentElement.style.setProperty('--secondary-color', secondary);
                document.documentElement.style.setProperty('--background-color', background);
                document.documentElement.style.setProperty('--text-color', text);

                // Atualizar elementos específicos
                const elements = document.querySelectorAll('.text-warning, .border-warning, .bg-warning');
                elements.forEach(el => {
                    if (el.classList.contains('text-warning')) {
                        el.style.color = primary;
                    }
                    if (el.classList.contains('border-warning')) {
                        el.style.borderColor = primary;
                    }
                    if (el.classList.contains('bg-warning')) {
                        el.style.backgroundColor = primary;
                        if (el.classList.contains('btn')) {
                            el.style.color = secondary;
                        }
                    }
                });

                // Atualizar cards
                document.querySelectorAll('.card.bg-dark').forEach(card => {
                    card.style.backgroundColor = secondary;
                });
            }

            // Carregar cores salvas
            function loadSavedColors() {
                if (localStorage.getItem('primaryColor')) {
                    const primary = localStorage.getItem('primaryColor');
                    const secondary = localStorage.getItem('secondaryColor');
                    const background = localStorage.getItem('backgroundColor');
                    const text = localStorage.getItem('textColor');

                    document.getElementById('primaryColor').value = primary;
                    document.getElementById('primaryColorHex').value = primary;
                    document.getElementById('secondaryColor').value = secondary;
                    document.getElementById('secondaryColorHex').value = secondary;
                    document.getElementById('backgroundColor').value = background;
                    document.getElementById('backgroundColorHex').value = background;
                    document.getElementById('textColor').value = text;
                    document.getElementById('textColorHex').value = text;

                    applyColorPreview();
                    applyColorsToSystem(primary, secondary, background, text);
                }
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

            // Inicializar página
            renderCardsTable();
            loadSavedColors();
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