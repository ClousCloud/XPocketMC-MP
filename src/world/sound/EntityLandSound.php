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

use xpocketmc\block\Block;
use xpocketmc\entity\Entity;
use pocketmine\math\Vector3;
use xpocketmc\network\mcpe\convert\TypeConverter;
use xpocketmc\network\mcpe\protocol\LevelSoundEventPacket;
use xpocketmc\network\mcpe\protocol\types\LevelSoundEvent;

/**
 * Played when an entity hits the ground after falling a distance that doesn't cause damage, e.g. due to jumping.
 */
class EntityLandSound implements Sound{
	public function __construct(
		private Entity $entity,
		private Block $blockLandedOn
	){}

	public function encode(Vector3 $pos) : array{
		return [LevelSoundEventPacket::create(
			LevelSoundEvent::LAND,
			$pos,
			TypeConverter::getInstance()->getBlockTranslator()->internalIdToNetworkId($this->blockLandedOn->getStateId()),
			$this->entity::getNetworkTypeId(),
			false, //TODO: does isBaby have any relevance here?
			false
		)];
	}
}