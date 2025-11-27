<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contato - Agape</title>
    <link rel="stylesheet" href="{{url('frontend/css/style.css')}}" />
    <script src="{{url('frontend/js/script.js')}}" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />
</head>

<body class="Nunito-Font page-termos">
    <!-- Mobile Header -->
    <div class="top-header">
        <img class="mobile-logo-system" src="{{ url('frontend/img/logo-agape.png') }}" alt="Agape"
            onclick="window.location.href='{{ url('/') }}'" />
        <button class="mobile-toggle" id="mobile-toggle-auth">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>

    <!-- Desktop Header -->
    <header id="header-menu">
        <!-- Logo Mobile -->
        <img src="{{url('frontend/img/logo-agape.png')}}" alt="Agape" class="mobile-logo"
            onclick="window.location.href='{{url('/')}}'" />

        <div class="left-menu">
            <img src="{{url('frontend/img/logo-agape.png')}}" alt="" />
            <a href="{{url('/')}}">Início</a>
            <a href="{{url('/')}}">Funcionalidades</a>
            <a href="{{url('/')}}">Sobre</a>
            <a href="{{url('views/contato')}}">Contato</a>
        </div>
        <div class="right-menu">
            <a href="{{ route('auth.login.form') }}" class="btn-logar Nunito-Font">Log In</a>
            <button onclick="goToCadastro()" type="submit" class="btn-cadastrar">
                Cadastrar
            </button>
        </div>

        <!-- Botão Hamburger Mobile -->
        <div class="hamburger-menu" id="hamburger-btn">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </header>

    <!-- Mobile Sidebar -->
    <div class="sidebar" id="sidebar-auth">
        <div class="sidebar-content">
            <div class="sidebar-item" onclick="window.location.href='{{ url('/') }}'">
                <span>Início</span>
            </div>
            <div class="sidebar-item" onclick="window.location.href='{{ url('/') }}'">
                <span>Funcionalidades</span>
            </div>
            <div class="sidebar-item" onclick="window.location.href='{{ url('/') }}'">
                <span>Sobre</span>
            </div>
            <div class="sidebar-item" onclick="window.location.href='{{ url('views/contato') }}'">
                <span>Contato</span>
            </div>

            <!-- Botões estéticos como antes -->
            <div class="sidebar-buttons">
                <a href="{{ route('auth.login.form') }}" class="sidebar-btn-login">Log In</a>
                <button onclick="goToCadastro()" class="sidebar-btn-register">Cadastrar</button>
            </div>
        </div>
    </div>

    <!-- Overlay -->
    <div class="overlay" id="overlay-auth"></div>

    <!-- Menu Lateral Mobile -->
    <div class="mobile-menu" id="mobile-menu">
        <div class="mobile-menu-header">
            <img src="{{url('frontend/img/logo-agape.png')}}" alt="Agape" />
            <button class="close-btn" id="close-btn">&times;</button>
        </div>
        <nav class="mobile-menu-nav">
            <a href="{{url('/')}}">Início</a>
            <a href="{{url('/')}}">Funcionalidades</a>
            <a href="{{url('/')}}">Sobre</a>
            <a href="{{url('views/contato')}}">Contato</a>
        </nav>
        <div class="mobile-menu-buttons">
            <a href="{{ route('auth.login.form') }}" class="mobile-btn-login">Log In</a>
            <button onclick="goToCadastro()" class="mobile-btn-register">Cadastrar</button>
        </div>
    </div>

    <!-- Overlay -->
    <div class="mobile-menu-overlay" id="mobile-overlay"></div>

    <main class="main-terms-privacy">
        <h1 class="h1-page-termos">Política de Uso - Empresa Ágape</h1>
        <section class="terms-privacy-introduction">
            <nav class="terms-privacy-introduction-left">
                <h1>Resumo Declaração de privacidade</h1>
                <div>
                    <p> A Empresa Ágape oferece soluções de gerenciamento de estoque destinadas a facilitar o controle
                        de
                        produtos, movimentações e registros internos de empresas contratantes. Este documento apresenta
                        a
                        Política de Uso do sistema da Ágape, estabelecendo regras, direitos e responsabilidades de ambas
                        as
                        partes.</p>
                </div>
            </nav>

            <nav class="terms-privacy-introduction-right">
                <img width="80%" height="auto" src="{{url('frontend/img/img-termos-de-uso.jpg')}}" alt="">
            </nav>
        </section>
    </main>

    <main class="main-terms-privacy-2">
        <section class="terms-privacy-acceptance">
            <nav class="terms-privacy-acceptance-nav">
                <div class="andes-landings-title__misc"></div>
                <h2>1. Aceitação dos Termos</h2>
                <p>
                    Ao utilizar o sistema da Ágape, a empresa contratante declara estar de acordo com todos os termos aqui estabelecidos. Caso não concorde com alguma cláusula, deverá interromper o uso imediatamente.
                </p>
            </nav>
        </section>

        <section class="terms-privacy-acceptance">
            <nav class="terms-privacy-acceptance-nav">
                <div class="andes-landings-title__misc"></div>
                <h2>2. Acesso e Tratamento dos Dados</h2>
                <h3>2.1. Acesso aos Dados</h3>
                <p>
                    Com a ativação da conta, a Ágape terá acesso aos dados inseridos na plataforma, tais como produtos, estoques, movimentações, fornecedores e demais informações operacionais necessárias ao funcionamento do sistema.
                </p> <br>
                <h3>2.2. Uso dos Dados</h3>
                <p>
                    Os dados poderão ser utilizados para:
                    <ul style="margin-left: 20px;">
                        <li>Geração de relatórios e indicadores operacionais;</li>
                        <li>Otimização de funcionalidades;</li>
                        <li>Aperfeiçoamento dos serviços;</li>
                        <li>Cumprimento de exigências legais ou regulatórias.</li>
                    </ul>
                </p> <br>
                <h3>2.3. Compartilhamento de Dados</h3>
                <p>
                    O acesso às informações poderá ocorrer entre setores internos da Ágape exclusivamente para suporte técnico, manutenção, auditoria e melhoria da plataforma.
                </p>
            </nav>
        </section>

        <section class="terms-privacy-acceptance">
            <nav class="terms-privacy-acceptance-nav">
                <div class="andes-landings-title__misc"></div>
                <h2>3. Confidencialidade e Proteção de Informações</h2>
                <p>
                    A Ágape compromete-se a manter sigilo sobre todas as informações comerciais, técnicas e operacionais da empresa contratante, não as divulgando ou comercializando sem autorização expressa.
                </p>
            </nav>
        </section>

        <section class="terms-privacy-acceptance">
            <nav class="terms-privacy-acceptance-nav">
                <div class="andes-landings-title__misc"></div>
                <h2>4. Segurança da Informação</h2>
                <p>
                    A plataforma adota medidas de segurança como criptografia, controle de acesso e monitoramento contínuo. No entanto, nenhuma solução digital é isenta de riscos, cabendo também ao cliente adotar boas práticas de segurança, especialmente no uso e armazenamento de credenciais. <br> <br>

                    A Ágape realiza auditorias e backups periódicos, mas recomenda que o cliente mantenha também cópias próprias de segurança.
                </p>
            </nav>
        </section>

        <section class="terms-privacy-acceptance">
            <nav class="terms-privacy-acceptance-nav">
                <div class="andes-landings-title__misc"></div>
                <h2>5. Responsabilidades da Empresa Contratante</h2>
                <p>
                    A empresa contratante é responsável por:
                    <ul style="margin-left: 20px;">
                        <li>Manter suas credenciais de acesso seguras;</li>
                        <li>Garantir a veracidade e integridade das informações cadastradas;</li>
                        <li>Utilizar a plataforma dentro da finalidade contratada;</li>
                        <li>Cumprir as normas estabelecidas neste documento.</li>
                    </ul>
                    <p>
                        A Ágape não se responsabiliza por prejuízos decorrentes de uso indevido do sistema pelo cliente.
                    </p>
                </p>
            </nav>
        </section>

        <section class="terms-privacy-acceptance">
            <nav class="terms-privacy-acceptance-nav">
                <div class="andes-landings-title__misc"></div>
                <h2>6. Limitação de Responsabilidade</h2>
                <p>
                    A Ágape não se responsabiliza por:
                    <ul style="margin-left: 20px;">
                        <li>Falhas técnicas de terceiros (internet, servidores externos, integrações etc.);;</li>
                        <li>Perdas decorrentes do mau uso da plataforma;</li>
                        <li>Perda de dados ocasionada por fatores externos à infraestrutura da Ágape;</li>
                        <li>Indisponibilidades ocasionadas por manutenções programadas, que serão previamente informadas.</li>
                    </ul>
                </p>
            </nav>
        </section>

        <section class="terms-privacy-acceptance">
            <nav class="terms-privacy-acceptance-nav">
                <div class="andes-landings-title__misc"></div>
                <h2>7. Operação, Suporte e Funcionamento do Sistema</h2>
                <h3>7.1. Suporte Técnico</h3>
                <p>
                    O suporte será prestado de segunda a sexta-feira, das 9h às 17h, via e-mail ou chat interno.
                </p> <br>
                <h3>7.2. Interrupções e Manutenções</h3>
                <p>
                    Poderão ocorrer interrupções programadas para atualização e melhorias da plataforma, sempre com aviso prévio.
                </p> <br>
                <h3>7.3. Treinamento</h3>
                <p>
                    A Ágape poderá oferecer treinamentos e materiais de capacitação para melhor uso da plataforma.
                </p> <br>
                <h3>7.4. Alterações na Plataforma</h3>
                <p>
                    A Ágape poderá modificar, aprimorar ou remover funcionalidades a qualquer momento, desde que não prejudique a usabilidade contratada.
                </p>
            </nav>
        </section>

        <section class="terms-privacy-acceptance">
            <nav class="terms-privacy-acceptance-nav">
                <div class="andes-landings-title__misc"></div>
                <h2>8. Propriedade Intelectual</h2>
                <p>
                    Todo o conteúdo, código, design e funcionalidades da plataforma são de propriedade exclusiva da Ágape, sendo proibida sua reprodução, cópia, engenharia reversa ou redistribuição sem autorização formal.
                </p>
            </nav>
        </section>

        <section class="terms-privacy-acceptance">
            <nav class="terms-privacy-acceptance-nav">
                <div class="andes-landings-title__misc"></div>
                <h2>9. Licença de Uso</h2>
                <p>
                    A empresa contratante recebe uma licença não exclusiva, intransferível e limitada para utilizar a plataforma conforme os termos aqui descritos.
                </p>
            </nav>
        </section>

        <section class="terms-privacy-acceptance">
            <nav class="terms-privacy-acceptance-nav">
                <div class="andes-landings-title__misc"></div>
                <h2>10. Integrações com Terceiros</h2>
                <p>
                    A plataforma pode oferecer integrações com serviços externos, cujos termos e políticas são de responsabilidade das empresas terceiras.
                </p>
            </nav>
        </section>

        <section class="terms-privacy-acceptance">
            <nav class="terms-privacy-acceptance-nav">
                <div class="andes-landings-title__misc"></div>
                <h2>11. Relatórios e Histórico de Dados</h2>
                <p>
                    A plataforma disponibiliza relatórios gerenciais gerados a partir das informações inseridas.
                    Dados poderão ser mantidos por até 6 meses após o encerramento da conta para fins legais e históricos.
                </p>
            </nav>
        </section>

        <section class="terms-privacy-acceptance">
            <nav class="terms-privacy-acceptance-nav">
                <div class="andes-landings-title__misc"></div>
                <h2>12. Cobrança, Pagamentos e Reajustes</h2>
                <p>
                    Os valores acordados deverão ser pagos nos prazos definidos em contrato.
                    A falta de pagamento poderá resultar na suspensão de acesso.
                    Os preços poderão ser reajustados anualmente conforme índices econômicos ou melhorias aplicadas ao sistema.
                </p>
            </nav>
        </section>

        <section class="terms-privacy-acceptance">
            <nav class="terms-privacy-acceptance-nav">
                <div class="andes-landings-title__misc"></div>
                <h2>13. Cancelamento de Conta</h2>
                <p>
                    O cancelamento deverá ser solicitado formalmente e poderá levar até 7 dias úteis para ser processado.               
                </p>
            </nav>
        </section>

        <section class="terms-privacy-acceptance">
            <nav class="terms-privacy-acceptance-nav">
                <div class="andes-landings-title__misc"></div>
                <h2>14. Atualizações dos Termos</h2>
                <p>
                    A Ágape poderá atualizar estes termos periodicamente. As alterações serão comunicadas por e-mail ou notificação interna, permitindo ao usuário revisar as mudanças antes de continuar utilizando o sistema.
                </p>
            </nav>
        </section>

        <section class="terms-privacy-acceptance margin-bottom-20">
            <nav class="terms-privacy-acceptance-nav">
                <div class="andes-landings-title__misc"></div>
                <h2>15. Disposições Finais</h2>
                <p>
                    Este documento constitui o acordo integral entre as partes.
                    Caso alguma cláusula seja considerada inválida, as demais permanecerão em vigor.
                    O foro competente para resolver eventuais conflitos será o da comarca sede da Ágape.
                </p>
            </nav>
        </section>
    </main>

</body>

</html>