<?php

/**
arquivo: arquivos_cfg.php

Arquivo integrante do sistema de Leilão de Fretes desenvolvido por INKID
Autor: Caio de Oliveira Hodos
Contato: caio.hodos@yahoo.com.br

Copyright 2011 INKID
contato@inkid.net
http://www.inkid.net
 
*/

$dir_cfg_servidor = "configuracao/cfg_servidor.php";

if (file_exists($dir_cfg_servidor)){
    $confg_servidor = parse_ini_file($dir_cfg_servidor);
}
else{
    printError("Arquivo de configuração do servidor não encontrado!");
    exit;
}

$database = $confg_servidor[database];
$db_host = $confg_servidor[db_host];
$db_user = $confg_servidor[db_user];
$db_pwd = $confg_servidor[db_pwd];
$db_name = $confg_servidor[db_name];

//link para arquivo de configuracao
$diretorio_configuracoes = "configuracao/configuracoes.php";


$ofertas_table = "salve_ofertas";
$cidades_table = "salve_cidades";
$status_table = "salve_status_ofertas";
$users_table = "salve_usuarios";

?>