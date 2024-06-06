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

use xpocketmc\block\utils\AgeableTrait;
use xpocketmc\block\utils\BlockEventHelper;
use xpocketmc\block\utils\FortuneDropHelper;
use xpocketmc\block\utils\StaticSupportTrait;
use xpocketmc\item\Item;
use xpocketmc\math\Facing;
use function mt_rand;

class NetherWartPlant extends Flowable{
	use AgeableTrait;
	use StaticSupportTrait;

	public const MAX_AGE = 3;

	private function canBeSupportedAt(Block $block) : bool{
		return $block->getSide(Facing::DOWN)->getTypeId() === BlockTypeIds::SOUL_SAND;
	}

	public function ticksRandomly() : bool{
		return $this->age < self::MAX_AGE;
	}

	public function onRandomTick() : void{
		if($this->age < self::MAX_AGE && mt_rand(0, 10) === 0){ //Still growing
			$block = clone $this;
			$block->age++;
			BlockEventHelper::grow($this, $block, null);
		}
	}

	public function getDropsForCompatibleTool(Item $item) : array{
		return [
			$this->asItem()->setCount($this->age === self::MAX_AGE ? FortuneDropHelper::discrete($item, 2, 4) : 1)
		];
	}
}