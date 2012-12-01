<?php

namespace Minecraft;

class Server {


	protected $hostname;
	protected $port;


	public function __construct($hostname = '127.0.0.1', $port = 25565) {
		$this->setPort($port);
		$this->setHostname($hostname);
	}

	
	/**
	 * Must be IP or domain. (only IPv4)
	 */
	public function setHostname($hostname) {
		
		// Overload for hostname:port syntax.
		if( preg_match('/:\d+$/', $hostname) ) {
			
			// if protocol (e.g., 'http') was included; strip it out
			if( preg_match('/:\/\//', $hostname) ) {
				list($protocol, $this->hostname, $this->port) = explode(':', str_replace('//', '', $hostname));
			} else {
				list($this->hostname, $this->port) = explode(':', $hostname);
			}
			
		} else {
			$this->hostname = $hostname;
		}
	}


	public function getHostname() {
		return $this->hostname;
	}


	public function setPort($port) {

		if(is_int($port)) {
			$this->port = $port;
		} else if( is_numeric($port) ) {
			$this->port = intval($port);
		}
	}


	public function getPort() {
		return $this->port;
	}


}