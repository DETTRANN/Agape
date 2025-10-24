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
                <div class="header-sections">
                    <img src="{{url('frontend/img/icons8-robot-50.png')}}" alt="Perfil" />
                    <div>Perfil</div>
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

    <!-- Formulário de Logout (Hidden) -->
    <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- Main Content -->
    <main class="main-content-wrapper">
        <!-- Seção de controles -->
        <section class="estoque-controls-section">
            <div class="estoque-controls">
                <div class="estoque-search-section">
                    <h1 style="color: white; margin: 0;">Auditoria de Estoque</h1>
                    <p style="color: #ccc; margin: 5px 0 0 0;">Histórico completo de todas as alterações</p>
                </div>
                <div class="estoque-action-buttons">
                    <a href="{{ route('auditoria.relatorio') }}" class="btn-atualizar">Relatório Detalhado</a>
                    <a href="{{ route('transferencias.index') }}" class="btn-novo">Ver Transferências</a>
                </div>
            </div>
        </section>

        <!-- Estatísticas -->
        <section class="estoque-controls-section" style="padding-top: 0;">
            <div class="conteiner" style="grid-template-columns: repeat(4, 1fr); gap: 20px; margin: 0 30px;">
                <div class="itens_estoque_atualizacao">
                    <div class="card-icon">📝</div>
                    <div class="card-content">
                        <h2>Criações</h2>
                        <p class="card-value">{{ $estatisticas['criacoes'] }}</p>
                        <span class="card-label">itens criados</span>
                    </div>
                </div>
                
                <div class="itens_estoque_atualizacao">
                    <div class="card-icon">✏️</div>
                    <div class="card-content">
                        <h2>Atualizações</h2>
                        <p class="card-value">{{ $estatisticas['atualizacoes'] }}</p>
                        <span class="card-label">alterações</span>
                    </div>
                </div>
                
                <div class="itens_estoque_atualizacao">
                    <div class="card-icon">🚚</div>
                    <div class="card-content">
                        <h2>Transferências</h2>
                        <p class="card-value">{{ $estatisticas['transferencias'] }}</p>
                        <span class="card-label">movimentações</span>
                    </div>
                </div>
                
                <div class="itens_estoque_atualizacao">
                    <div class="card-icon">🗑️</div>
                    <div class="card-content">
                        <h2>Exclusões</h2>
                        <p class="card-value">{{ $estatisticas['exclusoes'] }}</p>
                        <span class="card-label">itens removidos</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Filtros -->
        <section class="estoque-controls-section" style="padding-top: 0;">
            <div class="estoque-controls">
                <form method="GET" style="display: flex; gap: 15px; align-items: end;">
                    <div class="search-column-group">
                        <label for="tipo_operacao" style="color: white;">Tipo de Operação:</label>
                        <select name="tipo_operacao" id="tipo_operacao" style="padding: 8px;">
                            <option value="">Todos</option>
                            <option value="criacao" {{ request('tipo_operacao') == 'criacao' ? 'selected' : '' }}>Criação</option>
                            <option value="atualizacao" {{ request('tipo_operacao') == 'atualizacao' ? 'selected' : '' }}>Atualização</option>
                            <option value="transferencia" {{ request('tipo_operacao') == 'transferencia' ? 'selected' : '' }}>Transferência</option>
                            <option value="exclusao" {{ request('tipo_operacao') == 'exclusao' ? 'selected' : '' }}>Exclusão</option>
                        </select>
                    </div>
                    
                    <div class="search-column-group">
                        <label for="produto_id" style="color: white;">Produto:</label>
                        <select name="produto_id" id="produto_id" style="padding: 8px;">
                            <option value="">Todos</option>
                            @foreach($produtos as $produto)
                            <option value="{{ $produto->id }}" {{ request('produto_id') == $produto->id ? 'selected' : '' }}>
                                {{ $produto->nome_item }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="search-input-group">
                        <label for="data_inicio" style="color: white;">Data Início:</label>
                        <input type="date" name="data_inicio" id="data_inicio" value="{{ request('data_inicio') }}" style="padding: 8px;">
                    </div>
                    
                    <div class="search-input-group">
                        <label for="data_fim" style="color: white;">Data Fim:</label>
                        <input type="date" name="data_fim" id="data_fim" value="{{ request('data_fim') }}" style="padding: 8px;">
                    </div>
                    
                    <button type="submit" class="btn-atualizar">Filtrar</button>
                    <a href="{{ route('auditoria.index') }}" class="btn-limpar">Limpar</a>
                </form>
            </div>
        </section>

        <!-- Lista de Auditoria -->
        <section class="estoque-table-section">
            <div class="estoque-table-container">
                <table class="estoque-table">
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

    <style>
    .tipo-criacao { background: #28a745; color: #fff; padding: 4px 8px; border-radius: 12px; font-size: 11px; font-weight: 600; }
    .tipo-atualizacao { background: #007bff; color: #fff; padding: 4px 8px; border-radius: 12px; font-size: 11px; font-weight: 600; }
    .tipo-transferencia { background: #ffc107; color: #000; padding: 4px 8px; border-radius: 12px; font-size: 11px; font-weight: 600; }
    .tipo-exclusao { background: #dc3545; color: #fff; padding: 4px 8px; border-radius: 12px; font-size: 11px; font-weight: 600; }
    
    .search-input-group, .search-column-group {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }
    
    .search-input-group input, .search-column-group select {
        border: 1px solid #444;
        border-radius: 4px;
        background: #2a2d3e;
        color: white;
        min-width: 120px;
    }
    </style>
</body>
</html>
