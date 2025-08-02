function goToCadastro() {
  window.location.href = "register.html";
}

function goToLogin() {
  window.location.href = "login.html";
}

// Função para navegação suave entre seções
function scrollToSection(sectionClass) {
  const section = document.querySelector(sectionClass);
  if (section) {
    const headerHeight = document.querySelector("#header-menu").offsetHeight;
    const targetPosition = section.offsetTop - headerHeight;

    window.scrollTo({
      top: targetPosition,
      behavior: "smooth",
    });
  }
}

// Função para controlar o header durante scroll
function handleHeaderScroll() {
  const header = document.querySelector("header");
  const headerMenu = document.getElementById("header-menu");
  const scrollThreshold = 80; // Pixels de scroll antes da transição

  if (window.scrollY > scrollThreshold) {
    header.classList.add("scrolled");
    headerMenu.classList.add("scrolled");
  } else {
    header.classList.remove("scrolled");
    headerMenu.classList.remove("scrolled");
  }
}

// Throttle function para otimizar performance
function throttle(func, limit) {
  let inThrottle;
  return function () {
    const args = arguments;
    const context = this;
    if (!inThrottle) {
      func.apply(context, args);
      inThrottle = true;
      setTimeout(() => (inThrottle = false), limit);
    }
  };
}

// Versão otimizada da função de scroll
const optimizedHeaderScroll = throttle(handleHeaderScroll, 10);

function validateFields() {
  const campos = document.querySelectorAll(".validacao");
  const botao = document.getElementById("btn-Cadastrar-Register");

  const temCampoVazio = Array.from(campos).some(
    (campo) => campo.value.trim() === ""
  );

  if (temCampoVazio) {
    botao.disabled = true;
  } else {
    botao.disabled = false;
  }
}

// Inicialização do carrossel horizontal
function initHorizontalCarousel() {
  const carrossel = document.getElementById("carrossel");
  const barraItens = document.getElementById("barraItens");
  const thirdSection = document.querySelector(".main-third-content");
  const autoIndicator = document.getElementById("autoIndicator");

  if (!carrossel || !barraItens || !thirdSection) return;

  const items = carrossel.querySelectorAll(".carousel-item");

  // Variáveis para controle automático
  let autoScrollInterval;
  let userInteractionTime = 0;
  let isUserInteracting = false;
  const AUTO_SCROLL_DELAY = 4000; // 4 segundos entre mudanças automáticas
  const USER_INTERACTION_TIMEOUT = 8000; // 8 segundos após interação do usuário

  // Criar segmentos da barra de indicadores
  items.forEach((_, idx) => {
    const seg = document.createElement("div");
    barraItens.appendChild(seg);
    seg.addEventListener("click", () => {
      resetUserInteraction();
      scrollToItem(idx);
    });
  });

  const segmentos = barraItens.children;

  // Função para resetar interação do usuário
  function resetUserInteraction() {
    isUserInteracting = true;
    userInteractionTime = Date.now();
    clearInterval(autoScrollInterval);
    stopAutoScroll(); // Garantir que o indicador suma

    // Reiniciar auto-scroll após período de inatividade
    setTimeout(() => {
      if (Date.now() - userInteractionTime >= USER_INTERACTION_TIMEOUT) {
        isUserInteracting = false;
        if (isCarouselCentered) {
          startAutoScroll();
        }
      }
    }, USER_INTERACTION_TIMEOUT);
  }

  // Função para iniciar scroll automático
  function startAutoScroll() {
    if (autoScrollInterval) clearInterval(autoScrollInterval);

    // Mostrar indicador
    if (autoIndicator) {
      autoIndicator.classList.add("visible");
    }

    autoScrollInterval = setInterval(() => {
      if (!isUserInteracting && isCarouselCentered) {
        const currentIndex = Math.round(
          carouselScrollPosition / (items[0].offsetWidth + 100)
        );
        const nextIndex = (currentIndex + 1) % items.length;
        scrollToItem(nextIndex);
      }
    }, AUTO_SCROLL_DELAY);
  }

  // Função para parar scroll automático
  function stopAutoScroll() {
    clearInterval(autoScrollInterval);

    // Esconder indicador
    if (autoIndicator) {
      autoIndicator.classList.remove("visible");
    }
  }

  // Função para atualizar a barra de indicadores
  function atualizarBarra() {
    const scrollLeft = carrossel.scrollLeft;
    const itemWidth = items[0].offsetWidth + 100; // largura do item + gap
    const currentIndex = Math.round(scrollLeft / itemWidth);

    Array.from(segmentos).forEach((s, i) => {
      s.classList.remove("active");
      if (i === currentIndex) {
        s.classList.add("active");
        // Adicionar animação de pulso para indicar mudança
        s.style.transform = "scale(1.2)";
        setTimeout(() => {
          s.style.transform = "scale(1)";
        }, 300);
      }
    });
  }

  // Função para rolar para um item específico com animação melhorada
  function scrollToItem(index) {
    const itemWidth = items[0].offsetWidth + 100; // largura do item + gap
    const targetScrollLeft = index * itemWidth;

    // Adicionar classe de transição suave temporariamente
    carrossel.style.scrollBehavior = "smooth";
    carrossel.scrollTo({
      left: targetScrollLeft,
      behavior: "smooth",
    });

    carouselScrollPosition = targetScrollLeft; // Sincronizar com nossa variável

    // Remover scroll-behavior após animação para não interferir com drag
    setTimeout(() => {
      carrossel.style.scrollBehavior = "auto";
    }, 500);
  }

  // Event listeners
  carrossel.addEventListener("scroll", atualizarBarra);

  // Ativar primeiro item
  if (segmentos.length > 0) {
    segmentos[0].classList.add("active");
  }

  // Variáveis para controle do scroll
  let isInCarouselArea = false;
  let carouselScrollPosition = 0;
  let isCarouselCentered = false;

  // Função para detectar se estamos na área do carrossel e se está centralizado
  function checkCarouselArea() {
    const rect = thirdSection.getBoundingClientRect();
    const windowHeight = window.innerHeight;

    // Verificar se a seção está visível na tela
    const wasInCarouselArea = isInCarouselArea;
    isInCarouselArea =
      rect.top <= windowHeight * 0.2 && rect.bottom >= windowHeight * 0.8;

    // Verificar se o carrossel está mais centralizado (entre 10% e 90% da tela)
    const wasCentered = isCarouselCentered;
    isCarouselCentered =
      rect.top <= windowHeight * 0.1 && rect.bottom >= windowHeight * 0.9;

    // Gerenciar auto-scroll baseado na visibilidade
    if (isCarouselCentered && !wasCentered) {
      // Carrossel ficou centralizado - iniciar auto-scroll se não há interação
      if (!isUserInteracting) {
        startAutoScroll();
      }
    } else if (!isCarouselCentered && wasCentered) {
      // Carrossel saiu do centro - parar auto-scroll
      stopAutoScroll();
    }
  }

  // Event listener principal para scroll da página
  window.addEventListener(
    "wheel",
    (e) => {
      checkCarouselArea();

      if (isInCarouselArea) {
        // Parar auto-scroll quando usuário interage
        resetUserInteraction();

        // Se o carrossel não está centralizado, apenas centralizar a seção
        if (!isCarouselCentered) {
          // Permitir que a página role normalmente para centralizar o carrossel
          return;
        }

        // Agora que está centralizado, ativar scroll horizontal
        e.preventDefault();

        const deltaY = e.deltaY;
        const maxScrollLeft = carrossel.scrollWidth - carrossel.clientWidth;

        // Converter scroll vertical em horizontal com easing
        const scrollSpeed = 3;
        let targetPosition = carouselScrollPosition + deltaY * scrollSpeed;

        // Limitar dentro dos bounds com margem para permitir saída
        if (targetPosition < -50) {
          // Se tentar scrollar muito para trás, permitir scroll da página para cima
          carouselScrollPosition = 0;
          carrossel.scrollLeft = 0;
          isInCarouselArea = false;
          window.scrollBy(0, deltaY);
          return;
        }

        if (targetPosition > maxScrollLeft + 50) {
          // Se tentar scrollar muito para frente, permitir scroll da página para baixo
          carouselScrollPosition = maxScrollLeft;
          carrossel.scrollLeft = maxScrollLeft;
          isInCarouselArea = false;
          window.scrollBy(0, deltaY);
          return;
        }

        // Aplicar scroll normal dentro dos limites com suavização
        carouselScrollPosition = Math.max(
          0,
          Math.min(targetPosition, maxScrollLeft)
        );

        // Smooth scroll para melhor experiência
        carrossel.scrollTo({
          left: carouselScrollPosition,
          behavior: "auto",
        });
        atualizarBarra();
      }
    },
    { passive: false }
  );

  // Event listener para scroll da página (para detectar área)
  window.addEventListener("scroll", () => {
    checkCarouselArea();
    // Sincronizar posição do carrossel com scroll real
    carouselScrollPosition = carrossel.scrollLeft;
  });

  // Suporte para navegação por teclado melhorado
  window.addEventListener("keydown", (e) => {
    if (isInCarouselArea && isCarouselCentered) {
      resetUserInteraction();

      if (e.key === "ArrowLeft") {
        e.preventDefault();
        const currentIndex = Math.round(
          carouselScrollPosition / (items[0].offsetWidth + 100)
        );
        if (currentIndex > 0) {
          scrollToItem(currentIndex - 1);
        }
      } else if (e.key === "ArrowRight") {
        e.preventDefault();
        const currentIndex = Math.round(
          carouselScrollPosition / (items[0].offsetWidth + 100)
        );
        if (currentIndex < items.length - 1) {
          scrollToItem(currentIndex + 1);
        }
      } else if (e.key === "Home") {
        e.preventDefault();
        scrollToItem(0);
      } else if (e.key === "End") {
        e.preventDefault();
        scrollToItem(items.length - 1);
      }
    }
  });

  // Suporte para arrastar com mouse melhorado
  let isDragging = false;
  let startX = 0;
  let scrollLeftStart = 0;
  let dragStartTime = 0;

  carrossel.addEventListener("mousedown", (e) => {
    isDragging = true;
    startX = e.pageX;
    scrollLeftStart = carrossel.scrollLeft;
    dragStartTime = Date.now();
    carrossel.style.cursor = "grabbing";
    carrossel.style.userSelect = "none";
    resetUserInteraction();
  });

  carrossel.addEventListener("mousemove", (e) => {
    if (!isDragging) return;
    e.preventDefault();

    const deltaX = e.pageX - startX;
    const newScrollLeft = scrollLeftStart - deltaX;
    carrossel.scrollLeft = newScrollLeft;
    carouselScrollPosition = newScrollLeft;
  });

  carrossel.addEventListener("mouseup", (e) => {
    if (isDragging) {
      isDragging = false;
      carrossel.style.cursor = "grab";
      carrossel.style.userSelect = "auto";

      // Implementar snap-to-item após drag
      const dragDistance = Math.abs(e.pageX - startX);
      const dragDuration = Date.now() - dragStartTime;

      // Se foi um drag rápido ou significativo, fazer snap
      if (dragDistance > 50 || dragDuration < 200) {
        const itemWidth = items[0].offsetWidth + 100;
        const currentIndex = Math.round(carouselScrollPosition / itemWidth);
        scrollToItem(currentIndex);
      }
    }
  });
  carrossel.addEventListener("mouseleave", () => {
    if (isDragging) {
      isDragging = false;
      carrossel.style.cursor = "grab";
      carrossel.style.userSelect = "auto";
    }
  });

  // Suporte para touch/swipe em dispositivos móveis
  let touchStartX = 0;
  let touchStartTime = 0;

  carrossel.addEventListener("touchstart", (e) => {
    touchStartX = e.touches[0].clientX;
    touchStartTime = Date.now();
    resetUserInteraction();
  });

  carrossel.addEventListener("touchmove", (e) => {
    if (!touchStartX) return;

    const touchX = e.touches[0].clientX;
    const deltaX = touchStartX - touchX;
    carrossel.scrollLeft = carouselScrollPosition + deltaX;
  });

  carrossel.addEventListener("touchend", (e) => {
    if (!touchStartX) return;

    const touchEndX = e.changedTouches[0].clientX;
    const deltaX = touchStartX - touchEndX;
    const touchDuration = Date.now() - touchStartTime;

    touchStartX = 0;

    // Implementar swipe gesture
    if (Math.abs(deltaX) > 50 && touchDuration < 300) {
      const currentIndex = Math.round(
        carouselScrollPosition / (items[0].offsetWidth + 100)
      );
      if (deltaX > 0 && currentIndex < items.length - 1) {
        scrollToItem(currentIndex + 1);
      } else if (deltaX < 0 && currentIndex > 0) {
        scrollToItem(currentIndex - 1);
      }
    } else {
      // Snap to nearest item
      const itemWidth = items[0].offsetWidth + 100;
      const currentIndex = Math.round(carrossel.scrollLeft / itemWidth);
      scrollToItem(currentIndex);
    }
  });

  // Definir cursor inicial
  carrossel.style.cursor = "grab";

  // Pause auto-scroll when mouse is over carousel
  carrossel.addEventListener("mouseenter", () => {
    if (isCarouselCentered) {
      resetUserInteraction();
    }
  });

  // Resume auto-scroll when mouse leaves (após delay)
  carrossel.addEventListener("mouseleave", () => {
    setTimeout(() => {
      if (!isUserInteracting && isCarouselCentered) {
        startAutoScroll();
      }
    }, 2000);
  });

  // Inicialização
  checkCarouselArea();
  carouselScrollPosition = carrossel.scrollLeft;
  atualizarBarra();

  // Iniciar auto-scroll se já estiver centralizado
  if (isCarouselCentered) {
    startAutoScroll();
  }
}

document.addEventListener("DOMContentLoaded", function () {
  // Validação de campos (para página de cadastro)
  const campos = document.querySelectorAll(".validacao");

  if (campos.length > 0) {
    validateFields();

    campos.forEach((campo) => {
      campo.addEventListener("input", validateFields);
    });
  }

  // Inicializar carrossel horizontal (para página inicial)
  initHorizontalCarousel();

  // Inicializar controle do header
  handleHeaderScroll(); // Executa uma vez para definir estado inicial
  window.addEventListener("scroll", optimizedHeaderScroll);
});
