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

namespace xpocketmc\block\inventory;

use xpocketmc\inventory\SimpleInventory;
use xpocketmc\world\Position;

class BrewingStandInventory extends SimpleInventory implements BlockInventory{
	use BlockInventoryTrait;

	public const SLOT_INGREDIENT = 0;
	public const SLOT_BOTTLE_LEFT = 1;
	public const SLOT_BOTTLE_MIDDLE = 2;
	public const SLOT_BOTTLE_RIGHT = 3;
	public const SLOT_FUEL = 4;

	public function __construct(Position $holder, int $size = 5){
		$this->holder = $holder;
		parent::__construct($size);
	}
}