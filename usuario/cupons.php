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
	header("Location: ../oferta.php?error=999");
    exit;
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
					
					<script type='text/javascript' src='../js/jquery-1.7.1.min.js'></script>
					
					<script type='text/javascript'>
						function CarregaCupons(opcao) {
							if(opcao){
						
								if (opcao == 'todos') {
									document.getElementById('todos').setAttribute('class', 'menu');
									document.getElementById('disponiveis').setAttribute('class', 'menu_middle_off');
									document.getElementById('usados').setAttribute('class', 'menu_middle_off');
									document.getElementById('vencidos').setAttribute('class', 'menu_middle_off');
								}
						
								if (opcao == 'disponiveis') {
									document.getElementById('todos').setAttribute('class', 'menu_middle_off');
									document.getElementById('disponiveis').setAttribute('class', 'menu');
									document.getElementById('usados').setAttribute('class', 'menu_middle_off');
									document.getElementById('vencidos').setAttribute('class', 'menu_middle_off');
								}
								
								if (opcao == 'usados') {
									document.getElementById('todos').setAttribute('class', 'menu_middle_off');
									document.getElementById('disponiveis').setAttribute('class', 'menu_middle_off');
									document.getElementById('usados').setAttribute('class', 'menu');
									document.getElementById('vencidos').setAttribute('class', 'menu_middle_off');
								}
								
								if (opcao == 'vencidos') {
									document.getElementById('todos').setAttribute('class', 'menu_middle_off');
									document.getElementById('disponiveis').setAttribute('class', 'menu_middle_off');
									document.getElementById('usados').setAttribute('class', 'menu_middle_off');
									document.getElementById('vencidos').setAttribute('class', 'menu');
								}
							}
						}
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
						
echo "						<div style='position:relative;float:left;width:100%;margin-top:10px;padding-top:14px'>
							
								<div id='todos' class='menu' style='border-top-left-radius:6px;' onclick=\"CarregaCupons('todos')\">Todos</div>
								<div id='disponiveis' class='menu_middle_off' onclick=\"CarregaCupons('disponiveis')\">Disponíveis</div>
								<div id='usados' class='menu_middle_off' onclick=\"CarregaCupons('usados')\">Usados</div>
								<div id='vencidos' class='menu_middle_off' style='border-top-right-radius:6px;' onclick=\"CarregaCupons('vencidos')\">Vencidos</div>

								<div style='position:relative;float:left;width:99%;height:600px;background-color:#FFF;border:4px solid #AA0000;border-radius:10px;border-top-left-radius:0px;border-top:0px'>
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