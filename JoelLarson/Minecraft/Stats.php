<?php

namespace Minecraft;

class Stats {

	public static function retrieve( \Minecraft\Server $server )
	{
		$socket = stream_socket_client(sprintf('tcp://%s:%u', $server->getHostname(), $server->getPort()), $errno, $errstr, 1);

		if(!$socket) {
			throw new StatsException("Could not connect to the Minecraft server.");
		}

		fwrite($socket, "\xfe");
		
		$data = fread($socket, 256);
		
		fclose($socket);

		$stats = new \stdClass;

		// Is this a disconnect with the ping?
		if($data[0] !== "\xFF") {
			$stats->is_online = false;
			return $stats;
		}

		$data = substr($data, 3);
		$data = mb_convert_encoding($data, 'auto', 'UCS-2');
		$data = explode("\xA7", $data);		

		$stats->is_online = true;
		list($stats->motd, $stats->online_players, $stats->max_players) = $data;

		return $stats;
	}

}