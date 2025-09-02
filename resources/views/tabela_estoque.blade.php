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
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-error">
        {{ session('error') }}
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
          <div class="sidebar-item" onclick="window.location.href=`{{url('views/system')}}`">
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
                    <button class="btn-atualizar" onclick="window.location.reload()">Atualizar</button>
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
                        @foreach($produtos as $produto)
                        <tr class="estoque-row">
                            <td>{{ $produto->id_item }}</td>
                            <td><span class="status-{{ strtolower($produto->status) }}">{{ $produto->status }}</span></td>
                            <td>{{ $produto->nome_item }}</td>
                            <td>{{ $produto->descricao }}</td>
                            <td>{{ $produto->categoria }}</td>
                            <td>{{ $produto->numero_serie }}</td>
                            <td>{{ number_format($produto->preco, 2, ',', '.') }}</td>
                            <td>{{ \Carbon\Carbon::parse($produto->data_posse)->format('d/m/Y') }}</td>
                            <td>{{ $produto->responsavel }}</td>
                            <td>{{ $produto->localidade }}</td>
                            <td>{{ $produto->observacoes }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <!-- Modal Novo Produto -->
    <div class="modal" id="modalNovoProduto" style="display: none;">
        <div class="modal-content">
            <h2>Novo Item</h2>
            <form action="{{ route('produtos.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="id_item">ID Item</label>
                    <input type="text" id="id_item" name="id_item" required>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" required>
                        <option value="Disponível">Disponível</option>
                        <option value="Ocupado">Ocupado</option>
                        <option value="Manutenção">Manutenção</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="nome_item">Nome do Item</label>
                    <input type="text" id="nome_item" name="nome_item" required>
                </div>

                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <textarea id="descricao" name="descricao" required></textarea>
                </div>

                <div class="form-group">
                    <label for="categoria">Categoria</label>
                    <input type="text" id="categoria" name="categoria" required>
                </div>

                <div class="form-group">
                    <label for="numero_serie">Número de Série</label>
                    <input type="text" id="numero_serie" name="numero_serie" required>
                </div>

                <div class="form-group">
                    <label for="preco">Preço</label>
                    <input type="number" step="0.01" id="preco" name="preco" required>
                </div>

                <div class="form-group">
                    <label for="data_posse">Data de Posse</label>
                    <input type="date" id="data_posse" name="data_posse" required>
                </div>

                <div class="form-group">
                    <label for="responsavel">Responsável (email)</label>
                    <input type="email" id="responsavel" name="responsavel" required>
                </div>

                <div class="form-group">
                    <label for="localidade">Localidade</label>
                    <input type="text" id="localidade" name="localidade">
                </div>

                <div class="form-group">
                    <label for="observacoes">Observações</label>
                    <textarea id="observacoes" name="observacoes"></textarea>
                </div>

                <div class="form-buttons">
                    <button type="submit" class="btn-salvar">Salvar</button>
                    <button type="button" class="btn-cancelar" onclick="fecharModal()">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Função para filtrar a tabela
        function filtrarTabela() {
            const searchInput = document.getElementById('search-input').value.toLowerCase();
            const searchColumn = document.getElementById('search-column').value;
            const rows = document.querySelectorAll('.estoque-table tbody tr');

            rows.forEach(row => {
                let cell;
                switch(searchColumn) {
                    case 'id':
                        cell = row.cells[0]; // ID Item
                        break;
                    case 'status':
                        cell = row.cells[1]; // Status
                        break;
                    case 'nome':
                        cell = row.cells[2]; // Nome Item
                        break;
                    case 'descricao':
                        cell = row.cells[3]; // Descrição
                        break;
                    case 'categoria':
                        cell = row.cells[4]; // Categoria
                        break;
                    case 'serie':
                        cell = row.cells[5]; // Número de Série
                        break;
                    case 'preco':
                        cell = row.cells[6]; // Preço
                        break;
                    case 'data':
                        cell = row.cells[7]; // Data de Posse
                        break;
                    case 'responsavel':
                        cell = row.cells[8]; // Responsável
                        break;
                    case 'localidade':
                        cell = row.cells[9]; // Localidade
                        break;
                    case 'observacoes':
                        cell = row.cells[10]; // Observações
                        break;
                    default:
                        cell = null;
                }

                if (cell) {
                    const text = cell.textContent.toLowerCase();
                    row.style.display = text.includes(searchInput) ? '' : 'none';
                }
            });
        }

        // Função para limpar a pesquisa
        function limparPesquisa() {
            document.getElementById('search-input').value = '';
            document.querySelectorAll('.estoque-table tbody tr').forEach(row => {
                row.style.display = '';
            });
        }

        // Eventos para filtrar a tabela
        document.getElementById('search-input').addEventListener('input', filtrarTabela);
        document.getElementById('search-column').addEventListener('change', filtrarTabela);

        // Funções para o modal
        function abrirModal() {
            document.getElementById('modalNovoProduto').style.display = 'flex';
            document.getElementById('overlay').style.display = 'block';
        }

        function fecharModal() {
            document.getElementById('modalNovoProduto').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        }

        // Atualizar botão novo para abrir modal
        document.querySelector('.btn-novo').addEventListener('click', abrirModal);

        // Fechar modal ao clicar no overlay
        document.getElementById('overlay').addEventListener('click', fecharModal);
    </script>

    <style>
        .alert {
            padding: 16px;
            margin-bottom: 20px;
            border: 1px solid var(--cor-borda, #323238);
            border-radius: 6px;
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            min-width: 300px;
            max-width: 500px;
            backdrop-filter: blur(8px);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
            animation: slideIn 0.3s ease;
        }

        .alert-success {
            background-color: rgba(0, 179, 126, 0.1);
            border-color: var(--cor-sucesso, #00B37E);
            color: var(--cor-texto, #E1E1E6);
        }

        .alert-danger {
            background-color: rgba(170, 40, 52, 0.1);
            border-color: var(--cor-erro, #AA2834);
            color: var(--cor-texto, #E1E1E6);
        }

        .alert-error {
            background-color: rgba(170, 40, 52, 0.1);
            border-color: var(--cor-erro, #AA2834);
            color: var(--cor-texto, #E1E1E6);
        }

        .alert ul {
            margin: 8px 0 0 0;
            padding-left: 24px;
            color: var(--cor-texto-secundaria, #8D8D99);
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .modal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: var(--cor-fundo-secundaria, #202024);
            padding: 24px;
            border-radius: 12px;
            z-index: 1000;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
            border: 1px solid var(--cor-borda, #323238);
        }

        .modal h2 {
            color: var(--cor-texto, #E1E1E6);
            margin-bottom: 24px;
            font-size: 1.5em;
        }

        .modal-content {
            width: 500px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--cor-texto-secundaria, #8D8D99);
            font-size: 0.9em;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            background-color: var(--cor-input, #121214);
            border: 1px solid var(--cor-borda, #323238);
            border-radius: 6px;
            color: var(--cor-texto, #E1E1E6);
            transition: all 0.3s ease;
            font-size: 0.95em;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: var(--cor-primaria, #00875F);
            outline: none;
            box-shadow: 0 0 0 2px rgba(0, 135, 95, 0.2);
        }

        .form-group select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%238D8D99' viewBox='0 0 16 16'%3E%3Cpath d='M8 11L3 6h10l-5 5z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 36px;
        }

        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }

        .form-buttons {
            margin-top: 24px;
            text-align: right;
            display: flex;
            gap: 12px;
            justify-content: flex-end;
        }

        .btn-salvar,
        .btn-cancelar {
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
            font-size: 0.95em;
        }

        .btn-salvar {
            background-color: var(--cor-primaria, #00875F);
            color: var(--cor-texto, #E1E1E6);
        }

        .btn-cancelar {
            background-color: var(--cor-erro, #AA2834);
            color: var(--cor-texto, #E1E1E6);
        }

        .btn-salvar:hover {
            background-color: var(--cor-hover-primaria, #015F43);
            transform: translateY(-2px);
        }

        .btn-cancelar:hover {
            background-color: var(--cor-hover-erro, #7A1921);
            transform: translateY(-2px);
        }

        /* Estilos gerais para a tela de estoque */
        .main-content-wrapper {
            padding: 20px 20px 0 20px;
            background-color: var(--cor-fundo-principal, #121214);
            min-height: calc(100vh - 60px);
            font-family: var(--fonte-principal, 'Roboto', sans-serif);
        }

        /* Seção de controles */
        .estoque-controls-section {
            background: linear-gradient(145deg, var(--cor-fundo-secundaria, #202024), var(--cor-fundo-terciaria, #29292E));
            padding: 24px;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            margin-bottom: 24px;
            border: 1px solid var(--cor-borda, #323238);
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }

        .estoque-controls-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--cor-primaria, #00875F), transparent);
            opacity: 0.5;
        }

        .estoque-controls {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 24px;
            position: relative;
            z-index: 1;
        }

        .estoque-search-section {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            align-items: flex-end;
            flex: 1;
        }

        .search-input-group, .search-column-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .search-input-group label, .search-column-group label {
            font-size: 0.9em;
            color: var(--cor-texto-secundaria, #8D8D99);
        }

        .search-input-group input, .search-column-group select {
            padding: 14px 16px;
            background-color: var(--cor-input, #121214);
            border: 1px solid var(--cor-borda, #323238);
            border-radius: 8px;
            min-width: 220px;
            color: var(--cor-texto, #E1E1E6);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 0.95em;
            letter-spacing: 0.01em;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .search-input-group input:focus, 
        .search-column-group select:focus {
            border-color: var(--cor-primaria, #00875F);
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 135, 95, 0.15), 
                       inset 0 2px 4px rgba(0, 0, 0, 0.1);
            transform: translateY(-1px);
        }

        .search-column-group select {
            min-width: 150px;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%238D8D99' viewBox='0 0 16 16'%3E%3Cpath d='M8 11L3 6h10l-5 5z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 36px;
        }

        /* Botões de ação */
        .estoque-action-buttons {
            display: flex;
            gap: 12px;
            align-self: flex-end;
            margin-bottom: 6px;
        }

        .btn-atualizar, .btn-novo, .btn-limpar {
            padding: 14px 28px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 0.95em;
            letter-spacing: 0.01em;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-width: 120px;
            position: relative;
            overflow: hidden;
            height: 48px; /* Altura fixa para todos os botões */
        }

        .btn-atualizar {
            background: linear-gradient(135deg, var(--cor-secundaria, #323238), var(--cor-hover-secundaria, #29292E));
            color: var(--cor-texto, #E1E1E6);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .btn-novo {
            background: linear-gradient(135deg, var(--cor-primaria, #00875F), var(--cor-hover-primaria, #015F43));
            color: var(--cor-texto, #E1E1E6);
            box-shadow: 0 4px 12px rgba(0, 135, 95, 0.2);
        }

        .btn-limpar {
            background: linear-gradient(135deg, var(--cor-erro, #AA2834), var(--cor-hover-erro, #7A1921));
            color: var(--cor-texto, #E1E1E6);
            box-shadow: 0 4px 12px rgba(170, 40, 52, 0.2);
        }

        .btn-atualizar:hover { 
            background-color: var(--cor-hover-secundaria, #29292E);
            transform: translateY(-2px);
        }
        
        .btn-novo:hover { 
            background-color: var(--cor-hover-primaria, #015F43);
            transform: translateY(-2px);
        }
        
        .btn-limpar:hover { 
            background-color: var(--cor-hover-erro, #7A1921);
            transform: translateY(-2px);
        }

        /* Seção da tabela */
        .estoque-table-section {
            background: linear-gradient(145deg, var(--cor-fundo-secundaria, #202024), var(--cor-fundo-terciaria, #29292E));
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            border: 1px solid var(--cor-borda, #323238);
            position: relative;
            margin-bottom: 40px;
        }

        .estoque-table-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--cor-primaria, #00875F), transparent);
            opacity: 0.5;
        }

        .estoque-table-container {
            overflow: auto;
            padding: 24px;
            scrollbar-width: thin;
            scrollbar-color: var(--cor-primaria, #00875F) var(--cor-fundo-principal, #121214);
            max-height: calc(100vh - 300px); /* Altura máxima com espaço para outros elementos */
        }

        .estoque-table-container::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        .estoque-table-container::-webkit-scrollbar-track {
            background: var(--cor-fundo-principal, #121214);
            border-radius: 4px;
        }

        .estoque-table-container::-webkit-scrollbar-thumb {
            background: var(--cor-primaria, #00875F);
            border-radius: 4px;
        }

        .estoque-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 0.95em;
        }

        .estoque-table th {
            background: linear-gradient(180deg, var(--cor-fundo-terciaria, #29292E), var(--cor-fundo-secundaria, #202024));
            padding: 18px 16px;
            text-align: left;
            font-weight: 600;
            color: var(--cor-texto, #E1E1E6);
            border-bottom: 2px solid var(--cor-borda, #323238);
            letter-spacing: 0.02em;
            text-transform: uppercase;
            font-size: 0.85em;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .estoque-table td {
            padding: 16px;
            border-bottom: 1px solid var(--cor-borda, #323238);
            color: var(--cor-texto-secundaria, #8D8D99);
            transition: all 0.3s ease;
        }

        .estoque-table tbody tr {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: default;
        }

        .estoque-table tbody tr:hover {
            background-color: rgba(0, 135, 95, 0.05);
            transform: translateY(-1px);
        }

        .estoque-table tbody tr:hover td {
            color: var(--cor-texto, #E1E1E6);
        }

        /* Status colors */
        .status-disponivel { 
            color: #00FF00;
            font-weight: 600;
            padding: 6px 12px;
            background: rgba(0, 255, 0, 0.1);
            border-radius: 16px;
            display: inline-block;
            font-size: 0.9em;
            letter-spacing: 0.02em;
            border: 1px solid rgba(0, 255, 0, 0.2);
        }
        
        .status-ocupado { 
            color: var(--cor-erro, #AA2834);
            font-weight: 600;
            padding: 6px 12px;
            background: rgba(170, 40, 52, 0.1);
            border-radius: 16px;
            display: inline-block;
            font-size: 0.9em;
            letter-spacing: 0.02em;
            border: 1px solid rgba(170, 40, 52, 0.2);
        }
        
        .status-manutencao { 
            color: #FFFF00;
            font-weight: 600;
            padding: 6px 12px;
            background: rgba(255, 255, 0, 0.1);
            border-radius: 16px;
            display: inline-block;
            font-size: 0.9em;
            letter-spacing: 0.02em;
            border: 1px solid rgba(255, 255, 0, 0.2);
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .estoque-controls {
                flex-direction: column;
            }

            .estoque-search-section {
                width: 100%;
            }

            .search-input-group input,
            .search-column-group select {
                width: 100%;
                min-width: unset;
            }

            .estoque-action-buttons {
                width: 100%;
                justify-content: flex-end;
            }
        }
    </style>
  </body>
</html>
