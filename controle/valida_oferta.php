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
else {
	if (!$_SESSION[ADM]) {
		header("Location: ../oferta.php?error=15");
    	exit;
	}
}

if (isset($_POST[valida_oferta])) {
$sql = "SELECT *
		FROM $cupons_table CUPOM , $users_table USUARIO,$ofertas_table OFERTAS where
		OFERTAS.CONTA_EMPRESA = '" . $_SESSION[conta] .
		   "' and USUARIO.id = CUPOM.usuario  		
		   and CUPOM.TOKEN = '" . $_POST[codigo_cupom] ."'
		   and USUARIO.CPF = '" . $_POST[codigo_cpf] ."'";
		  echo $sql;
$result = $db->query($sql);
$num_cidades = $db->num_rows($result);
if ($num_cidades ==1) {
echo 'cupom validado';

}
else {
echo 'cupom nao validado';

}
}

if ($_GET[id]) {

$sql = "SELECT OFERTAS.*, DATE_FORMAT(OFERTAS.DATA_ATIVACAO, '%d-%m-%Y %H:%i') DATA_ATIVACAO, DATE_FORMAT(OFERTAS.DATA_ENCERRAMENTO, '%d-%m-%Y %H:%i') DATA_ENCERRAMENTO, REGIAO.ID REGIAO_ID, REGIAO.CIDADE REGIAO_DESC
		FROM $ofertas_table OFERTAS, $cidades_table REGIAO
		WHERE OFERTAS.REGIAO = REGIAO.ID
		AND OFERTAS.ID = " . $_GET[id];
$result = $db->query($sql);
$oferta = $db->fetch_array($result);

}

$sql = "SELECT * FROM $cidades_table";
$result = $db->query($sql);
$num_cidades = $db->num_rows($result);

echo "	<!DOCTYPE html>
			<html>
				<head>
					<meta name='viewport' content='initial-scale=1.0, user-scalable=no' />
					<meta http-equiv= 'Content-Type' content='text/html; charset=ISO-8859-1' />
					<meta name='description' content='Compra coletiva' />
					<meta http-equiv='refresh' content='900' />
					<title>mesalve - Compra Coletiva</title>
					
					<link rel='stylesheet' type='text/css' href='../css/geral.css'/>
					<link rel='stylesheet' type='text/css' href='../css/calendario/jscal2.css' />
					<link rel='stylesheet' type='text/css' href='../css/calendario/border-radius.css' />
					<link rel='stylesheet' type='text/css' href='../css/calendario/win2k/win2k.css' />
					
					<style type='text/css'>
					.window{
							display:none;
							width:300px;
							height:300px;
							position:absolute;
							left:0;
							top:0;
							background:#FFF;
							z-index:9900;
							padding:10px;
							border-radius:10px;
						}
						 
						#mascara{
							display:none;
							position:absolute;
							left:0;
							top:0;
							z-index:9000;
							background-color:#000;
						}
						 
						.fechar{display:block; text-align:right;}
						
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
					
					<script type='text/javascript' src='../js/calendario/jscal2.js'></script>
					<script type='text/javascript' src='../js/calendario/lang/pt.js'></script>
					<script type='text/javascript' src='../js/jquery-1.7.1.min.js'></script>
					<script type='text/javascript' src='../js/jquery_validation/jquery.validate.js'></script>
					<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.3.1/jquery.min.js'></script>
					<script type='text/javascript'>
        				jQuery(document).ready( function() {
							$(document).ready(function(){
								$('a[rel=modal]').click( function(ev){
									ev.preventDefault();
							 
									var id = $(this).attr('href');
							 
									var alturaTela = $(document).height();
									var larguraTela = $(window).width();
								 
									//colocando o fundo preto
									$('#mascara').css({'width':larguraTela,'height':alturaTela});
									$('#mascara').fadeIn(1000);
									$('#mascara').fadeTo('slow',0.8);
							 
									var left = ($(window).width() /2) - ( $(id).width() / 2 );
									var top = ($(window).height() / 2) - ( $(id).height() / 2 );
								 
									$(id).css({'top':top,'left':left});
									$(id).show();  
								});
							 
								$('#mascara').click( function(){
									$(this).hide();
									$('.window').hide();
								});
							 
								$('.fechar').click(function(ev){
									ev.preventDefault();
									$('#mascara').hide();
									$('.window').hide();
								});
							});
						
						
                			jQuery('#formNovaOferta').validate({
                    			// Define as regras
                   		 		rules:{
									campo_titulo:{
										required: true,
										maxlength: 60
									}
                    			},
                   			 	// Define as mensagens de erro para cada regra
                    			messages:{
									campo_titulo:{
										required: 'Digite um título para a oferta',
										maxlength: 'O título deve ter no máximo 60 caracteres'
									}
                   	 			}
                			});
            			});
						
						
					</script>
					
					<script type='text/javascript'>
						function display_div(div,estado){
							document.getElementById(div).style.display = estado;
						}
						$(function() {
							$( '#dialog-confirm' ).dialog({
							resizable: false,
							height:140,
							modal: true,
							buttons: {
							'Delete all items': function() {
							$( this ).dialog( 'close' );
							},
							Cancel: function() {
							$( this ).dialog( 'close' );
							}
							}
							});
							});
					</script>
					
					<script type='text/javascript'>
						function apaga_titulo(){
							if (document.getElementById('titulo').value == 'Digite aqui um título para o seu anúncio') {
								document.getElementById('titulo').value = '';
							}
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
						
echo "					<form id='formNovaOferta' name='reg_oferta' method='post' action='" . $_SERVER['PHP_SELF'] . "' enctype='multipart/form-data'>
							<input type='hidden' name='id_oferta' value='" . $_GET[id] . "' />
							<div style='position:relative;float:left;width:100%;margin-top:10px;'>
															
								<div style='position:relative;float:left;width:32.5%;margin-top:24px;margin-right:1%'>
									<label for='campo_regulamento' class='label_padrao' style='width:99%'>Codigo Cupom</label>
									<input id='codigo_cupom' name='codigo_cupom' type='text' class='input_padrao' 'style='width:89%' />
								</div>
								<div style='position:relative;float:left;width:32.5%;margin-top:24px;margin-right:1%'>
									<label for='campo_destaques' class='label_padrao' style='width:99%'>CPF</label>
									<input id='codigo_cpf' name='codigo_cpf' type='text' class='input_padrao' 'style='width:89%' />
								</div>
								
								<div class='div_campo_titulo' style='width:97%;padding:1.5%;background-position:left;margin-top:24px;text-align:right'>
									<input id='valida_oferta' name='valida_oferta' type='submit' class='button_padrao' value='Validar' />
								</div>
							</div>
						</form>
						</div>
					</div>
					<div class='rodape'>
						<div class='caixas_submain'>";
							
echo "					</div>
					</div>
					<!-- inicio -->	
		<a href='#janela1' rel='modal'>Janela modal</a>
		<a href='#janela2' rel	='modal'>Janela 2 modal</a>


		<div class='window' id='janela1'>
			<a href='#' class='fechar'>X Fechar</a>
			<h4>Cupom Invalido</h4>
			<p>Este cupom não é valido, para qualquer dúvida estamos à disposição. </p>
		</div>

		<div class='window' id='janela2'>
			<a href='#' class='fechar'>X Fechar</a>
			<h4>Confirmação</h4>
			<form action='#' method='post'>
				<p>Voce confirma a utilização deste cupom? </p>

				<input type='submit' value='enviar'>

			</form>
		</div>

		<!-- mascara para cobrir o site -->	
		<div id='mascara'></div>
		
		<!-- fim -->	
					
					
					
					
				</body>
			</html>";

?>