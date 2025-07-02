function goToCadastro() {
  window.location.href = "register.html";
}

function goToLogin() {
  window.location.href = "login.html";
}

function validateFields() {
  const campos = document.querySelectorAll(".validacao");
  const botao = document.getElementById("btn-Cadastrar-Register");

  const temCampoVazio = Array.from(campos).some((campo) => campo.value.trim() === "");

  if (temCampoVazio) {
    botao.disabled = true;
  } else {
    botao.disabled = false;
  }
}

document.addEventListener("DOMContentLoaded", function () {
  const campos = document.querySelectorAll(".validacao");

  validateFields();

  campos.forEach((campo) => {
    campo.addEventListener("input", validateFields);
  });
});
