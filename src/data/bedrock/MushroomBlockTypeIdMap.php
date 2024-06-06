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

use xpocketmc\block\utils\MushroomBlockType;
use xpocketmc\data\bedrock\block\BlockLegacyMetadata as LegacyMeta;
use xpocketmc\utils\SingletonTrait;

final class MushroomBlockTypeIdMap{
	use SingletonTrait;
	/** @phpstan-use IntSaveIdMapTrait<MushroomBlockType> */
	use IntSaveIdMapTrait;

	public function __construct(){
		foreach(MushroomBlockType::cases() as $case){
			$this->register(match($case){
				MushroomBlockType::PORES => LegacyMeta::MUSHROOM_BLOCK_ALL_PORES,
				MushroomBlockType::CAP_NORTHWEST => LegacyMeta::MUSHROOM_BLOCK_CAP_NORTHWEST_CORNER,
				MushroomBlockType::CAP_NORTH => LegacyMeta::MUSHROOM_BLOCK_CAP_NORTH_SIDE,
				MushroomBlockType::CAP_NORTHEAST => LegacyMeta::MUSHROOM_BLOCK_CAP_NORTHEAST_CORNER,
				MushroomBlockType::CAP_WEST => LegacyMeta::MUSHROOM_BLOCK_CAP_WEST_SIDE,
				MushroomBlockType::CAP_MIDDLE => LegacyMeta::MUSHROOM_BLOCK_CAP_TOP_ONLY,
				MushroomBlockType::CAP_EAST => LegacyMeta::MUSHROOM_BLOCK_CAP_EAST_SIDE,
				MushroomBlockType::CAP_SOUTHWEST => LegacyMeta::MUSHROOM_BLOCK_CAP_SOUTHWEST_CORNER,
				MushroomBlockType::CAP_SOUTH => LegacyMeta::MUSHROOM_BLOCK_CAP_SOUTH_SIDE,
				MushroomBlockType::CAP_SOUTHEAST => LegacyMeta::MUSHROOM_BLOCK_CAP_SOUTHEAST_CORNER,
				MushroomBlockType::ALL_CAP => LegacyMeta::MUSHROOM_BLOCK_ALL_CAP,
			}, $case);
		}
	}
}