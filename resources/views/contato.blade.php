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
      rel="stylesheet"
    />
  </head>

  <body class="Nunito-Font">
    <!-- Mobile Header -->
    <div class="top-header">
      <img class="mobile-logo-system" src="{{ url('frontend/img/logo-agape.png') }}" alt="Agape" onclick="window.location.href='{{ url('/') }}'" />
      <button class="mobile-toggle" id="mobile-toggle-auth">
        <span></span>
        <span></span>
        <span></span>
      </button>
    </div>

    <!-- Desktop Header -->
    <header id="header-menu">
      <!-- Logo Mobile -->
      <img 
        src="{{url('frontend/img/logo-agape.png')}}" 
        alt="Agape" 
        class="mobile-logo"
        onclick="window.location.href='{{url('/')}}'"
      />
      
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

    <!-- Main Content -->
    <main class="main-contact Nunito-Font">
      <div class="main-left-contact">
        <img 
          id="img-contact" 
          src="{{url('frontend/img/contact-image.png')}}" 
          alt="Imagem de contato" 
        />
      </div>

      <div class="main-right-contact">
        <div class="title-contact">
          <div>Fale com a</div>
          <div class="contact-text-color-form">Agape</div>
        </div>

        @if(session('success'))
          <div class="alert alert-success" style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
            <strong>✅ Sucesso!</strong> {{ session('success') }}
          </div>
        @endif

        @if(session('error'))
          <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
            <strong>❌ Erro!</strong> {{ session('error') }}
          </div>
        @endif

        @if($errors->any())
          <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
            <strong>Erros encontrados:</strong>
            <ul style="margin: 10px 0 0 0; padding-left: 20px;">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif
        
        <form action="https://formsubmit.co/agapeinventory@gmail.com" method="POST" class="form-contact" id="contactForm">
          <!-- FormSubmit configuration -->
          <input type="hidden" name="_subject" value="Nova mensagem do site Agape!" />
          <input type="hidden" name="_next" value="{{ url('views/contato?success=true') }}" />
          <input type="hidden" name="_captcha" value="false" />
          <input type="hidden" name="_template" value="table" />
          <div class="contact-name-form">
            <div>
              <p>Nome</p>
              <input 
                type="text" 
                id="nome"
                name="nome" 
                class="validacao" 
                value="{{ old('nome') }}"
                autocomplete="name"
                required
              />
            </div>
            <div>
              <p>Email</p>
              <input 
                type="email" 
                id="email"
                name="email" 
                class="validacao" 
                value="{{ old('email') }}"
                autocomplete="email"
                required
              />
            </div>
          </div>

          <p>Assunto</p>
          <input 
            type="text" 
            id="assunto"
            name="assunto" 
            class="validacao" 
            value="{{ old('assunto') }}"
            autocomplete="off"
            required
          />

          <p>Mensagem</p>
          <textarea 
            id="mensagem"
            name="mensagem" 
            class="validacao" 
            rows="5" 
            autocomplete="off"
            required
          >{{ old('mensagem') }}</textarea>

          <button type="submit" class="contact-space" id="btn-enviar-contact">
            <span>Enviar Mensagem</span>
            <div class="btn-loading" style="display: none;">
              <div class="loading-spinner"></div>
            </div>
          </button>

          <div class="checkbox-contact">
            <input 
              type="checkbox" 
              id="termos"
              name="termos"
              class="checkbox-validacao" 
              autocomplete="off"
              required 
            />
            <label for="termos">
              Ao enviar esta mensagem, você concorda com nossos
              <a href="#" class="contact-text-color-form">
                Termos de Serviço e Política de Privacidade
              </a>
            </label>
          </div>

          <div class="contact-alternative">
            <div>Ou entre em contato através de:</div>
            <div class="contact-social-links">
              <div class="contact-social-item">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                  <path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7 .9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/>
                </svg>
                <span>(31) 1 2345-6789</span>
              </div>
              <div class="contact-social-item">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                  <path d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48L48 64zM0 176L0 384c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-208L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"/>
                </svg>
                <span>agapeinventory@gmail.com</span>
              </div>
            </div>
          </div>
        </form>
      </div>
    </main>

    <!-- Footer -->
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