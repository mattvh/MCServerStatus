<?php

class MCServerStatus {


	public $server;
	public $online, $motd, $online_players, $max_players;
	public $error = "OK";



	function __construct($url, $port = '25565') {

		$this->server = array(
			"url" => $url,
			"port" => $port
		);

		if ( $sock = @stream_socket_client('tcp://'.$url.':'.$port, $errno, $errstr, 1) ) {

			$this->online = true;

			fwrite($sock, "\xfe");
			$h = fread($sock, 2048);
			$h = str_replace("\x00", '', $h);
			$h = substr($h, 2);
			$data = explode("\xa7", $h);
			unset($h);
			fclose($sock);

			if (sizeof($data) == 3) {
				$this->motd = $data[0];
				$this->online_players = (int) $data[1];
				$this->max_players = (int) $data[2];
			}
			else {
				$this->error = "Cannot retrieve server info.";
			}

		}
		else {
			$this->online = false;
			$this->error = "Cannot connect to server.";
		}

	}



}