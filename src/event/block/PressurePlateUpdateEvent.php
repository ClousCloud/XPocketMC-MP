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

namespace xpocketmc\event\block;

use xpocketmc\block\Block;
use xpocketmc\entity\Entity;

/**
 * Called whenever the list of entities on a pressure plate changes.
 * Depending on the type of pressure plate, this might turn on/off its signal, or change the signal strength.
 */
final class PressurePlateUpdateEvent extends BaseBlockChangeEvent{
	/**
	 * @param Entity[] $activatingEntities
	 */
	public function __construct(
		Block $block,
		Block $newState,
		private array $activatingEntities
	){
		parent::__construct($block, $newState);
	}

	/**
	 * Returns a list of entities intersecting the pressure plate's activation box.
	 * If the pressure plate is about to deactivate, this list will be empty.
	 *
	 * @return Entity[]
	 */
	public function getActivatingEntities() : array{ return $this->activatingEntities; }
}