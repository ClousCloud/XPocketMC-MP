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

use xpocketmc\block\utils\StaticSupportTrait;
use xpocketmc\item\Item;
use xpocketmc\item\VanillaItems;
use xpocketmc\math\Facing;
use function mt_rand;

class DeadBush extends Flowable{
	use StaticSupportTrait;

	public function getDropsForIncompatibleTool(Item $item) : array{
		return [
			VanillaItems::STICK()->setCount(mt_rand(0, 2))
		];
	}

	public function isAffectedBySilkTouch() : bool{
		return true;
	}

	public function getFlameEncouragement() : int{
		return 60;
	}

	public function getFlammability() : int{
		return 100;
	}

	private function canBeSupportedAt(Block $block) : bool{
		$supportBlock = $block->getSide(Facing::DOWN);
		return
			$supportBlock->hasTypeTag(BlockTypeTags::SAND) ||
			$supportBlock->hasTypeTag(BlockTypeTags::MUD) ||
			match($supportBlock->getTypeId()){
				//can't use DIRT tag here because it includes farmland
				BlockTypeIds::PODZOL,
				BlockTypeIds::MYCELIUM,
				BlockTypeIds::DIRT,
				BlockTypeIds::GRASS,
				BlockTypeIds::HARDENED_CLAY,
				BlockTypeIds::STAINED_CLAY => true,
				//TODO: moss block
				default => false,
			};
	}
}