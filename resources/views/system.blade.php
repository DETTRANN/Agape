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
    <header>
      <section class="header-left">
        <img class="img-logo" src="{{url('frontend/img/logo-agape.png')}}" alt="" />
        <div class="header-sections">
          <img src="{{url('frontend/img/casa-simples-fina.png')}}" alt="" />
          <div>Início</div>
        </div>
        <div class="header-sections">
          <img src="{{url('frontend/img/grafico-de-barras.png')}}" alt="" />
          <div>Relatórios</div>
        </div>
        <div class="header-sections">
          <img src="{{url('frontend/img/estoque-pronto.png')}}" alt="" />
          <div>Estoque</div>
        </div>
        <div class="header-sections">
          <img src="{{url('frontend/img/localizacao.png')}}" alt="" />
          <div>Rastreio</div>
        </div>
        <div class="header-sections header-sections-notification">
          <img src="{{url('frontend/img/notificacao.png')}}" alt="" />
        </div>
        <div class="header-sections header-sections-person dropdown">
          <img src="{{url('frontend/img/user-alien.png')}}" alt="" class="user-icon" />
          <ul class="user-menu">
            <li class="menu-item">
              <img src="{{url('frontend/img/icons8-robot-50.png')}}" alt="" class="menu-icon" />
              <span>Perfil</span>
            </li>
            <li class="menu-item">
              <img src="{{url('frontend/img/configuracoes.png')}}" alt="" class="menu-icon" />
              <span>Configurações</span>
            </li>
            <li class="menu-item">
              <img src="{{url('frontend/img/contato.png')}}" alt="" class="menu-icon" />
              <span>Contato</span>
            </li>
            <li class="menu-item">
              <img src="{{url('frontend/img/termos-e-condicoes.png')}}" alt="" class="menu-icon" />
              <span>Termos de Uso</span>
            </li>
            <li class="menu-divider"></li>
            <li class="menu-item logout">
              <span>Log out</span>
            </li>
          </ul>
        </div>
      </section>
    </header>

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
          <button class="btn-view-reports">Visualizar Relatórios</button>
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
          <button class="btn-stock">Consultar Estoque</button>
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
