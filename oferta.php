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
//require_once "../comum/funcoes.php"; //inicia configuracoes

global $db;

$sql = "SELECT * FROM $ofertas_table";
$result = $db->query($sql);
$oferta = $db->fetch_array($result);

echo "	<!DOCTYPE html>
			<html>
				<head>
					<meta name='viewport' content='initial-scale=1.0, user-scalable=no' />
					<meta http-equiv= 'Content-Type' content='text/html; charset=ISO-8859-1' />
					<meta name='description' content='Compra coletiva' />
					<meta http-equiv='refresh' content='900' />
					<title>mesalve - Compra Coletiva</title>
					
					<link rel='stylesheet' type='text/css' href='css/geral.css'/>
					
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
						
echo "						<div style='position:relative;float:left;width:100%;margin-top:110px;'>
							
								<div style='position:absolute;float:left;width:64%;height:260px;z-index:20;margin-top:90px'>
									<div style='position:relative;float:left;width:35%;height:100%;'>
										<div class='preco_etiqueta'>
											<div class='caixa_valor_real'>
												R$ " . $oferta['VALOR_REAL'] . "
											</div>
											<div class='caixa_valor_desconto'>
												R$ " . $oferta['VALOR_DESCONTO'] . "
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
										</div>
										<div class='info_subetiqueta'>	
										</div>
									</div>
									<div class='img_oferta' style=\"background: url('imagens/" . $oferta['FOTO1'] . "') no-repeat\">
									</div>
								</div>
							
								<div class='caixa_oferta'>
									<div class='titulo_oferta'>
										" . substr($oferta['TITULO_OFERTA'], 0, 59) . "
									</div>
								</div>
							
								<div class='caixa_oferta_lat'>
								</div>
							
								<div class='caixa_oferta_lat' style='margin-top:16px'>
									<div style=\"position:relaive;float:left;width:100%;height:38%;background: url('imagens/" . $oferta['FOTO1'] . "') no-repeat;\">
									</div>
								</div>
							
								<div class='caixa_oferta_lat' style='margin-top:16px'>
								</div>
							</div>
							
							<div class='caixa_oferta_inf'>
							</div>
							
							<div class='caixa_oferta_inf'>
							</div>
							
							<div class='caixa_oferta_inf'>
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