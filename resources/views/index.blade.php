<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" />
    <title>Agape</title>
    <link rel="stylesheet" href="{{url('frontend/css/style.css')}}" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />
    <script src="{{url('frontend/js/script.js')}}" defer></script>
  </head>

  <body>
    <header id="header-menu">
      <!-- Logo Mobile -->
      <img 
        src="{{url('frontend/img/logo-agape.png')}}" 
        alt="Agape" 
        class="mobile-logo"
        onclick="scrollToSection('.main-content')"
      />
      
      <div class="left-menu">
        <img
          src="{{url('frontend/img/logo-agape.png')}}"
          alt=""
          onclick="scrollToSection('.main-content')"
        />
        <div onclick="scrollToSection('.main-content')">Início</div>
        <div onclick="scrollToSection('.main-third-content')">
          Funcionalidades
        </div>
        <div onclick="scrollToSection('.main-fifth-content')">Sobre</div>
        <a href="{{url('views/contato')}}">Contato</a>
      </div>
      <div class="right-menu">
        <a href="{{url('views/login')}}" class="btn-logar Nunito-Font">Log In</a>
        <button onclick="goToCadastro()" type="button" class="btn-cadastrar">
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

    <!-- Menu Lateral Mobile -->
    <div class="mobile-menu" id="mobile-menu">
      <div class="mobile-menu-header">
        <img src="{{url('frontend/img/logo-agape.png')}}" alt="Agape" />
        <button class="close-btn" id="close-btn">&times;</button>
      </div>
      <nav class="mobile-menu-nav">
        <a href="#" onclick="scrollToSection('.main-content'); closeMobileMenu()">Início</a>
        <a href="#" onclick="scrollToSection('.main-third-content'); closeMobileMenu()">Funcionalidades</a>
        <a href="#" onclick="scrollToSection('.main-fifth-content'); closeMobileMenu()">Sobre</a>
        <a href="{{url('views/contato')}}">Contato</a>
      </nav>
      <div class="mobile-menu-buttons">
        <a href="{{url('views/login')}}" class="mobile-btn-login">Log In</a>
        <button onclick="goToCadastro()" class="mobile-btn-register">Cadastrar</button>
      </div>
    </div>

    <!-- Overlay -->
    <div class="mobile-menu-overlay" id="mobile-overlay"></div>

    <main class="main-content">
      <section class="left-section">
        <h1>Gerencie seu estoque com <span>Agape</span></h1>
        <p>
          Gestão de estoque descomplicada, eficiente e acessível: com o Ágape,
          você tem controle total dos seus produtos, mais organização no dia a
          dia e decisões mais rápidas — tudo na palma da sua mão.
        </p>

        <button onclick="goToCadastro()" type="submit" class="btn-comecar">
          Começar
        </button>
      </section>
      <section class="right-section">
        <img src="{{url('frontend/img/mulher_e_prateleira_rosa_com_caixas.png')}}" alt="" />
      </section>
    </main>

    <main class="main-second-content">
      <nav class="nav-organizador-estoque">
        <h1>Organizador de Estoque: A Solução para o Seu Negócio</h1>
        <p>
          Um organizador de estoque, também conhecido como sistema de gestão de
          estoque, é uma ferramenta essencial para empresas de todos os tamanhos
          que lidam com produtos físicos. Ele permite controlar, rastrear e
          gerenciar o fluxo de mercadorias, desde a entrada no armazém até a
          saída para o cliente.
        </p>
      </nav>
      <nav class="nav-organizador-estoque-img">
        <img
          src="{{url('frontend/img/Captura_de_tela_2025-06-29_211831-removebg-preview.png')}}"
          alt=""
        />
      </nav>
    </main>

    <main class="main-third-content">
      <h1>Por que escolher <span>Agape</span></h1>

      <!-- Barra de indicadores -->
      <div id="barraItens"></div>

      <!-- Container do carrossel -->
      <div id="carrossel" class="container scrollx">
        <section class="carousel-item">
          <img src="{{url('frontend/img/icon-caminhao.png')}}" alt="Ícone de simplicidade e rapidez" />
          <div>
            <h2>Simples, rápido e sem complicação</h2>
            <p>
              • Interface intuitiva para cadastro e controle de produtos<br />
              • Acompanhamento em tempo real sem complicações<br />
              • Navegação fluida e responsiva em qualquer dispositivo
            </p>
          </div>
        </section>
        <section class="carousel-item">
          <img src="{{url('frontend/img/icon-rastreio.png')}}" alt="Ícone de rastreamento inteligente" />
          <div>
            <h2>Rastreio inteligente de produtos</h2>
            <p>
              • Controle total sobre movimentações e estoque<br />
              • Alertas automáticos para produtos em falta ou vencidos<br />
              • Relatórios detalhados e análises em tempo real
            </p>
          </div>
        </section>
        <section class="carousel-item">
          <img src="{{url('frontend/img/icon-suporte.png')}}" alt="Ícone de suporte humano" />
          <div>
            <h2>Suporte humano especializado</h2>
            <p>
              • Atendimento rápido e personalizado<br />
              • Equipe dedicada ao sucesso do seu negócio<br />
              • Treinamento completo e documentação detalhada
            </p>
          </div>
        </section>
      </div>
    </main>

    <main class="main-fourth-content">
      <!-- Nova seção Requisitos do Sistema -->
      <div class="top-courses-section">
        <div class="top-courses-header">
          <h2>Requisitos do Sistema</h2>
        </div>

        <div class="courses-grid">
          <div class="course-card career-path">
            <div class="course-badge">Gerencial</div>
            <h3>Controle Administrativo Completo</h3>
            <p>
              Gerencie usuários, permissões e configurações do sistema com
              ferramentas administrativas avançadas e interface intuitiva.
            </p>
            <div class="course-meta">
              <span class="difficulty">� Administrativo</span>
              <span class="duration">Alto nível</span>
            </div>
          </div>

          <div class="course-card course">
            <div class="course-badge">Core System</div>
            <h3>Arquitetura do Sistema Agape</h3>
            <p>
              Sistema robusto com tecnologia moderna, banco de dados otimizado e
              arquitetura escalável para atender empresas de todos os tamanhos.
            </p>
            <div class="course-meta">
              <span class="difficulty">⚙️ Tecnologia Core</span>
              <span class="duration">Base do Sistema</span>
            </div>
          </div>

          <div class="course-card certification-path">
            <div class="course-badge">Proteção</div>
            <h3>Segurança e Proteção de Dados</h3>
            <p>
              Criptografia avançada, autenticação de dois fatores, backup
              automático e conformidade com LGPD para máxima proteção.
            </p>
            <div class="course-meta">
              <span class="difficulty">� Segurança</span>
              <span class="duration">Premium</span>
            </div>
          </div>

          <div class="course-card skill-path">
            <div class="course-badge">Autenticação</div>
            <h3>Sistema de Autenticação</h3>
            <p>
              Cadastro simplificado, login seguro, recuperação de senha e
              gerenciamento de sessões para acesso rápido e protegido.
            </p>
            <div class="course-meta">
              <span class="difficulty">� Cadastro/Login</span>
              <span class="duration">Essencial</span>
            </div>
          </div>
        </div>
      </div>
    </main>

    <main class="main-fifth-content">
      <nav class="left-fifth-content">
        <div>Sobre Nós</div>
        <div>
          Transformamos a <span>gestão de estoque</span> em algo simples e
          eficiente
        </div>
        <p>
          Gerenciar estoque não precisa ser complicado. Na Ágape, tornamos esse
          processo mais simples e eficiente com um sistema prático de
          acompanhamento por etapas. Ajudamos negócios de todos os tamanhos a
          organizar melhor seus produtos e otimizar sua operação diária.
        </p>
      </nav>
      <nav class="right-fifth-content">
        <img src="{{url('frontend/img/main-fifth-content-imagemmain.png')}}" alt="" />
      </nav>
    </main>

    <main class="main-sixth-05-content">
      <h1>Junte-se ao melhor gerenciador de estoque!</h1>
    </main>

    <main class="main-sixth-content">
      <nav class="left-sixth-content">
        <img
          src="{{url('frontend/img/main-sixth-content-imagemmain-removebg-preview.png')}}   "
          alt=""
        />
      </nav>
      <nav class="right-sixth-content">
        <h1>Comece grátis</h1>
        <p>
          Se você chegou até aqui, deve estar pelo menos um pouco curioso.
          Inscreva-se e dê o primeiro passo em direção aos seus objetivos.
        </p>
        <button onclick="goToCadastro()" type="submit" class="btn-register-now">
          Começar
        </button>
      </nav>
    </main>

    <footer>
      <nav class="Left-footer">
        <h2>Informações Gerais</h2>
        <div>Serviços</div>
        <div>Quem somos?</div>
        <div>Política de privacidade</div>
        <div>Termos de serviço</div>
      </nav>
      <nav class="Middle-footer">
        <h2>Contatos</h2>
        <div>
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
            <path
              d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7 .9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"
            />
          </svg>
          <span>(31) 1 2345-6789</span>
        </div>
        <div>
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            <path
              d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48L48 64zM0 176L0 384c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-208L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"
            />
          </svg>
          <span>agapeinventory@gmail.com</span>
        </div>
        <div>
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
            <path
              d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"
            />
          </svg>
          <span>@agape_inventory</span>
        </div>
      </nav>
      <nav class="Right-footer">
        <h2>Fale Conosco</h2>
        <form class="contact-form">
          <input type="text" id="nome" placeholder="Digite seu nome" required />
          <input
            type="email"
            id="email"
            placeholder="Digite seu email"
            required
          />
          <button type="submit" class="btn-enviar">Enviar</button>
        </form>
      </nav>
    </footer>
  </body>
</html>
