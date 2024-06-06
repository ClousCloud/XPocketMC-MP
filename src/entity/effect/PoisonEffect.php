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

use xpocketmc\color\Color;
use xpocketmc\entity\Entity;
use xpocketmc\entity\Living;
use xpocketmc\event\entity\EntityDamageEvent;
use xpocketmc\lang\Translatable;

class PoisonEffect extends Effect{
	private bool $fatal;

	public function __construct(Translatable|string $name, Color $color, bool $isBad = false, int $defaultDuration = 600, bool $hasBubbles = true, bool $fatal = false){
		parent::__construct($name, $color, $isBad, $defaultDuration, $hasBubbles);
		$this->fatal = $fatal;
	}

	public function canTick(EffectInstance $instance) : bool{
		if(($interval = (25 >> $instance->getAmplifier())) > 0){
			return ($instance->getDuration() % $interval) === 0;
		}
		return true;
	}

	public function applyEffect(Living $entity, EffectInstance $instance, float $potency = 1.0, ?Entity $source = null) : void{
		if($entity->getHealth() > 1 || $this->fatal){
			$ev = new EntityDamageEvent($entity, EntityDamageEvent::CAUSE_MAGIC, 1);
			$entity->attack($ev);
		}
	}
}