<?php
error_reporting(E_ERROR);
set_time_limit(0);
ob_implicit_flush();

if(count($argv) < 2)
{
	die("\nUsage: php cliente.php <destination> <port>\n");
}

$sock = socket_create(AF_INET,SOCK_STREAM,0);

if(socket_connect($sock, $argv[1], $argv[2]))
{
	echo "Cliente conectado!";
}
else
{
	echo "Conexão Recusada";
}
