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
ob_end_flush();
//consulta conta registrada do usuario
$sql = "SELECT *, DATE_FORMAT(CUPONS.VENCIMENTO, '%d/%m/%Y %H:%i') VENCIMENTO
		FROM $cupons_table CUPONS, $ofertas_table OFERTAS
		WHERE CUPONS.ID = " . $_GET[id];


$result_cupom = $db->query($sql);
$cupom = $db->fetch_array($result_cupom);


// New - Novo documento PDF com orientação P - Retrato (Picture) que pode ser também L - Paisagem (Landscape)
$pdf= new FPDF('P',"mm","A4");
 
$pdf-> Open();
 
// Definindo Fonte
$pdf->SetFont('arial','',10);
 
//posicao vertical no caso -1 e o limite da margem
$pdf->SetY("-2");
 
        //::::::::::::::::::Cabecalho::::::::::::::::::::
       
        $pdf->Cell(0,5,$cupom['TITULO_OFERTA'],0,1,'R');
        $pdf->Cell(0,0,'',1,1,'L');
 
        $pdf->Ln(8);    
 
        $pdf-> SetFont('arial','B',10);
        $pdf->SetFillColor(122,122,122);
 
        $pdf-> SetFont('Times','B',9);
        $pdf-> Cell(30,5,'mesalve: ',0,0);
        $pdf-> SetFont('Times','',9);
        $pdf-> Cell(75,5,'@mesalve',0,1);
        $pdf-> Ln(3);
 
        $pdf-> SetFont('Times','B',9);
        $pdf-> Cell(30,5,'REGULAMENTO: ',0,1);
        $pdf-> SetFont('Times','',9);
        $pdf-> MultiCell(75,5,$cupom['REGULAMENTO'],0,1);
		
		$pdf-> Cell(30,5,'DESTAQUES: ',0,1);
        $pdf-> SetFont('Times','',9);
        $pdf-> MultiCell(75,5,$cupom['DESTAQUES'],0,1);
         
        $pdf-> Output(rand(1000,100000000) . '.pdf','D');
		ob_end_flush();

 ?>    

   