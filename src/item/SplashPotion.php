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

namespace xpocketmc\item;

use xpocketmc\data\runtime\RuntimeDataDescriber;
use xpocketmc\entity\Location;
use xpocketmc\entity\projectile\SplashPotion as SplashPotionEntity;
use xpocketmc\entity\projectile\Throwable;
use xpocketmc\player\Player;

class SplashPotion extends ProjectileItem{

	private PotionType $potionType = PotionType::WATER;

	protected function describeState(RuntimeDataDescriber $w) : void{
		$w->enum($this->potionType);
	}

	public function getType() : PotionType{ return $this->potionType; }

	/**
	 * @return $this
	 */
	public function setType(PotionType $type) : self{
		$this->potionType = $type;
		return $this;
	}

	public function getMaxStackSize() : int{
		return 1;
	}

	protected function createEntity(Location $location, Player $thrower) : Throwable{
		return new SplashPotionEntity($location, $thrower, $this->potionType);
	}

	public function getThrowForce() : float{
		return 0.5;
	}
}