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

use xpocketmc\entity\Location;
use xpocketmc\entity\projectile\Throwable;
use xpocketmc\event\entity\ProjectileLaunchEvent;
use xpocketmc\math\Vector3;
use xpocketmc\player\Player;
use xpocketmc\world\sound\ThrowSound;

abstract class ProjectileItem extends Item{

	abstract public function getThrowForce() : float;

	abstract protected function createEntity(Location $location, Player $thrower) : Throwable;

	public function onClickAir(Player $player, Vector3 $directionVector, array &$returnedItems) : ItemUseResult{
		$location = $player->getLocation();

		$projectile = $this->createEntity(Location::fromObject($player->getEyePos(), $player->getWorld(), $location->yaw, $location->pitch), $player);
		$projectile->setMotion($directionVector->multiply($this->getThrowForce()));

		$projectileEv = new ProjectileLaunchEvent($projectile);
		$projectileEv->call();
		if($projectileEv->isCancelled()){
			$projectile->flagForDespawn();
			return ItemUseResult::FAIL;
		}

		$projectile->spawnToAll();

		$location->getWorld()->addSound($location, new ThrowSound());

		$this->pop();

		return ItemUseResult::SUCCESS;
	}
}