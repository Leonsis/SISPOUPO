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

                <!-- Conteúdo do usuários -->
                <div class="container-fluid p-3 p-md-4">
                    <!-- Título e botão -->
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                        <h2 class="text-warning mb-2 mb-sm-0">
                            <i class="bi bi-people-fill me-2"></i>
                            Gerenciar Usuários
                        </h2>
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#userModal">
                            <i class="bi bi-person-plus-fill me-2"></i>
                            Novo Usuário
                        </button>
                    </div>

                    <!-- Tabela de usuários -->
                    <div class="card bg-dark border-warning text-light">
                        <div class="card-header border-warning">
                            <div class="row g-2 align-items-center">
                                <div class="col-md-6">
                                    <h5 class="text-warning mb-0">
                                        <i class="bi bi-list-ul me-2"></i>
                                        Lista de Usuários
                                    </h5>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text bg-dark border-warning text-warning">
                                            <i class="bi bi-search"></i>
                                        </span>
                                        <input type="text" class="form-control bg-dark text-light border-warning" 
                                               id="searchUser" placeholder="Buscar usuário...">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-dark table-hover mb-0" id="usersTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nome</th>
                                            <th>Email</th>
                                            <th>Nível</th>
                                            <th>Status</th>
                                            <th>Data Cadastro</th>
                                            <th class="text-center">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody id="usersTableBody">
                                        @foreach ($vUsuarios as $usuario)
                                            <tr>
                                                <td>#{{ $usuario->id }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-warning bg-opacity-25 rounded-circle p-2 me-2" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                                            <i class="bi bi-person-fill text-warning"></i>
                                                        </div>
                                                        {{ $usuario->nome }}
                                                    </div>
                                                </td>
                                                <td>{{ $usuario->email }}</td>
                                                <td>
                                                    <span class="badge {{ $usuario->tipo_usuario === 'USUARIO_ADMIN' ? 'bg-danger' : ($usuario->tipo_usuario === 'USUARIO_PADRAO' ? 'bg-info' : 'bg-secondary') }}">
                                                        {{ $usuario->tipo_usuario }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge {{ $usuario->situacao_cadastral == 1 ? 'bg-success' : 'bg-secondary' }}">
                                                        {{ $usuario->situacao_cadastral == 1 ? 'Ativo' : 'Inativo' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($usuario->created_at)->format('d/m/Y') }}
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-1 justify-content-center">
                                                        <button class="btn btn-sm btn-warning edit-user" 
                                                                data-id="{{ $usuario->id }}"
                                                                data-nome_usuario="{{ $usuario->nome_usuario }}"
                                                                data-nome="{{ $usuario->nome }}"
                                                                data-email="{{ $usuario->email }}"
                                                                data-cpf_cnpj="{{ $usuario->cpf_cnpj }}"
                                                                data-telefone="{{ $usuario->telefone }}"
                                                                data-tipo_usuario="{{ $usuario->tipo_usuario }}"
                                                                data-situacao_cadastral="{{ $usuario->situacao_cadastral }}"
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#editModal" 
                                                                title="Editar">
                                                            <i class="bi bi-pencil-fill"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-danger delete-user" 
                                                                data-id="{{ $usuario->id }}" 
                                                                data-name="{{ $usuario->nome }}" 
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
                                <span class="text-light" id="totalUsers">Total: {{ $vNTotalUsuarios }} usuários</span>
                                <nav aria-label="Navegação de páginas">
                                    <ul class="pagination pagination-sm mb-0">
                                        <li class="page-item disabled">
                                            <a class="page-link bg-dark border-warning text-warning" href="#">Anterior</a>
                                        </li>
                                        <li class="page-item active">
                                            <a class="page-link bg-warning border-warning text-dark" href="#">1</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link bg-dark border-warning text-warning" href="#">2</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link bg-dark border-warning text-warning" href="#">3</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link bg-dark border-warning text-warning" href="#">Próximo</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Cadastro -->
        <div class="modal fade" id="userModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-dark text-light">
                    <div class="modal-header border-warning">
                        <h5 class="modal-title text-warning" id="modalTitle">
                            <i class="bi bi-person-plus-fill me-2"></i>
                            Novo Usuário
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>                    
                    <form action="{{ route('usuarios.store') }}" method="POST" id="userForm" novalidate>
                        @csrf 
                        <input type="hidden" name="_method" value="POST" id="formMethod">
                        <input type="hidden" id="userId" name="id">

                        <div class="modal-body">
                            <!-- Nome de Usuário -->
                            <div class="mb-3">
                                <label for="userName" class="form-label fw-semibold">Nome de Usuário</label>
                                <input name="nome_usuario" type="text" class="form-control bg-dark text-light border-warning" id="userName" placeholder="Digite o nome de usuário" required>
                                <div class="invalid-feedback">Por favor, informe o nome do usuário.</div>
                            </div>
                            
                            <!-- Nome Completo -->
                            <div class="mb-3">
                                <label for="namerUser" class="form-label fw-semibold">Nome completo</label>
                                <input name="nome" type="text" class="form-control bg-dark text-light border-warning" id="namerUser" placeholder="Digite o nome completo" required>
                                <div class="invalid-feedback">Por favor, informe o nome completo.</div>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="userEmail" class="form-label fw-semibold">Email</label>
                                <input name="email" type="email" class="form-control bg-dark text-light border-warning" id="userEmail" placeholder="Digite o email" required>
                                <div class="invalid-feedback">Por favor, informe um email válido.</div>
                            </div>

                            <!-- CPF/CNPJ -->
                            <div class="mb-3">
                                <label for="userCpf_cnpj" class="form-label fw-semibold">CPF/CNPJ</label>
                                <input name="cpf_cnpj" type="text" class="form-control bg-dark text-light border-warning" id="cpf_cnpj" placeholder="Digite o CPF/CNPJ" required>
                                <div class="invalid-feedback">CPF: 11 dígitos | CNPJ: 14 dígitos</div>
                                <small class="text-muted">CPF: 11 dígitos | CNPJ: 14 dígitos</small>
                            </div>

                            <!-- Telefone -->
                            <div class="mb-3">
                                <label for="userTelefone" class="form-label fw-semibold">Telefone</label>
                                <input name="telefone" type="text" class="form-control bg-dark text-light border-warning" id="userTelefone" placeholder="Digite o telefone" required>
                                <div class="invalid-feedback">Por favor, informe o telefone.</div>
                            </div>
                            
                            <!-- Senha -->
                            <div class="mb-3">
                                <label for="userPassword" class="form-label fw-semibold">Senha</label>
                                <div class="input-group">
                                    <input name="password" type="password" class="form-control bg-dark text-light border-warning" id="userPassword" placeholder="Digite a senha" minlength="6">
                                    <button class="btn border-warning" type="button" id="togglePasswordModal">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback">A senha deve ter no mínimo 6 caracteres.</div>
                                <div class="form-text text-secondary" id="passwordHelp">Mínimo 6 caracteres (opcional para edição)</div>
                            </div>                            
                            
                            <!-- Nível de Acesso -->
                            <div class="mb-3">
                                <label for="userLevel" class="form-label fw-semibold">Nível de acesso</label>
                                <select name="tipo_usuario" class="form-select bg-dark text-light border-warning" id="userLevel" required>
                                    <option value="">Selecione...</option>
                                    <option value="USUARIO_PADRAO">USUARIO_PADRAO</option>
                                    <option value="USUARIO_ADMIN">USUARIO_ADMIN</option>
                                    <option value="USUARIO_EMPRESA">USUARIO_EMPRESA</option>                                    
                                </select>
                                <div class="invalid-feedback">Por favor, selecione um nível de acesso.</div>
                            </div>
                            
                            <!-- Status -->
                            <div class="mb-3">
                                <label for="userStatus" class="form-label fw-semibold">Status</label>
                                <select name="situacao_cadastral" class="form-select bg-dark text-light border-warning" id="userStatus" required>                                    
                                    <option value="1">Ativo</option>
                                    <option value="0">Inativo</option>
                                </select>
                                <div class="invalid-feedback">Por favor, selecione um status.</div>
                            </div>
                        </div>
                        
                        <div class="modal-footer border-warning">
                            <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-warning" id="saveUserBtn">
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
                        <input type="hidden" id="editUserId" name="id">

                        <div class="modal-body">
                            <!-- Nome de Usuário -->
                            <div class="mb-3">
                                <label for="editUserName" class="form-label fw-semibold">Nome de Usuário</label>
                                <input name="nome_usuario" type="text" class="form-control bg-dark text-light border-warning" id="editUserName" placeholder="Digite o nome de usuário" required>
                                <div class="invalid-feedback">Por favor, informe o nome do usuário.</div>
                            </div>
                            
                            <!-- Nome Completo -->
                            <div class="mb-3">
                                <label for="editNamerUser" class="form-label fw-semibold">Nome completo</label>
                                <input name="nome" type="text" class="form-control bg-dark text-light border-warning" id="editNamerUser" placeholder="Digite o nome completo" required>
                                <div class="invalid-feedback">Por favor, informe o nome completo.</div>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="editUserEmail" class="form-label fw-semibold">Email</label>
                                <input name="email" type="email" class="form-control bg-dark text-light border-warning" id="editUserEmail" placeholder="Digite o email" required>
                                <div class="invalid-feedback">Por favor, informe um email válido.</div>
                            </div>

                            <!-- CPF/CNPJ -->
                            <div class="mb-3">
                                <label for="editCpfCnpj" class="form-label fw-semibold">CPF/CNPJ</label>
                                <input name="cpf_cnpj" type="text" class="form-control bg-dark text-light border-warning" id="editCpfCnpj" placeholder="Digite o CPF/CNPJ" required>
                                <div class="invalid-feedback">CPF: 11 dígitos | CNPJ: 14 dígitos</div>
                                <small class="text-muted">CPF: 11 dígitos | CNPJ: 14 dígitos</small>
                            </div>

                            <!-- Telefone -->
                            <div class="mb-3">
                                <label for="editTelefone" class="form-label fw-semibold">Telefone</label>
                                <input name="telefone" type="text" class="form-control bg-dark text-light border-warning" id="editTelefone" placeholder="Digite o telefone" required>
                                <div class="invalid-feedback">Por favor, informe o telefone.</div>
                            </div>
                            
                            <!-- Senha -->
                            <div class="mb-3">
                                <label for="editPassword" class="form-label fw-semibold">Nova Senha</label>
                                <div class="input-group">
                                    <input name="password" type="password" class="form-control bg-dark text-light border-warning" id="editPassword" placeholder="Digite a nova senha" minlength="6">
                                    <button class="btn border-warning" type="button" id="toggleEditPassword">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback">A senha deve ter no mínimo 6 caracteres.</div>
                                <div class="form-text text-secondary">Deixe em branco para manter a senha atual</div>
                            </div>

                            <!-- Confirmar Senha -->
                            <div class="mb-3">
                                <label for="editPasswordConfirmation" class="form-label fw-semibold">Confirmar Nova Senha</label>
                                <input name="password_confirmation" type="password" class="form-control bg-dark text-light border-warning" id="editPasswordConfirmation" placeholder="Confirme a nova senha">
                                <div class="invalid-feedback">As senhas não coincidem.</div>
                            </div>
                            
                            <!-- Nível de Acesso -->
                            <div class="mb-3">
                                <label for="editUserLevel" class="form-label fw-semibold">Nível de acesso</label>
                                <select name="tipo_usuario" class="form-select bg-dark text-light border-warning" id="editUserLevel" required>
                                    <option value="">Selecione...</option>
                                    <option value="USUARIO_PADRAO">USUARIO_PADRAO</option>
                                    <option value="USUARIO_ADMIN">USUARIO_ADMIN</option>
                                    <option value="USUARIO_EMPRESA">USUARIO_EMPRESA</option>                                    
                                </select>
                                <div class="invalid-feedback">Por favor, selecione um nível de acesso.</div>
                            </div>
                            
                            <!-- Status -->
                            <div class="mb-3">
                                <label for="editUserStatus" class="form-label fw-semibold">Status</label>
                                <select name="situacao_cadastral" class="form-select bg-dark text-light border-warning" id="editUserStatus" required>                                    
                                    <option value="1">Ativo</option>
                                    <option value="0">Inativo</option>
                                </select>
                                <div class="invalid-feedback">Por favor, selecione um status.</div>
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
                        <p>Tem certeza que deseja excluir o usuário <strong id="deleteUserName"></strong>?</p>
                        <p class="text-danger small">Esta ação não pode ser desfeita.</p>
                        <input type="hidden" id="deleteUserId">
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
                // MÁSCARA CPF/CNPJ - Modal Cadastro
                // ============================================
                $('#cpf_cnpj, #editCpfCnpj').on('input', function () {

                    // Remove caracteres especiais e mantém letras e números
                    let valor = $(this).val().replace(/[^\p{L}\p{N}]/gu, '').toUpperCase();

                    // Limita a 14 caracteres
                    valor = valor.slice(0, 14);

                    // ============================================
                    // CPF - até 11 caracteres
                    // Formato: 000.000.000-00
                    // ============================================
                    if (valor.length <= 11) {

                        if (valor.length > 3) {
                            valor = valor.slice(0, 3) + '.' + valor.slice(3);
                        }

                        if (valor.length > 7) {
                            valor = valor.slice(0, 7) + '.' + valor.slice(7);
                        }

                        if (valor.length > 11) {
                            valor = valor.slice(0, 11) + '-' + valor.slice(11);
                        }

                    // ============================================
                    // CNPJ ALFANUMÉRICO - 12 a 14 caracteres
                    // Formato: AA.AAA.AAA/AAAA-00
                    // ============================================
                    } else {

                        valor = valor.replace(/[^\p{L}\p{N}]/gu, '');

                        let mascarado = '';

                        mascarado = valor.slice(0, 2);

                        if (valor.length > 2) {
                            mascarado += '.' + valor.slice(2, 5);
                        }

                        if (valor.length > 5) {
                            mascarado += '.' + valor.slice(5, 8);
                        }

                        if (valor.length > 8) {
                            mascarado += '/' + valor.slice(8, 12);
                        }

                        if (valor.length > 12) {
                            mascarado += '-' + valor.slice(12, 14);
                        }

                        valor = mascarado;
                    }

                    $(this).val(valor);

                });

                // ============================================
                // MÁSCARA TELEFONE
                // ============================================
                $('#userTelefone, #editTelefone').on('input', function() {
                    let valor = $(this).val().replace(/\D/g, '');
                    
                    if (valor.length > 11) {
                        valor = valor.slice(0, 11);
                    }
                    
                    if (valor.length > 0) {
                        if (valor.length <= 2) {
                            valor = '(' + valor;
                        } else if (valor.length <= 6) {
                            valor = '(' + valor.slice(0, 2) + ') ' + valor.slice(2);
                        } else if (valor.length <= 10) {
                            valor = '(' + valor.slice(0, 2) + ') ' + valor.slice(2, 6) + '-' + valor.slice(6);
                        } else {
                            valor = '(' + valor.slice(0, 2) + ') ' + valor.slice(2, 7) + '-' + valor.slice(7);
                        }
                    }
                    
                    $(this).val(valor);
                });

                // ============================================
                // VALIDAÇÃO DO FORMULÁRIO DE CADASTRO
                // ============================================
                $('#userForm').on('submit', function(e) {
                    let isValid = true;
                    let firstError = null;
                    let errorMessages = [];
                    
                    // Limpa erros anteriores
                    $(this).find('.is-invalid').removeClass('is-invalid');
                    $(this).find('.alert-validation').remove();
                    
                    // Nome de Usuário
                    const nomeUsuario = $('#userName').val().trim();
                    if (nomeUsuario === '') {
                        isValid = false;
                        $('#userName').addClass('is-invalid');
                        errorMessages.push('Nome de usuário é obrigatório.');
                        if (!firstError) firstError = $('#userName');
                    }
                    
                    // Nome Completo
                    const nome = $('#namerUser').val().trim();
                    if (nome === '') {
                        isValid = false;
                        $('#namerUser').addClass('is-invalid');
                        errorMessages.push('Nome completo é obrigatório.');
                        if (!firstError) firstError = $('#namerUser');
                    }
                    
                    // Email
                    const email = $('#userEmail').val().trim();
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (email === '') {
                        isValid = false;
                        $('#userEmail').addClass('is-invalid');
                        errorMessages.push('E-mail é obrigatório.');
                        if (!firstError) firstError = $('#userEmail');
                    } else if (!emailRegex.test(email)) {
                        isValid = false;
                        $('#userEmail').addClass('is-invalid');
                        errorMessages.push('E-mail inválido.');
                        if (!firstError) firstError = $('#userEmail');
                    }
                    
                    // CPF/CNPJ
                    const cpfCnpj = $('#cpf_cnpj').val().replace(/[^\p{L}\p{N}]/gu, '');
                    if (cpfCnpj === '') {
                        isValid = false;
                        $('#cpf_cnpj').addClass('is-invalid');
                        errorMessages.push('CPF/CNPJ é obrigatório.');
                        if (!firstError) firstError = $('#cpf_cnpj');
                    } else if (cpfCnpj.length !== 11 && cpfCnpj.length !== 14) {
                        isValid = false;
                        $('#cpf_cnpj').addClass('is-invalid');
                        errorMessages.push('CPF deve ter 11 dígitos ou CNPJ 14 dígitos.');
                        if (!firstError) firstError = $('#cpf_cnpj');
                    }
                    
                    // Telefone
                    const telefone = $('#userTelefone').val().replace(/\D/g, '');
                    if (telefone === '') {
                        isValid = false;
                        $('#userTelefone').addClass('is-invalid');
                        errorMessages.push('Telefone é obrigatório.');
                        if (!firstError) firstError = $('#userTelefone');
                    } else if (telefone.length < 10) {
                        isValid = false;
                        $('#userTelefone').addClass('is-invalid');
                        errorMessages.push('Telefone inválido.');
                        if (!firstError) firstError = $('#userTelefone');
                    }
                    
                    // Senha
                    const password = $('#userPassword').val();
                    if (password === '') {
                        isValid = false;
                        $('#userPassword').addClass('is-invalid');
                        errorMessages.push('Senha é obrigatória.');
                        if (!firstError) firstError = $('#userPassword');
                    } else if (password.length < 6) {
                        isValid = false;
                        $('#userPassword').addClass('is-invalid');
                        errorMessages.push('Senha deve ter no mínimo 6 caracteres.');
                        if (!firstError) firstError = $('#userPassword');
                    }                        
                    
                    // Nível de Acesso
                    const nivelAcesso = $('#userLevel').val();
                    if (nivelAcesso === '') {
                        isValid = false;
                        $('#userLevel').addClass('is-invalid');
                        errorMessages.push('Nível de acesso é obrigatório.');
                        if (!firstError) firstError = $('#userLevel');
                    }
                    
                    // Status
                    const status = $('#userStatus').val();
                    if (status === '') {
                        isValid = false;
                        $('#userStatus').addClass('is-invalid');
                        errorMessages.push('Status é obrigatório.');
                        if (!firstError) firstError = $('#userStatus');
                    }
                    
                    // Se houver erros, exibe alerta no modal
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
                });

                // ============================================
                // PREENCHER MODAL DE EDIÇÃO
                // ============================================
                $(document).on('click', '.edit-user', function() {
                    const id = $(this).data('id');
                    const nomeUsuario = $(this).data('nome_usuario') || '';
                    const nome = $(this).data('nome') || '';
                    const email = $(this).data('email') || '';
                    
                    // ✅ Converte para string e garante que não seja null/undefined
                    const cpfCnpj = String($(this).data('cpf_cnpj') || '');
                    const telefone = String($(this).data('telefone') || '');
                    
                    const tipoUsuario = $(this).data('tipo_usuario') || '';
                    const situacaoCadastral = $(this).data('situacao_cadastral') || 1;

                    console.log('📝 Editando usuário:', { id, nomeUsuario, nome, email, cpfCnpj, telefone });
                    
                    // Define a action do formulário
                    $('#editForm').attr('action', '/cartoes/update-action/' + id);
                    
                    // Preenche os campos básicos
                    $('#editUserId').val(id);
                    $('#editUserName').val(nomeUsuario);
                    $('#editNamerUser').val(nome);
                    $('#editUserEmail').val(email);
                    
                    // Formata CPF/CNPJ (agora com segurança)
                    let cpfFormatado = cpfCnpj.replace(/\D/g, '');
                    if (cpfFormatado.length > 0) {
                        if (cpfFormatado.length <= 11) {
                            cpfFormatado = cpfFormatado.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
                        } else {
                            cpfFormatado = cpfFormatado.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, '$1.$2.$3/$4-$5');
                        }
                    }
                    $('#editCpfCnpj').val(cpfFormatado);
                    
                    // Formata telefone (agora com segurança)
                    let telFormatado = telefone.replace(/\D/g, '');
                    if (telFormatado.length > 0) {
                        if (telFormatado.length <= 10) {
                            telFormatado = telFormatado.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
                        } else {
                            telFormatado = telFormatado.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
                        }
                    }
                    $('#editTelefone').val(telFormatado);
                    
                    // Preenche selects
                    $('#editUserLevel').val(tipoUsuario);
                    $('#editUserStatus').val(situacaoCadastral);
                    
                    // Limpa campos de senha
                    $('#editPassword').val('');
                    $('#editPasswordConfirmation').val('');
                    
                    // Remove validações anteriores
                    $('#editForm .is-invalid').removeClass('is-invalid');
                    $('#editForm .alert-validation').remove();
                });

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

                // ============================================
                // TOGGLE SENHA
                // ============================================
                $('#togglePasswordModal').on('click', function() {
                    const passwordInput = $('#userPassword');
                    const icon = $(this).find('i');
                    
                    if (passwordInput.attr('type') === 'password') {
                        passwordInput.attr('type', 'text');
                        icon.removeClass('bi-eye-fill').addClass('bi-eye-slash-fill');
                    } else {
                        passwordInput.attr('type', 'password');
                        icon.removeClass('bi-eye-slash-fill').addClass('bi-eye-fill');
                    }
                });

                $('#toggleEditPassword').on('click', function() {
                    const passwordInput = $('#editPassword');
                    const icon = $(this).find('i');
                    
                    if (passwordInput.attr('type') === 'password') {
                        passwordInput.attr('type', 'text');
                        icon.removeClass('bi-eye-fill').addClass('bi-eye-slash-fill');
                    } else {
                        passwordInput.attr('type', 'password');
                        icon.removeClass('bi-eye-slash-fill').addClass('bi-eye-fill');
                    }
                });

                // ============================================
                // RESET FORMULÁRIO AO FECHAR MODAL
                // ============================================
                $('#userModal').on('hidden.bs.modal', function() {
                    $('#userForm')[0].reset();
                    $('#userForm .is-invalid').removeClass('is-invalid');
                    $('#userForm .alert-validation').remove();
                    $('#userId').val('');
                    $('#formMethod').val('POST');
                    $('#modalTitle').html('<i class="bi bi-person-plus-fill me-2"></i> Novo Usuário');
                    $('#saveUserBtn').html('<i class="bi bi-save me-2"></i> Salvar');
                });

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
                // BUSCAR USUÁRIOS
                // ============================================
                $('#searchUser').on('keyup', function() {
                    const value = $(this).val().toLowerCase();
                    $('#usersTableBody tr').filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                    });
                });

                // ============================================
                // FECHAR SIDEBAR NO MOBILE
                // ============================================
                $('#toggleSidebar')?.on('click', function() {
                    $('#sidebar').toggleClass('show');
                });

                $(document).on('click', function(event) {
                    const sidebar = $('#sidebar');
                    const toggleBtn = $('#toggleSidebar');
                    
                    if (window.innerWidth < 992 && 
                        sidebar.hasClass('show') &&
                        !sidebar.is(event.target) &&
                        sidebar.has(event.target).length === 0 &&
                        !toggleBtn.is(event.target) &&
                        toggleBtn.has(event.target).length === 0) {
                        sidebar.removeClass('show');
                    }
                });
            });

            // ============================================
            // ERROS DO LARAVEL - ALERT EM PORTUGUÊS
            // ============================================
            @if ($errors->any())
                @php
                    $errorMessages = $errors->all();
                    $errorCount = count($errorMessages);
                    
                    $friendlyMessages = [];
                    
                    foreach ($errorMessages as $error) {
                        // =============================================
                        // MAPEAMENTO CORRIGIDO
                        // =============================================
                        
                        // 1. Nome de Usuário
                        // Verifica "nome usuario" (com espaço) OU "nome_usuario" (com underline)
                        if (str_contains($error, 'nome usuario') || str_contains($error, 'nome_usuario') || str_contains($error, 'Nome de Usuário')) {
                            if (str_contains($error, 'already been taken') || str_contains($error, 'já está em uso')) {
                                $friendlyMessages[] = '👤 Este Nome de Usuário já está em uso.';
                            } elseif (str_contains($error, 'required') || str_contains($error, 'obrigatório')) {
                                $friendlyMessages[] = '👤 O campo Nome de Usuário é obrigatório.';
                            } elseif (str_contains($error, 'max') || str_contains($error, 'máximo')) {
                                $friendlyMessages[] = '👤 O Nome de Usuário excedeu o limite de 100 caracteres.';
                            } else {
                                $friendlyMessages[] = '👤 O campo Nome de Usuário é obrigatório ou já está em uso.';
                            }
                            continue;
                        }
                        
                        // 2. Nome Completo (apenas "nome" SEM "usuario")
                        if ((str_contains($error, 'nome') || str_contains($error, 'Nome')) && 
                            !str_contains($error, 'nome usuario') && 
                            !str_contains($error, 'nome_usuario') && 
                            !str_contains($error, 'Nome de Usuário')) {
                            
                            if (str_contains($error, 'required') || str_contains($error, 'obrigatório')) {
                                $friendlyMessages[] = '📝 O campo Nome Completo é obrigatório.';
                            } elseif (str_contains($error, 'max') || str_contains($error, 'máximo')) {
                                $friendlyMessages[] = '📝 O Nome Completo excedeu o limite de 100 caracteres.';
                            } else {
                                $friendlyMessages[] = '📝 O campo Nome Completo é obrigatório.';
                            }
                            continue;
                        }
                        
                        // 3. Email
                        if (str_contains($error, 'email') || str_contains($error, 'E-mail')) {
                            if (str_contains($error, 'already been taken') || str_contains($error, 'já está em uso')) {
                                $friendlyMessages[] = '📧 Este E-mail já está cadastrado.';
                            } elseif (str_contains($error, 'required') || str_contains($error, 'obrigatório')) {
                                $friendlyMessages[] = '📧 O campo E-mail é obrigatório.';
                            } elseif (str_contains($error, 'valid')) {
                                $friendlyMessages[] = '📧 Digite um endereço de e-mail válido.';
                            } else {
                                $friendlyMessages[] = '📧 O campo E-mail é obrigatório ou já está cadastrado.';
                            }
                            continue;
                        }
                        
                        // 4. CPF/CNPJ
                        if (str_contains($error, 'cpf_cnpj') || str_contains($error, 'CPF/CNPJ')) {
                            if (str_contains($error, 'already been taken') || str_contains($error, 'já está em uso')) {
                                $friendlyMessages[] = '🆔 Este CPF/CNPJ já está cadastrado.';
                            } else {
                                $friendlyMessages[] = '🆔 O campo CPF/CNPJ invalido.';
                            }
                            continue;                            
                        }
                        
                        // 5. Telefone
                        if (str_contains($error, 'telefone') || str_contains($error, 'Telefone')) {
                            if (str_contains($error, 'required') || str_contains($error, 'obrigatório')) {
                                $friendlyMessages[] = '📱 O campo Telefone é obrigatório.';
                            } else {
                                $friendlyMessages[] = '📱 O campo Telefone é obrigatório.';
                            }
                            continue;
                        }
                        
                        // 6. Senha
                        if (str_contains($error, 'password') || str_contains($error, 'senha') || str_contains($error, 'Senha')) {
                            if (str_contains($error, 'required') || str_contains($error, 'obrigatório')) {
                                $friendlyMessages[] = '🔒 A Senha é obrigatória.';
                            } elseif (str_contains($error, 'min') || str_contains($error, 'caracteres')) {
                                $friendlyMessages[] = '🔒 A Senha deve ter no mínimo 6 caracteres.';
                            } elseif (str_contains($error, 'confirmed') || str_contains($error, 'coincidem')) {
                                $friendlyMessages[] = '🔒 As senhas não coincidem.';
                            } else {
                                $friendlyMessages[] = '🔒 A Senha deve ter no mínimo 6 caracteres.';
                            }
                            continue;
                        }
                        
                        // 7. Tipo Usuário / Nível de Acesso
                        if (str_contains($error, 'tipo_usuario') || 
                            str_contains($error, 'tipo usuario') || 
                            str_contains($error, 'Nível de acesso')) {
                            if (str_contains($error, 'required') || str_contains($error, 'obrigatório')) {
                                $friendlyMessages[] = '🎯 O campo Nível de Acesso é obrigatório.';
                            } else {
                                $friendlyMessages[] = '🎯 O campo Nível de Acesso é obrigatório.';
                            }
                            continue;
                        }
                        
                        // 8. Situação Cadastral / Status
                        if (str_contains($error, 'situacao_cadastral') || 
                            str_contains($error, 'Status')) {
                            if (str_contains($error, 'required') || str_contains($error, 'obrigatório')) {
                                $friendlyMessages[] = '📊 O campo Status é obrigatório.';
                            } else {
                                $friendlyMessages[] = '📊 O campo Status é obrigatório.';
                            }
                            continue;
                        }
                        
                        // 9. Erros genéricos (fallback)
                        if (str_contains($error, 'already been taken') || 
                            str_contains($error, 'já está em uso') || 
                            str_contains($error, 'unique')) {
                            $friendlyMessages[] = '⚠️ Este valor já está sendo usado por outro usuário.';
                            continue;
                        }
                        
                        if (str_contains($error, 'required') || 
                            str_contains($error, 'obrigatório')) {
                            $friendlyMessages[] = '⚠️ Este campo é obrigatório.';
                            continue;
                        }
                        
                        // Se nada funcionar, mantém o erro original
                        $friendlyMessages[] = $error;
                    }
                    
                    // Monta o texto do alerta
                    $errorText = "⚠️ VALIDAÇÃO DE DADOS\n\n";
                    $errorText .= "📋 Total: {$errorCount} erro(s)\n\n";
                    
                    foreach ($friendlyMessages as $index => $msg) {
                        $errorText .= ($index + 1) . "️⃣ " . $msg . "\n";
                    }
                @endphp
                
                
                // Mostra os erros originais no console para debug
                console.group('🔴 ERROS ORIGINAIS DO LARAVEL');
                console.log('Total: {{ $errorCount }} erro(s)');
                @foreach ($errorMessages as $error)
                    console.log('  ❌ "{{ addslashes($error) }}"');
                @endforeach
                console.groupEnd();
                
                // Mostra as mensagens amigáveis
                console.group('✅ MENSAGENS AMIGÁVEIS');
                @foreach ($friendlyMessages as $msg)
                    console.log('  ✅ {{ $msg }}');
                @endforeach
                console.groupEnd();
                
                // Exibe alerta com mensagens amigáveis
                alert(`{{ addslashes($errorText) }}`);
                
            @endif
        </script>
    </body>
</html>