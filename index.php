<?php
/*
Arquivo : login.php

Descrição:
* Processa o formulário de autenticação de usuários no sistema
* 
* Funcionalidades principais:
* - Validação de credenciais (e-mail e senha)
* - Verificação de status de confirmação do usuário
* - Geração e armazenamento de token de sessão seguro
* - Redirecionamento para área restrita após login válido
* - Feedback visual para usuário (erros/sucessos)
* - Gerenciamento de sessões através de tokens criptográficos
* 
* Fluxo de autenticação:
* 1. Recebe credenciais via POST
* 2. Valida campos obrigatórios
* 3. Criptografa a senha para comparação
* 4. Busca usuário no banco de dados
* 5. Verifica status de confirmação
* 6. Gera token de sessão único
* 7. Atualiza token no banco de dados
* 8. Armazena token na sessão PHP
* 9. Redireciona para área restrita
* 
* Segurança:
* - Uso de prepared statements para prevenir SQL injection
* - Criptografia SHA1 para senhas (observação: considerar migrar para bcrypt)
* - Tokens de sessão únicos e complexos
* - Validação server-side rigorosa
* - Sanitização de inputs
* 
* Dependências:
* - PHPMailer (disponível mas não utilizado neste arquivo)
* - Arquivo config.php com configurações do banco
* - Bootstrap 5 para estilos e icones
* - jQuery para interações client-side
* 
* Observações:
* - Tokens de sessão são regenerados a cada login
* - O sistema verifica o status "confirmado" do usuário
* 
* @author Eduardo Torres do Ó
*/ 


// PUXA AS CONFIGURAÇÕES E CONEXÃO COM O BANCO
require("assets/config/config.php");


/****************************************************************
 PROCESSAMENTO DO FORMULÁRIO DE LOGIN
****************************************************************/

// SE A POSTAGEM EXISTIR
if(isset($_POST["email"]) && isset($_POST["senha"]) && !empty($_POST["email"]) && !empty($_POST["senha"])){

  // TRATA OS DADOS
  $email=trataPost($_POST["email"]);
  $senha=trataPost($_POST["senha"]);
  $senha_cript=sha1($senha);

  // VERIFICA SE O USUARIO  ESTA CADASTRADO
  $sql = $pdo->prepare("SELECT * FROM usuarios WHERE email=? AND senha=? LIMIT 1 ");
  $sql->execute(array($email,$senha_cript));
  $usuario = $sql->fetch(PDO::FETCH_ASSOC);


  // SE FOI CADASTRADO
  if($usuario){

    // SE ELE ESTA CONFIRMADO
    if($usuario["status"] == "confirmado"){

      // CRIA UM TOKIEN RANDOMICO CRIPTOGRAFADO COM A DATA ATUAL
      $token= sha1(uniqid().date("d-m-Y-H-i-s"));

      // ATUALIZA O TOKEN DESSE USUARIO NO BANCO
      $sql= $pdo->prepare("UPDATE usuarios SET token =? WHERE email=? AND senha=? ");

      // SE CONSEGIU ATUALIZAR O TOKEN DO USUARIO 
      if($sql->execute(array($token,$email,$senha_cript))){

        // ARMAZENA O TOKIEN NA SESSION
        $_SESSION["TOKEN"]= $token;

        // REDIRECIONA O USUARIO PARA PAGINA RESTRITA
        header("location: restrita.php");
      }

      // SE O USUARIO NAO ESTIVER COM O STATUS CONFIRMADO
    }else{
      $erro_login = " Por favor confirme seu e-mail";

    }


    // SE O USUARIO NEM FOI CADASTRADO
  }else{

    // GERA MENSAGEM DE ERRO 
    $erro_login= " Usuário ou senha incorretos";

  }





}




?>







<!DOCTYPE html>
<html lang="pt-br">
  <head>

    <!-- META-TAGS PARA CONFIGURAÇÕES DO SITE (COMPATIBILIDADE ,FORMATAÇÃO DO ESCOPO , ETC) -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>

    <!-- REFERENCIAS BOOTSTRAP ANIMAÇÃO E ESTILO CSS EXTERNO -->

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
      rel="stylesheet"
    />

    <link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>


    <link rel="stylesheet" href="assets/css/form.css" />
    <link rel="stylesheet" href="assets/css/aut.css" />  


    </head>

  <body>
    <div class="aut-container">
      <h3>Login</h3>
      <form method="post">

      <!-- ------------------------------------
       AREA DO FORMULÁRIO
      ---------------------------------------->

      <!-- SE O USUÁRIO FOI CADASTRADO COM SUCESSO -->
      <?php if (isset($_GET['result']) && ($_GET['result']=="ok")){ ?>
          <div class=" animate__animated animate__rubberBand  sucesso" >
          Usuário cadastrado com sucesso!
          </div>               
      <?php }?>

      <!-- SE O USUÁRIO NÃO ESTIVER CADASTRADO (ERRO_LOGIN)-->
      <?php if(isset($erro_login)){ ?>
          <div class="erro-geral animate__animated animate__rubberBand text-center">
          <?php echo $erro_login ?>
          </div>
      <?php } ?>


      <div class="input-group">
        <span class="input-group-text"><i class="bi bi-person"></i></span>
        <input
          type="email"
          name="email"
          class="form-control"
          placeholder="Digite seu email"
          required
        />
      </div>

      <div class="input-group">
        <span class="input-group-text"><i class="bi bi-lock"></i></span>
        <input
          type="password"
          name="senha"
          class="form-control"
          placeholder="Digite sua senha"
          required
        />
      </div>

      <button type="submit" class="btn-aut">Logar</button>

      <div class="aut-links">
        <p><a href="cadastrar.php">Ainda não tenho cadastro</a></p>
        <p><a href="esqueci.php">Esqueci a senha</a></p>
      </div>
      </form>
    </div>
      
    <!-- REFERÊNCIA DO BOOTSTRAP CSS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- REFERÊNCIA DO JQUERY -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>     
      
    <script>

      // TEMPORIZADOR PARA REMOVER A MENSAGEM DE SUCESSO E ERRO-GERAL
      setTimeout(() => {
         $('.erro-geral').fadeOut(600, function() { $(this).remove(); });
         $('.sucesso').fadeOut(600, function() { $(this).remove(); });
         
      }, 3200);

      // TEMPORIZADOR PARA SUBSTITUIR PARAMETRO DA URL RESULT=?OK , EVITANDO CONLFITO DE MENSAGENS , SEJA DE SUCESSO OU ERRO AO MESMO TEMPO
      setTimeout(function() {
          if (window.location.search.includes('result=')) {
              const novaURL = window.location.origin + window.location.pathname + window.location.hash;
              history.replaceState({}, '', novaURL);
          }
      }, 2000);



    </script>
  </body>
</html>
