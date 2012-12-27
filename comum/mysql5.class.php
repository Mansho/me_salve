<?php
/**
arquivo: mysql5.class.php

Arquivo integrante do sistema de Leilão de Fretes desenvolvido por INKID
Autor: Caio de Oliveira Hodos
Contato: caio.hodos@yahoo.com.br

Copyright 2011 INKID
contato@inkid.net
http://www.inkid.net
 
*/

header('Content-Type: text/html; charset=ISO-8859-1');

class mysql5 {
    var $db_host;
    var $db_user;
    var $db_pwd;
    var $db_name;
    var $queries = 0;
    var $connections = 0;
    var $link;

	//carrega variaveis passadas em inicia_cfg.php
    function set($db_host, $db_user, $db_pwd, $db_name)
    {
        $this->db_host = $db_host;
        $this->db_user = $db_user;
        $this->db_pwd = $db_pwd;
        $this->db_name = $db_name;
    }

    function connect()
    {
        // connect to mysql
        $this->link = mysql_connect($this->db_host, $this->db_user, $this->db_pwd)
        or die("Could not connect to mysql server: " . mysql_error());
		mysql_set_charset('ISO-8859-1',$this->link); 
		//$charset = mysql_client_encoding($this->link);
		//echo "enc".$charset;
        // connect to the database
        mysql_select_db($this->db_name, $this->link)
        or die("Database: database not found");
        $this->connections++;
        // return $db_link for other functions
        // return $link;
    }

	//realiza consulta
    function query($sql)
    {
		//echo $sql . "<br>";
        if (!isset($this->link)) {
            $this->connect();
        }
        $result = mysql_query($sql, $this->link)
        or die("Invalid query: " . mysql_error());
        // used for other functions
        $this->queries++;
        return $result;
    }

    function fetch_array($result)
    {
        // create an array called $row
        $row = mysql_fetch_array($result);
        // return the array $row or false if none found
        return $row;
    }

    function num_rows($result)
    {
        // determine row count
        $num_rows = mysql_num_rows($result);
        // return the row count or false if none foune
        return $num_rows;
    }

    function insert_id()
    {
        // connect to the database
        // $link = $this->connect();
        // Get the ID generated from the previous INSERT operation
        $last_id = mysql_insert_id($this->link);
        // return last ID
        return $last_id;
    }

    function num_fields($result)
    {
        $result = mysql_num_fields($result);
        return $result;
    }
}

?>