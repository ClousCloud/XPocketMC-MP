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

namespace xpocketmc\world\generator\object;

use xpocketmc\utils\Random;

final class TreeFactory{

	/**
	 * @param TreeType|null $type default oak
	 */
	public static function get(Random $random, ?TreeType $type = null) : ?Tree{
		return match($type){
			null, TreeType::OAK => new OakTree(), //TODO: big oak has a 1/10 chance
			TreeType::SPRUCE => new SpruceTree(),
			TreeType::JUNGLE => new JungleTree(),
			TreeType::ACACIA => new AcaciaTree(),
			TreeType::BIRCH => new BirchTree($random->nextBoundedInt(39) === 0),
			default => null,
		};
	}
}