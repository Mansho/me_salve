<?php

/**

Arquivo integrante do sistema de Compras Coletivas desenvolvido por INKID
Autor: Caio de Oliveira Hodos
Contato: caio.hodos@inkid.net

Copyright 2011 INKID
contato@inkid.net
http://www.inkid.net
 
*/

function insereImagem($foto) {
	
	// Largura máxima em pixels
	$largura = 1500;
	// Altura máxima em pixels
	$altura = 1800;
	// Tamanho máximo do arquivo em bytes
	$tamanho = 100000;
 
   	// Verifica se o arquivo é uma imagem
    if(!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $foto["type"])){
	   header("Location: registra_leilao.php?error=10");
       exit;
   	} 
 
	// Pega as dimensões da imagem
	$dimensoes = getimagesize($foto["tmp_name"]);
 
	// Verifica se a largura da imagem é maior que a largura permitida
	if($dimensoes[0] > $largura) {
		header("Location: registra_leilao.php?error=7");
        exit;
	}
 
	// Verifica se a altura da imagem é maior que a altura permitida
	if($dimensoes[1] > $altura) {
		header("Location: registra_leilao.php?error=8");
        exit;
	}
 
	// Verifica se o tamanho da imagem é maior que o tamanho permitido
	if($foto["size"] > $tamanho) {
		header("Location: registra_leilao.php?error=9");
        exit;
	}

 
	// Pega extensão da imagem
	preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);
 
    // Gera um nome único para a imagem
    $nome_imagem = md5(uniqid(time())) . "." . $ext[1];
 
    // Caminho de onde ficará a imagem
    $caminho_imagem = "../imagens/fotos/" . $nome_imagem;
 
	// Faz o upload da imagem para seu respectivo caminho
	move_uploaded_file($foto["tmp_name"], $caminho_imagem);
	
	return $nome_imagem;

}

?>