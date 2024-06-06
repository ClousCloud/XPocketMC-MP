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

use xpocketmc\block\utils\Fallable;
use xpocketmc\block\utils\FallableTrait;
use xpocketmc\block\utils\FortuneDropHelper;
use xpocketmc\item\Item;
use xpocketmc\item\VanillaItems;

class Gravel extends Opaque implements Fallable{
	use FallableTrait;

	public function getDropsForCompatibleTool(Item $item) : array{
		if(FortuneDropHelper::bonusChanceDivisor($item, 10, 3)){
			return [
				VanillaItems::FLINT()
			];
		}

		return parent::getDropsForCompatibleTool($item);
	}

	public function isAffectedBySilkTouch() : bool{
		return true;
	}
}