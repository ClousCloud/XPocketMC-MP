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
use xpocketmc\event\Cancellable;
use xpocketmc\event\CancellableTrait;
use xpocketmc\math\Vector3;
use xpocketmc\utils\Utils;

class BlockTeleportEvent extends BlockEvent implements Cancellable{
	use CancellableTrait;

	public function __construct(
		Block $block,
		private Vector3 $to
	){
		parent::__construct($block);
	}

	public function getTo() : Vector3{
		return $this->to;
	}

	public function setTo(Vector3 $to) : void{
		Utils::checkVector3NotInfOrNaN($to);
		$this->to = $to;
	}
}