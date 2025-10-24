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
                <div class="header-sections active" data-section="relatorios" onclick="goToRelatorios()">
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

  <main class="main-relatorios">
    <div class="conteiner">
        <section class="itens_estoque_atualizacao">
            <div>
                <h2>Total de Itens</h2>
                <p>{{ $totalItens }}</p>
            </div>
        </section>
        <section class="itens_estoque_atualizacao">
            <div>
                <h2>Valor de Estoque</h2>
                <p>R$ {{ number_format($valorEstoque, 2, ',', '.') }}</p>
            </div>
        </section>
        <section class="itens_estoque_atualizacao">
            <div>
                <h2>Última Atualização</h2>
                <p>{{ \Carbon\Carbon::parse($ultimaAtualizacao)->format('d/m/Y H:i') }}</p>
            </div>
        </section>
    </div>
    <div class="conteiner-secundario">
      <section class="tabela_produtos"></section>
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