<?php

/**

Arquivo integrante do sistema de Compras Coletivas desenvolvido por INKID
Autor: Caio de Oliveira Hodos
Contato: caio.hodos@inkid.net

Copyright 2011 INKID
contato@inkid.net
http://www.inkid.net
 
*/

require_once "../configuracao/arquivos_cfg_down.php"; //atalhos para arquivos de configuração
require_once "../comum/$database.class.php";
require_once "../configuracao/inicia_cfg.php"; //inicia configuracoes
require_once "../comum/funcoes.php";

global $db;

session_start();

if (isset($_POST[campo_user])) {
	$password = md5($_POST[campo_senha]); //pega senha com criptografia MD5
	$_SESSION[conta] = (checkUser($_POST[campo_user], $password));
		
    if ($_SESSION[conta]) {
    	$_SESSION[user] = $_POST[campo_user];
        $_SESSION[enc_pwd] = $password;
		$_SESSION[acesso]= date("Y-n-j H:i:s"); 
		
		session_write_close();
			
		if ((substr_count($_SERVER[HTTP_REFERER], 'error')) > 0) {
			header("Location: $_SERVER[PHP_SELF]");
			exit;
		}
		else {
			header("Location: $_SERVER[HTTP_REFERER]");
			exit;
		}
			
    } else {
       header("Location: ../home.php?error=1");
       exit;
    }
}

if (!isCookieSet()) {

echo "	<!DOCTYPE html>
			<html>
				<head>
					<meta name='viewport' content='initial-scale=1.0, user-scalable=no' />
					<meta http-equiv= 'Content-Type' content='text/html; charset=ISO-8859-1' />
					<meta name='description' content='Compra coletiva' />
					<meta http-equiv='refresh' content='900' />
					<title>mesalve - Compra Coletiva</title>
					
					<link rel='stylesheet' type='text/css' href='../css/geral.css'/>

					<style type='text/css'>
						label.error {
							float:right;
							font-family:Verdana, Geneva, sans-serif;
							text-align:left;
							color:#FF0;
							margin-top:1.5px;
							font-size:9px;
							font-weight:600;
							margin-right:7px;
						}
				
						input.error {
							background:#EEDD82;
							border:1px solid #FF0000;
						}
				
						select.error {
							background:#EEDD82;
							border:1px solid #FF0000;
						}
					</style>
					
					<script type='text/javascript' src='../js/jquery-1.7.1.min.js'></script>
					<script type='text/javascript' src='../js/jquery_validation/jquery.validate.js'></script>
					
					<script type='text/javascript'>
        				jQuery(document).ready( function() {
                			jQuery('#formNovoCadastro').validate({
                    			// Define as regras
                   		 		rules:{
									campo_nome:{
										required: true
									},
									campo_email:{
										required: true,
										email: true
									},
									campo_senha:{
                            			required: true,
										minlength: 6,
										maxlength: 20
                        			},
									campo_rsenha:{
                            			required: true,
										equalTo: '#senha'
                        			}
                    			},
                   			 	// Define as mensagens de erro para cada regra
                    			messages:{
									campo_nome:{
										required: 'Digite seu nome'
									},
									campo_email:{
										required: 'Digite seu e-mail para contato',
										email: 'Digite um e-mail válido'
									},
									campo_senha:{
										required: 'Digite uma senha',
										minlength: 'A senha deve ter no mínimo seis caracteres',
										maxlength: 'A senha deve ter no máximo vinte caracteres'
									},
									campo_rsenha:{
										required: 'Repita a senha informada',
										equalTo: 'Repita a senha informada no campo acima'
									}
                   	 			}
                			});
            			});
					</script>
					
					<script type='text/javascript'>
						function display_div(div,estado){
							document.getElementById(div).style.display = estado;
						}
					</script>
				
					<!--[if  IE 8]>
						<style type='text/css'>
							#wrap {display:table;}
						</style>
					<![endif]-->				
				</head>
				
				<body>
				
					<div id='wrap'>
						<div class='caixas_submain' style='margin-top:20px;overflow:auto;padding-bottom:80px;'>";
						
							require "../comum/cabecalho_down.php";
						
echo "						<div style='position:relative;float:left;width:100%;margin-top:10px;'>
								<form id='formLogin' name='login' method='post' action='" . $_SERVER['PHP_SELF'] . "'>	
									<div style='position:relative;float:left;width:68%;margin-top:12px'>
										<div style='position:relative;float:left;width:100%;'>
											<label for='campo_user' class='label_padrao' style='font-size:1.6em'>E-mail</label>
											<input id='email' name='campo_user' type='text' class='input_padrao' style='height:24px;font-size:1.5em' />
										</div>
										<div style='position:relative;float:left;width:100%;margin-top:8px'>
											<label for='campo_senha' class='label_padrao' style='font-size:1.6em'>Senha</label>
											<input id='senha' name='campo_senha' type='text' class='input_padrao' style='height:24px;font-size:1.5em' />
										</div>
									</div>
									<div style='position:relative;float:right;width:24%;margin-top:7px;padding:1%;border-left:2px solid #EC0000;'>
										<a href='../usuario/cadastro.php'>
											<input id='cadastrar' name='cadastrar' type='button' class='button_padrao' style='width:auto' value='Cadastrar' />
										</a>
										<input id='cadastrar' name='cadastrar' type='button' class='button_padrao' style='width:auto;margin-top:8px' value='Conecte com o Facebook' />
									</div>
									<div class='div_campo_titulo' style='width:66%;padding:1%;background:#EC0000;margin-top:12px;text-align:right;border-radius:12px'>
										<input id='entrar' name='entrar' type='submit' class='button_padrao' style='width:auto' value='Entrar' />
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class='rodape'>
						<div class='caixas_submain'>";
							
echo "					</div>
					</div>
				</body>
			</html>";
			
}
else {
	header("Location: ../oferta.php");
    exit;
}

?>