<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gestão de Estoque - Agape</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{url('frontend/css/inventory.css')}}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
  </head>
  <body>
    <!-- Alert Messages -->
    @if($errors->any())
    <div class="alert alert-danger">
        <strong>Erro nos dados:</strong>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

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
          <div class="header-sections" data-section="inicio" onclick="window.location.href='{{route('system.page')}}'">
            <img src="{{url('frontend/img/casa-simples-fina.png')}}" alt="Início" />
            <div>Início</div>
          </div>
          <div class="header-sections" data-section="relatorios">
            <img src="{{url('frontend/img/grafico-de-barras.png')}}" alt="Relatórios" />
            <div>Relatórios</div>
          </div>
          <div class="header-sections active" data-section="estoque">
            <img src="{{url('frontend/img/estoque-pronto.png')}}" alt="Estoque" />
            <div>Estoque</div>
          </div>
          <div class="header-sections" data-section="rastreio">
            <img src="{{url('frontend/img/localizacao.png')}}" alt="Rastreio" />
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
          <div class="header-sections header-sections-notification">
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
          <div class="sidebar-item" onclick="window.location.href='{{route('system.page')}}'">
            <img src="{{url('frontend/img/casa-simples-fina.png')}}" alt="Início" />
            <span>Início</span>
          </div>
          <div class="sidebar-item">
            <img src="{{url('frontend/img/grafico-de-barras.png')}}" alt="Relatórios" />
            <span>Relatórios</span>
          </div>
          <div class="sidebar-item active">
            <img src="{{url('frontend/img/estoque-pronto.png')}}" alt="Estoque" />
            <span>Estoque</span>
          </div>
          <div class="sidebar-item">
            <img src="{{url('frontend/img/localizacao.png')}}" alt="Rastreio" />
            <span>Rastreio</span>
          </div>
          
          <!-- Bottom section mobile -->
          <div class="sidebar-bottom">
            <div class="sidebar-item">
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
            <span>Termos de Uso</span>
          </div>
          <div class="sidebar-item sidebar-logout" onclick="document.getElementById('logout-form').submit();">
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

    <!-- Scripts -->
    <script src="{{url('frontend/js/script.js')}}" defer></script>
    <script>
        // Auto-dismiss alerts após 5 segundos
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.transform = 'translateX(100%)';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 300);
            });
        }, 5000);

        // Definir data padrão como hoje
        document.addEventListener('DOMContentLoaded', function() {
            const dataPosse = document.getElementById('data_posse');
            if (dataPosse) {
                const hoje = new Date().toISOString().split('T')[0];
                dataPosse.value = hoje;
            }
        });
    </script>
  </body>
</html>
