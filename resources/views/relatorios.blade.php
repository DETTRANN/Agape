<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Relatórios</title>
    <link rel="stylesheet" href="{{url('frontend/css/inventory.css')}}" />
    <script src="{{url('frontend/js/script.js')}}" defer></script>
</head>

<body class="page-relatorios">
    <!-- Mobile Header -->
    <div class="top-header">
        <img class="mobile-logo" src="{{url('frontend/img/logo-agape.png')}}" alt="Agape" onclick="window.location.href='{{url('/')}}'" />
        <button class="mobile-toggle" id="mobile-toggle" onclick="toggleRelatoriosSidebar()">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
    
    <!-- Mobile Sidebar (fora do header para não ser ocultado no mobile) -->
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
          <div class="sidebar-item">
            <img src="{{url('frontend/img/localizacao.png')}}" alt="Rastreio" />
            <span>Rastreio</span>
          </div>
          
          <!-- Bottom section mobile -->
          <div class="sidebar-bottom">
            <div class="sidebar-item" onclick="toggleNotifications()">
              <img src="{{url('frontend/img/notificacao.png')}}" alt="Notificações" />
              <span>Notificações</span>
              <div class="notification-badge-mobile">!</div>
            </div>
            <div class="sidebar-item" onclick="showMobileProfileMenu()">
              <img src="@auth{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : url('frontend/img/user-alien.png') }}@else{{url('frontend/img/user-alien.png')}}@endauth" alt="Perfil" />
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
            <span>Termos de Uso</span>
          </div>
          <div class="sidebar-item sidebar-logout" onclick="document.getElementById('logout-form').submit();">
            <span>Sair</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Overlay -->
    <div class="overlay" id="overlay" onclick="handleRelatoriosOverlayClick()"></div>

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
                
                <!-- Perfil do Usuário com Foto -->
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
                    <img src="@auth{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : url('frontend/img/user-alien.png') }}@else{{url('frontend/img/user-alien.png')}}@endauth" alt="" />
                    <div>Perfil</div>
                </div>
            </div>
        </section>
    </header>

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

    <!-- Linha 2: Itens Valiosos e Vendas Anuais -->
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
                <th>Localidade</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @forelse($itensMaisValiosos as $item)
              <tr>
                <td>{{ $item->nome_item }}</td>
                <td>{{ $item->categoria }}</td>
                <td>R$ {{ number_format($item->preco, 2, ',', '.') }}</td>
                <td>{{ $item->localidade ?? 'N/A' }}</td>
                <td>
                  <span class="status-badge status-{{ strtolower(str_replace(' ', '', $item->status)) }}">
                    {{ $item->status }}
                  </span>
                </td>
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

      <section class="vendas-anuais">
        <div class="vendas-anuais__container">
          <h2 class="vendas-anuais__title">Relatório de Vendas Anuais {{ now()->year }}</h2>
          <div class="vendas-anuais__content">
            <div class="vendas-stat">
              <span class="vendas-icon">📈</span>
              <div>
                <p class="vendas-label">Total de Vendas</p>
                <p class="vendas-value">{{ $totalVendasAno ?? 0 }}</p>
              </div>
            </div>
            <div class="vendas-stat">
              <span class="vendas-icon">�</span>
              <div>
                <p class="vendas-label">Valor Total</p>
                <p class="vendas-value">R$ {{ number_format($valorTotalVendas ?? 0, 2, ',', '.') }}</p>
              </div>
            </div>
            <div class="vendas-stat">
              <span class="vendas-icon">�</span>
              <div>
                <p class="vendas-label">Ticket Médio</p>
                <p class="vendas-value">R$ {{ number_format($mediaValorVenda ?? 0, 2, ',', '.') }}</p>
              </div>
            </div>
            <div class="vendas-stat">
              <span class="vendas-icon">�</span>
              <div>
                <p class="vendas-label">Mais Vendido</p>
                <p class="vendas-value" style="font-size: 14px;">{{ isset($produtoMaisVendido) ? $produtoMaisVendido['nome'] : 'Nenhum' }}</p>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <!-- Linha 3: Rotatividade, Itens em Falta e Fornecedores -->
    <div class="conteiner-terciario">
      <section class="rotatividade">
        <div class="rotatividade__container">
          <h2 class="rotatividade__title">Produtos com maior rotatividade</h2>
          <div class="rotatividade__table">
            @forelse($produtosRotatividade as $produto)
            <div class="rotatividade__row rotatividade__row--item">
              <span class="rotatividade__item">{{ $produto['nome'] }}</span>
              <span class="rotatividade__value">{{ $produto['rotatividade'] }}</span>
            </div>
            @empty
            <div class="rotatividade__row">
              <span class="rotatividade__item">Nenhum produto disponível</span>
            </div>
            @endforelse
          </div>
        </div>
      </section>

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