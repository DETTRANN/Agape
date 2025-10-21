# 📧 Sistema de Contato - Configuração de Email

## ✅ Funcionalidades Implementadas

### 1. **Formulário de Contato Funcional**

-   **Controller**: `ContatoController`
-   **Template de Email**: `resources/views/emails/contato.blade.php`
-   **Validações**: Nome, email, assunto e mensagem obrigatórios
-   **UX**: Loading durante envio, mensagens de feedback, auto-hide

### 2. **Sistema de Email Profissional**

-   **Destinatário**: `agapeinventory@gmail.com`
-   **Template HTML**: Design profissional com cores do Agape
-   **Reply-To**: Email do remetente para facilitar resposta
-   **Subject**: "Contato do Site: [assunto]"

## 🔧 Como Configurar o Gmail

### **Passo 1: Habilitar 2FA no Gmail**

1. Acesse: [myaccount.google.com](https://myaccount.google.com)
2. Vá em **Segurança** → **Verificação em duas etapas**
3. Ative a verificação em duas etapas

### **Passo 2: Gerar Senha de App**

1. Acesse: [myaccount.google.com/apppasswords](https://myaccount.google.com/apppasswords)
2. Selecione **App**: Mail
3. Selecione **Device**: Windows Computer
4. Clique em **Gerar**
5. **Copie a senha gerada** (16 caracteres)

### **Passo 3: Configurar o .env**

No arquivo `.env`, substitua `your_app_password_here` pela senha gerada:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=agapeinventory@gmail.com
MAIL_PASSWORD=senha_de_app_aqui_16_caracteres
MAIL_FROM_ADDRESS="agapeinventory@gmail.com"
MAIL_FROM_NAME="Agape Inventory"
```

### **Passo 4: Testar o Sistema**

1. Acesse: `http://127.0.0.1:8000/views/contato`
2. Preencha o formulário
3. Clique em **Enviar Mensagem**
4. Verifique a caixa de entrada do `agapeinventory@gmail.com`

## 🚨 Importante

-   **Nunca commite** a senha do Gmail no Git
-   **Use variáveis de ambiente** para credenciais
-   **Configure HTTPS** em produção para segurança
-   **Monitore** os logs de email em `storage/logs/laravel.log`

## 📋 Campos do Formulário

-   **Nome**: Nome completo do remetente
-   **Email**: Email para resposta (configurado como Reply-To)
-   **Assunto**: Título da mensagem
-   **Mensagem**: Conteúdo da mensagem (até 5000 caracteres)

## 🎨 Template de Email

O email enviado inclui:

-   ✅ Design profissional com cores do Agape (#8B5FBF)
-   ✅ Todos os dados do formulário organizados
-   ✅ Data e hora do envio
-   ✅ Email do remetente destacado para resposta
-   ✅ Layout responsivo para mobile

## 🔍 Logs e Debugging

Para debug, verifique:

-   `storage/logs/laravel.log` - Logs de erro
-   Se `MAIL_MAILER=log`, emails ficam em `storage/logs/laravel.log`
-   Para testar sem email real, use `MAIL_MAILER=log`

## 🌟 Próximos Passos Opcionais

1. **Auto-resposta**: Enviar confirmação para o remetente
2. **Captcha**: Adicionar proteção anti-spam
3. **Anexos**: Permitir upload de arquivos
4. **Categorização**: Diferentes tipos de contato
5. **Dashboard**: Painel para gerenciar mensagens

