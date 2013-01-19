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
require_once "../comum/funcoes.php"; //inicia configuracoes

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

if (isset($_POST[ativa_oferta])) {
	
	$sql = "UPDATE $ofertas_table SET STATUS = 2, DATA_ATIVACAO = NOW() WHERE ID = " . $_POST[id_ativa] . " AND STATUS = 1";
	$db->query($sql);
	
}

if (isset($_POST[apaga_oferta])) {
	
	$sql = "DELETE FROM $ofertas_table WHERE ID = " . $_POST[id_apaga] . " AND STATUS = 1";
	$db->query($sql);
	
}

$sql = "SELECT OFERTAS.*, STATUS.DESCRICAO STATUS_DESC
		FROM $ofertas_table OFERTAS, $status_table STATUS
		WHERE OFERTAS.STATUS = STATUS.ID";
		
if ($_GET[titulo]) {
	$sql .= " ORDER BY OFERTAS.TITULO_OFERTA " . $_GET[titulo];
}

if ($_GET[status]) {
	$sql .= " ORDER BY OFERTAS.STATUS " . $_GET[status];
}

if ($_GET[data_fim]) {
	$sql .= " ORDER BY OFERTAS.DATA_ENCERRAMENTO " . $_GET[data_fim];
}
		
$result_ofertas = $db->query($sql);
$num_ofertas = $db->num_rows($result_ofertas);

echo "	<!DOCTYPE html>
			<html>
				<head>
					<meta name='viewport' content='initial-scale=1.0, user-scalable=no' />
					<meta http-equiv= 'Content-Type' content='text/html; charset=ISO-8859-1' />
					<meta name='description' content='Compra coletiva' />
					<meta http-equiv='refresh' content='900' />
					<title>mesalve - Compra Coletiva</title>
					
					<link rel='stylesheet' type='text/css' href='../css/geral.css'/>
					
					<script type='text/javascript' src='../js/jquery-1.7.1.min.js'></script>
					
					<script type='text/javascript'>
						function display_div(div,estado){
							document.getElementById(div).style.display = estado;
						}
					</script>
					
					<script type='text/javascript'>
						function alturaCover() {
							var altura = jQuery(document).height();
							altura = altura+'px';
							document.getElementById('cover').style.height = altura;
						}
					</script>
				
					<!--[if  IE 8]>
						<style type='text/css'>
							#wrap {display:table;}
						</style>
					<![endif]-->				
				</head>
				
				<body onload='alturaCover()'>
				
					<div id='cover' onclick=\"display_div('cover','none');display_div('alerta_ativar','none');document.getElementById('id_ativa').value = ''\"></div>
					<div id='alerta_ativar' class='caixa_alerta'>
						<div class='mensagem_alerta'>Mensagem de Confirmação</div>
						<div class='mensagem_alerta' style='background-color:#BF0000;font-size:1.2em;font-weight:normal;border-radius:0px;border-bottom-left-radius:6px;border-bottom-right-radius:6px'>
							<div style='position:relative;float:left'>
								Tem certeza que deseja ativar a oferta selecionada?
							</div>
							<div style='position:relative;float:left;width:100%;margin-top:6px;text-align:center;'>
								<form id='formAtivaOferta' name='form_ativa_oferta' method='post' action='" . $_SERVER['PHP_SELF'] . "'>
									<input type='hidden' id='id_ativa' name='id_ativa' value='' />
									<input id='ativa_oferta' name='ativa_oferta' type='submit' class='button_padrao' value='Sim' />
									<input id='cancela' name='cancela' type='button' class='button_padrao' value='Não' onclick=\"display_div('cover','none');display_div('alerta_ativar','none');document.getElementById('id_ativa').value = ''\" />
								</form>
							</div>
						</div>
					</div>
					
					<div id='alerta_apagar' class='caixa_alerta'>
						<div class='mensagem_alerta'>Mensagem de Confirmação</div>
						<div class='mensagem_alerta' style='background-color:#BF0000;font-size:1.2em;font-weight:normal;border-radius:0px;border-bottom-left-radius:6px;border-bottom-right-radius:6px'>
							<div style='position:relative;float:left'>
								Tem certeza que deseja apagar a oferta selecionada?
							</div>
							<div style='position:relative;float:left;width:100%;margin-top:6px;text-align:center;'>
								<form id='formApagaOferta' name='form_apaga_oferta' method='post' action='" . $_SERVER['PHP_SELF'] . "'>
									<input type='hidden' id='id_apaga' name='id_apaga' value='' />
									<input id='apaga_oferta' name='apaga_oferta' type='submit' class='button_padrao' value='Sim' />
									<input id='cancela' name='cancela' type='button' class='button_padrao' value='Não' onclick=\"display_div('cover','none');display_div('alerta_apagar','none');document.getElementById('id_apaga').value = ''\" />
								</form>
							</div>
						</div>
					</div>
				
					<div id='wrap'>
						<div class='caixas_submain' style='margin-top:20px;overflow:auto;padding-bottom:80px;'>";
						
							require "../comum/cabecalho_down.php";
						
echo "						<div style='position:relative;float:left;width:100%;margin-top:10px;'>
								<div style='position:relative;float:left;width:99%;text-align:right;margin-bottom:10px'>
									<a href='nova_oferta.php'>
									<input id='cadastrar' name='cadastrar' type='button' class='button_padrao' style='width:auto' value='Nova Oferta' />
									</a>
								</div>
								
								<div class='caixa_padrao'>
									<div class='cabeca_caixa_padrao'>
										<div style='position:relative;float:left;width:22%;padding:8px;font-size:1.4em;color:#FFF;font-weight:bold'>";
											
											if ($_GET[titulo] == 'desc') {
												echo "<a href='" . $_SERVER['PHP_SELF'] . "?titulo=asc' style='color:#FFF'>Título &#9660;</a>";
											}
											else {
												echo "<a href='" . $_SERVER['PHP_SELF'] . "?titulo=desc' style='color:#FFF'>Título &#9650;</a>";
											}
											
echo "									</div>
										<div style='position:relative;float:left;width:12%;padding:8px;font-size:1.4em;color:#FFF;font-weight:bold'>";
										
											if ($_GET[status] == 'desc') {
												echo "<a href='" . $_SERVER['PHP_SELF'] . "?status=asc' style='color:#FFF'>Estado &#9660;</a>";
											}
											else {
												echo "<a href='" . $_SERVER['PHP_SELF'] . "?status=desc' style='color:#FFF'>Estado &#9650;</a>";
											}
										
echo "									</div>
										<div style='position:relative;float:left;width:15%;padding:8px;font-size:1.4em;color:#FFF;font-weight:bold'>";
										
											if ($_GET[data_fim] == 'desc') {
												echo "<a href='" . $_SERVER['PHP_SELF'] . "?data_fim=asc' style='color:#FFF'>Encerramento &#9660;</a>";
											}
											else {
												echo "<a href='" . $_SERVER['PHP_SELF'] . "?data_fim=desc' style='color:#FFF'>Encerramento &#9650;</a>";
											}
										
echo "									</div>
										<div style='position:relative;float:left;width:12%;padding:8px;font-size:1.4em;color:#FFF;font-weight:bold'>Valores</div>
										<div style='position:relative;float:left;width:15%;padding:8px;font-size:1.4em;color:#FFF;font-weight:bold'>Cupons</div>
										<div style='position:relative;float:left;width:12%;padding:8px;font-size:1.4em;color:#FFF;font-weight:bold'>Ações</div>
									</div>
									<div style='position:relative;float:left;width:100%;height:303px;overflow:auto'>
									";
										for($j=0;$j<$num_ofertas;$j++){
											
											$oferta = $db->fetch_array($result_ofertas);
											
											$percentual_vendido = (($oferta['CUPONS_COMPRADOS'] / $oferta['MAXIMO_CUPONS']) * 100) . "%";
											
echo "									<div style='position:relative;float:left;width:100%;background-color:#F3EBEB;border-bottom:1px solid #E9D9D9;'>
											<div style='position:relative;float:left;width:22%;padding:8px;font-size:1.2em;color:#6A0000;white-space:nowrap;overflow:hidden;'>" . $oferta['TITULO_OFERTA'] . "</div>
											<div style='position:relative;float:left;width:12%;padding:8px;font-size:1.2em;color:#6A0000;font-weight:bold'>" . $oferta['STATUS_DESC'] . "</div>
											<div style='position:relative;float:left;width:15%;padding:8px;font-size:1.2em;color:#6A0000;'>" . $oferta['DATA_ENCERRAMENTO'] . "</div>
											<div style='position:relative;float:left;width:12%;padding:8px;font-size:1.2em;color:#6A0000;'>
												<div style='position:relative;float:left;font-size:0.9em;color:#F00;text-decoration:line-through'>
													" . $oferta['VALOR_REAL'] . "
												</div>
												<div style='position:relative;float:left;font-size:1.1em;color:#009900;font-weight:bold;margin-left:3px;margin-top:-2px'>
													" . $oferta['VALOR_DESCONTO'] . "
												</div>
											</div>
											<div style='position:relative;float:left;width:15%;padding:8px;font-size:1.1em;color:#000;'>
												<div style='position:relative;float:left;width:80%;height:15px;margin-left:10%;border:1px solid #666'>
													<div style='position:absolute;float:left;width:100%;z-index:40;text-align:center;font-weight:bold;'>" . $oferta['CUPONS_COMPRADOS'] . "/" . $oferta['MAXIMO_CUPONS'] . "</div>
													<div style='position:relative;float:left;width:$percentual_vendido;height:100%;background-color:green;box-shadow:inset 2px 9px 6px -8px #F2FFF2;'></div>
												</div>
											</div>
											<div style='position:relative;float:left;width:12%;padding:6px 8px 2px 8px;font-size:1.2em;color:#6A0000;'>";
												
												if ($oferta['STATUS'] == 1) {
													echo "	<a href='edita_oferta.php?id=" . $oferta['ID'] . "' title='Editar'><img src='../imagens/botao_editar.png' hspace='2' /></a>
															<img src='../imagens/botao_ativar.png' hspace='2' style='cursor:pointer' title='Ativar' onclick=\"display_div('cover','block');display_div('alerta_ativar','block');document.getElementById('id_ativa').value = '" . $oferta['ID'] . "'\" />
															<img src='../imagens/botao_deletar.png' hspace='2' style='cursor:pointer' title='Apagar' onclick=\"display_div('cover','block');display_div('alerta_apagar','block');document.getElementById('id_apaga').value = '" . $oferta['ID'] . "'\" />";
												}
												
echo "										</div>
										</div>";
										}
echo "								</div>
								</div>
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