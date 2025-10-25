// Funções de navegação
const goToCadastro = () => (window.location.href = "/views/register");
const goToLogin = () => (window.location.href = "/views/login");
const goToResetPassword = () => (window.location.href = "/views/pwdreset");
const goToEstoque = () => (window.location.href = "/views/tabela_estoque");
const goToRelatorios = () => (window.location.href = "/views/relatorios");
const goToSystem = () => (window.location.href = "/views/system");
const goToTransferencias = () => (window.location.href = "/transferencias");
const goToAuditoria = () => (window.location.href = "/auditoria");

// Função para navegação suave entre seções
function scrollToSection(sectionClass) {
    const section = document.querySelector(sectionClass);
    if (section) {
        const headerHeight =
            document.querySelector("#header-menu")?.offsetHeight || 0;
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
    const scrollThreshold = 80;

    if (header && headerMenu) {
        if (window.scrollY > scrollThreshold) {
            header.classList.add("scrolled");
            headerMenu.classList.add("scrolled");
        } else {
            header.classList.remove("scrolled");
            headerMenu.classList.remove("scrolled");
        }
    }
}

// Função para inicializar o formulário de contato
function initContactForm() {
    console.log("Inicializando formulário de contato");

    const contactForm = document.getElementById("contactForm");
    if (!contactForm) {
        console.log("Formulário de contato não encontrado");
        return;
    }

    const button = document.getElementById("btn-enviar-contact");
    const buttonText = button?.querySelector("span:not(.btn-loading)");
    const buttonLoading = button?.querySelector(".btn-loading");
    const requiredFields = contactForm.querySelectorAll(
        "input[required], textarea[required]"
    );
    const checkbox = contactForm.querySelector(
        "input[type='checkbox'][required]"
    );

    console.log("Elementos encontrados:", {
        contactForm: !!contactForm,
        button: !!button,
        buttonText: !!buttonText,
        buttonLoading: !!buttonLoading,
        requiredFields: requiredFields.length,
        checkbox: !!checkbox,
    });

    if (!button || !buttonText || !buttonLoading) {
        console.error("Elementos do botão não encontrados");
        return;
    }

    // Função para validar se todos os campos estão preenchidos
    function validateForm() {
        let isValid = true;

        // Verificar campos obrigatórios
        requiredFields.forEach((field) => {
            if (!field.value.trim()) {
                isValid = false;
            }
        });

        // Verificar checkbox se existir
        if (checkbox && !checkbox.checked) {
            isValid = false;
        }

        console.log("Validação do formulário:", {
            isValid,
            fieldsCount: requiredFields.length,
            checkboxChecked: checkbox ? checkbox.checked : "N/A",
        });

        // Habilitar/desabilitar botão
        if (isValid) {
            button.disabled = false;
            button.style.opacity = "1";
            button.style.cursor = "pointer";
        } else {
            button.disabled = true;
            button.style.opacity = "0.5";
            button.style.cursor = "not-allowed";
        }

        return isValid;
    }

    // Adicionar event listeners para validação em tempo real
    requiredFields.forEach((field) => {
        if (field) {
            field.addEventListener("input", validateForm);
            field.addEventListener("change", validateForm);
        }
    });

    if (checkbox) {
        checkbox.addEventListener("change", validateForm);
    }

    // Validação inicial
    validateForm();

    // Handler do submit
    contactForm.addEventListener("submit", function (e) {
        console.log("Formulário submetido");

        // Validar antes de enviar
        if (!validateForm()) {
            e.preventDefault();
            alert(
                "Por favor, preencha todos os campos obrigatórios e aceite os termos."
            );
            return;
        }

        // Mostrar loading
        buttonText.style.display = "none";
        buttonLoading.style.display = "flex";
        button.disabled = true;
        button.style.opacity = "0.7";
        button.style.cursor = "not-allowed";

        console.log("Estado de loading ativado");

        // Timeout para restaurar botão em caso de erro
        setTimeout(() => {
            if (buttonLoading.style.display === "flex") {
                console.log("Timeout - restaurando botão");
                buttonText.style.display = "inline";
                buttonLoading.style.display = "none";
                validateForm(); // Revalidar para restaurar estado correto
            }
        }, 15000); // 15 segundos timeout
    });

    console.log("Formulário de contato inicializado com sucesso");
}

// Função para auto-hide de mensagens de alerta
function initAlertAutoHide() {
    const alerts = document.querySelectorAll(".alert");
    console.log("Inicializando auto-hide para", alerts.length, "alertas");

    alerts.forEach((alert) => {
        setTimeout(() => {
            alert.style.transition = "opacity 0.5s ease";
            alert.style.opacity = "0";
            setTimeout(() => {
                alert.remove();
            }, 500);
        }, 5000); // 5 segundos para auto-hide
    });
}

// Função para inicializar menu mobile
function initMobileMenu() {
    const hamburgerBtn = document.getElementById("hamburger-btn");
    const mobileMenu = document.getElementById("mobile-menu");
    const mobileOverlay = document.getElementById("mobile-overlay");
    const closeBtn = document.getElementById("close-btn");

    if (hamburgerBtn && mobileMenu && mobileOverlay && closeBtn) {
        hamburgerBtn.addEventListener("click", openMobileMenu);
        closeBtn.addEventListener("click", closeMobileMenu);
        mobileOverlay.addEventListener("click", closeMobileMenu);

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

    hamburgerBtn?.classList.add("active");
    mobileMenu?.classList.add("active");
    mobileOverlay?.classList.add("active");
    document.body.style.overflow = "hidden";
}

function closeMobileMenu() {
    const hamburgerBtn = document.getElementById("hamburger-btn");
    const mobileMenu = document.getElementById("mobile-menu");
    const mobileOverlay = document.getElementById("mobile-overlay");

    hamburgerBtn?.classList.remove("active");
    mobileMenu?.classList.remove("active");
    mobileOverlay?.classList.remove("active");
    document.body.style.overflow = "";
}

// Inicialização principal quando o DOM carrega
document.addEventListener("DOMContentLoaded", function () {
    console.log("DOM carregado, inicializando aplicação");

    // Inicializar todas as funcionalidades
    initContactForm();
    initAlertAutoHide();
    initMobileMenu();

    // Adicionar listener para scroll do header
    window.addEventListener("scroll", handleHeaderScroll);

    console.log("Aplicação inicializada com sucesso");
});

// Função para controlar o header durante scroll
function handleHeaderScroll() {
    const header = document.querySelector("header");
    const headerMenu = document.getElementById("header-menu");
    const topHeader = document.querySelector(".top-header"); // Header mobile da página system
    const authTopHeader = document.querySelector(".top-header"); // Header mobile das páginas login/register
    const scrollThreshold = 80; // Pixels de scroll antes da transição

    // Para páginas com header-menu tradicional (index, login, register, etc.)
    if (header && headerMenu) {
        if (window.scrollY > scrollThreshold) {
            header.classList.add("scrolled");
            headerMenu.classList.add("scrolled");
        } else {
            header.classList.remove("scrolled");
            headerMenu.classList.remove("scrolled");
        }
    }

    // Para página system - não aplicar transformações no header mobile
    if (topHeader && topHeader.classList.contains("system-header")) {
        // Header mobile da página system mantém-se fixo sem alterações de scroll
        return;
    }

    // Para páginas de login/register - aplicar efeito de scroll azulado
    if (authTopHeader && !authTopHeader.classList.contains("system-header")) {
        const authSidebar =
            document.querySelector("#sidebar-auth") ||
            document.querySelector(".sidebar");

        if (window.scrollY > scrollThreshold) {
            authTopHeader.classList.add("scrolled");
            // Aplicar também no sidebar se existir
            if (authSidebar) {
                authSidebar.classList.add("scrolled");
            }
        } else {
            authTopHeader.classList.remove("scrolled");
            // Remover também do sidebar se existir
            if (authSidebar) {
                authSidebar.classList.remove("scrolled");
            }
        }
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

    // Toggle do menu ao clicar no ícone
    userIcon.addEventListener("click", (e) => {
        e.preventDefault();
        e.stopPropagation();
        userMenu.classList.toggle("menu-open");

        if (userMenu.classList.contains("menu-open")) {
            document.body.classList.add("dropdown-open");
        } else {
            document.body.classList.remove("dropdown-open");
        }
    });

    // Fechar menu ao clicar fora
    document.addEventListener("click", (e) => {
        if (!dropdown.contains(e.target)) {
            userMenu.classList.remove("menu-open");
            document.body.classList.remove("dropdown-open");
        }
    });
}

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

    // Verificar se há parâmetro de sucesso na URL
    checkForSuccessMessage();

    contactForm.addEventListener("submit", function (e) {
        // Não prevenir o envio - deixar o FormSubmit funcionar

        const btnText = btnEnviar.querySelector("span");
        const btnLoading = btnEnviar.querySelector(".btn-loading");

        // Mostrar loading
        if (btnText && btnLoading) {
            btnText.style.display = "none";
            btnLoading.style.display = "block";
        }
        btnEnviar.disabled = true;

        // O FormSubmit vai cuidar do envio e redirecionamento
    });
}

// Função para verificar mensagem de sucesso do FormSubmit
function checkForSuccessMessage() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get("success") === "true") {
        // Mostrar mensagem de sucesso
        showContactSuccess();

        // Limpar a URL removendo o parâmetro
        const newUrl = window.location.pathname;
        window.history.replaceState({}, "", newUrl);
    }
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
    initSystemMobile();
    initEstoqueEvents();
    initAuthMobile();
});

/* ===============================================
   SYSTEM MOBILE SIDEBAR
   =============================================== */

function initSystemMobile() {
    const mobileToggle = document.getElementById("mobile-toggle");
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("overlay");

    if (mobileToggle && sidebar && overlay) {
        // Toggle sidebar
        mobileToggle.addEventListener("click", function () {
            toggleSystemSidebar();
        });

        // Close on overlay click
        overlay.addEventListener("click", function () {
            closeSystemSidebar();
        });

        // Close on ESC key
        document.addEventListener("keydown", function (e) {
            if (e.key === "Escape" && sidebar.classList.contains("active")) {
                closeSystemSidebar();
            }
        });
    }
}

function toggleSystemSidebar() {
    const mobileToggle = document.getElementById("mobile-toggle");
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("overlay");

    if (sidebar.classList.contains("active")) {
        closeSystemSidebar();
    } else {
        openSystemSidebar();
    }
}

function openSystemSidebar() {
    const mobileToggle = document.getElementById("mobile-toggle");
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("overlay");

    mobileToggle.classList.add("active");
    sidebar.classList.add("active");
    overlay.classList.add("active");
    document.body.style.overflow = "hidden";
}

function closeSystemSidebar() {
    const mobileToggle = document.getElementById("mobile-toggle");
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("overlay");

    mobileToggle.classList.remove("active");
    sidebar.classList.remove("active");
    overlay.classList.remove("active");
    document.body.style.overflow = "";
}

/* ===============================================
   FUNCIONALIDADES DA TABELA DE ESTOQUE
   =============================================== */

// Função para filtrar a tabela de estoque
function filtrarTabela() {
    const searchInput = document.getElementById("search-input");
    const searchColumn = document.getElementById("search-column");
    const rows = document.querySelectorAll(".estoque-table tbody tr");

    if (!searchInput || !searchColumn || !rows.length) return;

    const searchValue = searchInput.value.toLowerCase().trim();
    const columnToSearch = searchColumn.value;

    console.log("Pesquisando por:", searchValue, "na coluna:", columnToSearch);

    rows.forEach((row) => {
        let cell;
        switch (columnToSearch) {
            case "id_item":
                cell = row.cells[0]; // ID
                break;
            case "status":
                cell = row.cells[1]; // Status
                break;
            case "nome":
                cell = row.cells[2]; // Nome Item
                break;
            case "descricao":
                cell = row.cells[3]; // Descrição
                break;
            case "categoria":
                cell = row.cells[4]; // Categoria
                break;
            case "serie":
                cell = row.cells[5]; // Número de Série
                break;
            case "preco":
                cell = row.cells[6]; // Preço
                break;
            case "data":
                cell = row.cells[7]; // Data de Posse
                break;
            case "responsavel":
                cell = row.cells[8]; // Responsável
                break;
            case "localidade":
                cell = row.cells[9]; // Localidade
                break;
            case "observacoes":
                cell = row.cells[10]; // Observações
                break;
            default:
                cell = null;
        }

        if (cell) {
            const text = cell.textContent.toLowerCase().trim();
            const matches = searchValue === "" || text.includes(searchValue);
            row.style.display = matches ? "" : "none";

            if (columnToSearch === "id_item") {
                console.log("ID da linha:", text, "corresponde:", matches);
            }
        }
    });
}

// Função para limpar a pesquisa da tabela
function limparPesquisa() {
    const searchInput = document.getElementById("search-input");
    const rows = document.querySelectorAll(".estoque-table tbody tr");

    if (searchInput) {
        searchInput.value = "";
    }

    rows.forEach((row) => {
        row.style.display = "";
    });
}

// Funções para controle do modal de novo produto
function abrirModal() {
    const modal = document.getElementById("modalNovoProduto");
    const overlay = document.getElementById("overlay");

    if (modal && overlay) {
        modal.style.display = "flex";
        overlay.classList.add("active");
        document.body.style.overflow = "hidden";

        // Foco no primeiro campo do formulário
        const primeiroInput = modal.querySelector("input");
        if (primeiroInput) {
            setTimeout(() => primeiroInput.focus(), 100);
        }
    }
}

function fecharModal() {
    const modal = document.getElementById("modalNovoProduto");
    const overlay = document.getElementById("overlay");

    if (modal && overlay) {
        modal.style.display = "none";
        overlay.classList.remove("active");
        document.body.style.overflow = "";
    }
}

/* ===============================================
   ESTOQUE MOBILE SIDEBAR
   =============================================== */

function toggleEstoqueSidebar() {
    const sidebar = document.getElementById("sidebar");
    const toggle = document.querySelector(".mobile-toggle");
    const overlay = document.getElementById("overlay");

    if (sidebar && toggle && overlay) {
        const isActive = sidebar.classList.contains("active");

        if (isActive) {
            closeEstoqueSidebar();
        } else {
            openEstoqueSidebar();
        }
    }
}

function openEstoqueSidebar() {
    const sidebar = document.getElementById("sidebar");
    const toggle = document.querySelector(".mobile-toggle");
    const overlay = document.getElementById("overlay");

    if (sidebar && toggle && overlay) {
        sidebar.classList.add("active");
        toggle.classList.add("active");
        overlay.classList.add("active");
        document.body.style.overflow = "hidden";
    }
}

function closeEstoqueSidebar() {
    const sidebar = document.getElementById("sidebar");
    const toggle = document.querySelector(".mobile-toggle");
    const overlay = document.getElementById("overlay");

    if (sidebar && toggle && overlay) {
        sidebar.classList.remove("active");
        toggle.classList.remove("active");
        overlay.classList.remove("active");
        document.body.style.overflow = "";
    }
}

// Função para lidar com cliques no overlay (sidebar ou modal)
function handleEstoqueOverlayClick() {
    const sidebar = document.getElementById("sidebar");
    const modal = document.getElementById("modalNovoProduto");

    // Verificar qual elemento está ativo
    if (sidebar && sidebar.classList.contains("active")) {
        closeEstoqueSidebar();
    } else if (modal && modal.style.display === "block") {
        fecharModal();
    }
}

/* ===============================================
   RELATORIOS MOBILE SIDEBAR
   =============================================== */

function toggleRelatoriosSidebar() {
    const sidebar = document.getElementById("sidebar");
    const toggle = document.querySelector(".mobile-toggle");
    const overlay = document.getElementById("overlay");

    if (!sidebar) return;

    const isActive = sidebar.classList.contains("active");

    if (isActive) {
        closeRelatoriosSidebar();
    } else {
        openRelatoriosSidebar();
    }
}

function openRelatoriosSidebar() {
    const sidebar = document.getElementById("sidebar");
    const toggle = document.querySelector(".mobile-toggle");
    const overlay = document.getElementById("overlay");

    if (!sidebar) return;
    sidebar.classList.add("active");
    if (toggle) toggle.classList.add("active");
    if (overlay) overlay.classList.add("active");
    document.body.style.overflow = "hidden";
}

function closeRelatoriosSidebar() {
    const sidebar = document.getElementById("sidebar");
    const toggle = document.querySelector(".mobile-toggle");
    const overlay = document.getElementById("overlay");

    if (!sidebar) return;
    sidebar.classList.remove("active");
    if (toggle) toggle.classList.remove("active");
    if (overlay) overlay.classList.remove("active");
    document.body.style.overflow = "";
}

function handleRelatoriosOverlayClick() {
    const sidebar = document.getElementById("sidebar");

    if (sidebar && sidebar.classList.contains("active")) {
        closeRelatoriosSidebar();
    }
}

function initRelatoriosMobile() {
    const sidebar = document.getElementById("sidebar");

    // Fechar sidebar com tecla ESC
    document.addEventListener("keydown", function (e) {
        if (
            e.key === "Escape" &&
            sidebar &&
            sidebar.classList.contains("active")
        ) {
            closeRelatoriosSidebar();
        }
    });
}

function initEstoqueMobile() {
    const sidebar = document.getElementById("sidebar");

    // Fechar sidebar com tecla ESC
    document.addEventListener("keydown", function (e) {
        if (
            e.key === "Escape" &&
            sidebar &&
            sidebar.classList.contains("active")
        ) {
            closeEstoqueSidebar();
        }
    });
}

// Função para inicializar eventos da tabela de estoque
function initEstoqueEvents() {
    // Event listeners para filtro de pesquisa
    const searchInput = document.getElementById("search-input");
    const searchColumn = document.getElementById("search-column");
    const btnLimpar = document.querySelector(".btn-limpar");
    const btnNovo = document.querySelector(".btn-novo");

    if (searchInput) {
        searchInput.addEventListener("input", filtrarTabela);
    }

    if (searchColumn) {
        searchColumn.addEventListener("change", filtrarTabela);
    }

    if (btnLimpar) {
        btnLimpar.addEventListener("click", limparPesquisa);
    }

    if (btnNovo) {
        btnNovo.addEventListener("click", abrirModal);
    }

    // Fechar modal com tecla ESC
    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape") {
            const modal = document.getElementById("modalNovoProduto");
            if (modal && modal.style.display === "block") {
                fecharModal();
            }
        }
    });

    // Prevenir fechamento do modal ao clicar dentro do conteúdo
    const modalContent = document.querySelector(".modal-content");
    if (modalContent) {
        modalContent.addEventListener("click", function (e) {
            e.stopPropagation();
        });
    }

    // Inicializar menu mobile de estoque
    initEstoqueMobile();

    console.log("Eventos da tabela de estoque inicializados com sucesso!");
}

/* ===============================================
   RESTO DO CÓDIGO JAVASCRIPT EXISTENTE
   =============================================== */

/* ===============================================
   SYSTEM MENU NAVIGATION
   =============================================== */

function showProfileMenu() {
    const mainMenu = document.querySelector(".main-menu");
    const profileMenu = document.querySelector(".profile-menu");

    if (mainMenu && profileMenu) {
        mainMenu.style.display = "none";
        profileMenu.style.display = "block";
    }
}

function showMainMenu() {
    const mainMenu = document.querySelector(".main-menu");
    const profileMenu = document.querySelector(".profile-menu");

    if (mainMenu && profileMenu) {
        profileMenu.style.display = "none";
        mainMenu.style.display = "block";
    }
}

/* ===============================================
   MOBILE SIDEBAR PROFILE MENU
   =============================================== */

function showMobileProfileMenu() {
    const sidebarMainMenu = document.querySelector(".sidebar-main-menu");
    const sidebarProfileMenu = document.querySelector(".sidebar-profile-menu");

    if (sidebarMainMenu && sidebarProfileMenu) {
        sidebarMainMenu.style.display = "none";
        sidebarProfileMenu.style.display = "block";
    }
}

function showMobileMainMenu() {
    const sidebarMainMenu = document.querySelector(".sidebar-main-menu");
    const sidebarProfileMenu = document.querySelector(".sidebar-profile-menu");

    if (sidebarMainMenu && sidebarProfileMenu) {
        sidebarProfileMenu.style.display = "none";
        sidebarMainMenu.style.display = "block";
    }
}

/* ===============================================
   MOBILE NAVIGATION LOGIN/REGISTER PAGES
   =============================================== */

function initAuthMobile() {
    const mobileToggle = document.querySelector("#mobile-toggle-auth");
    const sidebar = document.querySelector("#sidebar-auth");
    const overlay = document.querySelector("#overlay-auth");

    console.log("Inicializando AuthMobile...");
    console.log("Toggle encontrado:", mobileToggle);
    console.log("Sidebar encontrada:", sidebar);
    console.log("Overlay encontrado:", overlay);

    if (mobileToggle && sidebar && overlay) {
        // Remover event listeners anteriores para evitar duplicação
        const newToggle = mobileToggle.cloneNode(true);
        mobileToggle.parentNode.replaceChild(newToggle, mobileToggle);

        // Toggle sidebar com novo elemento
        newToggle.addEventListener("click", function (e) {
            e.preventDefault();
            e.stopPropagation();
            console.log("Clique no toggle detectado!");
            toggleAuthSidebar();
        });

        // Close on overlay click
        overlay.addEventListener("click", function (e) {
            e.preventDefault();
            console.log("Clique no overlay detectado!");
            closeAuthSidebar();
        });

        // Close on ESC key
        document.addEventListener("keydown", function (e) {
            if (e.key === "Escape" && sidebar.classList.contains("active")) {
                console.log("ESC pressionado - fechando sidebar");
                closeAuthSidebar();
            }
        });

        // Close sidebar when clicking on navigation items
        const sidebarItems = sidebar.querySelectorAll(".sidebar-item");
        sidebarItems.forEach((item) => {
            item.addEventListener("click", function () {
                console.log("Item do sidebar clicado - fechando sidebar");
                closeAuthSidebar();
            });
        });

        console.log("Event listeners adicionados com sucesso!");
    } else {
        console.log("Nem todos os elementos foram encontrados para AuthMobile");
        console.log("Tentando com seletores alternativos...");

        // Fallback para elementos sem IDs específicos
        const fallbackToggle = document.querySelector(".mobile-toggle");
        const fallbackSidebar = document.querySelector(".sidebar");
        const fallbackOverlay = document.querySelector(".overlay");

        if (fallbackToggle && fallbackSidebar && fallbackOverlay) {
            console.log("Usando elementos fallback");

            fallbackToggle.addEventListener("click", function (e) {
                e.preventDefault();
                e.stopPropagation();
                console.log("Clique no fallback toggle detectado!");
                toggleAuthSidebarFallback();
            });

            fallbackOverlay.addEventListener("click", function (e) {
                e.preventDefault();
                console.log("Clique no fallback overlay detectado!");
                closeAuthSidebarFallback();
            });
        }
    }
}

function toggleAuthSidebar() {
    const mobileToggle =
        document.querySelector("#mobile-toggle-auth") ||
        document.querySelector(".mobile-toggle");
    const sidebar =
        document.querySelector("#sidebar-auth") ||
        document.querySelector(".sidebar");
    const overlay =
        document.querySelector("#overlay-auth") ||
        document.querySelector(".overlay");

    console.log("toggleAuthSidebar chamado");
    console.log(
        "Sidebar tem classe active?",
        sidebar?.classList.contains("active")
    );

    if (sidebar?.classList.contains("active")) {
        console.log("Fechando sidebar...");
        closeAuthSidebar();
    } else {
        console.log("Abrindo sidebar...");
        openAuthSidebar();
    }
}

function openAuthSidebar() {
    const mobileToggle =
        document.querySelector("#mobile-toggle-auth") ||
        document.querySelector(".mobile-toggle");
    const sidebar =
        document.querySelector("#sidebar-auth") ||
        document.querySelector(".sidebar");
    const overlay =
        document.querySelector("#overlay-auth") ||
        document.querySelector(".overlay");
    const topHeader = document.querySelector(".top-header");

    console.log("openAuthSidebar executado");

    if (mobileToggle) {
        mobileToggle.classList.add("active");
        console.log("Toggle ativado");
    }
    if (sidebar) {
        sidebar.classList.add("active");

        // Se o header está scrolled, aplicar também no sidebar
        if (topHeader && topHeader.classList.contains("scrolled")) {
            sidebar.classList.add("scrolled");
        }

        console.log("Sidebar ativada");
    }
    if (overlay) {
        overlay.classList.add("active");
        console.log("Overlay ativado");
    }

    // Adicionar classe sidebar-open no header para mostrar border bottom
    if (topHeader) {
        topHeader.classList.add("sidebar-open");
        console.log("Header marcado como sidebar-open");
    }

    document.body.style.overflow = "hidden";
    console.log("Body overflow hidden");
}

function closeAuthSidebar() {
    const mobileToggle =
        document.querySelector("#mobile-toggle-auth") ||
        document.querySelector(".mobile-toggle");
    const sidebar =
        document.querySelector("#sidebar-auth") ||
        document.querySelector(".sidebar");
    const overlay =
        document.querySelector("#overlay-auth") ||
        document.querySelector(".overlay");

    console.log("closeAuthSidebar executado");

    if (mobileToggle) {
        mobileToggle.classList.remove("active");
        console.log("Toggle desativado");
    }
    if (sidebar) {
        sidebar.classList.remove("active");
        console.log("Sidebar desativada");
    }
    if (overlay) {
        overlay.classList.remove("active");
        console.log("Overlay desativado");
    }

    // Remover classe sidebar-open do header
    const topHeader = document.querySelector(".top-header");
    if (topHeader) {
        topHeader.classList.remove("sidebar-open");
        console.log("Header removido sidebar-open");
    }

    document.body.style.overflow = "";
    console.log("Body overflow restaurado");
}

// Funções fallback para compatibilidade
function toggleAuthSidebarFallback() {
    const sidebar = document.querySelector(".sidebar");
    if (sidebar?.classList.contains("active")) {
        closeAuthSidebarFallback();
    } else {
        openAuthSidebarFallback();
    }
}

function openAuthSidebarFallback() {
    const mobileToggle = document.querySelector(".mobile-toggle");
    const sidebar = document.querySelector(".sidebar");
    const overlay = document.querySelector(".overlay");
    const topHeader = document.querySelector(".top-header");

    if (mobileToggle) mobileToggle.classList.add("active");
    if (sidebar) {
        sidebar.classList.add("active");

        // Se o header está scrolled, aplicar também no sidebar
        if (topHeader && topHeader.classList.contains("scrolled")) {
            sidebar.classList.add("scrolled");
        }
    }
    if (overlay) overlay.classList.add("active");

    // Adicionar classe sidebar-open no header
    if (topHeader) {
        topHeader.classList.add("sidebar-open");
    }

    document.body.style.overflow = "hidden";
}

function closeAuthSidebarFallback() {
    const mobileToggle = document.querySelector(".mobile-toggle");
    const sidebar = document.querySelector(".sidebar");
    const overlay = document.querySelector(".overlay");
    const topHeader = document.querySelector(".top-header");

    if (mobileToggle) mobileToggle.classList.remove("active");
    if (sidebar) sidebar.classList.remove("active");
    if (overlay) overlay.classList.remove("active");

    // Remover classe sidebar-open do header
    if (topHeader) {
        topHeader.classList.remove("sidebar-open");
    }

    document.body.style.overflow = "";
}

// Initialize auth mobile when DOM is loaded
// (A inicialização está unificada no event listener principal acima)

// =====================================
// SISTEMA DE CONTATO
// =====================================

// A função initContactForm já está definida acima

// =====================================
// FUNCIONALIDADES ESPECÍFICAS DO ESTOQUE
// =====================================

// Auto-dismiss de alertas após 5 segundos
function initEstoqueAlerts() {
    setTimeout(function () {
        const alerts = document.querySelectorAll(".alert");
        alerts.forEach((alert) => {
            alert.style.transform = "translateX(100%)";
            alert.style.opacity = "0";
            setTimeout(() => alert.remove(), 300);
        });
    }, 5000);
}

// Definir data padrão como hoje no formulário
function initEstoqueDateDefaults() {
    const dataPosse = document.getElementById("data_posse");
    if (dataPosse) {
        const hoje = new Date().toISOString().split("T")[0];
        dataPosse.value = hoje;
    }
}

// Inicializar funções específicas do estoque quando a página carregar
document.addEventListener("DOMContentLoaded", function () {
    // Verificar se estamos na página de estoque
    if (window.location.pathname.includes("tabela_estoque")) {
        initEstoqueAlerts();
        initEstoqueDateDefaults();
        initNotificationSystem();
        initEstoqueEvents(); // Inicializar eventos e menu mobile
    }

    // Verificar se estamos na página de relatórios
    if (window.location.pathname.includes("relatorios")) {
        initRelatoriosMobile(); // Inicializar menu mobile de relatórios
    }
});

// =====================================
// SISTEMA DE NOTIFICAÇÕES
// =====================================

// Controlar painel de notificações
function toggleNotifications() {
    const panel = document.getElementById("notificationsPanel");
    const overlay = document.getElementById("overlay");

    if (panel && overlay) {
        // Usar requestAnimationFrame para suavizar animações
        requestAnimationFrame(() => {
            panel.classList.toggle("active");
            overlay.classList.toggle("active");

            // Evitar scroll do body quando painel estiver aberto
            if (panel.classList.contains("active")) {
                document.body.style.overflow = "hidden";
            } else {
                document.body.style.overflow = "";
            }
        });
    }
}

// Fechar notificações quando clicar no overlay
function initNotificationSystem() {
    const overlay = document.getElementById("overlay");
    const panel = document.getElementById("notificationsPanel");

    if (overlay && panel) {
        overlay.addEventListener("click", function () {
            if (panel.classList.contains("active")) {
                toggleNotifications();
            }
        });

        // Fechar com tecla ESC
        document.addEventListener("keydown", function (e) {
            if (e.key === "Escape" && panel.classList.contains("active")) {
                toggleNotifications();
            }
        });
    }

    console.log("Sistema de notificações inicializado");
}
