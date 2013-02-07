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

if ($_GET['id']) {
	$id = $_GET['id'];
}
else {
	header("Location: ../oferta.php?error=17");
    exit;
}

$sql_oferta  = "SELECT * FROM $ofertas_table WHERE  ID = $id";
$result_oferta = $db->query($sql_oferta);
$num_ofertas = $db->num_rows($result_oferta);

if ($num_ofertas != 1) {
	header("Location: ../oferta.php?error=17");
    exit;
}

$oferta = $db->fetch_array($result_oferta);

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
					
					<script type='text/javascript'>
						function calculaTotal(){	
							
							var quantidade = document.getElementsByName('quantidade[]')

							var soma = 0;

							for (var i = 0; i < quantidade.length ; i++)
							{
								soma = soma + parseInt(quantidade[i].value);
							}
							
							var total = soma * " . $oferta['VALOR_DESCONTO'] . ";
							total = parseFloat(total).toFixed(2);
							document.getElementById('total_compra').innerHTML  = total;
						}
					</script>
					
					<script type='text/javascript'>
						function calculaSubtotal(div,quant){							
							var val = quant * " . $oferta['VALOR_DESCONTO'] . ";
							val = parseFloat(val).toFixed(2);
							var val_text = 'R$ ' + val;
							document.getElementById(div).innerHTML  = val_text;
							
							calculaTotal();
						}
					</script>
					
					<script type='text/javascript'>
						function insereAdicional(camada){
							var next = camada + 1;
							
							var val = \"<div style='position:relative;float:left;width:98%;margin-left:1%;padding-bottom:4px;margin-top:4px;'><div style='position:relative;float:left;width:50%'><input style='position:relative;float:left;width:90%;background-color:#F3EBEB;border:1px solid #6A0000;border-radius:3px;font-size:1.2em;padding:3px;color:#6A0000;font-weight:bold' /></div><div style='position:relative;float:left;width:20%;margin-left:58px;'><div style='position:relative;float:left;width:30%'><input name='quantidade[]' style='position:relative;float:left;width:80%;background-color:#F3EBEB;border:1px solid #6A0000;border-radius:3px;font-size:1.2em;padding:3px;color:#6A0000;font-weight:bold' value='1' onkeyup=\\\"calculaSubtotal('subtotal\"+camada+\"',this.value)\\\"/></div><div style='position:relative;float:left;color:#6A0000;font-weight:bold;font-size:1.2em;margin-top:3px'>x R$ " . $oferta['VALOR_DESCONTO'] . "</div></div><div id='subtotal\"+camada+\"' style='position:relative;float:left;margin-left:142px;margin-top:1px;color:#6A0000;font-weight:bold;font-size:1.2em;'>R$ " . $oferta['VALOR_DESCONTO'] . "</div></div><div id='adicional\"+next+\"' style='position:relative;float:left;width:100%;'><input id='camada\"+next+\"' type='hidden' value='\"+next+\"' /><input type='button' class='button_padrao' style='width:auto;padding:4px;font-size:1.1em;border-radius:5px;margin-left:10px' value='Adicionar' onclick='insereAdicional(camada\"+next+\".value);calculaTotal();' /></div>\";
							
							document.getElementById('adicional'+camada).innerHTML  = val;
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
								<div class='caixa_padrao' style='overflow:hidden;height:auto'>
									<div style='position:relative;float:left;width:100%;padding:4px;padding-left:8px;background-color:#6A0000;color:#FFF;font-size:1.7em;font-weight:bold'>
									Sua Compra
									</div>
									
									<div style='position:relative;float:left;width:100%;padding:6px;background-color:#F3EBEB;border-bottom: 1px solid #E9D9D9;'>
										<div style='position:relative;float:left;width:12%;'>
											<div class='imagem_edita_oferta' style=\"border-radius:0px;height:80px;background: url('../imagens/fotos/" . $oferta['FOTO1'] . "') no-repeat;background-size:contain;background-position:center;\"></div>						
										</div>
										<div style='position:relative;float:left;font-size:1.6em;font-weight:bold'>" . $oferta['TITULO_OFERTA'] . "</div>
									</div>
									
									<div style='position:relative;float:left;width:98%;margin-left:1%;padding-bottom:2px;margin-top:4px;border-bottom:1px solid #6A0000;color:#6A0000;font-weight:bold;font-size:1.4em'>
										<div style='position:relative;float:left;margin-left:8px'>Nome</div>
										<div style='position:relative;float:left;margin-left:480px'>Quantidade</div>
										<div style='position:relative;float:left;margin-left:250px'>Subtotal</div>
									</div>
									<form id='form_compra' name='form_compra' method='post' action='" . $_SERVER['PHP_SELF'] . "'>	
									<div style='position:relative;float:left;width:98%;margin-left:1%;padding-bottom:4px;margin-top:4px;'>
										<div style='position:relative;float:left;width:50%'>
											<input style='position:relative;float:left;width:90%;background-color:#F3EBEB;border:1px solid #6A0000;border-radius:3px;font-size:1.2em;padding:3px;color:#6A0000;font-weight:bold' />
										</div>
										<div style='position:relative;float:left;width:20%;margin-left:58px;'>
											<div style='position:relative;float:left;width:30%'>
												<input name='quantidade[]' style='position:relative;float:left;width:80%;background-color:#F3EBEB;border:1px solid #6A0000;border-radius:3px;font-size:1.2em;padding:3px;color:#6A0000;font-weight:bold' value='1' onkeyup=\"calculaSubtotal('subtotal1',this.value)\"/>
											</div>
											<div style='position:relative;float:left;color:#6A0000;font-weight:bold;font-size:1.2em;margin-top:3px'>
												x R$ " . $oferta['VALOR_DESCONTO'] . "
											</div>
										</div>
										<div id='subtotal1' style='position:relative;float:left;margin-left:142px;margin-top:1px;color:#6A0000;font-weight:bold;font-size:1.2em;'>R$ " . $oferta['VALOR_DESCONTO'] . "</div>
									</div>
									<div id='adicional2' style='position:relative;float:left;width:100%;margin-bottom:8px'>
										<input id='camada2' type='hidden' value='2' />
										<input type='button' class='button_padrao' style='width:auto;padding:4px;font-size:1.1em;border-radius:5px;margin-left:10px' value='Adicionar' onclick=\"insereAdicional(camada2.value);calculaTotal();\" />
									</div>
									
									<div style='position:relative;float:left;bottom:0px;width:98%;padding:4px;padding-right:20px;background-color:#6A0000;color:#FFF;font-size:1.4em;font-weight:bold;'>
										<div id='total_compra' style='position:relative;float:right;'>" . $oferta['VALOR_DESCONTO'] . "</div>
										<div style='position:relative;float:right;'>Total a pagar: R$&nbsp;</div>
									</div>
									</form>
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