<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auditoria de Estoque - Agape</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{url('frontend/css/inventory.css')}}" />
    <script src="{{url('frontend/js/script.js')}}" defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <!-- Alert Messages -->
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
                <div class="header-sections" data-section="transferencias" onclick="goToTransferencias()">
                    <img src="{{url('frontend/img/cargo-truck.png')}}" alt="Transferências" />
                    <div>Transferências</div>
                </div>
                <div class="header-sections active" data-section="auditoria" onclick="goToAuditoria()">
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
                <div class="sidebar-item" onclick="goToTransferencias()">
                    <img src="{{url('frontend/img/cargo-truck.png')}}" alt="Transferências" />
                    <span>Transferências</span>
                </div>
                <div class="sidebar-item active" onclick="goToAuditoria()">
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
                    <p><strong>{{ $produtosVencidos->count() }}</strong> {{ $produtosVencidos->count() == 1 ? 'produto está vencido' : 'produtos estão vencidos' }}:</p>
                    <ul style="margin: 8px 0; padding-left: 20px;">
                        @foreach($produtosVencidos->take(3) as $produto)
              @php
                $diasVencido = (int) \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($produto->data_validade), false);
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
                    <p><strong>{{ $produtosProximosVencimento->count() }}</strong> {{ $produtosProximosVencimento->count() == 1 ? 'produto vencerá' : 'produtos vencerão' }} em breve:</p>
                    <ul style="margin: 8px 0; padding-left: 20px;">
                        @foreach($produtosProximosVencimento->take(3) as $produto)
              @php
                $diasRestantes = (int) \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($produto->data_validade), false);
              @endphp
                            <li><strong>{{ $produto->nome_item }}</strong> - Vence em {{ $diasRestantes }} {{ $diasRestantes == 1 ? 'dia' : 'dias' }}</li>
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
                    <p>{{ round($porcentagemOcupados) }}% dos itens estão ocupados ({{ $itensOcupados }}/{{ $totalItens }})</p>
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
                    <p>{{ round($porcentagemOcupados) }}% dos itens estão ocupados ({{ $itensOcupados }}/{{ $totalItens }})</p>
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
    <main class="auditoria-page">
        <!-- Seção de controles -->
        <section class="auditoria-header">
            <div class="auditoria-header-content">
                <div class="auditoria-title-section">
                    <h1>Auditoria de Estoque</h1>
                    <p>Histórico completo de todas as alterações</p>
                </div>
                <div class="auditoria-actions">
                    <a href="{{ route('auditoria.relatorio') }}" class="btn-atualizar">Relatório Detalhado</a>
                    <a href="{{ route('transferencias.index') }}" class="btn-novo">Ver Transferências</a>
                </div>
            </div>
        </section>

        <!-- Estatísticas -->
        <section class="auditoria-stats">
            <div class="auditoria-stats-grid">
                <div class="auditoria-stat-card stat-criacao">
                    <div class="stat-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 5v14M5 12h14"/>
                        </svg>
                    </div>
                    <div class="stat-info">
                        <span class="stat-label">Criações</span>
                        <span class="stat-value">{{ $estatisticas['criacoes'] }}</span>
                        <span class="stat-description">itens criados</span>
                    </div>
                </div>
                
                <div class="auditoria-stat-card stat-atualizacao">
                    <div class="stat-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                    </div>
                    <div class="stat-info">
                        <span class="stat-label">Atualizações</span>
                        <span class="stat-value">{{ $estatisticas['atualizacoes'] }}</span>
                        <span class="stat-description">alterações registradas</span>
                    </div>
                </div>
                
                <div class="auditoria-stat-card stat-transferencia">
                    <div class="stat-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 12H3m18 0l-6-6m6 6l-6 6"/>
                        </svg>
                    </div>
                    <div class="stat-info">
                        <span class="stat-label">Transferências</span>
                        <span class="stat-value">{{ $estatisticas['transferencias'] }}</span>
                        <span class="stat-description">movimentações entre locais</span>
                    </div>
                </div>
                
                <div class="auditoria-stat-card stat-exclusao">
                    <div class="stat-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                        </svg>
                    </div>
                    <div class="stat-info">
                        <span class="stat-label">Exclusões</span>
                        <span class="stat-value">{{ $estatisticas['exclusoes'] }}</span>
                        <span class="stat-description">itens removidos</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Filtros -->
        <section class="auditoria-filters">
            <form method="GET" class="auditoria-filter-form">
                <div class="search-column-group">
                    <label for="tipo_operacao">Tipo de Operação:</label>
                    <select name="tipo_operacao" id="tipo_operacao">
                        <option value="">Todos</option>
                        <option value="criacao" {{ request('tipo_operacao') == 'criacao' ? 'selected' : '' }}>Criação</option>
                        <option value="atualizacao" {{ request('tipo_operacao') == 'atualizacao' ? 'selected' : '' }}>Atualização</option>
                        <option value="transferencia" {{ request('tipo_operacao') == 'transferencia' ? 'selected' : '' }}>Transferência</option>
                        <option value="exclusao" {{ request('tipo_operacao') == 'exclusao' ? 'selected' : '' }}>Exclusão</option>
                    </select>
                </div>
                
                <div class="search-column-group">
                    <label for="produto_id">Produto:</label>
                    <select name="produto_id" id="produto_id">
                        <option value="">Todos</option>
                        @foreach($produtos as $produto)
                        <option value="{{ $produto->id }}" {{ request('produto_id') == $produto->id ? 'selected' : '' }}>
                            {{ $produto->nome_item }}
                        </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="search-input-group">
                    <label for="data_inicio">Data Início:</label>
                    <input type="date" name="data_inicio" id="data_inicio" value="{{ request('data_inicio') }}">
                </div>
                
                <div class="search-input-group">
                    <label for="data_fim">Data Fim:</label>
                    <input type="date" name="data_fim" id="data_fim" value="{{ request('data_fim') }}">
                </div>
                
                <button type="submit" class="btn-atualizar">Filtrar</button>
                <a href="{{ route('auditoria.index') }}" class="btn-limpar">Limpar</a>
            </form>
        </section>

        <!-- Lista de Auditoria -->
        <section class="auditoria-table-section">
            <div class="auditoria-table-container">
                <table class="estoque-table auditoria-table">
                    <thead>
                        <tr>
                            <th>Data/Hora</th>
                            <th>Produto</th>
                            <th>Operação</th>
                            <th>Campo</th>
                            <th>Valor Anterior</th>
                            <th>Valor Novo</th>
                            <th>Usuário</th>
                            <th>IP</th>
                            <th>Observações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($auditorias as $auditoria)
                        <tr>
                            <td>
                                <strong>{{ $auditoria->created_at->format('d/m/Y') }}</strong><br>
                                <small style="opacity: 0.7;">{{ $auditoria->created_at->format('H:i:s') }}</small>
                            </td>
                            <td>
                                @if($auditoria->produto)
                                <a href="{{ route('auditoria.show', $auditoria->produto_id) }}" 
                                   style="color: #ffd700; text-decoration: none;">
                                    {{ $auditoria->produto->nome_item }}
                                </a>
                                @else
                                <span style="opacity: 0.5;">Produto removido</span>
                                @endif
                            </td>
                            <td>
                                <span class="tipo-{{ $auditoria->tipo_operacao }}">
                                    {{ ucfirst($auditoria->tipo_operacao) }}
                                </span>
                            </td>
                            <td>{{ $auditoria->campo_alterado ?? '-' }}</td>
                            <td>
                                @if($auditoria->valor_anterior)
                                <small style="opacity: 0.8;">{{ Str::limit($auditoria->valor_anterior, 30) }}</small>
                                @else
                                -
                                @endif
                            </td>
                            <td>
                                @if($auditoria->valor_novo)
                                <small style="opacity: 0.8;">{{ Str::limit($auditoria->valor_novo, 30) }}</small>
                                @else
                                -
                                @endif
                            </td>
                            <td>
                                {{ $auditoria->user->nome ?? 'Sistema' }}
                            </td>
                            <td>
                                <small style="opacity: 0.6;">{{ $auditoria->ip_usuario ?? '-' }}</small>
                            </td>
                            <td>
                                @if($auditoria->observacoes)
                                <small style="opacity: 0.8;">{{ Str::limit($auditoria->observacoes, 40) }}</small>
                                @else
                                -
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" style="text-align: center; padding: 2rem; color: var(--cor-texto-secundaria);">
                                <div style="display: flex; flex-direction: column; align-items: center; gap: 1rem;">
                                    <img src="{{url('frontend/img/icons8-robot-50.png')}}" alt="Sem auditoria" style="width: 64px; height: 64px; opacity: 0.5;">
                                    <p style="margin: 0; font-size: 1.1rem;">Nenhum registro de auditoria encontrado</p>
                                    <p style="margin: 0; font-size: 0.9rem; opacity: 0.7;">As alterações no estoque aparecerão aqui</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Paginação -->
            @if($auditorias->hasPages())
            <div style="padding: 20px; text-align: center;">
                {{ $auditorias->appends(request()->query())->links() }}
            </div>
            @endif
        </section>
    </main>
</body>
</html>
