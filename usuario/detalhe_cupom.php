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
require_once "../fpdf16/fpdf.php";

global $db;

session_start();

if (!isCookieSet()) {
	header("Location: ../oferta.php?error=14");
    exit;
}
if(!($_SERVER['REQUEST_METHOD'] == 'POST')) {

ob_end_flush();

$sql = "SELECT *, CUPONS.ID CUPOM
		FROM $cupons_table CUPONS, $ofertas_table OFERTAS
		WHERE CUPONS.ID = " . $_GET[id] . "
		AND CUPONS.OFERTA = OFERTAS.ID
		AND CUPONS.USUARIO = " . $_SESSION[conta];


$result_cupom = $db->query($sql);

$num_cupom = $db->num_rows($result_cupom);

if ($num_cupom != 1) {
	header("Location: ../oferta.php?error=15");
    exit;
}

$cupom = $db->fetch_array($result_cupom);

echo "<div id='fechar_cupom' style='position:relative;float:left;width:100%;text-align:right;color:#FFF;margin-bottom:6px;cursor:pointer' onclick=\"display_div('cover','none'),display_div('exibe_cupom','none')\">Fechar</div>";
echo 	"<div class='caixa_interna_cupom'>
			<div style='position:relative;float:left;width:700px;height:100%;margin-left:50%;left:-350px'>
				<div style='position:relative;float:left;width:100%;'>
					<div style='position:relative;float:left;'>
						<img src='../imagens/logo_branco.jpg'>
					</div>
					<div style='position:relative;float:right;font-size:2.3em;font-family:Verdana, Geneva, sans-serif;color:#6A0000;margin-top:16px'>
						Cupom Me Salve
					</div>
				</div>
				<div style='position:relative;float:left;width:94%;padding:2.5%;border:2px solid #6A0000'>
					<div style='position:relative;float:left;width:98%;font-size:1.7em;font-weight:bold'>Nome</div>
					
					<div style='position:relative;float:left;width:98%;font-size:1.4em;font-weight:bold;color:#333;margin-top:16px'>Estabelecimento</div>
					<div style='position:relative;float:left;width:98%;font-size:1.2em;color:#333;'>Nome Estabelecimento</div>
					
					<div style='position:relative;float:left;width:98%;font-size:1.4em;font-weight:bold;color:#333;margin-top:16px'>Produto</div>
					<div style='position:relative;float:left;width:98%;font-size:1.2em;color:#333;'>Descrição produtos</div>
					
					<div style='position:relative;float:left;width:98%;font-size:1.4em;font-weight:bold;color:#333;margin-top:16px'>Endereço</div>
					<div style='position:relative;float:left;width:98%;font-size:1.2em;color:#333;'>Descrição endereço</div>
					<div style='position:relative;float:left;width:98%;font-size:1.2em;color:#333;'><span style='font-size:1.1em;font-weight:bold;'>Telefone: </span>Descrição telefone</div>
					
					<div style='position:relative;float:left;width:30%;font-size:1.4em;color:#333;margin-top:16px'><b>Valor Original</b><br />R$ 20,00</div>
					<div style='position:relative;float:left;width:30%;font-size:1.4em;color:#333;margin-top:16px'><b>Valor Pago</b><br />R$ 10,00</div>
					
					<div style='position:relative;float:left;width:30%;font-size:1.4em;color:#333;margin-top:16px'><b>Código</b><br />ABC123XYZ</div>
				</div>
				<div id='print_cupom' style='position:absolute;bottom:0px;width:100%;text-align:center'>
					<input id='imprimir' type='button' class='button_padrao' style='width:auto' value='Imprimir' onclick='printpage()'>
				</div>
			</div>
		</div>";


//echo "<div class='caixa_interna_cupom'>" . $cupom['TITULO_OFERTA'] . " - " . $cupom['VENCIMENTO'] . "<a href='converttopdf.php?id=" . $_GET[id] . "'>Demo</a></div>";


}

 ?>    
 

   