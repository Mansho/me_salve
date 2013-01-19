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
	   header("Location: nova_oferta.php?error=10");
       exit;
   	} 
 
	// Pega as dimensões da imagem
	$dimensoes = getimagesize($foto["tmp_name"]);
 
	// Verifica se a largura da imagem é maior que a largura permitida
	if($dimensoes[0] > $largura) {
		header("Location: nova_oferta.php?error=7");
        exit;
	}
 
	// Verifica se a altura da imagem é maior que a altura permitida
	if($dimensoes[1] > $altura) {
		header("Location: nova_oferta.php?error=8");
        exit;
	}
 
	// Verifica se o tamanho da imagem é maior que o tamanho permitido
	if($foto["size"] > $tamanho) {
		header("Location: nova_oferta.php?error=9");
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

function isCookieSet()
{
	if (checkUser($_SESSION["user"], $_SESSION["enc_pwd"], TRUE) && $_SESSION["user"] != '')
        return true;
    else
        return false;
}

// Verifica teste de cookie e encaminha para verificaÃ§Ã£o no banco
function checkUser($name, $pwd, $cookieCheck = FALSE)
{

	//Define nome temporÃ¡rio caso esteja fazendo teste de Cookie
	if ($name == '' AND $cookieCheck == TRUE){
		$name = 'dummyusernamenoteverused'; // dummy username
		}

    return checkUserDB($name, $pwd);
}

function checkUserDB($name, $pwd)
{
    global $users_table, $db;
	//verifica existencia do nome no banco e retorna caso senha esteja correta
    $sql = "select * from " . $users_table . " where email='" . $name . "'";
    $result = $db->query($sql);
    $num_rows = $db->num_rows($result);

    if ($num_rows != 1)
        return false;
		
    $row = $db->fetch_array($result);

	//verifica se senha estÃ¡ correta
    if (!checkPwd($pwd, $row['SENHA']))
        return false;

    return $row['ID'];
}

function checkADM($conta)
{
    global $users_table, $db;
	//verifica existencia do nome no banco e retorna caso senha esteja correta
    $sql = "select * from " . $users_table . " where id=" . $conta . " and adm = 1";
    $result = $db->query($sql);
    $num_rows = $db->num_rows($result);

    if ($num_rows != 1)
        return false;
	else 
		return true;
}

function checkPwd($pwd1, $pwd2)
{
    if ($pwd1 == $pwd2)
        return true;
    else
        return false;
}

function isAdministrator($conta)
{
    global $users_table, $db;

    $sql = "select * from " . $users_table . " where ID='" . $conta . "' and ADM=1";
    $result = $db->query($sql);
    $num_rows = $db->num_rows($result);

    if ($num_rows == 1) {
        return true;
    } else {
        return false;
    }
}

?>