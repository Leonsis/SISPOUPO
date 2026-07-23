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
                                        @foreach ($usuarios as $usuario)
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
                                                    <span class="badge {{ $usuario->level === 'Admin' ? 'bg-danger' : $usuario->level === 'Editor' ? 'bg-info' : 'bg-secondary' }}">
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
                                                        <button class="btn btn-sm edit-user" data-id="{{ $usuario->id }}" title="Editar">
                                                            <i class="bi bi-pencil-fill"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-danger delete-user" data-id="{{ $usuario->id }}" data-name="{{ $usuario->nome }}" title="Excluir">
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
                                <span class="text-light" id="totalUsers">Total: 0 usuários</span>
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

        <!-- Modal de Cadastro/Edição -->
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
                    <form id="userForm" novalidate>
                        <div class="modal-body">
                            <input type="hidden" id="userId">
                            
                            <div class="mb-3">
                                <label for="userName" class="form-label fw-semibold">Nome completo</label>
                                <input type="text" class="form-control bg-dark text-light border-warning" 
                                       id="userName" placeholder="Digite o nome completo" required>
                                <div class="invalid-feedback">Por favor, informe o nome do usuário.</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="userEmail" class="form-label fw-semibold">Email</label>
                                <input type="email" class="form-control bg-dark text-light border-warning" 
                                       id="userEmail" placeholder="Digite o email" required>
                                <div class="invalid-feedback">Por favor, informe um email válido.</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="userPassword" class="form-label fw-semibold">Senha</label>
                                <div class="input-group">
                                    <input type="password" class="form-control bg-dark text-light border-warning" 
                                           id="userPassword" placeholder="Digite a senha" minlength="6">
                                    <button class="btn btn-outline-warning border-warning" type="button" id="togglePasswordModal">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback">A senha deve ter no mínimo 6 caracteres.</div>
                                <div class="form-text text-secondary" id="passwordHelp">Mínimo 6 caracteres (opcional para edição)</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="userLevel" class="form-label fw-semibold">Nível de acesso</label>
                                <select class="form-select bg-dark text-light border-warning" id="userLevel" required>
                                    <option value="">Selecione...</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Editor">Editor</option>
                                    <option value="User">Usuário</option>
                                    <option value="Viewer">Visualizador</option>
                                </select>
                                <div class="invalid-feedback">Por favor, selecione um nível de acesso.</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="userStatus" class="form-label fw-semibold">Status</label>
                                <select class="form-select bg-dark text-light border-warning" id="userStatus" required>
                                    <option value="">Selecione...</option>
                                    <option value="Ativo">Ativo</option>
                                    <option value="Inativo">Inativo</option>
                                    <option value="Pendente">Pendente</option>
                                    <option value="Bloqueado">Bloqueado</option>
                                </select>
                                <div class="invalid-feedback">Por favor, selecione um status.</div>
                            </div>
                        </div>
                        <div class="modal-footer border-warning">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-warning" id="saveUserBtn">
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
            // Dados iniciais dos usuários
            let nextId = 6;
            let editingId = null;                        

            // Salvar usuário (criar/editar)
            document.getElementById('userForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const form = this;
                if (!form.checkValidity()) {
                    form.classList.add('was-validated');
                    return;
                }

                const id = document.getElementById('userId').value;
                const name = document.getElementById('userName').value.trim();
                const email = document.getElementById('userEmail').value.trim();
                const password = document.getElementById('userPassword').value;
                const level = document.getElementById('userLevel').value;
                const status = document.getElementById('userStatus').value;

                if (id) {
                    // Editar usuário existente
                    const index = users.findIndex(u => u.id === parseInt(id));
                    if (index !== -1) {
                        users[index] = {
                            ...users[index],
                            name,
                            email,
                            level,
                            status,
                            ...(password ? { password } : {})
                        };
                        showToast('Usuário atualizado com sucesso!', 'success');
                    }
                } else {
                    // Criar novo usuário
                    const newUser = {
                        id: nextId++,
                        name,
                        email,
                        password: password || '123456',
                        level,
                        status,
                        date: new Date().toISOString().split('T')[0]
                    };
                    users.push(newUser);
                    showToast('Usuário cadastrado com sucesso!', 'success');
                }

                renderTable();
                resetForm();
                bootstrap.Modal.getInstance(document.getElementById('userModal')).hide();
            });

            // Editar usuário
            document.addEventListener('click', function(e) {
                if (e.target.closest('.edit-user')) {
                    const btn = e.target.closest('.edit-user');
                    const id = parseInt(btn.dataset.id);
                    const user = users.find(u => u.id === id);
                    
                    if (user) {
                        editingId = id;
                        document.getElementById('userId').value = id;
                        document.getElementById('userName').value = user.name;
                        document.getElementById('userEmail').value = user.email;
                        document.getElementById('userPassword').value = '';
                        document.getElementById('userPassword').placeholder = 'Nova senha (opcional)';
                        document.getElementById('userLevel').value = user.level;
                        document.getElementById('userStatus').value = user.status;
                        document.getElementById('modalTitle').innerHTML = '<i class="bi bi-pencil-fill me-2"></i>Editar Usuário';
                        document.getElementById('saveUserBtn').innerHTML = '<i class="bi bi-pencil-fill me-2"></i>Atualizar';
                        document.getElementById('passwordHelp').textContent = 'Deixe em branco para manter a senha atual';
                        
                        const modal = new bootstrap.Modal(document.getElementById('userModal'));
                        modal.show();
                    }
                }
            });

            // Excluir usuário
            document.addEventListener('click', function(e) {
                if (e.target.closest('.delete-user')) {
                    const btn = e.target.closest('.delete-user');
                    const id = parseInt(btn.dataset.id);
                    const name = btn.dataset.name;
                    
                    document.getElementById('deleteUserId').value = id;
                    document.getElementById('deleteUserName').textContent = name;
                    
                    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
                    modal.show();
                }
            });

            // Confirmar exclusão
            document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
                const id = parseInt(document.getElementById('deleteUserId').value);
                users = users.filter(u => u.id !== id);
                renderTable();
                showToast('Usuário excluído com sucesso!', 'danger');
                bootstrap.Modal.getInstance(document.getElementById('deleteModal')).hide();
            });

            // Resetar formulário
            function resetForm() {
                document.getElementById('userForm').reset();
                document.getElementById('userId').value = '';
                document.getElementById('userPassword').placeholder = 'Digite a senha';
                document.getElementById('modalTitle').innerHTML = '<i class="bi bi-person-plus-fill me-2"></i>Novo Usuário';
                document.getElementById('saveUserBtn').innerHTML = '<i class="bi bi-save me-2"></i>Salvar';
                document.getElementById('passwordHelp').textContent = 'Mínimo 6 caracteres (opcional para edição)';
                document.getElementById('userForm').classList.remove('was-validated');
            }

            // Reset ao fechar modal
            document.getElementById('userModal').addEventListener('hidden.bs.modal', function() {
                resetForm();
            });

            // Toggle senha no modal
            document.getElementById('togglePasswordModal').addEventListener('click', function() {
                const passwordInput = document.getElementById('userPassword');
                const icon = this.querySelector('i');
                
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.classList.remove('bi-eye-fill');
                    icon.classList.add('bi-eye-slash-fill');
                } else {
                    passwordInput.type = 'password';
                    icon.classList.remove('bi-eye-slash-fill');
                    icon.classList.add('bi-eye-fill');
                }
            });

            // Buscar usuários
            document.getElementById('searchUser').addEventListener('input', function() {
                const search = this.value.toLowerCase().trim();
                if (search === '') {
                    renderTable(users);
                } else {
                    const filtered = users.filter(user => 
                        user.name.toLowerCase().includes(search) ||
                        user.email.toLowerCase().includes(search) ||
                        user.level.toLowerCase().includes(search) ||
                        user.status.toLowerCase().includes(search)
                    );
                    renderTable(filtered);
                }
            });

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

            // Renderizar tabela inicial
            renderTable();
        </script>
    </body>
</html>