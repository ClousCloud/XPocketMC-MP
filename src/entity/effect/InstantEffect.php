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

namespace xpocketmc\entity\effect;

use xpocketmc\color\Color;
use xpocketmc\lang\Translatable;

abstract class InstantEffect extends Effect{

	public function __construct(Translatable|string $name, Color $color, bool $bad = false, bool $hasBubbles = true){
		parent::__construct($name, $color, $bad, 1, $hasBubbles);
	}

	public function canTick(EffectInstance $instance) : bool{
		return true; //If forced to last longer than 1 tick, these apply every tick.
	}
}