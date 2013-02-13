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

if (!isCookieSet()) {
	header("Location: ../oferta.php?error=14");
    exit;
}

if (isset($_POST[cadastrar])) {
	
	if (($_POST[campo_nome] == '') || ($_POST[campo_email] == '')) {
    	header("Location: edita_cadastro.php?error=1");
        exit;
	}
	
	if ($_POST[campo_nova_senha] != '') {

    	if ($_POST[campo_nova_senha] != $_POST[campo_rsenha]) {
			header("Location: edita_cadastro.php?error=12");
        	exit;
		}
		
		$password = md5($_POST[campo_senha]);

		if ($password != $_SESSION[enc_pwd]) {
			header("Location: edita_cadastro.php?error=12");
        	exit;
		}
		
		if ($_POST[campo_email] != $_SESSION[user]) {
			$sql = "SELECT EMAIL FROM $users_table WHERE EMAIL = '$_POST[campo_email]' AND ID != " . $_SESSION[conta];
    		$result = $db->query($sql);
   			$numrows = $db->num_rows($result);

    		if ($numrows > 0) {
				header("Location: edita_cadastro.php?error=11");
       			exit;
			}
		}
	
		$campo_nascimento = str_replace("/","-",$_POST[campo_nascimento]);
		$campo_nascimento = strtotime($campo_nascimento);
		$campo_nascimento= date("Y-m-d",$campo_nascimento);
		
		$password = md5($_POST[campo_nova_senha]);
	
		// Insere os dados no banco
		$sql = "UPDATE $users_table SET NOME = '$_POST[campo_nome]', EMAIL = '$_POST[campo_email]', DATA_NASCIMENTO = '$campo_nascimento', SEXO = '$_POST[campo_sexo]', REGIAO = '$_POST[campo_regiao]', SENHA = '$password' WHERE ID = " . $_SESSION[conta];
		$db->query($sql);
	
		$_SESSION[user] = $_POST[campo_email];
    	$_SESSION[enc_pwd] = $password;
		$_SESSION[acesso]= date("Y-n-j H:i:s"); 
			
		session_write_close();
	}
	else {
		$campo_nascimento = str_replace("/","-",$_POST[campo_nascimento]);
		$campo_nascimento = strtotime($campo_nascimento);
		$campo_nascimento= date("Y-m-d",$campo_nascimento);
		
		if ($_POST[campo_email] != $_SESSION[user]) {
			$sql = "SELECT EMAIL FROM $users_table WHERE EMAIL = '$_POST[campo_email]' AND ID != " . $_SESSION[conta];
    		$result = $db->query($sql);
   			$numrows = $db->num_rows($result);

    		if ($numrows > 0) {
				header("Location: edita_cadastro.php?error=11");
       			exit;
			}
		}

		// Insere os dados no banco
		$sql = "UPDATE $users_table SET NOME = '$_POST[campo_nome]', EMAIL = '$_POST[campo_email]', DATA_NASCIMENTO = '$campo_nascimento', SEXO = '$_POST[campo_sexo]', REGIAO = '$_POST[campo_regiao]' WHERE ID = " . $_SESSION[conta];
		$db->query($sql);
	
		$_SESSION[user] = $_POST[campo_email];
		$_SESSION[acesso]= date("Y-n-j H:i:s"); 
			
		session_write_close();
	}
	
}

$sql = "SELECT *,DATE_FORMAT(DATA_NASCIMENTO, '%d-%m-%Y') NASCIMENTO FROM $users_table WHERE ID = " . $_SESSION[conta];
$result_dados = $db->query($sql);
$info = $db->fetch_array($result_dados);


$sql = "SELECT * FROM $cidades_table";
$result_cidades = $db->query($sql);
$num_cidades = $db->num_rows($result_cidades);



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
					<script type='text/javascript' src='../js/jquery.maskedinput-1.3.min.js'></script>
					

					
					<script type='text/javascript'>
        				jQuery(document).ready( function() {
                			jQuery('#formAlteraCadastro').validate({
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
										required: function(element) {
        									return jQuery('#nova_senha').val().length > 0;
      									},
										minlength: 6
                        			},
									campo_nova_senha:{
										minlength: 6,
										maxlength: 20
                        			},
									campo_rsenha:{
										equalTo: '#nova_senha'
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
										required: 'Digite uma senha'
									},
									campo_nova_senha:{
										minlength: 'A senha deve ter no mínimo seis caracteres',
										maxlength: 'A senha deve ter no máximo vinte caracteres'
									},
									campo_rsenha:{
										equalTo: 'Repita a senha informada no campo acima'
									}
                   	 			}
                			});
							jQuery('#nova_senha').blur(function() {
 								jQuery('#senha').valid();
							});
            			});
					</script>
					
					<script type='text/javascript'>
						jQuery(function(jQuery){
  							jQuery('#data_nascimento').mask('99/99/9999');
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
							<form id='formAlteraCadastro' name='altera_cadastro' method='post' action='edita_cadastro.php?error=16'>
								<div style='position:relative;float:left;width:100%;margin-top:12px'>
									<div style='position:relative;float:left;width:80%;'>
										<label for='campo_nome' class='label_padrao' style='font-size:1.6em'>Nome</label>
										<input id='nome' name='campo_nome' type='text' class='input_padrao' style='height:27px;font-size:1.5em' value='" . $info['NOME'] . "' />
									</div>
									<div style='position:relative;float:left;width:80%;margin-top:8px'>
										<label for='campo_email' class='label_padrao' style='font-size:1.6em'>E-mail</label>
										<input id='email' name='campo_email' type='text' class='input_padrao' style='height:27px;font-size:1.5em' value='" . $info['EMAIL'] . "' />
									</div>
									<div style='position:relative;float:left;width:80%;margin-top:32px'>
										<label for='campo_senha' class='label_padrao' style='font-size:1.6em'>Senha</label>
										<input id='senha' name='campo_senha' type='text' class='input_padrao' style='height:27px;font-size:1.5em' />
									</div>
									<div style='position:relative;float:left;width:80%;margin-top:8px'>
										<label for='campo_nova_senha' class='label_padrao' style='font-size:1.6em'>Nova Senha</label>
										<input id='nova_senha' name='campo_nova_senha' type='text' class='input_padrao' style='height:27px;font-size:1.5em' />
									</div>
									<div style='position:relative;float:left;width:80%;margin-top:8px'>
										<label for='campo_rsenha' class='label_padrao' style='font-size:1.6em'>Repita a Senha</label>
										<input id='rsenha' name='campo_rsenha' type='text' class='input_padrao' style='height:27px;font-size:1.5em' />
									</div>
									<div style='position:relative;float:left;width:80%;margin-top:32px'>
										<label for='campo_nascimento' class='label_padrao' style='font-size:1.6em'>Data de Nascimento</label>
										<input id='data_nascimento' name='campo_nascimento' type='text' class='input_padrao' style='height:27px;font-size:1.5em' value='" . $info['NASCIMENTO'] . "' />
									</div>
									<div style='position:relative;float:left;width:80%;margin-top:8px'>
										<label for='campo_sexo' class='label_padrao' style='font-size:1.6em'>Sexo</label>
										<select id='sexo' name='campo_sexo' type='text' class='input_padrao' style='height:36px;width:56.5%;font-size:1.5em' />";
										if ($info['SEXO'] == 'M'){
											echo "	<option value='M'>Masculino</value>
													<option value='F'>Feminino</value>";
										}
										else {
											echo "	<option value='F'>Feminino</value>
													<option value='M'>Masculino</value>";
										}
											
echo "									</select>
									</div>
									<div style='position:relative;float:left;width:80%;margin-top:8px'>
										<label for='campo_região' class='label_padrao' style='font-size:1.6em'>Região</label>
										<select id='regiao' name='campo_regiao' type='text' class='input_padrao' style='height:36px;width:56.5%;font-size:1.5em' />
											<option value=" . $info['REGIAO'] . ">$regiao_desc</option>";
											for($j=0;$j<$num_cidades;$j++){
												$row = $db->fetch_array($result_cidades);
												echo "<option value=" . $row['ID'] . ">" . $row['CIDADE'] . "</option>";
											}
echo "									</select>
									</div>
								</div>
								<div class='div_campo_titulo' style='width:76%;padding:1.5%;background-position:left;margin-top:24px;text-align:right'>
									<input id='cadastrar' name='cadastrar' type='submit' class='button_padrao' style='width:auto' value='Salvar' />
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

?>