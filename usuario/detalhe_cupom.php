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
//consulta conta registrada do usuario
$sql = "SELECT *, DATE_FORMAT(CUPONS.VENCIMENTO, '%d/%m/%Y %H:%i') VENCIMENTO
		FROM $cupons_table CUPONS, $ofertas_table OFERTAS
		WHERE CUPONS.ID = " . $_GET[id];


$result_cupom = $db->query($sql);
$cupom = $db->fetch_array($result_cupom);
	
echo $cupom['TITULO_OFERTA'] . " - " . $cupom['VENCIMENTO'];


}

 ?>    
 <a href="converttopdf.php?id=<?php echo $_GET[id];?>">Demo</a>

   