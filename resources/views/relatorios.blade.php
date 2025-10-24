<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios</title>
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
            <img class="img-logo" src="{{url('frontend/img/logo-agape.png')}}" alt="Agape Logo" onclick="window.location.href='{{url('/')}}'" />
            <div class="logo-separator"></div>

            <!-- Menu Principal -->
            <div class="main-menu">
                <div class="header-sections" data-section="inicio" onclick="goToSystem()">
                    <img src="{{url('frontend/img/casa-simples-fina.png')}}" alt="" />
                    <div>Início</div>
                </div>
                <div class="header-sections active" data-section="relatorios" onclick="goToRelatorios()">
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
                    <form action="{{ route('auth.logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit"
                            style="background: none; border: none; color: inherit; cursor: pointer; font-family: inherit; font-size: inherit;">
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
                <div class="sidebar-item" onclick="goToSystem()">
                    <img src="{{url('frontend/img/casa-simples-fina.png')}}" alt="Início" />
                    <span>Início</span>
                </div>
                <div class="sidebar-item active" onclick="goToRelatorios()">
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
                <div class="sidebar-item" onclick="document.getElementById('logout-form-mobile').submit();">
                    <img src="{{url('frontend/img/user-alien.png')}}" alt="Sair" />
                    <span>Sair</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Overlay -->
    <div class="overlay" id="overlay"></div>

    <!-- Formulário de Logout Mobile (Hidden) -->
    <form id="logout-form-mobile" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

  <main class="main-relatorios">

    <!-- Cards de estatísticas -->
    <div class="conteiner">
        <section class="itens_estoque_atualizacao card-stat">
            <div class="card-icon">📦</div>
            <div class="card-content">
                <h2>Total de Itens</h2>
                <p class="card-value">{{ $totalItens }}</p>
                <span class="card-label">itens cadastrados</span>
            </div>
        </section>
        <section class="itens_estoque_atualizacao card-stat">
            <div class="card-icon">💰</div>
            <div class="card-content">
                <h2>Valor de Estoque</h2>
                <p class="card-value">R$ {{ number_format($valorEstoque, 2, ',', '.') }}</p>
                <span class="card-label">valor total</span>
            </div>
        </section>
        <section class="itens_estoque_atualizacao card-stat">
            <div class="card-icon">🕐</div>
            <div class="card-content">
                <h2>Última Atualização</h2>
                <p class="card-value">{{ \Carbon\Carbon::parse($ultimaAtualizacao)->format('d/m/Y') }}</p>
                <span class="card-label">{{ \Carbon\Carbon::parse($ultimaAtualizacao)->format('H:i') }}</span>
            </div>
        </section>
    </div>
    <div class="conteiner-secundario">
      <section class="tabela_produtos">
        <div class="tabela_produtos__container">
          <h2 class="tabela_produtos__title">Itens Mais Valiosos</h2>
          <table class="tabela_produtos__table">
            <thead>
              <tr>
                <th>Item</th>
                <th>Categoria</th>
                <th>Preço</th>
                <th>Status</th>
                <th>Localidade</th>
              </tr>
            </thead>
            <tbody>
              @forelse($itensMaisValiosos as $item)
              <tr>
                <td>{{ $item->nome_item }}</td>
                <td>{{ $item->categoria }}</td>
                <td>R$ {{ number_format($item->preco, 2, ',', '.') }}</td>
                <td>
                  <span class="status-badge status-{{ strtolower(str_replace(' ', '', $item->status)) }}">
                    {{ $item->status }}
                  </span>
                </td>
                <td>{{ $item->localidade ?? 'N/A' }}</td>
              </tr>
              @empty
              <tr>
                <td colspan="5" style="text-align: center; padding: 1rem;">Nenhum item cadastrado</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </section>
      <section class="rotatividade">
        <div class="rotatividade__container">
          <h2 class="rotatividade__title">Produtos com maior<br>rotatividade</h2>
          <div class="rotatividade__table">
            @forelse($produtosRotatividade as $produto)
            <div class="rotatividade__row rotatividade__row--item">
              <span class="rotatividade__item">{{ $produto['nome'] }}</span>
              <span class="rotatividade__value">{{ $produto['rotatividade'] }}</span>
            </div>
            @empty
            <div class="rotatividade__row">
              <span class="rotatividade__item">Nenhum produto com rotatividade</span>
            </div>
            @endforelse
          </div>
        </div>
      </section>
    </div>
    <div class="conteiner-terciario">
    <section class="itensFalta_fornecedores">
        <div>
            <h2>Itens em Falta</h2>
            <div class="itensFalta_fornecedores__linha">
                <div>
                    <div>
                        <h3>Item</h3>
                        <ul class="itensFalta_fornecedores__lista">
                          @forelse($itensFalta as $item)
                          <li>{{ $item['nome'] }}</li>
                          @empty
                          <li>Nenhum item</li>
                          @endforelse
                        </ul>
                    </div>
                </div>
                <div>
                    <div>
                        <h3>Quantidade</h3>
                        <ul class="itensFalta_fornecedores__lista">
                          @forelse($itensFalta as $item)
                          <li>{{ $item['quantidade'] }}</li>
                          @empty
                          <li>-</li>
                          @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="itensFalta_fornecedores">
      <div>
        <h2>Principais Fornecedores</h2>
        <ul class="fornecedores__lista">
          @forelse($principaisFornecedores as $fornecedor)
          <li>{{ $fornecedor }}</li>
          @empty
          <li>Nenhum fornecedor cadastrado</li>
          @endforelse
        </ul>
      </div>
    </section>
</div>
</main>
</body>
</html>