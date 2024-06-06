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

namespace xpocketmc\utils;

trait SingletonTrait{
	/** @var self|null */
	private static $instance = null;

	private static function make() : self{
		return new self();
	}

	public static function getInstance() : self{
		if(self::$instance === null){
			self::$instance = self::make();
		}
		return self::$instance;
	}

	public static function setInstance(self $instance) : void{
		self::$instance = $instance;
	}

	public static function reset() : void{
		self::$instance = null;
	}
}