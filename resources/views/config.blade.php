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
                                                                <button class="btn btn-sm btn-warning edit-cartao" 
                                                                        data-id="{{ $cartao->id }}"
                                                                        data-nome-cartao="{{ $cartao->nome_cartao }}"
                                                                        data-limite-credito="{{ $cartao->limite_credito }}"
                                                                        data-dia-vencimento="{{ $cartao->dia_vencimento }}"                                                                        
                                                                        data-bs-toggle="modal" 
                                                                        data-bs-target="#editModal" 
                                                                        title="Editar">
                                                                    <i class="bi bi-pencil-fill"></i>
                                                                </button>
                                                                <button class="btn btn-sm btn-outline-danger delete-cartao" 
                                                                        data-id="{{ $cartao->id }}" 
                                                                        data-nome-cartao="{{ $cartao->nome_cartao }}"
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
                                    <form action="{{ route('style.store') }}" method="POST">
                                        @csrf

                                        <div class="mb-3">
                                            <label for="primaryColor" class="form-label fw-semibold">
                                                Cor Primária
                                                <small class="text-secondary d-block">Usada em títulos e destaques principais</small>
                                            </label>
                                            <div class="d-flex align-items-center gap-3">
                                                <input type="color" class="form-control form-control-color bg-dark border-warning" id="primaryColor" value="#f5b645" style="width: 60px; height: 50px; padding: 5px;">
                                                <input name="primaryColorHex" type="text" class="form-control bg-dark text-light border-warning" id="primaryColorHex" value="#f5b645" style="max-width: 150px;">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="secondaryColor" class="form-label fw-semibold">
                                                Cor Secundária
                                                <small class="text-secondary d-block">Usada em botões e elementos interativos</small>
                                            </label>
                                            <div class="d-flex align-items-center gap-3">
                                                <input type="color" class="form-control form-control-color bg-dark border-warning" id="secondaryColor" value="#1a1a2e" style="width: 60px; height: 50px; padding: 5px;">
                                                <input name="secondaryColorHex" type="text" class="form-control bg-dark text-light border-warning" id="secondaryColorHex" value="#1a1a2e" style="max-width: 150px;">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="backgroundColor" class="form-label fw-semibold">
                                                Cor de Fundo
                                                <small class="text-secondary d-block">Cor de fundo principal do sistema</small>
                                            </label>
                                            <div class="d-flex align-items-center gap-3">
                                                <input type="color" class="form-control form-control-color bg-dark border-warning" id="backgroundColor" value="#0d0d1a" style="width: 60px; height: 50px; padding: 5px;">
                                                <input name="backgroundColorHex" type="text" class="form-control bg-dark text-light border-warning" id="backgroundColorHex" value="#0d0d1a" style="max-width: 150px;">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="textColor" class="form-label fw-semibold">
                                                Cor do Texto
                                                <small class="text-secondary d-block">Cor padrão para textos</small>
                                            </label>
                                            <div class="d-flex align-items-center gap-3">
                                                <input type="color" class="form-control form-control-color bg-dark border-warning" id="textColor" value="#cccccc" style="width: 60px; height: 50px; padding: 5px;">
                                                <input name="textColorHex" type="text" class="form-control bg-dark text-light border-warning" id="textColorHex" value="#cccccc" style="max-width: 150px;">
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <div class="p-3 rounded-3 mb-3" id="previewBox" style="background-color: #0d0d1a; border: 2px solid #f5b645;">
                                                <h6 class="text-warning mb-2">Preview</h6>
                                                <p class="text-light" style="color: #cccccc !important;">
                                                    Exemplo de como as cores ficarão no sistema.
                                                    <span class="text-warning">Destaque em amarelo</span>
                                                </p>
                                                <button class="btn btn-warning btn-sm" disabled>Botão Exemplo</button>
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
                                <label for="CardName" class="form-label fw-semibold">Nome do Cartão</label>
                                <input name="nome_cartao" type="text" class="form-control bg-dark text-light border-warning" id="CardName" placeholder="Ex: Nubank, Itaú, etc." required>
                                <div class="invalid-feedback">Por favor, informe o nome do cartão.</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="CardLimit" class="form-label fw-semibold">Limite de Crédito (R$)</label>
                                <input name="limite_credito" type="number" step="0.01" class="form-control bg-dark text-light border-warning" id="CardLimit" placeholder="0,00" required>
                                <div class="invalid-feedback">Por favor, informe o limite do cartão.</div>
                            </div>

                            <div class="mb-3">
                                <label for="CardDueDate" class="form-label fw-semibold">Dia do Vencimento</label>
                                <select id="CardDueDate" name="dia_vencimento" class="form-select bg-dark text-light border-warning" required>
                                    <option value="">Selecione o dia</option>
                                </select>

                                <script>
                                    var select = document.getElementById("CardDueDate");

                                    for (let i = 1; i <= 31; i++) {
                                        var option = document.createElement("option");
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

        <!-- Modal de Edição (APENAS UM, FORA DO LOOP) -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-dark text-light">
                    <div class="modal-header border-warning">
                        <h5 class="modal-title text-warning">
                            <i class="bi bi-pencil-fill me-2"></i>
                            Editar Usuário
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>                    
                    <form action="#" method="POST" id="editForm" novalidate>
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="editCartaoId" name="id">

                            <div class="modal-body">
                                <input type="hidden" id="cardId">
                                
                                <div class="mb-3">
                                    <label for="editCardName" class="form-label fw-semibold">Nome do Cartão</label>
                                    <input name="nome_cartao" type="text" class="form-control bg-dark text-light border-warning" id="editCardName" placeholder="Ex: Nubank, Itaú, etc." required>
                                    <div class="invalid-feedback">Por favor, informe o nome do cartão.</div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="editCardLimit" class="form-label fw-semibold">Limite de Crédito (R$)</label>
                                    <input name="limite_credito" type="number" step="0.01" class="form-control bg-dark text-light border-warning" id="editCardLimit" placeholder="0,00" required>
                                    <div class="invalid-feedback">Por favor, informe o limite do cartão.</div>
                                </div>

                                <div class="mb-3">
                                    <label for="editCardDueDate" class="form-label fw-semibold">Dia do Vencimento</label>
                                    <select id="editCardDueDate" name="dia_vencimento" class="form-select bg-dark text-light border-warning" required>
                                        <option value="">Selecione o dia</option>
                                    </select>

                                    <script>
                                        select = document.getElementById("editCardDueDate");

                                        for (let i = 1; i <= 31; i++) {
                                            option = document.createElement("option");
                                            option.value = i;
                                            option.textContent = i;
                                            select.appendChild(option);
                                        }
                                    </script>
                                </div>
                                
                            </div>                                                                                          
                        
                            <div class="modal-footer border-warning">
                                <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-warning">
                                    <i class="bi bi-save me-2"></i>
                                    Atualizar
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
                        <p>Tem certeza que deseja excluir o usuário <strong id="deleteCartaoName"></strong>?</p>
                        <p class="text-danger small">Esta ação não pode ser desfeita.</p>
                        <input type="hidden" id="deleteCartaoId">
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

        <script>                                        
            $(document).ready(function() {
                // ============================================
                // VALIDAÇÃO DO FORMULÁRIO DE EDIÇÃO
                // ============================================
                $('#editForm').on('submit', function(e) {
                    let isValid = true;
                    let firstError = null;
                    let errorMessages = [];
                    
                    $(this).find('.is-invalid').removeClass('is-invalid');
                    $(this).find('.alert-validation').remove();
                    
                    // Campos obrigatórios
                    const campos = [
                        { id: '#editCardName', nome: 'Nome de cartão' },
                        { id: '#editCardLimit', nome: 'Limite do cartão' },
                        { id: '#editCardDueDate', nome: 'Data de Vencimento' },                                            
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
                });
                
                // ============================================
                // PREENCHER MODAL DE EDIÇÃO
                // ============================================
                $(document).on('click', '.edit-cartao', function() {
                    // ✅ Usa data() com camelCase (como o jQuery converte)
                    const id = $(this).data('id');
                    const nomeCartao = $(this).data('nomeCartao') || '';  // ← camelCase
                    const limiteCredito = $(this).data('limiteCredito') || '';  // ← camelCase
                    const diaVencimento = $(this).data('diaVencimento') || '';  // ← camelCase
                    
                    // Define a action do formulário
                    $('#editForm').attr('action', '/cartoes/update-action/' + id);

                    console.log('📝 Dados via data:', { id, nomeCartao, limiteCredito, diaVencimento });
                    
                    // Preenche os campos
                    $('#editCardName').val(nomeCartao);
                    $('#editCardLimit').val(limiteCredito);
                    $('#editCardDueDate').val(diaVencimento);
                    $('#editCartaoId').val(id);                                    
                });
                
                // ============================================
                // EXCLUIR CARTÃO
                // ============================================
                // ============================================
                // EXCLUIR CARTÃO
                // ============================================
                $(document).on('click', '.delete-cartao', function() {
                    const id = $(this).data('id');
                    const nomeCartao = $(this).data('nome-cartao');
                    
                    $('#deleteCartaoId').val(id);
                    $('#deleteCartaoName').text(nomeCartao);
                    $('#deleteModal').modal('show');
                });

                $('#confirmDeleteBtn').on('click', function() {
                    const id = $('#deleteCartaoId').val();
                    
                    // ✅ CORRIGIDO: Use a URL correta
                    const url = '/cartoes/delete-action/' + id;  // Se estiver usando /delete-action/{id}        
                    
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
            });            
        </script>

        {{-- @if ($errors->any())
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
        @endif --}}
    </body>
</html>