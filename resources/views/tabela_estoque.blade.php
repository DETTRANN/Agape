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
        <img class="img-logo" src="{{url('frontend/img/logo-agape.png')}}" alt="" />
        <div class="logo-separator"></div>
        
        <!-- Menu Principal -->
        <div class="main-menu">
          <div class="header-sections" data-section="inicio">
            <img src="{{url('frontend/img/casa-simples-fina.png')}}" alt="" />
            <div>Início</div>
          </div>
          <div class="header-sections" data-section="relatorios">
            <img src="{{url('frontend/img/grafico-de-barras.png')}}" alt="" />
            <div>Relatórios</div>
          </div>
          <div class="header-sections" data-section="estoque">
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
            <img src="{{url('frontend/img/icons8-robot-50.png')}}" alt="" />
            <div>Perfil</div>
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
            <div>Log out</div>
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
          <div class="sidebar-item sidebar-logout" onclick="window.location.href='{{url('/')}}'">
            <span>Log out</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Overlay -->
    <div class="overlay" id="overlay"></div>

    <main class="main-content-wrapper">
        <!-- Seção de controles -->
        <section class="estoque-controls-section">
            <div class="estoque-controls">
                <div class="estoque-search-section">
                    <div class="search-input-group">
                        <label for="search-input">Digite o que deseja pesquisar:</label>
                        <input type="text" id="search-input" placeholder="Pesquisar..." />
                    </div>
                    <div class="search-column-group">
                        <label for="search-column">Coluna de pesquisa:</label>
                        <select id="search-column">
                            <option value="id">ID Item</option>
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
                    <button class="btn-limpar" onclick="limparPesquisa()">Limpar</button>
                </div>
                <div class="estoque-action-buttons">
                    <button class="btn-atualizar">Atualizar</button>
                    <button class="btn-novo">+ Novo</button>
                </div>
            </div>
        </section>

        <!-- Seção da tabela -->
        <section class="estoque-table-section">
            <div class="estoque-table-container">
                <table class="estoque-table">
                    <thead>
                        <tr>
                            <th>ID Item</th>
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
                        <tr class="estoque-row">
                            <td>053</td>
                            <td><span class="status-ocupado">Ocupado</span></td>
                            <td>Notebook</td>
                            <td>Lenovo</td>
                            <td>Informática</td>
                            <td>leh-1908</td>
                            <td>2350,00</td>
                            <td>12/09/2023</td>
                            <td>emailexemplo@gmail.com</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <!-- Linhas vazias para mostrar a estrutura -->
                        <tr class="estoque-row">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr class="estoque-row">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr class="estoque-row">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr class="estoque-row">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr class="estoque-row">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <script>
        function limparPesquisa() {
            document.getElementById('search-input').value = '';
        }
    </script>

  </body>
</html>
