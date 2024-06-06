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

use xpocketmc\block\Liquid;
use xpocketmc\entity\Living;
use xpocketmc\math\Vector3;
use xpocketmc\world\sound\EndermanTeleportSound;
use function min;
use function mt_rand;

class ChorusFruit extends Food{

	public function getFoodRestore() : int{
		return 4;
	}

	public function getSaturationRestore() : float{
		return 2.4;
	}

	public function requiresHunger() : bool{
		return false;
	}

	public function onConsume(Living $consumer) : void{
		$world = $consumer->getWorld();

		$origin = $consumer->getPosition();
		$minX = $origin->getFloorX() - 8;
		$minY = min($origin->getFloorY(), $consumer->getWorld()->getMaxY()) - 8;
		$minZ = $origin->getFloorZ() - 8;

		$maxX = $minX + 16;
		$maxY = $minY + 16;
		$maxZ = $minZ + 16;

		$worldMinY = $world->getMinY();

		for($attempts = 0; $attempts < 16; ++$attempts){
			$x = mt_rand($minX, $maxX);
			$y = mt_rand($minY, $maxY);
			$z = mt_rand($minZ, $maxZ);

			while($y >= $worldMinY && !$world->getBlockAt($x, $y, $z)->isSolid()){
				$y--;
			}
			if($y < $worldMinY){
				continue;
			}

			$blockUp = $world->getBlockAt($x, $y + 1, $z);
			$blockUp2 = $world->getBlockAt($x, $y + 2, $z);
			if($blockUp->isSolid() || $blockUp instanceof Liquid || $blockUp2->isSolid() || $blockUp2 instanceof Liquid){
				continue;
			}

			//Sounds are broadcasted at both source and destination
			$world->addSound($origin, new EndermanTeleportSound());
			$consumer->teleport($target = new Vector3($x + 0.5, $y + 1, $z + 0.5));
			$world->addSound($target, new EndermanTeleportSound());

			break;
		}
	}

	public function getCooldownTicks() : int{
		return 20;
	}
}