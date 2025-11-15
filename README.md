# 🔐 Sistema de Login – PHP + MySQL

Sistema completo de autenticação desenvolvido em PHP, com recuperação de senha, confirmação por e-mail, área restrita e integração com PHPMailer.

O projeto inclui:

- Tela de cadastro
- Login com validação
- Recuperação de senha
- Validação por código
- Logout
- Área restrita protegida
- Integração via PHPMailer
- Arquivo SQL pronto para importar

---

## 🧾 Sumário

- Funcionalidades
- Tecnologias
- Estrutura
- Instalação
- Banco de Dados
- Fluxo de Autenticação
- UI
- Licença
- Autor

---

## 🧩 Funcionalidades

- Cadastro de novos usuários
- Login protegido com validação
- Recuperação de senha via token
- Confirmação de código por e-mail
- Envio de mensagens via **PHPMailer**
- Sessões seguras (`$_SESSION`)
- Duas áreas restritas (`restrita.php`, `restrita2.php`)
- Arquivo SQL pronto para uso

---

## 🖥️ Tecnologias Utilizadas

### Frontend

- HTML5
- CSS3
- Bootstrap 5
- JavaScript

### Backend

- PHP 8
- MySQL
- PHPMailer
- Apache Server

---

## 📁 Estrutura do Projeto

```
login(doc)/
├── index.php
├── cadastrar.php
├── confirmacao.php
├── email_enviado_recupera.php
├── esqueci.php
├── recupera_senha.php
├── restrita.php
├── restrita2.php
├── logout.php
├── obrigado.php
├── teste.sql
│
└── assets/
    ├── config/config.php
    ├── css/aut.css
    ├── css/form.css
    ├── lib/PHPMailer/
```

---

## ⚙️ Instalação e Configuração

### Pré‑requisitos

- PHP 8
- MySQL
- Apache
- PhpMyAdmin

### Instalação

```
C:\xampp\htdocs\login
http://localhost/login
```

Configure o arquivo:

```
assets/config/config.php
```

---

## 📊 Banco de Dados

### Tabela `usuarios`

```sql
CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  senha VARCHAR(255) NOT NULL,
  codigo VARCHAR(10),
  data_cadastro DATETIME NOT NULL,
  status ENUM('novo','confirmado') DEFAULT 'novo'
);
```

---

## 🔐 Fluxo de Autenticação

1. Cadastro → e-mail enviado
2. Confirmação via código
3. Login com sessão
4. Área restrita
5. Recuperação de senha

---

## 🎨 UI e Estilo

- Estilo moderno com Bootstrap
- Páginas limpas e responsivas
- Animação Lottie na tela de obrigado

---

## 📄 Licença

> © 2025 Eduardo Torres – Todos os direitos reservados.

Este projeto é de uso **exclusivamente pessoal e educacional**.

---

## 👨‍💻 Autor

**Eduardo Torres**  
Desenvolvedor Full Stack

- GitHub: https://github.com/edutorres-dev
- Email: edutorres_dev@hotmail.com
- Linkedin: https://www.linkedin.com/in/eduardo-torres-do-%C3%B3-576085385/
