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
> Os arquivos possuem comentários internos explicativos para compreensão da estrutura do código e funcionalidades .

---

## ⚙️ Instalação e Configuração

### Pré‑requisitos

- PHP 8
- MySQL
- Apache
- PhpMyAdmin

## ⚙️ Instalação e Configuração

### 1. Pré-requisitos

- PHP 8+
- MySQL 5.7+
- Apache Web Server
- PHPMailer (biblioteca)
- Editor de código (VSCode recomendado)
- PhpMyAdmin (opcional)

> Para facilitar, use o [XAMPP](https://www.apachefriends.org/pt_br/index.html), que já vem com PHP, MySQL e Apache.

---

### 2. Instalação com XAMPP

#### Windows

1. Baixe o XAMPP e instale com Apache, MySQL, PHP e PhpMyAdmin.
2. Copie o projeto para: `C:\xampp\htdocs\NomeDoProjeto`
3. Inicie Apache e MySQL via XAMPP Control Panel
4. Acesse: `http://localhost/NomeDoProjeto`

#### Linux

```bash
# Baixe e instale o XAMPP
wget https://www.apachefriends.org/xampp-files/8.2.4/xampp-linux-x64-8.2.4-0-installer.run
chmod +x xampp-linux-*.run
sudo ./xampp-linux-*.run
sudo /opt/lampp/lampp start

# Copie seu projeto para o diretório correto
sudo mv bella-vitta /opt/lampp/htdocs/
sudo chown -R $USER:$USER /opt/lampp/htdocs/bella-vitta

# Acesse via navegador
http://localhost/bella-vitta
```

#### macOS

1. Baixe o `.dmg` do XAMPP
2. Instale e execute Apache/MySQL
3. Copie o projeto para: `/Applications/XAMPP/htdocs/bella-vitta`
4. Acesse: `http://localhost/bella-vitta`

---

### 3. Configuração do Projeto

Edite `assets/config/config.php` com suas credenciais locais ou de produção:

```php
$modo = "local"; // ou "producao"

if ($modo == "local") {
    $servidor = "localhost";
    $usuario = "root";
    $senha = "";
    $banco = "bella_vitta";
}
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
