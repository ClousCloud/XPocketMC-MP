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

namespace xpocketmc\entity\effect;

use xpocketmc\entity\Entity;
use xpocketmc\entity\Living;
use xpocketmc\player\Player;

class LevitationEffect extends Effect{

	public function canTick(EffectInstance $instance) : bool{
		return true;
	}

	public function applyEffect(Living $entity, EffectInstance $instance, float $potency = 1.0, ?Entity $source = null) : void{
		if(!($entity instanceof Player)){ //TODO: ugly hack, player motion isn't updated properly by the server yet :(
			$entity->addMotion(0, ($instance->getEffectLevel() / 20 - $entity->getMotion()->y) / 5, 0);
		}
	}

	public function add(Living $entity, EffectInstance $instance) : void{
		$entity->setHasGravity(false);
	}

	public function remove(Living $entity, EffectInstance $instance) : void{
		$entity->setHasGravity();
	}
}