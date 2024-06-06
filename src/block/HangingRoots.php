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
use xpocketmc\item\enchantment\VanillaEnchantments;
use xpocketmc\item\Item;
use xpocketmc\math\Facing;

final class HangingRoots extends Flowable{
	use StaticSupportTrait;

	private function canBeSupportedAt(Block $block) : bool{
		return $block->getAdjacentSupportType(Facing::UP)->hasCenterSupport(); //weird I know, but they can be placed on the bottom of fences
	}

	public function getDropsForIncompatibleTool(Item $item) : array{
		if($item->hasEnchantment(VanillaEnchantments::SILK_TOUCH())){
			return $this->getDropsForCompatibleTool($item);
		}
		return [];
	}
}