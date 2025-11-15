<?php

/*
* Arquivo: recupera_senha.php
* 
* Descrição:
* Processa a redefinição de senha de usuários através de um código de recuperação único.
* 
* Funcionalidades :
* - Validação de código de recuperação via URL
* - Processamento seguro do formulário de nova senha
* - Validação de critérios para nova senha
* - Atualização segura da senha no banco de dados
* - Feedback visual claro para o usuário
* - Redirecionamento após sucesso
* 
* Fluxo de operação:
* 1. Verifica existência do código de recuperação na URL
* 2. Valida o código no banco de dados
* 3. Processa o formulário de nova senha quando submetido
* 4. Aplica validações rigorosas na nova senha
* 5. Atualiza a senha no banco de dados (com criptografia)
* 6. Redireciona para login após sucesso
* 
* Segurança:
* - Uso de prepared statements para prevenir SQL injection
* - Criptografia SHA1 para senhas (observação: considerar bcrypt)
* - tratamento de todos os inputs
* - Validação server-side rigorosa
* - Tokens únicos para recuperação
* 
* Dependências:
* - PHPMailer (disponível para envio de e-mails)
* - Arquivo config.php com configurações do banco
* - Bootstrap 5 para estilos e icones
* - jQuery para interações client-side
* - Animate.css para feedback visual
* 
* 
* Observações:
* - O código de recuperação é válido por tempo indeterminado
* - Não há limite de tentativas para redefinição
* - A senha é atualizada imediatamente após confirmação
* 
* @author Eduardo Torres do Ó
* 

*/




// PUXANDO INFORMACÕES DE CONFIGURAÇÃO DO BANCO
require("assets/config/config.php");


/****************************************************************
 PROCESSAMENTO DA RECUPERAÇÃO DE SENHA
****************************************************************/

// SE O CODIGO DE RECUPERACAO DE SENHA EXISTIR ( VERIFICA VIA GET)
if(isset($_GET["cod"]) && !empty($_GET["cod"])){
  
  // TRATA ESSE CODIGO
  $cod=trataPost($_GET["cod"]);

  // SE A POSTAGEM DE RECUPERAR SENHA EXISTIR
  if(isset($_POST["senha"]) && isset($_POST["repete_senha"])){

    //SE OS CAMPOS FOREM VAZIOS
    if( empty($_POST['senha']) || empty($_POST['repete_senha'])){
      $erro_geral = " Todos os campos são obrigatórios!";
    
      // SE FORAM PREENCHIDOS
    }else{
      // TRATA OS DADOS
      $senha=trataPost($_POST["senha"]);
      $senha_cript=sha1($_POST["senha"]);
      $repete_senha=trataPost($_POST["repete_senha"]);


      //VALIDACAO DOS CAMPOS :

      // SENHA
      if (
      strlen($senha) < 6 ||  
      !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $senha) ||  
      !preg_match('/[a-zA-Z].*[a-zA-Z]/', $senha) 
      ){
      $erro_senha = "A senha deve conter pelo menos 6 caracteres, 1 caractere especial e 2 letras";
      }


      //VERIFICA SE REPETE SENHA É IGUAL A SENHA
      if($senha !== $repete_senha){
      $erro_repete_senha = "Senha e repetição de senha diferentes!";
      }

      // SE NAO TEVE ERRO
      if(!isset($erro_geral)  && !isset($erro_senha) && !isset($erro_repete_senha)){

        // VERIFICA SE O USUARIO TEM ESSE CODIGO DE RECUPERACAO
        $sql= $pdo->prepare(" SELECT * FROM usuarios WHERE recupera_senha=? LIMIT 1 ");
        $sql->execute(array($cod));
        $usuario= $sql->fetch();

        // SE NAO ENCONTRAR USUARIO COM ESSE CODIGO
        if(!$usuario){
          echo "Recuperação de Senha Inválida !";

          // SE EXISTIR USUARIO COM O CODIGO
        }else{

          // ATUALIZA A SENHA DO USUARIO 
          $sql= $pdo->prepare("UPDATE usuarios SET senha=? WHERE recupera_senha=? ");

          // SE CONSEGIU ATUALIZAR
          if($sql->execute(array($senha_cript , $cod))){

            // REDIRECIONA O USUARIO PARA O LOGIN
            header("Location: index.php");
          }
          
        }
      
      
      
      }




    }




  }



}



?>









<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trocar Senha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
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
      
        <h3>Trocar a Senha</h3>
      <!-- ------------------------------------
       AREA DO FORMULÁRIO
      ---------------------------------------->
        <form method="post">
            
            <!-- SE OS CAMPOS NAO FORAM PREENCHIDOS(ERRO_GERAL) -->
          <?php if(isset($erro_geral)){ ?>
        
            <div class="erro-geral animate__animated animate__rubberBand text-center">
              
              <?php echo $erro_geral ?>
            
            </div>
        
          <?php  } ?>

          <!-- CAMPO SENHA -->
            <div <?php if(isset($erro_geral) || isset($erro_senha)){echo 'class=" input-group erro-borda "';}else{ echo' class="input-group"';}?> >
                <span class="input-group-text "><i <?php if(isset($erro_geral) || isset($erro_senha)){echo 'class=" bi bi-lock text-danger "';}else{ echo' class="bi bi-lock-fill"';}?>></i></span>
                <input 
                    class="form-control"
                    name="senha"
                    type="password"
                    placeholder="Nova Senha "
                    required
                />
            </div>

            <!-- SE OCORRER SOMENTE O ERRO_SENHA -->
            <?php if(isset($erro_senha)){ ?>
              <div class="erro-validacao">
                <?php echo $erro_senha  ?>
                
              </div>
    
            <?php } ?>


            <!-- CAMPO REPETIR SENHA -->
            <div  <?php if(isset($erro_geral) || isset($erro_repete_senha)){echo 'class=" input-group erro-borda "';}else{ echo' class="input-group"';}?>> 
                <span class="input-group-text "><i <?php if(isset($erro_geral) || isset($erro_repete_senha)){echo 'class=" bi bi-lock-fill text-danger "';}else{ echo' class="bi bi-lock-fill"';}?>></i></span>
                <input 
                    class="form-control"
                    name="repete_senha"
                    type="password"
                    placeholder="Repita a Nova Senha"
                    required
                />
            </div>
            
            <!-- SE OCORRER SOMENTE O ERRO_REPETE_SENHA -->
            <?php if(isset($erro_repete_senha)){ ?>
              <div class="erro-validacao">
                <?php echo $erro_repete_senha  ?>
                
              </div>
    
            <?php } ?>

            

            <!-- BOTÃO ALTERAR SENHA -->
            <button type="submit" class="btn-aut">Alterar a Senha</button>

            <!-- LINK PARA VOLTAR -->
            <div class="aut-links">
                <p><a href="index.php">Voltar para o login</a></p>
            </div>
        </form>
    </div>
    
    
    <!-- REFERÊNCIA JQUERY -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
    
    // TEMPORIZADOR PARA AS MENSAGENS DE ERRO
      setTimeout(() => {
        //   REMOVE ERRO GERAL(CAMPO VAZIO) E ERRO_VALIDACAO(CAMPO ESPECEIFICO)
          $('.erro-geral').fadeOut(600, function() { $(this).remove(); });
          $('.erro-validacao').fadeOut(600, function() { $(this).remove(); });
          
            //REMOVE O ERRO-INPUT ( BORDA AVERMELHADA) E TEXT-DANGER
            $('.erro-borda').removeClass('erro-borda')
            $('.text-danger').removeClass('text-danger')      
          
      }, 3200);
    </script>


</body>
</html>