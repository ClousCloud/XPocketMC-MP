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

namespace xpocketmc\data\bedrock;

use xpocketmc\block\utils\MobHeadType;
use xpocketmc\utils\SingletonTrait;

final class MobHeadTypeIdMap{
	use SingletonTrait;
	/** @phpstan-use IntSaveIdMapTrait<MobHeadType> */
	use IntSaveIdMapTrait;

	private function __construct(){
		foreach(MobHeadType::cases() as $case){
			$this->register(match($case){
				MobHeadType::SKELETON => 0,
				MobHeadType::WITHER_SKELETON => 1,
				MobHeadType::ZOMBIE => 2,
				MobHeadType::PLAYER => 3,
				MobHeadType::CREEPER => 4,
				MobHeadType::DRAGON => 5,
				MobHeadType::PIGLIN => 6,
			}, $case);
		}
	}
}