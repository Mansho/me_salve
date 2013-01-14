<?php

/**

Arquivo integrante do sistema de Compras Coletivas desenvolvido por INKID
Autor: Caio de Oliveira Hodos
Contato: caio.hodos@inkid.net

Copyright 2011 INKID
contato@inkid.net
http://www.inkid.net
 
*/

require_once "../configuracao/arquivos_cfg_down.php"; //atalhos para arquivos de configura��o
require_once "../comum/$database.class.php";
require_once "../configuracao/inicia_cfg.php"; //inicia configuracoes
require_once "../comum/funcoes.php";

global $db;

$sql = "SELECT * FROM $cidades_table";
$list_cidades = $db->query($sql);
$num_cidades = $db->num_rows($list_cidades);

if (isset($_POST[salva_oferta])) {
	
	$now = date("Y-m-d H:i");
	$now = str_replace("-","",$now);
	$now = str_replace(" ","",$now);
	$now = str_replace(":","",$now);
	
	if (isset($_POST[campo_data_ativacao])) {
		$campo_data_ativacao = strtotime($_POST[campo_data_ativacao]);
		$campo_data_ativacao = date("Y-m-d H:i",$campo_data_ativacao);
		$campo_data_ativacao = str_replace("-","",$campo_data_ativacao);
		$campo_data_ativacao = str_replace(" ","",$campo_data_ativacao);
		$campo_data_ativacao = str_replace(":","",$campo_data_ativacao);
	}
	
	$campo_data_encerramento = strtotime($_POST[campo_data_encerramento]);
	$campo_data_encerramento = date("Y-m-d H:i",$campo_data_encerramento);
	$campo_data_encerramento = str_replace("-","",$campo_data_encerramento);
	$campo_data_encerramento = str_replace(" ","",$campo_data_encerramento);
	$campo_data_encerramento = str_replace(":","",$campo_data_encerramento);
	
	if (($_POST[campo_data_encerramento] == '') || ($_POST[campo_valor_real] == '') || ($_POST[campo_valor_desconto] == '') || ($_POST[campo_minimo_cupons] == '') || ($_POST[campo_maximo_cupons] == '') || ($_POST[campo_regiao] == '')) {
    	header("Location: nova_oferta.php?error=1");
        exit;
	}
	
	if (($_POST[campo_titulo] == '') || ($_POST[campo_titulo] == 'Digite aqui um t�tulo para o seu an�ncio')) {
    	header("Location: nova_oferta.php?error=2");
        exit;
	}
	
	if (($campo_data_ativacao < $now) || ($campo_data_encerramento < $now)){
		header("Location: nova_oferta.php?error=3");
       	exit;
	}
		
	if ($campo_data_ativacao > $campo_data_encerramento){
		header("Location: nova_oferta.php?error=4");
       	exit;
	}
	
	if ($_POST[campo_valor_real] <= $_POST[campo_valor_desconto]){
		header("Location: nova_oferta.php?error=5");
       	exit;
	}
	
	if ($_POST[campo_maximo_cupons] < $_POST[campo_minimo_cupons]){
		header("Location: nova_oferta.php?error=6");
       	exit;
	}
	
	$foto1 = $_FILES["campo_foto1"];
	
	if (!empty($foto1["name"])) {
		$foto1 = insereImagem($_FILES["campo_foto1"]);
	}
	else {
		$foto1 = "anjos.jpg";
	}
	
	$foto2 = $_FILES["campo_foto2"];
	
	if (!empty($foto2["name"])) {
		$foto2 = insereImagem($_FILES["campo_foto2"]);
	}
	else {
		$foto2 = NULL;
	}
	
	$foto3 = $_FILES["campo_foto3"];
	
	if (!empty($foto3["name"])) {
		$foto3 = insereImagem($_FILES["campo_foto3"]);
	}
	else {
		$foto3 = NULL;
	}
	
	// Insere os dados no banco
	$sql = "INSERT INTO $ofertas_table VALUES (NULL, '1', '1', '$now', '$campo_data_ativacao', '$campo_data_encerramento', '$_POST[campo_valor_real]', '$_POST[campo_valor_desconto]', '$_POST[campo_minimo_cupons]', '$_POST[campo_maximo_cupons]', '0', '$_POST[campo_regiao]', '$_POST[campo_titulo]', '$foto1', '$foto2', '$foto3', 'teste', 'teste2')";
	$db->query($sql);
 

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
					<link rel='stylesheet' type='text/css' href='../css/calendario/jscal2.css' />
					<link rel='stylesheet' type='text/css' href='../css/calendario/border-radius.css' />
					<link rel='stylesheet' type='text/css' href='../css/calendario/win2k/win2k.css' />
					
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
					
					<script type='text/javascript' src='../js/calendario/jscal2.js'></script>
					<script type='text/javascript' src='../js/calendario/lang/pt.js'></script>
					<script type='text/javascript' src='../js/jquery-1.7.1.min.js'></script>
					<script type='text/javascript' src='../js/jquery_validation/jquery.validate.js'></script>
					
					<script type='text/javascript'>
        				jQuery(document).ready( function() {
                			jQuery('#formNovaOferta').validate({
                    			// Define as regras
                   		 		rules:{
									campo_titulo:{
										required: true,
										maxlength: 60
									},
									campo_data_encerramento:{
										required: true
									},
									campo_valor_real:{
                            			required: true,
										digits: true
                        			},
									campo_valor_desconto:{
                            			required: true,
										digits: true
                        			},				
									campo_minimo_cupons:{
                            			required: true,
										digits: true,
										max: 20
                        			},
									campo_maximo_cupons:{
                            			required: true,
										digits: true
                        			},
									campo_regiao:{
                            			required: true
                        			}
                    			},
                   			 	// Define as mensagens de erro para cada regra
                    			messages:{
									campo_titulo:{
										required: 'Digite um t�tulo para a oferta',
										maxlength: 'O t�tulo deve ter no m�ximo 60 caracteres'
									},
									campo_data_encerramento:{
										required: 'Escolha uma data para o encerramento da oferta'
									},
									campo_valor_real:{
										required: 'Digite o valor original do produto ou servi�o',
										digits: 'Digite apenas n�meros, n�o s�o aceitos valores em centavos'
									},
									campo_valor_desconto:{
										required: 'Digite o valor com desconto do produto ou servi�o',
										digits: 'Digite apenas n�meros, n�o s�o aceitos valores em centavos'
									},
									campo_minimo_cupons:{
										required: 'Digite o m�nimo de cupons para ativar a oferta, caso n�o tenha m�nimo digite 0',
										digits: 'Digite apenas n�meros',
										max: 'O valor m�ximo aceito � 20'
									},
									campo_maximo_cupons:{
										required: 'Digite o n�mero m�ximo de cupons que poder�o ser adquiridos',
										digits: 'Digite apenas n�meros'
									},
									campo_regiao:{
                            			required: 'Escolha a regi�o da oferta'
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
					
					<script type='text/javascript'>
						function apaga_titulo(){
							if (document.getElementById('titulo').value == 'Digite aqui um t�tulo para o seu an�ncio') {
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
							<div style='position:relative;float:left;width:100%;margin-top:10px;'>
								<div class='div_campo_titulo'>
									<input id='titulo' name='campo_titulo' type='text' class='campo_titulo' value='Digite aqui um t�tulo para o seu an�ncio' onclick='apaga_titulo()' />
								</div>
								<div style='position:relative;float:left;width:100%;margin-top:12px'>
									<div style='position:relative;float:left;width:50%;'>
										<label for='campo_data_ativacao' class='label_padrao'>Data de Ativa��o</label>
										<input id='data_ativacao' name='campo_data_ativacao' type='text' class='input_padrao' />
									</div>
									<div style='position:relative;float:left;width:50%;'>
										<label for='campo_data_encerramento' class='label_padrao'>Data de Encerramento</label>
										<input id='data_encerramento' name='campo_data_encerramento' type='text' class='input_padrao' />
									</div>
								</div>
								
								<script type='text/javascript'>//<![CDATA[
    								var cal = Calendar.setup({
										showTime: true,
										onSelect   : function() { cal.hide() }
    								});
									cal.manageFields('data_encerramento', 'data_encerramento', '%d-%m-%Y %H:%M');
									//]]>
								</script>
								
								<script type='text/javascript'>//<![CDATA[
    								var cal = Calendar.setup({
										showTime: true,
										onSelect   : function() { cal.hide() }
    								});
									cal.manageFields('data_ativacao', 'data_ativacao', '%d-%m-%Y %H:%M');
									//]]>
								</script>
								
								<div style='position:relative;float:left;width:100%;margin-top:12px'>
									<div style='position:relative;float:left;width:50%;'>
										<label for='campo_valor_real' class='label_padrao'>Valor sem desconto</label>
										<input id='valor_real' name='campo_valor_real' type='text' class='input_padrao' />
									</div>
									<div style='position:relative;float:left;width:50%;'>
										<label for='campo_valor_desconto' class='label_padrao'>Valor com desconto</label>
										<input id='valor_desconto' name='campo_valor_desconto' type='text' class='input_padrao' />
									</div>
								</div>
								<div style='position:relative;float:left;width:100%;margin-top:12px'>
									<div style='position:relative;float:left;width:50%;'>
										<label for='campo_minimo_cupons' class='label_padrao'>M�nimo Cupons</label>
										<input id='minimo_cupons' name='campo_minimo_cupons' type='text' class='input_padrao' />
									</div>
									<div style='position:relative;float:left;width:50%;'>
										<label for='campo_maximo_cupons' class='label_padrao'>M�ximo Cupons</label>
										<input id='maximo_cupons' name='campo_maximo_cupons' type='text' class='input_padrao' />
									</div>
								</div>
								<div style='position:relative;float:left;width:100%;margin-top:24px'>
									<div style='position:relative;float:left;width:50%;'>
										<label for='campo_regiao' class='label_padrao'>Regi�o</label>
										<select name='campo_regiao' type='text' class='input_padrao' />
											<option value=''></value>";
											for($j=0;$j<$num_cidades;$j++){
												$row = $db->fetch_array($list_cidades);
												echo "<option value=" . $row['ID'] . ">" . $row['CIDADE'] . "</option>";
											}
echo "									</select>
									</div>
								</div>
								
								<div style='position:relative;float:left;width:32.5%;margin-top:24px;margin-right:1%'>
									<label for='campo_regulamento' class='label_padrao' style='width:99%'>Regulamento</label>
									<textarea name='campo_regulamento' style='width:99%;height:260px;margin-top:6px'></textarea>
								</div>
								<div style='position:relative;float:left;width:32.5%;margin-top:24px;margin-right:1%'>
									<label for='campo_destaques' class='label_padrao' style='width:99%'>Destaques</label>
									<textarea name='campo_destaques' style='width:99%;height:260px;margin-top:6px'></textarea>
								</div>
								<div style='position:relative;float:left;width:32.5%;margin-top:24px;'>
									<label class='label_padrao' style='width:99%'>Fotos</label>
									<input type='file' name='campo_foto1' style='width:100%;margin-top:6px' />
									<input type='file' name='campo_foto2' style='width:100%;margin-top:6px' />
									<input type='file' name='campo_foto3' style='width:100%;margin-top:6px' />
								</div>
								<div class='div_campo_titulo' style='width:97%;padding:1.5%;background-position:left;margin-top:24px;text-align:right'>
									<input id='salva_oferta' name='salva_oferta' type='submit' class='button_padrao' value='Salvar' />
								</div>
							</div>
						</form>
						</div>
					</div>
					<div class='rodape'>
						<div class='caixas_submain'>";
							
echo "					</div>
					</div>
				</body>
			</html>";

?>