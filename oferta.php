<?php

/**

Arquivo integrante do sistema de Compras Coletivas desenvolvido por INKID
Autor: Caio de Oliveira Hodos
Contato: caio.hodos@inkid.net

Copyright 2011 INKID
contato@inkid.net
http://www.inkid.net
 
*/


require_once "configuracao/arquivos_cfg.php"; //atalhos para arquivos de configuração
require_once "comum/$database.class.php";
require_once "configuracao/inicia_cfg.php"; //inicia configuracoes
require_once "comum/funcoes.php"; //inicia configuracoes

global $db;

session_start();

if (isCookieSet()) {
	$sql = "SELECT REGIAO FROM $users_table WHERE ID = " . $_SESSION[conta];
	$result_regiao = $db->query($sql);
	$conta = $db->fetch_array($result_regiao);
	
	$regiao = $conta['REGIAO'];
}
else {
	$regiao = 1;
}

if (!isset($_GET['id'])) {
$sql_principal  = "SELECT * FROM $ofertas_table WHERE REGIAO = $regiao AND PRINCIPAL =1";
$sql = "SELECT * FROM $ofertas_table WHERE REGIAO = $regiao and id not in (SELECT id FROM $ofertas_table WHERE REGIAO = $regiao AND PRINCIPAL =1) ";
}
else{
$sql_principal  = "SELECT * FROM $ofertas_table WHERE  ID =".$_GET['id']."";
$sql = "SELECT * FROM $ofertas_table WHERE REGIAO = $regiao and ID !=".$_GET['id']."";
}


$result_ofertas = $db->query($sql);

$result_oferta_principal = $db->query($sql_principal);
$principal=$db->fetch_array($result_oferta_principal);
echo $principal['ID'];

echo "	<!DOCTYPE html>
			<html>
				<head>
					<meta name='viewport' content='initial-scale=1.0, user-scalable=no' />
					<meta http-equiv= 'Content-Type' content='text/html; charset=ISO-8859-1' />
					<meta name='description' content='Compra coletiva' />
					<meta http-equiv='refresh' content='900' />
					<title>mesalve - Compra Coletiva</title>
					
					<link rel='stylesheet' type='text/css' href='css/geral.css'/>
					
					<script type='text/javascript' src='js/countdownpro.js' defer='defer'></script>
						<meta scheme='countdown1' name='d_before' content=''>
						<meta scheme='countdown1' name='d_units' content=' DIAS'>
						<meta scheme='countdown1' name='d_unit' content=' DIA'>
						<meta scheme='countdown1' name='d_after' content=' | '>
						<meta scheme='countdown1' name='h_before' content=''>
						<meta scheme='countdown1' name='h_units' content=''>
						<meta scheme='countdown1' name='h_unit' content=''>
						<meta scheme='countdown1' name='h_after' content=':'>
						<meta scheme='countdown1' name='m_before' content=''>
						<meta scheme='countdown1' name='m_units' content=''>
						<meta scheme='countdown1' name='m_unit' content=''>
						<meta scheme='countdown1' name='m_after' content=':'>
						<meta scheme='countdown1' name='s_before' content=''>
						<meta scheme='countdown1' name='s_units' content=''>
						<meta scheme='countdown1' name='s_unit' content=''>
						<meta scheme='countdown1' name='s_after' content=''>
						<meta scheme='countdown1' name='event_msg' content='ENCERRADO'>
					
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
						
							require "comum/cabecalho.php";
						
echo "						<div style='position:relative;float:left;width:100%;margin-top:10px;'>
							
								<div style='position:absolute;float:left;width:64%;height:260px;z-index:20;margin-top:90px'>
									<div style='position:relative;float:left;width:35%;height:100%;'>
										<div class='preco_etiqueta'>
											<div class='caixa_valor_real'>
												R$ " . $principal['VALOR_REAL'] . "
											</div>
											<div class='caixa_valor_desconto'>
												R$ " . $principal['VALOR_DESCONTO'] . "
											</div>
											
											<div style='position:relative;float:left;width:100%;text-align:center'>
												<div class='externo_botao'>
													<div class='botao_compra'>COMPRAR</div>
												</div>
											</div>
											
										</div>
										<div style='position:relative;float:left;height:100%;'>
											<img src='imagens/quina_externa.gif'>
										</div>
										<div class='info_subetiqueta'>
											<div style='position:relative;float:left;width:100%;font-size:1.1em;font-weight:bold;letter-spacing:2px;color:#BF0000'>
												Cupons Vendidos
											</div>
										</div>
										<div class='info_subetiqueta'>
											<div style='position:relative;float:left;width:100%;font-size:1.6em;font-weight:bold;color:#111;margin-top:6px;margin-bottom:3px'>
												<span id='countdown1'>" . $principal['DATA_ENCERRAMENTO'] . " GMT-03:00</span>
											</div>
											<div style='position:relative;float:left;width:100%;font-size:1.1em;font-weight:bold;letter-spacing:2px;color:#BF0000'>
												Tempo Restante
											</div>
										</div>
									</div>
									<div class='img_oferta' style=\"background: url('imagens/fotos/" . $principal['FOTO1'] . "') no-repeat\">
									</div>
								</div>
							
								<div class='caixa_oferta'>
									<div class='titulo_oferta'>
										" . substr($principal['TITULO_OFERTA'], 0, 59) . "
									</div>
								</div>";
							
								for($j=0;$j<3;$j++){
									
									$oferta = $db->fetch_array($result_ofertas);
									
									echo "	<div class='caixa_oferta_lat'>
												<div style=\"position:relative;float:left;width:100%;height:54%;background: url('imagens/fotos/" . $oferta['FOTO1'] . "') no-repeat;\"></div>
												<div class='titulo_oferta_menor'>
													" . substr($oferta['TITULO_OFERTA'], 0, 64) . "
												</div>
												<div class='info_caixa_menor'>
													<div style='position:relative;float:left;width:33%;text-align:center;color:#AE7575;text-decoration:line-through;margin-top:4px'>
														R$ " . $oferta['VALOR_REAL'] . "
													</div>
													<div style='position:relative;float:left;width:33%;text-align:center;color:#6A0000;margin-top:4px'>
														R$ " . $oferta['VALOR_DESCONTO'] . "
													</div>
													<div style='position:relative;float:left;width:33%;text-align:center'>
													<a href=oferta.php?id=".$oferta['ID'].">
														<input name='detalhes' type='button' class='button_padrao' value='Detalhes' />
													</a>
													</div>
												</div>
											</div>";
								
								}
							
echo "						</div>";

							$num_ofertas = $db->num_rows($result_ofertas);
							echo "num ofertas".$num_ofertas;
							if ($num_ofertas>=3) {
								
								for($j=3;$j<$num_ofertas;$j++){
									echo "teste";
									$oferta = $db->fetch_array($result_ofertas);
									
									echo "	<div class='caixa_oferta_inf'>
												<div style=\"position:relative;float:left;width:100%;height:54%;background: url('imagens/fotos/" . $oferta['FOTO1'] . "') no-repeat;\"></div>
												<div class='titulo_oferta_menor'>
													" . substr($oferta['TITULO_OFERTA'], 0, 64) . "
												</div>
												<div class='info_caixa_menor'>
													<div style='position:relative;float:left;width:33%;text-align:center;color:#AE7575;text-decoration:line-through;margin-top:4px'>
														R$ " . $oferta['VALOR_REAL'] . "
													</div>
													<div style='position:relative;float:left;width:33%;text-align:center;color:#6A0000;margin-top:4px'>
														R$ " . $oferta['VALOR_DESCONTO'] . "
													</div>
													<div style='position:relative;float:left;width:33%;text-align:center'>
														<a href=oferta.php?id=".$oferta['ID'].">
															<input name='detalhes' type='button' class='button_padrao' value='Detalhes' />
														</a>
													</div>
												</div>
											</div>";
								}
							}
							
echo "					</div>
					</div>
					<div class='rodape'>
						<div class='caixas_submain'>";
							
echo "					</div>
					</div>
				</body>
			</html>";

?>