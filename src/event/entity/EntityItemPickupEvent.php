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

use xpocketmc\entity\Entity;
use xpocketmc\event\Cancellable;
use xpocketmc\event\CancellableTrait;
use xpocketmc\inventory\Inventory;
use xpocketmc\item\Item;

/**
 * Called when an entity picks up an item, arrow, etc.
 * @phpstan-extends EntityEvent<Entity>
 */
class EntityItemPickupEvent extends EntityEvent implements Cancellable{
	use CancellableTrait;

	public function __construct(
		Entity $collector,
		private Entity $origin,
		private Item $item,
		private ?Inventory $inventory
	){
		$this->entity = $collector;
	}

	public function getOrigin() : Entity{
		return $this->origin;
	}

	/**
	 * Items to be received
	 */
	public function getItem() : Item{
		return clone $this->item;
	}

	/**
	 * Change the items to receive.
	 */
	public function setItem(Item $item) : void{
		$this->item = clone $item;
	}

	/**
	 * Inventory to which received items will be added.
	 */
	public function getInventory() : ?Inventory{
		return $this->inventory;
	}

	/**
	 * Change the inventory to which received items are added.
	 */
	public function setInventory(?Inventory $inventory) : void{
		$this->inventory = $inventory;
	}

}