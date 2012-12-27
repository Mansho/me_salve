<?php

/**
arquivo: inicia_cfg.php

Arquivo integrante do sistema de Leilão de Fretes desenvolvido por INKID
Autor: Caio de Oliveira Hodos
Contato: caio.hodos@yahoo.com.br

Copyright 2011 INKID
contato@inkid.net
http://www.inkid.net
 
*/

$db = new $database ();
$db->set($db_host, $db_user, $db_pwd, $db_name);

//verifica se arquivo de configuracao existe, atalho em arquivos_cfg.php
if (file_exists($diretorio_configuracoes))
{
	$configuracoes_sistema = parse_ini_file($diretorio_configuracoes); //pega diversas regras existentes
}
else
{
	echo "Arquivo de configuração não encontrado!";
	exit;
}

$onoff= $configuracoes_sistema[onoff]; //sistema ligado ou desligado

?>