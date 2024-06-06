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

namespace xpocketmc\world\particle;

use xpocketmc\color\Color;
use pocketmine\math\Vector3;
use xpocketmc\network\mcpe\protocol\LevelEventPacket;
use xpocketmc\network\mcpe\protocol\types\LevelEvent;

class PotionSplashParticle implements Particle{
	public function __construct(private Color $color){}

	/**
	 * Returns the default water-bottle splash colour.
	 *
	 * TODO: replace this with a standard surrogate object constant (first we need to implement them!)
	 */
	public static function DEFAULT_COLOR() : Color{
		return new Color(0x38, 0x5d, 0xc6);
	}

	public function getColor() : Color{
		return $this->color;
	}

	public function encode(Vector3 $pos) : array{
		return [LevelEventPacket::create(LevelEvent::PARTICLE_SPLASH, $this->color->toARGB(), $pos)];
	}
}