<?php

namespace Minecraft;

class Server {

	protected $hostname;
	protected $port;

	public function __construct($hostname = '127.0.0.1', $port = 25565) {
		// Overload for hostname:port syntax.
		if (stristr(':', $hostname)) {
			list($hostname, $port) = explode(':', $hostname);
		}

		$this->setHostname($hostname);
		$this->setPort($port);
	}

	public function setHostname($hostname) {
		// If hostname doesn't resolve, throw error.
		// Must be IP or domain. (only IPv4)
		$this->hostname = $hostname;
		return $this;
	}

	public function getHostname() {
		return $this->hostname;
	}

	public function setPort($port) {

		if (is_int($port)) {
			$this->port = $port;
		}

		return $this;
	}

	public function getPort() {
		return $this->port;
	}

}