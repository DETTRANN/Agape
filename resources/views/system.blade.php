<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
          <div class="header-sections" data-section="rastreio">
            <img src="{{url('frontend/img/localizacao.png')}}" alt="" />
            <div>Rastreio</div>
          </div>
        </div>

        <!-- Menu do Perfil (inicialmente oculto) -->
        <div class="profile-menu" style="display: none;">
          <div class="header-sections back-button" onclick="showMainMenu()">
            <span style="font-size: 20px;">←</span>
            <div>Voltar</div>
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
            <img src="{{url('frontend/img/user-alien.png')}}" alt="" />
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
          <div class="sidebar-item">
            <img src="{{url('frontend/img/localizacao.png')}}" alt="" />
            <span>Rastreio</span>
          </div>
          
          <!-- Bottom section mobile -->
          <div class="sidebar-bottom">
            <div class="sidebar-item">
              <img src="{{url('frontend/img/notificacao.png')}}" alt="" />
              <span>Notificações</span>
            </div>
            <div class="sidebar-item" onclick="showMobileProfileMenu()">
              <img src="{{url('frontend/img/user-alien.png')}}" alt="" />
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
