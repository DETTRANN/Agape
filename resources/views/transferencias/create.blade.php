<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Transferência - Agape</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{url('frontend/css/inventory.css')}}" />
    <script src="{{url('frontend/js/script.js')}}" defer></script>
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
                    <img src="{{url('frontend/img/casa-simples-fina.png')}}" alt="Início" />
                    <div>Início</div>
                </div>
                <div class="header-sections" data-section="relatorios" onclick="goToRelatorios()">
                    <img src="{{url('frontend/img/grafico-de-barras.png')}}" alt="Relatórios" />
                    <div>Relatórios</div>
                </div>
                <div class="header-sections" data-section="estoque" onclick="goToEstoque()">
                    <img src="{{url('frontend/img/estoque-pronto.png')}}" alt="Estoque" />
                    <div>Estoque</div>
                </div>
                <div class="header-sections active" data-section="transferencias" onclick="goToTransferencias()">
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
                <div class="header-sections header-sections-notification" onclick="toggleNotifications()">
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
                <div class="sidebar-item" onclick="goToSystem()">
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
                <div class="sidebar-item active" onclick="goToTransferencias()">
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
                <div class="sidebar-item" onclick="document.getElementById('logout-form').submit();">
                    <img src="{{url('frontend/img/user-alien.png')}}" alt="Sair" />
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
        <!-- Seção de controles -->
        <section class="estoque-controls-section">
            <div class="estoque-controls">
                <div class="estoque-search-section">
                    <h1 style="color: white; margin: 0;">Nova Transferência</h1>
                    <p style="color: #ccc; margin: 5px 0 0 0;">Solicitar transferência de produto entre localidades</p>
                </div>
                <div class="estoque-action-buttons">
                    <a href="{{ route('transferencias.index') }}" class="btn-atualizar">Voltar</a>
                </div>
            </div>
        </section>

        <!-- Formulário de Transferência -->
        <section class="estoque-table-section">
            <div class="estoque-table-container" style="padding: 2rem;">
                <form action="{{ route('transferencias.store') }}" method="POST" style="max-width: 800px; margin: 0 auto;">
                    @csrf
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                        <!-- Coluna Esquerda -->
                        <div>
                            <div class="form-group" style="margin-bottom: 1.5rem;">
                                <label for="produto_id" style="color: white; display: block; margin-bottom: 0.5rem; font-weight: 600;">Produto *</label>
                                <select id="produto_id" name="produto_id" required style="width: 100%; padding: 12px; border: 1px solid #444; border-radius: 8px; background: #2a2d3e; color: white;">
                                    <option value="">Selecione o produto</option>
                                    @foreach($produtos as $produto)
                                    <option value="{{ $produto->id }}" data-localidade="{{ $produto->localidade }}" data-responsavel="{{ $produto->responsavel }}">
                                        {{ $produto->nome_item }} ({{ $produto->categoria }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group" style="margin-bottom: 1.5rem;">
                                <label for="localidade_origem" style="color: white; display: block; margin-bottom: 0.5rem; font-weight: 600;">Localidade Atual</label>
                                <input type="text" id="localidade_origem" readonly style="width: 100%; padding: 12px; border: 1px solid #444; border-radius: 8px; background: #1a1d2e; color: #ccc;" placeholder="Selecione um produto primeiro">
                            </div>

                            <div class="form-group" style="margin-bottom: 1.5rem;">
                                <label for="responsavel_origem" style="color: white; display: block; margin-bottom: 0.5rem; font-weight: 600;">Responsável Atual</label>
                                <input type="email" id="responsavel_origem" readonly style="width: 100%; padding: 12px; border: 1px solid #444; border-radius: 8px; background: #1a1d2e; color: #ccc;" placeholder="Selecione um produto primeiro">
                            </div>
                        </div>

                        <!-- Coluna Direita -->
                        <div>
                            <div class="form-group" style="margin-bottom: 1.5rem;">
                                <label for="localidade_destino" style="color: white; display: block; margin-bottom: 0.5rem; font-weight: 600;">Nova Localidade *</label>
                                <input type="text" id="localidade_destino" name="localidade_destino" required style="width: 100%; padding: 12px; border: 1px solid #444; border-radius: 8px; background: #2a2d3e; color: white;" placeholder="Ex: Sala 201, Depósito B">
                            </div>

                            <div class="form-group" style="margin-bottom: 1.5rem;">
                                <label for="responsavel_destino" style="color: white; display: block; margin-bottom: 0.5rem; font-weight: 600;">Novo Responsável *</label>
                                <input type="email" id="responsavel_destino" name="responsavel_destino" required style="width: 100%; padding: 12px; border: 1px solid #444; border-radius: 8px; background: #2a2d3e; color: white;" placeholder="email@exemplo.com">
                            </div>

                            <div class="form-group" style="margin-bottom: 1.5rem;">
                                <label for="motivo" style="color: white; display: block; margin-bottom: 0.5rem; font-weight: 600;">Motivo da Transferência</label>
                                <select id="motivo" name="motivo" style="width: 100%; padding: 12px; border: 1px solid #444; border-radius: 8px; background: #2a2d3e; color: white;">
                                    <option value="">Selecione o motivo</option>
                                    <option value="Reorganização do estoque">Reorganização do estoque</option>
                                    <option value="Mudança de setor">Mudança de setor</option>
                                    <option value="Manutenção preventiva">Manutenção preventiva</option>
                                    <option value="Solicitação de usuário">Solicitação de usuário</option>
                                    <option value="Otimização de espaço">Otimização de espaço</option>
                                    <option value="Outro">Outro</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Observações (Full Width) -->
                    <div class="form-group" style="margin-bottom: 2rem;">
                        <label for="observacoes" style="color: white; display: block; margin-bottom: 0.5rem; font-weight: 600;">Observações</label>
                        <textarea id="observacoes" name="observacoes" rows="4" style="width: 100%; padding: 12px; border: 1px solid #444; border-radius: 8px; background: #2a2d3e; color: white; resize: vertical;" placeholder="Informações adicionais sobre a transferência..."></textarea>
                    </div>

                    <!-- Botões -->
                    <div style="display: flex; gap: 1rem; justify-content: center;">
                        <button type="submit" style="background: #28a745; color: white; padding: 12px 24px; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; min-width: 150px;">
                            Solicitar Transferência
                        </button>
                        <a href="{{ route('transferencias.index') }}" style="background: #6c757d; color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; min-width: 150px; text-align: center; display: inline-block;">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </section>
    </main>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const produtoSelect = document.getElementById('produto_id');
        const localidadeOrigemInput = document.getElementById('localidade_origem');
        const responsavelOrigemInput = document.getElementById('responsavel_origem');

        produtoSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            
            if (selectedOption.value) {
                const localidade = selectedOption.getAttribute('data-localidade') || 'Não informado';
                const responsavel = selectedOption.getAttribute('data-responsavel') || 'Não informado';
                
                localidadeOrigemInput.value = localidade;
                responsavelOrigemInput.value = responsavel;
            } else {
                localidadeOrigemInput.value = '';
                responsavelOrigemInput.value = '';
            }
        });
    });
    </script>

    <style>
    .form-group label {
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .form-group input, 
    .form-group select, 
    .form-group textarea {
        font-size: 14px;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    
    .form-group input:focus, 
    .form-group select:focus, 
    .form-group textarea:focus {
        outline: none;
        border-color: #ffd700;
        box-shadow: 0 0 0 2px rgba(255, 215, 0, 0.2);
    }
    
    button[type="submit"]:hover {
        background: #218838 !important;
    }
    
    @media (max-width: 768px) {
        .estoque-table-container > form > div:first-child {
            grid-template-columns: 1fr !important;
            gap: 1rem !important;
        }
    }
    </style>
</body>
</html>
