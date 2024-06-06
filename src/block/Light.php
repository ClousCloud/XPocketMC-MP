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

namespace xpocketmc\block;

use xpocketmc\data\runtime\RuntimeDataDescriber;
use xpocketmc\item\Item;
use xpocketmc\math\Vector3;
use xpocketmc\player\Player;

final class Light extends Flowable{
	public const MIN_LIGHT_LEVEL = 0;
	public const MAX_LIGHT_LEVEL = 15;

	private int $level = self::MAX_LIGHT_LEVEL;

	public function describeBlockItemState(RuntimeDataDescriber $w) : void{
		$w->boundedIntAuto(self::MIN_LIGHT_LEVEL, self::MAX_LIGHT_LEVEL, $this->level);
	}

	public function getLightLevel() : int{ return $this->level; }

	/** @return $this */
	public function setLightLevel(int $level) : self{
		if($level < self::MIN_LIGHT_LEVEL || $level > self::MAX_LIGHT_LEVEL){
			throw new \InvalidArgumentException("Light level must be in the range " . self::MIN_LIGHT_LEVEL . " ... " . self::MAX_LIGHT_LEVEL);
		}
		$this->level = $level;
		return $this;
	}

	public function canBeReplaced() : bool{ return true; }

	public function canBePlacedAt(Block $blockReplace, Vector3 $clickVector, int $face, bool $isClickedBlock) : bool{
		//light blocks behave like solid blocks when placing them on another light block
		return $blockReplace->canBeReplaced() && $blockReplace->getTypeId() !== $this->getTypeId();
	}

	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null, array &$returnedItems = []) : bool{
		$this->level = $this->level === self::MAX_LIGHT_LEVEL ?
			self::MIN_LIGHT_LEVEL :
			$this->level + 1;

		$this->position->getWorld()->setBlock($this->position, $this);

		return true;
	}
}