<?php
error_reporting(E_ERROR);
set_time_limit(0);
ob_implicit_flush();

if(count($argv) < 2)
{
	die("\nUsage: php php_socket_example.php <address> <port>\n");
}

$sock = socket_create(AF_INET,SOCK_STREAM,0);
socket_bind($sock, $argv[1], $argv[2]);
socket_listen($sock);

echo "\n[------------------------ Server started at ". $argv[1] . ":" .$argv[2] . " ---------------------------------]\n";

$client = array();
		
while(true)
{
	socket_set_block($sock);
	
	$read[0] = $sock;
	
	for($i = 0; $i < 5; $i++)
	{
		if($client[$i]['sock'] != null)
			$read[$i+1] = $client[$i]['sock'];
	}
	
	$ready = socket_select($read, $write = NULL, $except = NULL, $tv_sec = NULL);
	

	if(in_array($sock,$read))
	{
		for($i = 0;$i < 5; $i++)
		{
			if($client[$i]['sock'] == null)
			{
				if(($client[$i]['sock'] = socket_accept($sock)) < 0)
				{
					echo "Accept failed: ".socket_strerror($client[$i]['sock']);
				}
				else
				{
					echo "\n------------------------------- Client #".$i." connected! ------------------------------------\n";
				}
				
				break;
			}
			elseif($i == 4)
			{
				echo "The maximum client number (5) was exceeded";
			}
		}
		
		if(--$ready <= 0)
		continue;
	}
}
			