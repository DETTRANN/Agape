<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Transferência - Agape</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{url('frontend/css/inventory.css')}}" />
    <script src="{{url('frontend/js/script.js')}}" defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <!-- Alert Messages -->
    @if($errors->any())
    <div class="alert alert-danger">
        <strong>Erro nos dados:</strong>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if(session('success'))
    <div class="alert alert-success">
        <strong>Sucesso!</strong> {{ session('success') }}
    </div>
    @endif

    <!-- Mobile Header -->
    <div class="top-header">
        <img class="mobile-logo" src="{{url('frontend/img/logo-agape.png')}}" alt="Agape" onclick="window.location.href='{{url('/')}}'" />
        <button class="mobile-toggle" id="mobile-toggle">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>

    <!-- Desktop Header -->
    <header>
        <section class="header-left">
            <img class="img-logo" src="{{url('frontend/img/logo-agape.png')}}" alt="Agape Logo" onclick="window.location.href='{{url('/')}}'" />
            <div class="logo-separator"></div>
            
            <!-- Menu Principal -->
            <div class="main-menu">
                <div class="header-sections" data-section="inicio" onclick="goToSystem()">
                    <img src="{{url('frontend/img/casa-simples-fina.png')}}" alt="Início" />
                    <div>Início</div>
                </div>
                <div class="header-sections" data-section="relatorios" onclick="goToRelatorios()">
                    <img src="{{url('frontend/img/grafico-de-barras.png')}}" alt="Relatórios" />
                    <div>Relatórios</div>
                </div>
                <div class="header-sections" data-section="estoque" onclick="goToEstoque()">
                    <img src="{{url('frontend/img/estoque-pronto.png')}}" alt="Estoque" />
                    <div>Estoque</div>
                </div>
                <div class="header-sections active" data-section="transferencias" onclick="goToTransferencias()">
                    <img src="{{url('frontend/img/cargo-truck.png')}}" alt="Transferências" />
                    <div>Transferências</div>
                </div>
                <div class="header-sections" data-section="auditoria" onclick="goToAuditoria()">
                    <img src="{{url('frontend/img/icons8-robot-50.png')}}" alt="Auditoria" />
                    <div>Auditoria</div>
                </div>
            </div>

            <!-- Menu do Perfil (inicialmente oculto) -->
            <div class="profile-menu" style="display: none;">
                <div class="header-sections back-button" onclick="showMainMenu()">
                    <span style="font-size: 20px;">←</span>
                    <div>Voltar</div>
                </div>
                
                <!-- Perfil do Usuário Desktop com Foto -->
                <div class="profile-user-section">
                    <div class="profile-avatar-container">
                        <img src="@auth{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : url('frontend/img/user-alien.png') }}@else{{url('frontend/img/user-alien.png')}}@endauth" alt="Avatar" class="profile-user-avatar" id="desktopAvatar" onclick="openAvatarModal(this.src, '@auth{{ Auth::user()->nome }} {{ Auth::user()->sobrenome }}@else Usuário @endauth', '@auth{{ Auth::user()->email }}@else usuario@exemplo.com @endauth')" style="cursor: pointer;" />
                        <label for="desktopAvatarInput" class="avatar-edit-btn" title="Editar foto">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>
                            </svg>
                        </label>
                        <input type="file" id="desktopAvatarInput" accept="image/*" style="display: none;" onchange="handleAvatarChange(event, 'desktop')" />
                    </div>
                    <div class="profile-user-info">
                        <h3 class="profile-user-name">
                            @auth
                                {{ Auth::user()->nome }} {{ Auth::user()->sobrenome }}
                            @else
                                Usuário
                            @endauth
                        </h3>
                        <p class="profile-user-email">
                            @auth
                                {{ Auth::user()->email }}
                            @else
                                usuario@exemplo.com
                            @endauth
                        </p>
                    </div>
                </div>
                
                <div class="header-sections">
                    <img src="{{url('frontend/img/configuracoes.png')}}" alt="Configurações" />
                    <div>Configurações</div>
                </div>
                <div class="header-sections">
                    <img src="{{url('frontend/img/contato.png')}}" alt="Contato" />
                    <div>Contato</div>
                </div>
                <div class="header-sections">
                    <img src="{{url('frontend/img/termos-e-condicoes.png')}}" alt="Termos" />
                    <div>Termos de Uso</div>
                </div>
                <div class="header-sections logout" onclick="document.getElementById('logout-form').submit();">
                    <div>Sair</div>
                </div>
            </div>

            <!-- Notificações e Perfil -->
            <div class="bottom-section">
                <div class="header-sections header-sections-notification" onclick="toggleNotifications()">
                    <img src="{{url('frontend/img/notificacao.png')}}" alt="Notificações" />
                    <div>Notificações</div>
                </div>
                <div class="header-sections header-sections-person" onclick="showProfileMenu()">
                    <img src="{{url('frontend/img/user-alien.png')}}" alt="Perfil" />
                    <div>Perfil</div>
                </div>
            </div>
        </section>
    </header>

    <!-- Mobile Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-content">
            <!-- Menu Principal Mobile -->
            <div class="sidebar-main-menu">
                <div class="sidebar-item" onclick="goToSystem()">
                    <img src="{{url('frontend/img/casa-simples-fina.png')}}" alt="Início" />
                    <span>Início</span>
                </div>
                <div class="sidebar-item" onclick="goToRelatorios()">
                    <img src="{{url('frontend/img/grafico-de-barras.png')}}" alt="Relatórios" />
                    <span>Relatórios</span>
                </div>
                <div class="sidebar-item" onclick="goToEstoque()">
                    <img src="{{url('frontend/img/estoque-pronto.png')}}" alt="Estoque" />
                    <span>Estoque</span>
                </div>
                <div class="sidebar-item active" onclick="goToTransferencias()">
                    <img src="{{url('frontend/img/cargo-truck.png')}}" alt="Transferências" />
                    <span>Transferências</span>
                </div>
                <div class="sidebar-item" onclick="goToAuditoria()">
                    <img src="{{url('frontend/img/icons8-robot-50.png')}}" alt="Auditoria" />
                    <span>Auditoria</span>
                </div>
                
                <!-- Bottom section mobile -->
                <div class="sidebar-bottom">
                    <div class="sidebar-item" onclick="toggleNotifications()">
                        <img src="{{url('frontend/img/notificacao.png')}}" alt="Notificações" />
                        <span>Notificações</span>
                    </div>
                    <div class="sidebar-item" onclick="showMobileProfileMenu()">
                        <img src="{{url('frontend/img/user-alien.png')}}" alt="Perfil" />
                        <span>Perfil</span>
                    </div>
                </div>
            </div>

            <!-- Perfil do Usuário Mobile com Foto -->
            <div class="mobile-profile-user-section">
                <div class="mobile-profile-avatar-container">
                    <img src="@auth{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : url('frontend/img/user-alien.png') }}@else{{url('frontend/img/user-alien.png')}}@endauth" alt="Avatar" class="mobile-profile-user-avatar" id="mobileAvatar" onclick="openAvatarModal(this.src, '@auth{{ Auth::user()->nome }} {{ Auth::user()->sobrenome }}@else Usuário @endauth', '@auth{{ Auth::user()->email }}@else usuario@exemplo.com @endauth')" style="cursor: pointer;" />
                    <label for="mobileAvatarInput" class="mobile-avatar-edit-btn" title="Editar foto">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>
                        </svg>
                    </label>
                    <input type="file" id="mobileAvatarInput" accept="image/*" style="display: none;" onchange="handleAvatarChange(event, 'mobile')" />
                </div>
                <div class="mobile-profile-user-info">
                    <h3 class="mobile-profile-user-name">
                        @auth
                            {{ Auth::user()->nome }} {{ Auth::user()->sobrenome }}
                        @else
                            Usuário
                        @endauth
                    </h3>
                    <p class="mobile-profile-user-email">
                        @auth
                            {{ Auth::user()->email }}
                        @else
                            usuario@exemplo.com
                        @endauth
                    </p>
                </div>
            </div>

            <!-- Menu do Perfil Mobile (inicialmente oculto) -->
            <div class="sidebar-profile-menu" style="display: none;">
                <div class="sidebar-item sidebar-back-button" onclick="showMobileMainMenu()">
                    <span style="font-size: 20px;">←</span>
                    <span>Voltar</span>
                </div>
                <div class="sidebar-item">
                    <img src="{{url('frontend/img/icons8-robot-50.png')}}" alt="Perfil" />
                    <span>Perfil</span>
                </div>
                <div class="sidebar-item">
                    <img src="{{url('frontend/img/configuracoes.png')}}" alt="Configurações" />
                    <span>Configurações</span>
                </div>
                <div class="sidebar-item">
                    <img src="{{url('frontend/img/contato.png')}}" alt="Contato" />
                    <span>Contato</span>
                </div>
                <div class="sidebar-item">
                    <img src="{{url('frontend/img/termos-e-condicoes.png')}}" alt="Termos" />
                    <span>Termos</span>
                </div>
                <div class="sidebar-item" onclick="document.getElementById('logout-form').submit();">
                    <img src="{{url('frontend/img/user-alien.png')}}" alt="Sair" />
                    <span>Sair</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Overlay -->
    <div class="overlay" id="overlay"></div>

    <!-- Modal do Avatar -->
    <div class="avatar-modal" id="avatarModal" onclick="closeAvatarModal()">
        <div class="avatar-modal-content">
            <span class="avatar-modal-close" onclick="closeAvatarModal()">×</span>
            <img src="" alt="Avatar" class="modal-image" id="avatarModalImage" />
            <div class="modal-info">
                <h3 class="modal-name" id="avatarModalName">Nome do Usuário</h3>
                <p class="modal-email" id="avatarModalEmail">email@exemplo.com</p>
            </div>
        </div>
    </div>

    <!-- Formulário de Logout (Hidden) -->
    <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- Main Content -->
    <main class="transfer-page transfer-create">
        <!-- Header -->
        <section class="transfer-header">
            <div class="transfer-header-content">
                <div class="transfer-title">
                    <h1>Nova Transferência</h1>
                    <p>Solicitar transferência de produto entre localidades</p>
                </div>
                <div class="transfer-actions">
                    <a href="{{ route('transferencias.index') }}" class="btn-atualizar">Voltar</a>
                </div>
            </div>
        </section>

        <!-- Formulário de Transferência -->
        <section class="transfer-form-section">
            <div class="transfer-form-container">
                <form action="{{ route('transferencias.store') }}" method="POST" class="transfer-form">
                    @csrf

                    <div class="transfer-form-grid">
                        <!-- Coluna Esquerda -->
                        <div>
                            <div class="form-group">
                                <label for="produto_id">Produto *</label>
                                <select id="produto_id" name="produto_id" required>
                                    <option value="">Selecione o produto</option>
                                    @foreach($produtos as $produto)
                                    <option value="{{ $produto->id }}" data-localidade="{{ $produto->localidade }}" data-responsavel="{{ $produto->responsavel }}">
                                        {{ $produto->nome_item }} ({{ $produto->categoria }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="localidade_origem">Localidade Atual</label>
                                <input type="text" id="localidade_origem" readonly placeholder="Selecione um produto primeiro">
                            </div>

                            <div class="form-group">
                                <label for="responsavel_origem">Responsável Atual</label>
                                <input type="email" id="responsavel_origem" readonly placeholder="Selecione um produto primeiro">
                            </div>
                        </div>

                        <!-- Coluna Direita -->
                        <div>
                            <div class="form-group">
                                <label for="localidade_destino">Nova Localidade *</label>
                                <input type="text" id="localidade_destino" name="localidade_destino" required placeholder="Ex: Sala 201, Depósito B">
                            </div>

                            <div class="form-group">
                                <label for="responsavel_destino">Novo Responsável *</label>
                                <input type="email" id="responsavel_destino" name="responsavel_destino" required placeholder="email@exemplo.com">
                            </div>

                            <div class="form-group">
                                <label for="motivo">Motivo da Transferência</label>
                                <select id="motivo" name="motivo">
                                    <option value="">Selecione o motivo</option>
                                    <option value="Venda">Venda</option>
                                    <option value="Reorganização do estoque">Reorganização do estoque</option>
                                    <option value="Mudança de setor">Mudança de setor</option>
                                    <option value="Manutenção preventiva">Manutenção preventiva</option>
                                    <option value="Solicitação de usuário">Solicitação de usuário</option>
                                    <option value="Otimização de espaço">Otimização de espaço</option>
                                    <option value="Outro">Outro</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Observações (Full Width) -->
                    <div class="form-group">
                        <label for="observacoes">Observações</label>
                        <textarea id="observacoes" name="observacoes" rows="4" placeholder="Informações adicionais sobre a transferência..."></textarea>
                    </div>

                    <!-- Botões -->
                    <div class="transfer-actions">
                        <button type="submit" class="btn-novo">Solicitar Transferência</button>
                        <a href="{{ route('transferencias.index') }}" class="btn-atualizar">Cancelar</a>
                    </div>
                </form>
            </div>
        </section>
    </main>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const produtoSelect = document.getElementById('produto_id');
        const localidadeOrigemInput = document.getElementById('localidade_origem');
        const responsavelOrigemInput = document.getElementById('responsavel_origem');

        produtoSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            
            if (selectedOption.value) {
                const localidade = selectedOption.getAttribute('data-localidade') || 'Não informado';
                const responsavel = selectedOption.getAttribute('data-responsavel') || 'Não informado';
                
                localidadeOrigemInput.value = localidade;
                responsavelOrigemInput.value = responsavel;
            } else {
                localidadeOrigemInput.value = '';
                responsavelOrigemInput.value = '';
            }
        });
    });
    </script>

    
</body>
</html>
