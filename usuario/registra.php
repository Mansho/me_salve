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

if (isCookieSet()) {
	header("Location: ../oferta.php?error=13");
    exit;
}

if (isset($_POST[cadastrar])) {
	
	if (($_POST[campo_nome] == '') || ($_POST[campo_email] == '') || ($_POST[campo_senha] == '') || ($_POST[campo_rsenha] == '')) {
    	header("Location: registra.php?error=1");
        exit;
	}
	
	// verifica se usuário já foi cadastrado
    $sql = "SELECT email FROM $users_table WHERE email='$_POST[campo_email]'";
    $result = $db->query($sql);
    $numrows = $db->num_rows($result);

    if ($numrows > 0) {
		header("Location: registra.php?error=11");
        exit;
	}
	
	if ($_POST[campo_senha] != $_POST[campo_rsenha]) {
		header("Location: registra.php?error=12");
        exit;
	}
	
	$campo_nascimento = str_replace("/","-",$_POST[campo_nascimento]);
	$campo_nascimento = strtotime($campo_nascimento);
	$campo_nascimento= date("Y-m-d",$campo_nascimento);
	
	//faz a criptografia de senha	
	$password = md5($_POST[campo_senha]);
	
	// Insere os dados no banco
	$sql = "INSERT INTO $users_table(id,nome, email, data_nascimento, sexo, regiao, senha) VALUES (NULL, '$_POST[campo_nome]', '$_POST[campo_email]', '$campo_nascimento', '$_POST[campo_sexo]', '$_POST[campo_regiao]', '$password')";
	$db->query($sql);
	
	$_SESSION[user] = $_POST[campo_email];
    $_SESSION[enc_pwd] = $password;
	$_SESSION[acesso]= date("Y-n-j H:i:s"); 
			
	session_write_close();
}

echo "	<!DOCTYPE html>
			<html>
				<head>
					<meta name='viewport' content='initial-scale=1.0, user-scalable=no' />
					<meta http-equiv= 'Content-Type' content='text/html; charset=ISO-8859-1' />
					<meta name='description' content='Compra coletiva' />
					<meta http-equiv='refresh' content='900' />
					<title>mesalve - Compra Coletiva</title>
					
					<link rel='stylesheet' type='text/css' href='../css/geral.css'/>
					
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