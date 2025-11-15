<?php
/*
* Arquivo: esqueci.php
* 
* Descrição:
* Processa a solicitação de recuperação de senha, enviando um e-mail com link único para redefinição.
* Verifica se o usuário existe e está confirmado no sistema antes de enviar o e-mail.
* 
* Funcionalidades principais:
* 1. Validação do e-mail fornecido
* 2. Verificação do status do usuário (deve estar "confirmado")
* 3. Geração de código único de recuperação
* 4. Atualização do código no banco de dados
* 5. Envio de e-mail com PHPMailer
* 6. Redirecionamento com feedback
* 
* Fluxo de operação:
* 1. Recebe e-mail via POST
* 2. Valida e trata o e-mail
* 3. Busca usuário no banco (com status "confirmado")
* 4. Se encontrado:
*    - Gera código SHA1 único
*    - Atualiza no banco
*    - Envia e-mail com link de recuperação
*    - Redireciona para confirmação
* 5. Se não encontrado:
*    - Exibe mensagem de erro
* 
* Segurança:
* - Sanitização de todos os inputs
* - Verificação de status do usuário
* - Prepared statements para queries
* - Código único SHA1 para recuperação
* - Links HTTPS no e-mail
* - Validação de e-mail antes de enviar
* 
* Dependências:
* - PHPMailer para envio de e-mails
* - Arquivo config.php com configurações do banco
* - Função trataPost() para sanitização
* 
* 
* Observações importantes:
* - O código de recuperação tem validade indeterminada
* - Cada código é único por solicitação
* - O e-mail usa template HTML responsivo
* - Mensagens de erro são exibidas temporariamente
* 
/**

* @author Eduardo Torres do Ó
* 

*/


// PUXA AS INFORMACÕES DE CONFIGURACÃO DO BANCO
require("assets/config/config.php");

//REQUERIMENTO DA BIBLIOTECA PHPMAILER PARA DISPARO DE EMAIL(MODO PRODUÇÃO)
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'assets/lib/PHPMailer/src/Exception.php';
require 'assets/lib/PHPMailer/src/PHPMailer.php';
require 'assets/lib/PHPMailer/src/SMTP.php';



// SE EXISTE A POSTAGEM EMAIL
if(isset($_POST["email"]) && !empty($_POST["email"])){

    // TRATA OS DADOS
    $email=trataPost($_POST["email"]);

    // O USUARIO PRECISA ESTAR CONFIRMADO PARA MUDAR A SENHA
    $status="confirmado";

    // VERIFICA SE O USUARIO TEM CADASTRO
    $sql= $pdo->prepare("SELECT * FROM usuarios WHERE email=? AND status=? LIMIT 1");
    $sql->execute(array($email,$status));
    $usuario= $sql->fetch(PDO::FETCH_ASSOC);

    // SE O USUARIO TEM CADASTRO
    if($usuario){

        // ATUALIZA O CODIGO DE RECUPERACAO DE SENHA
        $sql= $pdo->prepare(" UPDATE usuarios SET recupera_senha=? WHERE email=?");
        
        // GERA UM CODIGO UNICO CRIPTOGRAFADO
        $cod = sha1(uniqid());

        // RECEBE O NOME CADASTRADO NO SISTEMA , SERÁ USADO PARA O ENVIO DE EMAIL(DESTINATARIO)
        $nome = $usuario['nome'];

        // SE CONSEGIU ATUALIZAR O CODIGO
        if($sql->execute(array($cod,$email))){

            // ENVIA O EMAIL PARA O USUARIO REFINIR SUA SENHA
            try {
                
                // INSTANCIA O PHP MAILER
                $mail = new PHPmailer(true);
                                
                // REMETENTE
                $mail->setFrom('teste@hotmail.com', 'teste');  

                // DESTINADO
                $mail->addAddress($email, $nome); 
                
                //CORPO DO EMAIL COMO HTML
                $mail->isHTML(true);  
                
                //TITULO DO EMAIL(ASSUNTO)
                $mail->Subject = 'Recuperação de Senha';
                
                // FORMATAÇÃO DE CONTEUDO
                $mail->CharSet = 'UTF-8'; 
                
                // CONTEÚDO DO EMAIL
                $mail->Body = '
                <div style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 0; margin: 0;">
                    <div style="max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                        
                        <!-- Conteúdo principal -->
                        <div style="padding: 30px; text-align: center; color: #333;">
                            <h2 style="color: #2c3e50; margin-bottom: 20px;">Redefinição de Senha</h2>
                            <p style="font-size: 16px; line-height: 1.6; margin-bottom: 25px;">
                                Recebemos uma solicitação para redefinir sua senha. <br>
                                Para continuar com o processo, clique no botão abaixo:
                            </p>
                            <a href="'.$site.'/recupera_senha.php?cod='.$cod.'" 
                                style="display: inline-block; padding: 14px 30px; background-color: #38bdf8; color: rgba(247, 247, 247, 1); text-decoration: none; border-radius: 5px; font-size: 16px; font-weight: bold;">
                                Recuperar Senha
                            </a>
                            <p style="font-size: 14px; color: #888; margin-top: 30px;">
                                Se você não solicitou essa alteração, ignore este e-mail com segurança.
                            </p>
                        </div>
                        
                    </div>
                </div>';

                //  ENVIA O EMAIL                     
                $mail->send();

                // REDIRECIONA PARA PÁGINA DE RECUPERAÇÃO DE SENHA
                header('location: email_enviado_recupera.php');

            // SE DER ALGUM ERRO NO ENVIO
            } catch (Exception $e) {
                echo "Houve um problema ao enviar o email de confirmação: {$mail->ErrorInfo}";
            }

            



        }





        
    }

}



?>



<!DOCTYPE html>
<html lang="pt-br">
  <head>

    <!-- META-TAGS PARA CONFIGURAÇÕES DO SITE (COMPATIBILIDADE ,FORMATAÇÃO DO ESCOPO , ETC) -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Recuperar Senha</title>

    <!-- LINKS DE REFERÊNCIA ( BOOTSTRAP ANIMAÇAO E CSS ESTILIZADO) -->

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
      rel="stylesheet"
    />

    <link rel="stylesheet" href="assets/css/form.css" />

  </head>

  <body>
    <div class="aut-container">
      <h3>Recuperar Senha</h3>

      <p
        style="
          color: #0369a1;
          margin-bottom: 1rem;
          font-size: 1rem;
          line-height: 1.5;
        "
      >
        Informe o e-mail cadastrado para redefinir sua senha.
      </p>

      <form method="post">

        <!-- ------------------------------------
        AREA DO FORMULÁRIO
        ---------------------------------------->

        <!-- CAMPO EMAIL -->
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-envelope"></i></span>
          <input
            name="email"
            type="email"
            class="form-control"
            placeholder="Digite seu e-mail"
            required
          />
        </div>

        <!-- BOTAO RECUPERA SENHA-->
        <button type="submit" class="btn-aut">Recuperar Senha</button>

        <!-- LINK PARA LOGIN-->
        <div class="aut-links">
          <p><a href="index.php">Voltar para login</a></p>
        </div>
      </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
