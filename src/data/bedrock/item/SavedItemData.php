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

namespace xpocketmc\data\bedrock\item;

use xpocketmc\data\bedrock\block\BlockStateData;
use pocketmine
bt\tag\CompoundTag;
use xpocketmc\VersionInfo;

final class SavedItemData{

	public const TAG_NAME = "Name";
	public const TAG_DAMAGE = "Damage";
	public const TAG_BLOCK = "Block";
	public const TAG_TAG = "tag";

	public function __construct(
		private string $name,
		private int $meta = 0,
		private ?BlockStateData $block = null,
		private ?CompoundTag $tag = null
	){}

	public function getName() : string{ return $this->name; }

	public function getMeta() : int{ return $this->meta; }

	public function getBlock() : ?BlockStateData{ return $this->block; }

	public function getTag() : ?CompoundTag{ return $this->tag; }

	public function toNbt() : CompoundTag{
		$result = CompoundTag::create();
		$result->setString(self::TAG_NAME, $this->name);
		$result->setShort(self::TAG_DAMAGE, $this->meta);

		if($this->block !== null){
			$result->setTag(self::TAG_BLOCK, $this->block->toNbt());
		}
		if($this->tag !== null){
			$result->setTag(self::TAG_TAG, $this->tag);
		}
		$result->setLong(VersionInfo::TAG_WORLD_DATA_VERSION, VersionInfo::WORLD_DATA_VERSION);

		return $result;
	}
}