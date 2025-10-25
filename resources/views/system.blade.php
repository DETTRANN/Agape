<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistema</title>
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
          <div class="header-sections active" data-section="inicio" onclick="goToSystem()">
            <img src="{{url('frontend/img/casa-simples-fina.png')}}" alt="" />
            <div>Início</div>
          </div>
          <div class="header-sections" data-section="relatorios" onclick="goToRelatorios()">
            <img src="{{url('frontend/img/grafico-de-barras.png')}}" alt="" />
            <div>Relatórios</div>
          </div>
          <div class="header-sections" data-section="estoque" onclick="goToEstoque()">
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
          
          <!-- Perfil do Usuário com Foto -->
          <div class="profile-user-section">
            <div class="profile-avatar-container">
              <img src="@auth{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : url('frontend/img/user-alien.png') }}@else{{url('frontend/img/user-alien.png')}}@endauth" alt="Avatar" class="profile-user-avatar" id="desktopAvatar" />
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
          <div class="sidebar-item active" onclick="goToSystem()">
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

        <!-- Menu do Perfil Mobile (inicialmente oculto) -->
        <div class="sidebar-profile-menu" style="display: none;">
          <div class="sidebar-item sidebar-back-button" onclick="showMobileMainMenu()">
            <span style="font-size: 20px;">←</span>
            <span>Voltar</span>
          </div>
          
          <!-- Perfil do Usuário Mobile com Foto -->
          <div class="mobile-profile-user-section">
            <div class="mobile-profile-avatar-container">
              <img src="@auth{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : url('frontend/img/user-alien.png') }}@else{{url('frontend/img/user-alien.png')}}@endauth" alt="Avatar" class="mobile-profile-user-avatar" id="mobileAvatar" />
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

    <!-- Modal de Visualização do Avatar -->
    <div class="avatar-modal" id="avatarModal" onclick="closeAvatarModal()">
      <div class="avatar-modal-content" onclick="event.stopPropagation()">
        <span class="avatar-modal-close" onclick="closeAvatarModal()">&times;</span>
        <img src="" alt="Avatar" class="avatar-modal-image" id="avatarModalImage">
        <div class="avatar-modal-info">
          <h3 id="avatarModalName"></h3>
          <p id="avatarModalEmail"></p>
        </div>
      </div>
    </div>

    <main>
      <nav>
        <section class="section-title-1">
          <h1>Relatórios</h1>
        </section>
        <section class="section-img-reports">
          <h3>Resumo mensal</h3>
          <img src="{{url('frontend/img/bar-graph 2.png')}}" alt="" />
        </section>
        <section>
          <p>Vendas e movimentações</p>
        </section>
        <section>
          <button class="btn-view-reports" onclick="goToRelatorios()">Visualizar Relatórios</button>
        </section>
      </nav>
      <nav>
        <section class="section-title-2">
          <h1>Estoque</h1>
        </section>
        <section class="section-img-stock">
          <img src="{{url('frontend/img/caixas.png')}}" alt="" />
        </section>
        <section>
          <p><span class="item-count-stock">0</span> Itens cadastrados</p>
        </section>
        <section>
          <button class="btn-stock" onclick="goToEstoque()">Consultar Estoque</button>
        </section>
      </nav>
      <nav>
        <section class="section-title-3">
          <h1>Rastreio</h1>
        </section>
        <section class="section-img-tracking">
          <img src="{{url('frontend/img/entrega-rapida (1).png')}}" alt="" />
        </section>
        <section>
          <p><span class="item-count-tracking">0</span> entregas a caminhho</p>
        </section>
        <section>
          <button class="btn-tracking">Acompanhar Rastreio</button>
        </section>
      </nav>
    </main>
    <article>
      <nav>
        <section>
          <h1>Histórico de Transferências</h1>
        </section>
        <section></section>
      </nav>
    </article>
  </body>
</html>
