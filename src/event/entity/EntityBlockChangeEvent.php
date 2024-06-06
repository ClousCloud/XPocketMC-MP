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

use xpocketmc\block\Block;
use xpocketmc\entity\Entity;
use xpocketmc\event\Cancellable;
use xpocketmc\event\CancellableTrait;

/**
 * Called when an Entity, excluding players, changes a block directly
 * @phpstan-extends EntityEvent<Entity>
 */
class EntityBlockChangeEvent extends EntityEvent implements Cancellable{
	use CancellableTrait;

	public function __construct(
		Entity $entity,
		private Block $from,
		private Block $to
	){
		$this->entity = $entity;
	}

	public function getBlock() : Block{
		return $this->from;
	}

	public function getTo() : Block{
		return $this->to;
	}
}