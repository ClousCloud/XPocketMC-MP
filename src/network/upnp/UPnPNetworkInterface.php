<?php

/*
 *
 * __  ______            _        _   __  __  ____      __  __ ____  
 * \ \/ /  _ \ ___   ___| | _____| |_|  \/  |/ ___|    |  \/  |  _ \ 
 *  \  /| |_) / _ \ / __| |/ / _ \ __| |\/| | |   _____| |\/| | |_) |
 *  /  \|  __/ (_) | (__|   <  __/ |_| |  | | |__|_____| |  | |  __/ 
 * /_/\_\_|   \___/ \___|_|\_\___|\__|_|  |_|\____|    |_|  |_|_|    
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author xpocketmc Team
 * @link http://www.xpocketmc.net/
 *
 *
 */

declare(strict_types=1);

namespace pocketmine
etwork\upnp;

use pocketmine
etwork\NetworkInterface;
use xpocketmc\utils\Internet;
use xpocketmc\utils\InternetException;

final class UPnPNetworkInterface implements NetworkInterface{
	private ?string $serviceURL = null;

	public function __construct(
		private \Logger $logger,
		private string $ip,
		private int $port
	){
		if(!Internet::$online){
			throw new \RuntimeException("Server is offline");
		}

		$this->logger = new \PrefixedLogger($logger, "UPnP Port Forwarder");
	}

	public function start() : void{
		$this->logger->info("Attempting to portforward...");

		try{
			$this->serviceURL = UPnP::getServiceUrl();
			UPnP::portForward($this->serviceURL, Internet::getInternalIP(), $this->port, $this->port);
			$this->logger->info("Forwarded $this->ip:$this->port to external port $this->port");
		}catch(UPnPException | InternetException $e){
			$this->logger->error("UPnP portforward failed: " . $e->getMessage());
		}
	}

	public function setName(string $name) : void{

	}

	public function tick() : void{

	}

	public function shutdown() : void{
		if($this->serviceURL === null){
			return;
		}

		UPnP::removePortForward($this->serviceURL, $this->port);
	}
}