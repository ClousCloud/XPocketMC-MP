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

namespace xpocketmc\event\entity;

use xpocketmc\entity\object\ItemEntity;

/**
 * Called when an item is spawned or loaded.
 *
 * Some possible reasons include:
 * - item is loaded from disk
 * - player dropping an item
 * - block drops
 * - loot of a player or entity
 *
 * @see PlayerDropItemEvent
 * @phpstan-extends EntityEvent<ItemEntity>
 */
class ItemSpawnEvent extends EntityEvent{

	public function __construct(ItemEntity $item){
		$this->entity = $item;

	}

	/**
	 * @return ItemEntity
	 */
	public function getEntity(){
		return $this->entity;
	}
}