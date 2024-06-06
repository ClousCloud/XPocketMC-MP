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

namespace xpocketmc\entity\projectile;

use xpocketmc\event\entity\ProjectileHitEvent;
use xpocketmc\network\mcpe\protocol\types\entity\EntityIds;
use xpocketmc\world\particle\PotionSplashParticle;
use xpocketmc\world\sound\PotionSplashSound;
use function mt_rand;

class ExperienceBottle extends Throwable{
	public static function getNetworkTypeId() : string{ return EntityIds::XP_BOTTLE; }

	protected function getInitialGravity() : float{ return 0.07; }

	public function getResultDamage() : int{
		return -1;
	}

	public function onHit(ProjectileHitEvent $event) : void{
		$this->getWorld()->addParticle($this->location, new PotionSplashParticle(PotionSplashParticle::DEFAULT_COLOR()));
		$this->broadcastSound(new PotionSplashSound());

		$this->getWorld()->dropExperience($this->location, mt_rand(3, 11));
	}
}