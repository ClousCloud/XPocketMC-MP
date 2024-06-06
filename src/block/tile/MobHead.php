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

namespace xpocketmc\block\tile;

use xpocketmc\block\utils\MobHeadType;
use xpocketmc\data\bedrock\MobHeadTypeIdMap;
use xpocketmc\data\SavedDataLoadingException;
use pocketmine
bt\tag\ByteTag;
use pocketmine
bt\tag\CompoundTag;

/**
 * @deprecated
 * @see \xpocketmc\block\MobHead
 */
class MobHead extends Spawnable{

	private const TAG_SKULL_TYPE = "SkullType"; //TAG_Byte
	private const TAG_ROT = "Rot"; //TAG_Byte
	private const TAG_MOUTH_MOVING = "MouthMoving"; //TAG_Byte
	private const TAG_MOUTH_TICK_COUNT = "MouthTickCount"; //TAG_Int

	private MobHeadType $mobHeadType = MobHeadType::SKELETON;
	private int $rotation = 0;

	public function readSaveData(CompoundTag $nbt) : void{
		if(($skullTypeTag = $nbt->getTag(self::TAG_SKULL_TYPE)) instanceof ByteTag){
			$mobHeadType = MobHeadTypeIdMap::getInstance()->fromId($skullTypeTag->getValue());
			if($mobHeadType === null){
				throw new SavedDataLoadingException("Invalid skull type tag value " . $skullTypeTag->getValue());
			}
			$this->mobHeadType = $mobHeadType;
		}
		$rotation = $nbt->getByte(self::TAG_ROT, 0);
		if($rotation >= 0 && $rotation <= 15){
			$this->rotation = $rotation;
		}
	}

	protected function writeSaveData(CompoundTag $nbt) : void{
		$nbt->setByte(self::TAG_SKULL_TYPE, MobHeadTypeIdMap::getInstance()->toId($this->mobHeadType));
		$nbt->setByte(self::TAG_ROT, $this->rotation);
	}

	public function setMobHeadType(MobHeadType $type) : void{
		$this->mobHeadType = $type;
	}

	public function getMobHeadType() : MobHeadType{
		return $this->mobHeadType;
	}

	public function getRotation() : int{
		return $this->rotation;
	}

	public function setRotation(int $rotation) : void{
		$this->rotation = $rotation;
	}

	protected function addAdditionalSpawnData(CompoundTag $nbt) : void{
		$nbt->setByte(self::TAG_SKULL_TYPE, MobHeadTypeIdMap::getInstance()->toId($this->mobHeadType));
		$nbt->setByte(self::TAG_ROT, $this->rotation);
	}
}