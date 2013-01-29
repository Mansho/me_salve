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

//consulta conta registrada do usuario
$sql = "SELECT *, CUPONS.ID CUPOM, DATE_FORMAT(CUPONS.VENCIMENTO, '%d/%m/%Y %H:%i') VENCIMENTO
		FROM $cupons_table CUPONS, $ofertas_table OFERTAS
		WHERE CUPONS.USUARIO = " . $_SESSION[conta] . "
			AND CUPONS.OFERTA = OFERTAS.ID";

if ($_GET['opcao'] == 'disponiveis') {
 $sql .= " AND CUPONS.STATUS = 1";
}

if ($_GET['opcao'] == 'usados') {
 $sql .= " AND CUPONS.STATUS = 2";
}

if ($_GET['opcao'] == 'vencidos') {
 $sql .= " AND CUPONS.STATUS = 3";
}

$result_cupons = $db->query($sql);
$num_cupons = $db->num_rows($result_cupons);



for($j=0;$j<$num_cupons;$j++){
	$cupom = $db->fetch_array($result_cupons);
	
	echo "	<div style='position:relative;float:left;width:98.6%;padding:6px;background-color:#F3F3F3;border-radius:6px;border-bottom: 2px dotted #DDD;'>
				<div style='position:relative;float:left;width:12%;'>
					<div class='imagem_edita_oferta' style=\"border-radius:0px;height:80px;background: url('../imagens/fotos/" . $cupom['FOTO1'] . "') no-repeat;background-size:contain;background-position:center;\"></div>						
				</div>
				<div class='caixa_desc_cupom'>" . $cupom['TITULO_OFERTA'] . "</div>
				<div style='position:relative;float:left;margin-left:16px;font-weight:bold;font-size:1.6em;color:#666;text-align:center;margin-top:15px'>
					Utilizar até:</br>
					<span style='font-size:1.2em;color:#222;'>" . $cupom['VENCIMENTO'] . "</span>
				</div>
				<div style='position:relative;float:right;margin-right:6px;height:82px;border-left: 2px dotted #555;padding-left:11px'>
					<div style='position:relative;float:left;margin-top:26px'>
						<input id='atualiza_oferta' name='atualiza_oferta' type='button' class='button_padrao' style='width:auto' value='Visualizar Cupom' onclick=\"display_div('cover','block'),display_div('exibe_cupom','block'),DetalhesCupons(" . $cupom['CUPOM'] . ")\"/>
					</div>
				</div>
			</div>";

}



?>