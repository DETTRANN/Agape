<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tabela de Estoque</title>
    <link rel="stylesheet" href="{{url('frontend/css/inventory.css')}}" />
    <script src="{{url('frontend/js/script.js')}}" defer></script>
  </head>
  <body>
    <!-- Mobile Header -->
    <div class="top-header system-header">
      <img class="mobile-logo" src="{{url('frontend/img/logo-agape.png')}}" alt="Agape" onclick="window.location.href='{{url('/')}}'" />
      <button class="mobile-toggle" id="mobile-toggle" onclick="toggleSystemSidebar()" aria-label="Abrir menu" aria-controls="sidebar" aria-expanded="false">
        <span></span>
        <span></span>
        <span></span>
      </button>
    </div>

    <!-- Desktop Header -->
    <header>
      <section class="header-left">
        <img class="img-logo" src="{{url('frontend/img/logo-agape.png')}}" alt="" />
        <div class="logo-separator"></div>
        
        <!-- Menu Principal -->
        <div class="main-menu">
          <div class="header-sections" data-section="inicio" onclick="goToSystem()">
            <img src="{{url('frontend/img/casa-simples-fina.png')}}" alt="" />
            <div>Início</div>
          </div>
          <div class="header-sections" data-section="relatorios" onclick="goToRelatorios()">
            <img src="{{url('frontend/img/grafico-de-barras.png')}}" alt="" />
            <div>Relatórios</div>
          </div>
          <div class="header-sections active" data-section="estoque" onclick="goToEstoque()">
            <img src="{{url('frontend/img/estoque-pronto.png')}}" alt="" />
            <div>Estoque</div>
          </div>
          <div class="header-sections" data-section="transferencias" onclick="goToTransferencias()">
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
            <img src="{{url('frontend/img/configuracoes.png')}}" alt="" />
            <div>Configurações</div>
          </div>
          <div class="header-sections">
            <img src="{{url('frontend/img/contato.png')}}" alt="" />
            <div>Contato</div>
          </div>
          <div class="header-sections">
            <img src="{{url('frontend/img/termos-e-condicoes.png')}}" alt="" />
            <div>Termos de Uso</div>
          </div>
          <div class="header-sections logout">
            <form action="{{ route('auth.logout') }}" method="POST" style="display: inline;">
              @csrf
              <button type="submit" onclick="goToLogin()" style="background: none; border: none; color: inherit; cursor: pointer; font-family: inherit; font-size: inherit;">
                Log out
              </button>
            </form>
          </div>
        </div>

        <!-- Notificações e Perfil -->
        <div class="bottom-section">
          <div class="header-sections header-sections-notification">
            <img src="{{url('frontend/img/notificacao.png')}}" alt="" />
            <div>Notificações</div>
          </div>
          <div class="header-sections header-sections-person" onclick="showProfileMenu()">
            <img src="@auth{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : url('frontend/img/user-alien.png') }}@else{{url('frontend/img/user-alien.png')}}@endauth" alt="" />
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
          <div class="sidebar-item" onclick="window.location.href='{{url('views/system')}}'">
            <img src="{{url('frontend/img/casa-simples-fina.png')}}" alt="" />
            <span>Início</span>
          </div>
          <div class="sidebar-item">
            <img src="{{url('frontend/img/grafico-de-barras.png')}}" alt="" />
            <span>Relatórios</span>
          </div>
          <div class="sidebar-item">
            <img src="{{url('frontend/img/estoque-pronto.png')}}" alt="" />
            <span>Estoque</span>
          </div>
          <div class="sidebar-item" onclick="goToTransferencias()">
            <img src="{{url('frontend/img/cargo-truck.png')}}" alt="Transferências" />
            <span>Transferências</span>
          </div>
          <div class="sidebar-item" onclick="goToAuditoria()">
            <img src="{{url('frontend/img/icons8-robot-50.png')}}" alt="Auditoria" />
            <span>Auditoria</span>
          </div>
          
          <!-- Bottom section mobile -->
          <div class="sidebar-bottom">
            <div class="sidebar-item">
              <img src="{{url('frontend/img/notificacao.png')}}" alt="" />
              <span>Notificações</span>
            </div>
            <div class="sidebar-item" onclick="showMobileProfileMenu()">
              <img src="@auth{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : url('frontend/img/user-alien.png') }}@else{{url('frontend/img/user-alien.png')}}@endauth" alt="" />
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
            <img src="{{url('frontend/img/icons8-robot-50.png')}}" alt="" />
            <span>Perfil</span>
          </div>
          <div class="sidebar-item">
            <img src="{{url('frontend/img/configuracoes.png')}}" alt="" />
            <span>Configurações</span>
          </div>
          <div class="sidebar-item">
            <img src="{{url('frontend/img/contato.png')}}" alt="" />
            <span>Contato</span>
          </div>
          <div class="sidebar-item">
            <img src="{{url('frontend/img/termos-e-condicoes.png')}}" alt="" />
            <span>Termos de Uso</span>
          </div>
          <div class="sidebar-item sidebar-logout">
            <form action="{{ route('auth.logout') }}" method="POST" style="display: inline;">
              @csrf
              <button onclick="goToLogin()" style="background: none; border: none; color: inherit; cursor: pointer; font-family: inherit; font-size: inherit; display: flex; align-items: center; gap: 8px; width: 100%;">
                <span>Log out</span>
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Overlay -->
    <div class="overlay" id="overlay" onclick="closeSystemSidebar()"></div>

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

    <!-- Painel de Notificações -->
    <div class="notifications-panel" id="notificationsPanel">
        <div class="notifications-header">
            <h3>Notificações do Sistema</h3>
            <button class="close-notifications" onclick="toggleNotifications()">&times;</button>
        </div>
        <div class="notifications-content">
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

    <!-- Formulário de Logout (Hidden) -->
    <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- Main Content -->
    <main class="main-content-wrapper">
        <!-- Seção de controles melhorada -->
        <section class="estoque-controls-section">
            <div class="estoque-controls">
                <div class="estoque-search-section">
                    <div class="search-input-group">
                        <label for="search-input">Pesquisar itens:</label>
                        <input type="text" id="search-input" placeholder="Digite para pesquisar..." />
                    </div>
                    <div class="search-column-group">
                        <label for="search-column">Filtrar por:</label>
                        <select id="search-column">
                            <option value="id_item">ID</option>
                            <option value="status">Status</option>
                            <option value="nome">Nome Item</option>
                            <option value="descricao">Descrição</option>
                            <option value="categoria">Categoria</option>
                            <option value="serie">Número de Série</option>
                            <option value="preco">Preço</option>
                            <option value="data">Data de Posse</option>
                            <option value="responsavel">Responsável</option>
                            <option value="localidade">Localidade</option>
                            <option value="observacoes">Observações</option>
                        </select>
                    </div>
                    <div class="estoque-action-buttons">
                        <button class="btn-limpar" type="button">Limpar</button>
                    </div>
                </div>
                <div class="estoque-action-buttons">
                    <button class="btn-atualizar" onclick="window.location.reload()">Atualizar</button>
                    <button class="btn-novo">Novo</button>
                </div>
            </div>
        </section>

        <!-- Seção da tabela melhorada -->
        <section class="estoque-table-section">
            <div class="estoque-table-container">
                <table class="estoque-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Status</th>
                            <th>Nome Item</th>
                            <th>Descrição</th>
                            <th>Categoria</th>
                            <th>Número de Série</th>
                            <th>Preço</th>
                            <th>Data de Posse</th>
                            <th>Responsável</th>
                            <th>Localidade</th>
                            <th>Observações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($produtos as $produto)
                        <tr class="estoque-row">
                            <td><strong>{{ $produto->id_item ?? 'N/A' }}</strong></td>
                            <td>
                                <span class="status-{{ strtolower(str_replace(' ', '', $produto->status)) }}">
                                    {{ $produto->status }}
                                </span>
                            </td>
                            <td>{{ $produto->nome_item }}</td>
                            <td>{{ Str::limit($produto->descricao, 50) }}</td>
                            <td>{{ $produto->categoria }}</td>
                            <td>{{ $produto->numero_serie ?? 'N/A' }}</td>
                            <td>R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
                            <td>{{ \Carbon\Carbon::parse($produto->data_posse)->format('d/m/Y') }}</td>
                            <td>{{ $produto->responsavel }}</td>
                            <td>{{ $produto->localidade ?? 'N/A' }}</td>
                            <td>{{ Str::limit($produto->observacoes, 30) ?? 'N/A' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" style="text-align: center; padding: 2rem; color: var(--cor-texto-secundaria);">
                                <div style="display: flex; flex-direction: column; align-items: center; gap: 1rem;">
                                    <img src="{{url('frontend/img/estoque-pronto.png')}}" alt="Sem itens" style="width: 64px; height: 64px; opacity: 0.5;">
                                    <p style="margin: 0; font-size: 1.1rem;">Nenhum item encontrado no estoque</p>
                                    <p style="margin: 0; font-size: 0.9rem; opacity: 0.7;">Clique em "Novo" para adicionar o primeiro item</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <!-- Modal Novo Produto -->
    <div class="modal" id="modalNovoProduto" style="display: none;">
        <div class="modal-content">
            <h2>Adicionar Novo Item</h2>
            <form action="{{ route('produtos.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="status">Status *</label>
                    <select id="status" name="status" required>
                        <option value="">Selecione o status</option>
                        <option value="Disponível">Disponível</option>
                        <option value="Ocupado">Ocupado</option>
                        <option value="Manutenção">Manutenção</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="nome_item">Nome do Item *</label>
                    <input type="text" id="nome_item" name="nome_item" required placeholder="Ex: Notebook Dell Inspiron">
                </div>

                <div class="form-group">
                    <label for="descricao">Descrição *</label>
                    <textarea id="descricao" name="descricao" required placeholder="Descreva o item em detalhes..."></textarea>
                </div>

                <div class="form-group">
                    <label for="categoria">Categoria *</label>
                    <input type="text" id="categoria" name="categoria" required placeholder="Ex: Eletrônicos, Móveis, etc.">
                </div>

                <div class="form-group">
                    <label for="numero_serie">Número de Série</label>
                    <input type="text" id="numero_serie" name="numero_serie" placeholder="Opcional">
                </div>

                <div class="form-group">
                    <label for="preco">Preço (R$) *</label>
                    <input type="number" step="0.01" min="0" id="preco" name="preco" required placeholder="0,00">
                </div>

                <div class="form-group">
                    <label for="data_posse">Data de Aquisição *</label>
                    <input type="date" id="data_posse" name="data_posse" required>
                </div>

                <div class="form-group">
                    <label for="responsavel">Responsável *</label>
                    <input type="email" id="responsavel" name="responsavel" required placeholder="email@exemplo.com">
                </div>

                <div class="form-group">
                    <label for="localidade">Localização</label>
                    <input type="text" id="localidade" name="localidade" placeholder="Ex: Sala 101, Depósito A">
                </div>

                <div class="form-group">
                    <label for="observacoes">Observações</label>
                    <textarea id="observacoes" name="observacoes" placeholder="Informações adicionais..."></textarea>
                </div>

                <div class="form-buttons">
                    <button type="submit" class="btn-salvar">Salvar Item</button>
                    <button type="button" class="btn-cancelar" onclick="fecharModal()">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

   
  </body>
</html>
