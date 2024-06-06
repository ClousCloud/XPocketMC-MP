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

namespace xpocketmc\data\bedrock\block\upgrade;

use xpocketmc\nbt\tag\Tag;
use xpocketmc\utils\Utils;
use function array_diff;
use function count;

final class BlockStateUpgradeSchemaBlockRemap{
	/**
	 * @param Tag[]    $oldState
	 * @param Tag[]    $newState
	 * @param string[] $copiedState
	 *
	 * @phpstan-param array<string, Tag> $oldState
	 * @phpstan-param array<string, Tag> $newState
	 * @phpstan-param list<string>       $copiedState
	 */
	public function __construct(
		public array $oldState,
		public string|BlockStateUpgradeSchemaFlattenedName $newName,
		public array $newState,
		public array $copiedState
	){}

	public function equals(self $that) : bool{
		$sameName = $this->newName === $that->newName ||
			(
				$this->newName instanceof BlockStateUpgradeSchemaFlattenedName &&
				$that->newName instanceof BlockStateUpgradeSchemaFlattenedName &&
				$this->newName->equals($that->newName)
			);
		if(!$sameName){
			return false;
		}

		if(
			count($this->oldState) !== count($that->oldState) ||
			count($this->newState) !== count($that->newState) ||
			count($this->copiedState) !== count($that->copiedState) ||
			count(array_diff($this->copiedState, $that->copiedState)) !== 0
		){
			return false;
		}
		foreach(Utils::stringifyKeys($this->oldState) as $propertyName => $propertyValue){
			if(!isset($that->oldState[$propertyName]) || !$that->oldState[$propertyName]->equals($propertyValue)){
				//different filter value
				return false;
			}
		}
		foreach(Utils::stringifyKeys($this->newState) as $propertyName => $propertyValue){
			if(!isset($that->newState[$propertyName]) || !$that->newState[$propertyName]->equals($propertyValue)){
				//different replacement value
				return false;
			}
		}

		return true;
	}
}