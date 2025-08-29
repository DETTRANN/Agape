function goToCadastro() {
    window.location.href = "/views/register";
}

function goToLogin() {
    window.location.href = "/views/login";
}

function goToSystem() {
    window.location.href = "/views/system";
}

function goToResetPassword() {
    window.location.href = "/views/pwdreset";
}

// Função para navegação suave entre seções
function scrollToSection(sectionClass) {
    const section = document.querySelector(sectionClass);
    if (section) {
        const headerHeight =
            document.querySelector("#header-menu").offsetHeight;
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

// Cache de elementos DOM para validação
let validationElements = null;

function initializeValidationElements() {
    if (!validationElements) {
        validationElements = {
            campos: document.querySelectorAll(".validacao"),
            checkbox: document.querySelectorAll(".checkbox-validacao"),
            botao: document.getElementById("btn-Cadastrar-Register"),
        };
    }
    return validationElements;
}

// Cache de elementos DOM para validação da página de redefinição de senha
let pwdRedefinitionValidationElements = null;

function initializePwdRedefinitionValidationElements() {
    if (!pwdRedefinitionValidationElements) {
        pwdRedefinitionValidationElements = {
            campos: document.querySelectorAll("#resetForm .validacao"),
            checkbox: document.querySelectorAll(
                "#resetForm .checkbox-validacao"
            ),
            botao: document.getElementById("btn-reset-password"),
        };
    }
    return pwdRedefinitionValidationElements;
}

// Cache de elementos DOM para validação da página de nova senha
let pwdResetValidationElements = null;

function initializePwdResetValidationElements() {
    if (!pwdResetValidationElements) {
        pwdResetValidationElements = {
            campos: document.querySelectorAll("#newPasswordForm .validacao"),
            checkbox: document.querySelectorAll(
                "#newPasswordForm .checkbox-validacao"
            ),
            botao: document.getElementById("btn-new-password"),
        };
    }
    return pwdResetValidationElements;
}

// Cache de elementos DOM para validação da página de login
let loginValidationElements = null;

function initializeLoginValidationElements() {
    if (!loginValidationElements) {
        loginValidationElements = {
            campos: document.querySelectorAll("#loginForm .validacao"),
            checkbox: document.querySelectorAll(
                "#loginForm .checkbox-validacao"
            ),
            botao: document.getElementById("btn-logar-login"),
        };
    }
    return loginValidationElements;
}

function validateFields() {
    const { campos, checkbox, botao } = initializeValidationElements();

    // Debug: verificar se elementos estão sendo encontrados
    console.log("Campos encontrados:", campos.length);
    console.log("Checkboxes encontrados:", checkbox.length);
    console.log("Botão encontrado:", botao ? "Sim" : "Não");

    const temCampoVazio = Array.from(campos).some(
        (campo) => campo.value.trim() === ""
    );

    const CheckboxNaoMarcado = Array.from(checkbox).some((cb) => !cb.checked);

    console.log("Tem campo vazio:", temCampoVazio);
    console.log("Checkbox não marcado:", CheckboxNaoMarcado);

    if (botao) {
        if (temCampoVazio || CheckboxNaoMarcado) {
            botao.disabled = true;
            console.log("Botão desabilitado");
        } else {
            botao.disabled = false;
            console.log("Botão habilitado");
        }
    }
}

// Função de validação para página de redefinição de senha
function validatePwdRedefinitionFields() {
    const { campos, checkbox, botao } =
        initializePwdRedefinitionValidationElements();

    const temCampoVazio = Array.from(campos).some(
        (campo) => campo.value.trim() === ""
    );

    const CheckboxNaoMarcado = Array.from(checkbox).some((cb) => !cb.checked);

    if (botao) {
        if (temCampoVazio || CheckboxNaoMarcado) {
            botao.disabled = true;
        } else {
            botao.disabled = false;
        }
    }
}

// Função de validação para página de nova senha
function validatePwdResetFields() {
    const { campos, checkbox, botao } = initializePwdResetValidationElements();

    const temCampoVazio = Array.from(campos).some(
        (campo) => campo.value.trim() === ""
    );

    const CheckboxNaoMarcado = Array.from(checkbox).some((cb) => !cb.checked);

    if (botao) {
        if (temCampoVazio || CheckboxNaoMarcado) {
            botao.disabled = true;
        } else {
            botao.disabled = false;
        }
    }
}

// Função de validação para página de login
function validateLoginFields() {
    const { campos, checkbox, botao } = initializeLoginValidationElements();

    const temCampoVazio = Array.from(campos).some(
        (campo) => campo.value.trim() === ""
    );

    const CheckboxNaoMarcado = Array.from(checkbox).some((cb) => !cb.checked);

    if (botao) {
        if (temCampoVazio || CheckboxNaoMarcado) {
            botao.disabled = true;
        } else {
            botao.disabled = false;
        }
    }
}

// Inicialização do carrossel horizontal
function initHorizontalCarousel() {
    const carrossel = document.getElementById("carrossel");
    const barraItens = document.getElementById("barraItens");
    const thirdSection = document.querySelector(".main-third-content");

    if (!carrossel || !barraItens || !thirdSection) return;

    const items = carrossel.querySelectorAll(".carousel-item");

    // Criar segmentos da barra de indicadores
    items.forEach((_, idx) => {
        const seg = document.createElement("div");
        barraItens.appendChild(seg);
        seg.addEventListener("click", () => {
            // MANUAL: Removido resetUserInteraction - apenas scroll direto
            scrollToItem(idx);
        });
    });

    const segmentos = barraItens.children;

    // MANUAL: Funções de auto-scroll removidas para controle 100% manual

    /* ========================================================================
       MELHORIAS IMPLEMENTADAS NO JAVASCRIPT:
       
       1. Transições mais suaves com cubic-bezier otimizado
       2. Debounce para evitar chamadas excessivas de funções
       3. RequestAnimationFrame para animações mais fluidas
       4. Interpolação suave para scroll customizado
       5. Performance otimizada com throttle nas atualizações
       6. NOVO: Controle 100% manual sem auto-scroll
       ======================================================================== */

    // FLUIDO: Função ultra otimizada para atualizar a barra com suavidade
    let updateBarThrottle = null;
    function atualizarBarra() {
        if (updateBarThrottle) return;

        updateBarThrottle = requestAnimationFrame(() => {
            const scrollLeft = carrossel.scrollLeft;
            const itemWidth = items[0].offsetWidth + 120;
            const currentIndex = Math.round(scrollLeft / itemWidth);

            Array.from(segmentos).forEach((s, i) => {
                s.classList.remove("active");
                if (i === currentIndex) {
                    s.classList.add("active");
                    // FLUIDO: Animação mais suave e responsiva
                    s.style.transition =
                        "all 0.25s cubic-bezier(0.25, 0.46, 0.45, 0.94)";
                    s.style.transform = "scale(1.1)";
                    s.style.boxShadow = "0 4px 20px rgba(255, 211, 0, 0.6)";

                    setTimeout(() => {
                        s.style.transform = "scale(1)";
                        s.style.boxShadow = "0 4px 20px rgba(255, 211, 0, 0.5)";
                    }, 100); // Mais rápido - 100ms para fluidez
                }
            });
            updateBarThrottle = null;
        });
    }

    // PERFORMANCE: Função de scroll DRAMATICAMENTE simplificada
    function scrollToItem(index) {
        const itemWidth = items[0].offsetWidth + 120;
        const targetScrollLeft = index * itemWidth;

        // PERFORMANCE: Usar scroll nativo que é mais otimizado
        carrossel.scrollTo({
            left: targetScrollLeft,
            behavior: "smooth",
        });

        carouselScrollPosition = targetScrollLeft;
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
        // MANUAL: Auto-scroll removido - controle 100% manual
        // if (isCarouselCentered && !wasCentered) {
        //     if (!isUserInteracting) {
        //         startAutoScroll();
        //     }
        // } else if (!isCarouselCentered && wasCentered) {
        //     stopAutoScroll();
        // }
    }

    // SCROLL: Event listener ULTRA FLUIDO para transições suaves
    window.addEventListener(
        "wheel",
        (e) => {
            checkCarouselArea();

            if (isInCarouselArea && isCarouselCentered) {
                const deltaY = e.deltaY;
                const maxScrollLeft =
                    carrossel.scrollWidth - carrossel.clientWidth;

                // FLUIDO: Velocidade mais suave - reduzida de 2 para 1.5
                let targetPosition = carouselScrollPosition + deltaY * 1.5;

                // SCROLL: Verificar se estamos nos limites do carrossel
                const isAtStart = carouselScrollPosition <= 0;
                const isAtEnd = carouselScrollPosition >= maxScrollLeft;

                // Se tentando scrollar para trás no início OU para frente no final
                if ((isAtStart && deltaY < 0) || (isAtEnd && deltaY > 0)) {
                    // PERMITIR scroll da página continuar naturalmente
                    isInCarouselArea = false;
                    // NÃO preventDefault - deixar o scroll da página funcionar
                    return;
                }

                // Caso contrário, controlar o carrossel normalmente
                e.preventDefault();

                if (targetPosition < 0) {
                    carouselScrollPosition = 0;
                } else if (targetPosition > maxScrollLeft) {
                    carouselScrollPosition = maxScrollLeft;
                } else {
                    carouselScrollPosition = targetPosition;
                }

                // FLUIDO: Aplicar scroll com transição mais suave
                carrossel.scrollTo({
                    left: carouselScrollPosition,
                    behavior: "auto",
                });

                atualizarBarra();
            }
        },
        { passive: false }
    );

    // Event listener para carousel area detection
    window.addEventListener("scroll", () => {
        // Carousel area detection
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
                    carouselScrollPosition / (items[0].offsetWidth + 120)
                );
                if (currentIndex > 0) {
                    scrollToItem(currentIndex - 1);
                }
            } else if (e.key === "ArrowRight") {
                e.preventDefault();
                const currentIndex = Math.round(
                    carouselScrollPosition / (items[0].offsetWidth + 120)
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
                const itemWidth = items[0].offsetWidth + 120;
                const currentIndex = Math.round(
                    carouselScrollPosition / itemWidth
                );
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
                carouselScrollPosition / (items[0].offsetWidth + 120)
            );
            if (deltaX > 0 && currentIndex < items.length - 1) {
                scrollToItem(currentIndex + 1);
            } else if (deltaX < 0 && currentIndex > 0) {
                scrollToItem(currentIndex - 1);
            }
        } else {
            // Snap to nearest item
            const itemWidth = items[0].offsetWidth + 120;
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

    // MANUAL: Auto-scroll removido - controle 100% manual
    // carrossel.addEventListener("mouseleave", () => {
    //     setTimeout(() => {
    //         if (!isUserInteracting && isCarouselCentered) {
    //             startAutoScroll();
    //         }
    //     }, 2000);
    // });

    // Inicialização
    checkCarouselArea();
    carouselScrollPosition = carrossel.scrollLeft;
    atualizarBarra();

    // MANUAL: Auto-scroll removido - inicialização manual apenas
    // if (isCarouselCentered) {
    //     startAutoScroll();
    // }
}

document.addEventListener("DOMContentLoaded", function () {
    // ========================================================================
    // CONFIGURAÇÃO GLOBAL DO HEADER SCROLL - Para todas as páginas
    // ========================================================================

    // Inicializar controle do header em todas as páginas
    handleHeaderScroll(); // Executa uma vez para definir estado inicial

    // Event listener global de scroll para o header
    window.addEventListener("scroll", optimizedHeaderScroll);

    // ========================================================================
    // FUNCIONALIDADES ESPECÍFICAS POR PÁGINA
    // ========================================================================

    // Validação de campos (para página de cadastro)
    const { campos, checkbox: checkboxes } = initializeValidationElements();

    if (campos.length > 0) {
        validateFields();

        // Event listeners para campos de input
        campos.forEach((campo) => {
            campo.addEventListener("input", validateFields);
        });

        // Event listeners para checkboxes
        checkboxes.forEach((checkbox) => {
            checkbox.addEventListener("change", validateFields);
        });
    }

    // Validação para página de redefinição de senha
    const camposPwdRedefinition = document.querySelectorAll(
        "#resetForm .validacao"
    );
    const checkboxesPwdRedefinition = document.querySelectorAll(
        "#resetForm .checkbox-validacao"
    );

    if (camposPwdRedefinition.length > 0) {
        validatePwdRedefinitionFields();

        // Event listeners para campos de input da redefinição
        camposPwdRedefinition.forEach((campo) => {
            campo.addEventListener("input", validatePwdRedefinitionFields);
        });

        // Event listeners para checkboxes da redefinição
        checkboxesPwdRedefinition.forEach((checkbox) => {
            checkbox.addEventListener("change", validatePwdRedefinitionFields);
        });
    }

    // Validação para página de nova senha
    const camposPwdReset = document.querySelectorAll(
        "#newPasswordForm .validacao"
    );
    const checkboxesPwdReset = document.querySelectorAll(
        "#newPasswordForm .checkbox-validacao"
    );

    if (camposPwdReset.length > 0) {
        validatePwdResetFields();

        // Event listeners para campos de input da nova senha
        camposPwdReset.forEach((campo) => {
            campo.addEventListener("input", validatePwdResetFields);
        });

        // Event listeners para checkboxes da nova senha
        checkboxesPwdReset.forEach((checkbox) => {
            checkbox.addEventListener("change", validatePwdResetFields);
        });
    }

    // Validação para página de login
    const camposLogin = document.querySelectorAll("#loginForm .validacao");
    const checkboxesLogin = document.querySelectorAll(
        "#loginForm .checkbox-validacao"
    );

    if (camposLogin.length > 0) {
        validateLoginFields();

        // Event listeners para campos de input do login
        camposLogin.forEach((campo) => {
            campo.addEventListener("input", validateLoginFields);
        });

        // Event listeners para checkboxes do login
        checkboxesLogin.forEach((checkbox) => {
            checkbox.addEventListener("change", validateLoginFields);
        });
    }

    // Inicializar carrossel horizontal (para página inicial)
    initHorizontalCarousel();

    // Inicializar dropdown do usuário
    initUserDropdown();
});

// ========================================================================
// DROPDOWN DO USUÁRIO - Funcionalidade consolidada do dropdown-test.js
// ========================================================================

// Função para inicializar o dropdown do usuário
function initUserDropdown() {
    console.log("Inicializando dropdown do usuário...");

    const dropdown = document.querySelector(".header-sections-person.dropdown");
    const userIcon = dropdown?.querySelector(".user-icon");
    const userMenu = dropdown?.querySelector(".user-menu");

    console.log("Dropdown encontrado:", dropdown);
    console.log("User icon encontrado:", userIcon);
    console.log("User menu encontrado:", userMenu);

    if (!dropdown || !userIcon || !userMenu) {
        console.log("Elementos do dropdown não encontrados!");
        return;
    }

    // Verificar se já foi inicializado para evitar duplicação de event listeners
    if (dropdown.hasAttribute("data-listeners-added")) {
        console.log("Dropdown já foi inicializado!");
        return;
    }

    dropdown.setAttribute("data-listeners-added", "true");
    console.log("Adicionando event listeners ao dropdown...");

    // Toggle do menu ao clicar no ícone
    userIcon.addEventListener("click", (e) => {
        console.log("Clique no ícone do usuário detectado!");
        e.preventDefault();
        e.stopPropagation();
        userMenu.classList.toggle("menu-open");

        // Controlar outros elementos quando dropdown aberto
        if (userMenu.classList.contains("menu-open")) {
            document.body.classList.add("dropdown-open");
            console.log("Menu aberto!");
        } else {
            document.body.classList.remove("dropdown-open");
            console.log("Menu fechado!");
        }
    });

    // Fechar menu ao clicar em qualquer item
    const menuItems = userMenu.querySelectorAll(".menu-item");
    menuItems.forEach((item) => {
        item.addEventListener("click", (e) => {
            e.stopPropagation();

            // Verificar qual item foi clicado
            const itemText = item.querySelector("span").textContent;

            switch (itemText) {
                case "Perfil":
                    console.log("Navegando para perfil...");
                    // window.location.href = 'profile.html';
                    break;
                case "Configurações":
                    console.log("Abrindo configurações...");
                    // window.location.href = 'settings.html';
                    break;
                case "Contato":
                    console.log("Abrindo contato...");
                    // window.location.href = 'contact.html';
                    break;
                case "Termos de Uso":
                    console.log("Mostrando termos de uso...");
                    // window.location.href = 'terms.html';
                    break;
                case "Log out":
                    console.log("Fazendo logout...");
                    // Aqui você pode adicionar a lógica de logout
                    // window.location.href = 'login.html';
                    break;
            }

            // Fechar o menu após clique
            userMenu.classList.remove("menu-open");
            document.body.classList.remove("dropdown-open");
        });
    });

    // Fechar menu ao clicar fora
    document.addEventListener("click", (e) => {
        if (!dropdown.contains(e.target)) {
            userMenu.classList.remove("menu-open");
            document.body.classList.remove("dropdown-open");
        }
    });

    // Fechar menu com tecla ESC
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape" && userMenu.classList.contains("menu-open")) {
            userMenu.classList.remove("menu-open");
            document.body.classList.remove("dropdown-open");
        }
    });
}

// Inicialização independente do dropdown (para todas as páginas)
// Esta inicialização garante que o dropdown funcione mesmo se outras funções falharem
document.addEventListener("DOMContentLoaded", function () {
    console.log("Inicialização independente do dropdown...");

    // Verificar se ainda não foi inicializado
    const dropdown = document.querySelector(".header-sections-person.dropdown");
    if (dropdown && !dropdown.hasAttribute("data-dropdown-initialized")) {
        dropdown.setAttribute("data-dropdown-initialized", "true");
        initUserDropdown();
    }
});

// ========================================================================
// FORMULÁRIO DE CONTATO - Funcionalidade para página de contato
// ========================================================================

// Função para inicializar o formulário de contato
function initContactForm() {
    const contactForm = document.getElementById("contactForm");
    const btnEnviar = document.getElementById("btn-enviar-contact");

    if (!contactForm || !btnEnviar) return;

    console.log("Formulário de contato inicializado");

    // Adicionar validação em tempo real
    const campos = contactForm.querySelectorAll(".validacao");
    const checkbox = contactForm.querySelector(".checkbox-validacao");

    function validateContactForm() {
        const temCampoVazio = Array.from(campos).some(
            (campo) => campo.value.trim() === ""
        );
        const checkboxNaoMarcado = checkbox && !checkbox.checked;

        if (btnEnviar) {
            if (temCampoVazio || checkboxNaoMarcado) {
                btnEnviar.disabled = true;
                btnEnviar.style.opacity = "0.5";
            } else {
                btnEnviar.disabled = false;
                btnEnviar.style.opacity = "1";
            }
        }
    }

    // Adicionar event listeners para validação em tempo real
    campos.forEach((campo) => {
        campo.addEventListener("input", validateContactForm);
    });

    if (checkbox) {
        checkbox.addEventListener("change", validateContactForm);
    }

    // Validação inicial
    validateContactForm();

    contactForm.addEventListener("submit", function (e) {
        e.preventDefault();

        const btnText = btnEnviar.querySelector("span");
        const btnLoading = btnEnviar.querySelector(".btn-loading");

        // Mostrar loading
        if (btnText && btnLoading) {
            btnText.style.display = "none";
            btnLoading.style.display = "block";
        }
        btnEnviar.disabled = true;

        // Simular envio (substituir por requisição real)
        setTimeout(() => {
            // Resetar botão
            if (btnText && btnLoading) {
                btnText.style.display = "block";
                btnLoading.style.display = "none";
            }
            btnEnviar.disabled = false;

            // Mostrar sucesso
            showContactSuccess();

            // Limpar formulário
            contactForm.reset();

            // Revalidar após reset
            validateContactForm();
        }, 2000);
    });
}

// Função para mostrar mensagem de sucesso
function showContactSuccess() {
    // Criar elemento de sucesso
    const successMessage = document.createElement("div");
    successMessage.className = "contact-success";
    successMessage.innerHTML = `
        <div class="success-content">
            <div class="success-icon">✓</div>
            <h3>Mensagem enviada com sucesso!</h3>
            <p>Entraremos em contato em breve.</p>
        </div>
    `;

    // Adicionar estilos
    successMessage.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: linear-gradient(135deg, #10dc60 0%, #16ba5a 100%);
        color: white;
        padding: 20px 24px;
        border-radius: 12px;
        box-shadow: 0 8px 32px rgba(16, 220, 96, 0.3);
        z-index: 10000;
        transform: translateX(400px);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    `;

    const successContent = successMessage.querySelector(".success-content");
    successContent.style.cssText = `
        display: flex;
        align-items: center;
        gap: 12px;
    `;

    const successIcon = successMessage.querySelector(".success-icon");
    successIcon.style.cssText = `
        width: 24px;
        height: 24px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 14px;
    `;

    const successTitle = successMessage.querySelector("h3");
    successTitle.style.cssText = `
        margin: 0;
        font-size: 16px;
        font-weight: 600;
    `;

    const successText = successMessage.querySelector("p");
    successText.style.cssText = `
        margin: 0;
        font-size: 14px;
        opacity: 0.9;
    `;

    document.body.appendChild(successMessage);

    // Animar entrada
    setTimeout(() => {
        successMessage.style.transform = "translateX(0)";
    }, 100);

    // Remover após 4 segundos
    setTimeout(() => {
        successMessage.style.transform = "translateX(400px)";
        setTimeout(() => {
            document.body.removeChild(successMessage);
        }, 300);
    }, 4000);
}

// Inicializar formulário de contato quando a página carregar
document.addEventListener("DOMContentLoaded", function () {
    initContactForm();
    initMobileMenu();
});

/* ===============================================
   MENU HAMBURGER MOBILE
   =============================================== */

function initMobileMenu() {
    const hamburgerBtn = document.getElementById("hamburger-btn");
    const mobileMenu = document.getElementById("mobile-menu");
    const mobileOverlay = document.getElementById("mobile-overlay");
    const closeBtn = document.getElementById("close-btn");

    if (hamburgerBtn && mobileMenu && mobileOverlay && closeBtn) {
        // Abrir menu
        hamburgerBtn.addEventListener("click", openMobileMenu);

        // Fechar menu
        closeBtn.addEventListener("click", closeMobileMenu);
        mobileOverlay.addEventListener("click", closeMobileMenu);

        // Fechar menu com ESC
        document.addEventListener("keydown", function (e) {
            if (e.key === "Escape" && mobileMenu.classList.contains("active")) {
                closeMobileMenu();
            }
        });
    }
}

function openMobileMenu() {
    const hamburgerBtn = document.getElementById("hamburger-btn");
    const mobileMenu = document.getElementById("mobile-menu");
    const mobileOverlay = document.getElementById("mobile-overlay");

    hamburgerBtn.classList.add("active");
    mobileMenu.classList.add("active");
    mobileOverlay.classList.add("active");

    // Prevenir scroll do body
    document.body.style.overflow = "hidden";
}

function closeMobileMenu() {
    const hamburgerBtn = document.getElementById("hamburger-btn");
    const mobileMenu = document.getElementById("mobile-menu");
    const mobileOverlay = document.getElementById("mobile-overlay");

    hamburgerBtn.classList.remove("active");
    mobileMenu.classList.remove("active");
    mobileOverlay.classList.remove("active");

    // Restaurar scroll do body
    document.body.style.overflow = "";
}
