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

namespace xpocketmc\block\utils;

use xpocketmc\block\Block;
use xpocketmc\entity\projectile\Projectile;
use pocketmine\math\RayTraceResult;
use xpocketmc\world\sound\AmethystBlockChimeSound;
use xpocketmc\world\sound\BlockPunchSound;

trait AmethystTrait{
	/**
	 * @see Block::onProjectileHit()
	 */
	public function onProjectileHit(Projectile $projectile, RayTraceResult $hitResult) : void{
		$this->position->getWorld()->addSound($this->position, new AmethystBlockChimeSound());
		$this->position->getWorld()->addSound($this->position, new BlockPunchSound($this));
	}
}