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

use xpocketmc\block\utils\FortuneDropHelper;
use xpocketmc\item\Item;
use xpocketmc\item\VanillaItems;
use function mt_rand;

class LapisOre extends Opaque{

	public function getDropsForCompatibleTool(Item $item) : array{
		return [
			VanillaItems::LAPIS_LAZULI()->setCount(FortuneDropHelper::weighted($item, min: 4, maxBase: 9))
		];
	}

	public function isAffectedBySilkTouch() : bool{
		return true;
	}

	protected function getXpDropAmount() : int{
		return mt_rand(2, 5);
	}
}