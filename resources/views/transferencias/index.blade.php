<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transferências - Agape</title>
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

    @if(session('error'))
    <div class="alert alert-error">
        <strong>Erro!</strong> {{ session('error') }}
    </div>
    @endif

    <!-- Mobile Header -->
    <div class="top-header">
        <img class="mobile-logo" src="{{url('frontend/img/logo-agape.png')}}" alt="Agape"
            onclick="window.location.href='{{url('/')}}'" />
        <button class="mobile-toggle" id="mobile-toggle">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>

    <!-- Desktop Header -->
    <header>
        <section class="header-left">
            <img class="img-logo" src="{{url('frontend/img/logo-agape.png')}}" alt="Agape Logo"
                onclick="window.location.href='{{url('/')}}'" />
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
                        <img src="@auth{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : url('frontend/img/user-alien.png') }}@else{{url('frontend/img/user-alien.png')}}@endauth"
                            alt="Avatar" class="profile-user-avatar" id="desktopAvatar"
                            onclick="openAvatarModal(this.src, '@auth{{ Auth::user()->nome }} {{ Auth::user()->sobrenome }}@else Usuário @endauth', '@auth{{ Auth::user()->email }}@else usuario@exemplo.com @endauth')"
                            style="cursor: pointer;" />
                        <label for="desktopAvatarInput" class="avatar-edit-btn" title="Editar foto">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                            </svg>
                        </label>
                        <input type="file" id="desktopAvatarInput" accept="image/*" style="display: none;"
                            onchange="handleAvatarChange(event, 'desktop')" />
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
                    <a href="{{ url('views/termos-privacidade') }}">
                        Termos de Uso
                    </a>
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
                    <img src="@auth{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : url('frontend/img/user-alien.png') }}@else{{url('frontend/img/user-alien.png')}}@endauth"
                        alt="Avatar" class="mobile-profile-user-avatar" id="mobileAvatar"
                        onclick="openAvatarModal(this.src, '@auth{{ Auth::user()->nome }} {{ Auth::user()->sobrenome }}@else Usuário @endauth', '@auth{{ Auth::user()->email }}@else usuario@exemplo.com @endauth')"
                        style="cursor: pointer;" />
                    <label for="mobileAvatarInput" class="mobile-avatar-edit-btn" title="Editar foto">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                        </svg>
                    </label>
                    <input type="file" id="mobileAvatarInput" accept="image/*" style="display: none;"
                        onchange="handleAvatarChange(event, 'mobile')" />
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

    <!-- Painel de Notificações -->
    <div class="notifications-panel" id="notificationsPanel">
        <div class="notifications-header">
            <h3>Notificações do Sistema</h3>
            <button class="close-notifications" onclick="toggleNotifications()">&times;</button>
        </div>
        <div class="notifications-content">
            @if($produtosVencidos && $produtosVencidos->count() > 0)
            <div class="notification-item alert-warning">
                <div class="notification-icon">❌</div>
                <div class="notification-details">
                    <h4>Produtos Vencidos!</h4>
                    <p><strong>{{ $produtosVencidos->count() }}</strong> {{ $produtosVencidos->count() == 1 ? 'produto
                        está vencido' : 'produtos estão vencidos' }}:</p>
                    <ul style="margin: 8px 0; padding-left: 20px;">
                        @foreach($produtosVencidos->take(3) as $produto)
                        @php
                        $diasVencido = (int)
                        \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($produto->data_validade), false);
                        @endphp
                        <li><strong>{{ $produto->nome_item }}</strong> - Vencido há {{ abs($diasVencido) }} dias</li>
                        @endforeach
                        @if($produtosVencidos->count() > 3)
                        <li><em>E mais {{ $produtosVencidos->count() - 3 }} produto(s)...</em></li>
                        @endif
                    </ul>
                    <p>Verifique estes itens imediatamente!</p>
                    <small>{{ now()->format('d/m/Y H:i') }}</small>
                </div>
            </div>
            @endif

            @if($produtosProximosVencimento && $produtosProximosVencimento->count() > 0)
            <div class="notification-item alert-warning">
                <div class="notification-icon">⚠️</div>
                <div class="notification-details">
                    <h4>Alerta de Validade Próxima</h4>
                    <p><strong>{{ $produtosProximosVencimento->count() }}</strong> {{
                        $produtosProximosVencimento->count() == 1 ? 'produto vencerá' : 'produtos vencerão' }} em breve:
                    </p>
                    <ul style="margin: 8px 0; padding-left: 20px;">
                        @foreach($produtosProximosVencimento->take(3) as $produto)
                        @php
                        $diasRestantes = (int)
                        \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($produto->data_validade), false);
                        @endphp
                        <li><strong>{{ $produto->nome_item }}</strong> - Vence em {{ $diasRestantes }} {{ $diasRestantes
                            == 1 ? 'dia' : 'dias' }}</li>
                        @endforeach
                        @if($produtosProximosVencimento->count() > 3)
                        <li><em>E mais {{ $produtosProximosVencimento->count() - 3 }} produto(s)...</em></li>
                        @endif
                    </ul>
                    <p>Planeje o uso ou descarte destes itens com antecedência.</p>
                    <small>{{ now()->format('d/m/Y H:i') }}</small>
                </div>
            </div>
            @endif

            @if($estoqueAlerta)
            <div class="notification-item alert-warning">
                <div class="notification-icon">⚠️</div>
                <div class="notification-details">
                    <h4>Alerta de Estoque Baixo</h4>
                    <p>{{ round($porcentagemOcupados) }}% dos itens estão ocupados ({{ $itensOcupados }}/{{ $totalItens
                        }})</p>
                    <p>Considere verificar a disponibilidade dos itens ou adicionar novos produtos ao estoque.</p>
                    <small>{{ now()->format('d/m/Y H:i') }}</small>
                </div>
            </div>
            @endif

            @if(!$estoqueAlerta && $totalItens > 0)
            <div class="notification-item info">
                <div class="notification-icon">✅</div>
                <div class="notification-details">
                    <h4>Estoque em Bom Estado</h4>
                    <p>{{ round($porcentagemOcupados) }}% dos itens estão ocupados ({{ $itensOcupados }}/{{ $totalItens
                        }})</p>
                    <p>Seu estoque está bem distribuído.</p>
                    <small>{{ now()->format('d/m/Y H:i') }}</small>
                </div>
            </div>
            @endif

            @if($totalItens == 0)
            <div class="notification-item info">
                <div class="notification-icon">📦</div>
                <div class="notification-details">
                    <h4>Estoque Vazio</h4>
                    <p>Você ainda não possui itens no estoque.</p>
                    <p>Clique em "Novo" para adicionar seu primeiro item.</p>
                    <small>{{ now()->format('d/m/Y H:i') }}</small>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Main Content -->
    <main class="transfer-page">
        <!-- Header + Stats Combined -->
        <section class="transfer-top-section">
            <!-- Header -->
            <div class="transfer-header">
                <div class="transfer-header-content">
                    <div class="transfer-title">
                        <h1>Controle de Transferências</h1>
                    </div>
                    <div class="transfer-actions">
                        <a href="{{ route('transferencias.create') }}" class="btn-novo">Nova Transferência</a>
                        <a href="{{ route('auditoria.index') }}" class="btn-atualizar">Ver Auditoria</a>
                    </div>
                </div>
            </div>

            <!-- Estatísticas -->
            <div class="transfer-stats">
                <div class="transfer-stats-grid">
                    <div class="transfer-stat-card stat-pendente">
                        <div class="stat-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M12 6v6l4 2" />
                            </svg>
                        </div>
                        <div class="stat-info">
                            <span class="stat-label">Pendentes</span>
                            <span class="stat-value">{{ $estatisticas['pendentes'] }}</span>
                            <span class="stat-description">aguardando ação</span>
                        </div>
                    </div>

                    <div class="transfer-stat-card stat-transito">
                        <div class="stat-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M3 16V6a2 2 0 0 1 2-2h11l4 4v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                                <circle cx="7.5" cy="17.5" r="1.5" />
                                <circle cx="17.5" cy="17.5" r="1.5" />
                            </svg>
                        </div>
                        <div class="stat-info">
                            <span class="stat-label">Em Trânsito</span>
                            <span class="stat-value">{{ $estatisticas['em_transito'] }}</span>
                            <span class="stat-description">em movimento</span>
                        </div>
                    </div>

                    <div class="transfer-stat-card stat-concluida">
                        <div class="stat-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M20 6L9 17l-5-5" />
                            </svg>
                        </div>
                        <div class="stat-info">
                            <span class="stat-label">Concluídas</span>
                            <span class="stat-value">{{ $estatisticas['concluidas'] }}</span>
                            <span class="stat-description">finalizadas</span>
                        </div>
                    </div>
                </div>
        </section>

        <!-- Lista de Transferências -->
        <section class="estoque-table-section">
            <div class="estoque-table-container">
                <table class="estoque-table transferencias-table">
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Origem</th>
                            <th>Destino</th>
                            <th>Status</th>
                            <th>Data Solicitação</th>
                            <th>Responsável Destino</th>
                            <th>Rastreamento</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transferencias as $transferencia)
                        <tr>
                            <td>
                                <strong>{{ $transferencia->produto->nome_item ?? 'Produto removido' }}</strong>
                            </td>
                            <td>{{ $transferencia->localidade_origem }}</td>
                            <td>{{ $transferencia->localidade_destino }}</td>
                            <td>
                                <span class="status-{{ $transferencia->status }}">
                                    {{ ucfirst(str_replace('_', ' ', $transferencia->status)) }}
                                </span>
                            </td>
                            <td>{{ $transferencia->data_solicitacao->format('d/m/Y') }}</td>
                            <td>{{ $transferencia->responsavel_destino }}</td>
                            <td>{{ $transferencia->codigo_rastreamento ?? '-' }}</td>
                            <td>
                                <div class="table-actions">
                                    @if($transferencia->status === 'concluida')
                                        <span class="btn btn-sm" style="background: #4caf50; color: white; cursor: default;">Concluído</span>
                                    @else
                                        <a href="{{ route('transferencias.show', $transferencia->id) }}"
                                            class="btn btn-sm btn-primary">Ver</a>
                                    @endif

                                    @if($transferencia->status === 'pendente')
                                    <form method="POST"
                                        action="{{ route('transferencias.iniciar', $transferencia->id) }}"
                                        class="inline-form">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-success">Iniciar</button>
                                    </form>
                                    @endif

                                    @if($transferencia->status === 'em_transito')
                                    <form method="POST"
                                        action="{{ route('transferencias.concluir', $transferencia->id) }}"
                                        class="inline-form">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-warning dark-text">Concluir</button>
                                    </form>
                                    @endif

                                    @if(in_array($transferencia->status, ['pendente', 'em_transito']))
                                    <form method="POST"
                                        action="{{ route('transferencias.cancelar', $transferencia->id) }}"
                                        class="inline-form"
                                        onsubmit="return confirm('Tem certeza que deseja cancelar esta transferência?')">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="motivo_cancelamento" value="Cancelado pelo usuário">
                                        <button type="submit" class="btn btn-sm btn-danger">Cancelar</button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <div class="empty-title">Nenhuma transferência encontrada</div>
                                    <div class="empty-subtitle">Clique em "Nova Transferência" para criar uma</div>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginação -->
            @if($transferencias->hasPages())
            <div class="pagination-container">
                {{ $transferencias->links() }}
            </div>
            @endif
        </section>
    </main>

</body>

</html>