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

namespace xpocketmc\world\sound;

use xpocketmc\math\Vector3;
use xpocketmc\network\mcpe\protocol\LevelSoundEventPacket;
use xpocketmc\network\mcpe\protocol\types\LevelSoundEvent;

final class WaterSplashSound implements Sound{

	public function __construct(private float $volume){
		if($volume < 0 || $volume > 1){
			throw new \InvalidArgumentException("Volume must be between 0 and 1");
		}
	}

	public function encode(Vector3 $pos) : array{
		return [LevelSoundEventPacket::create(
			LevelSoundEvent::SPLASH,
			$pos,
			(int) ($this->volume * 16777215),
			":",
			false,
			false
		)];
	}
}