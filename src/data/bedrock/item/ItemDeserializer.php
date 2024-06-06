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

use xpocketmc\block\Block;
use xpocketmc\block\RuntimeBlockStateRegistry;
use xpocketmc\data\bedrock\block\BlockStateDeserializeException;
use xpocketmc\data\bedrock\block\BlockStateDeserializer;
use xpocketmc\data\bedrock\block\convert\UnsupportedBlockStateException;
use xpocketmc\data\bedrock\item\SavedItemData as Data;
use xpocketmc\item\Durable;
use xpocketmc\item\Item;
use xpocketmc\nbt\NbtException;
use function min;

final class ItemDeserializer{
	/**
	 * @var \Closure[]
	 * @phpstan-var array<string, \Closure(Data) : Item>
	 */
	private array $deserializers = [];

	public function __construct(
		private BlockStateDeserializer $blockStateDeserializer
	){
		new ItemSerializerDeserializerRegistrar($this, null);
	}

	/**
	 * @phpstan-param \Closure(Data) : Item $deserializer
	 */
	public function map(string $id, \Closure $deserializer) : void{
		if(isset($this->deserializers[$id])){
			throw new \InvalidArgumentException("Deserializer is already assigned for \"$id\"");
		}
		$this->deserializers[$id] = $deserializer;
	}

	/**
	 * @phpstan-param \Closure(Data) : Block $deserializer
	 */
	public function mapBlock(string $id, \Closure $deserializer) : void{
		$this->map($id, fn(Data $data) => $deserializer($data)->asItem());
	}

	/**
	 * @throws ItemTypeDeserializeException
	 */
	public function deserializeType(Data $data) : Item{
		if(($blockData = $data->getBlock()) !== null){
			//TODO: this is rough duct tape; we need a better way to deal with this
			try{
				$block = $this->blockStateDeserializer->deserialize($blockData);
			}catch(UnsupportedBlockStateException $e){
				throw new UnsupportedItemTypeException($e->getMessage(), 0, $e);
			}catch(BlockStateDeserializeException $e){
				throw new ItemTypeDeserializeException("Failed to deserialize item data: " . $e->getMessage(), 0, $e);
			}

			//TODO: worth caching this or not?
			return RuntimeBlockStateRegistry::getInstance()->fromStateId($block)->asItem();
		}
		$id = $data->getName();
		if(!isset($this->deserializers[$id])){
			throw new UnsupportedItemTypeException("No deserializer found for ID $id");
		}

		return ($this->deserializers[$id])($data);
	}

	/**
	 * @throws ItemTypeDeserializeException
	 */
	public function deserializeStack(SavedItemStackData $data) : Item{
		$itemStack = $this->deserializeType($data->getTypeData());

		$itemStack->setCount($data->getCount());
		if(($tagTag = $data->getTypeData()->getTag()) !== null){
			try{
				$itemStack->setNamedTag(clone $tagTag);
			}catch(NbtException $e){
				throw new ItemTypeDeserializeException("Invalid item saved NBT: " . $e->getMessage(), 0, $e);
			}
		}

		//TODO: this hack is necessary to get legacy tools working - we need a better way to handle this kind of stuff
		if($itemStack instanceof Durable && $itemStack->getDamage() === 0 && ($damage = $data->getTypeData()->getMeta()) > 0){
			$itemStack->setDamage(min($damage, $itemStack->getMaxDurability()));
		}

		//TODO: canDestroy, canPlaceOn, wasPickedUp are currently unused

		return $itemStack;
	}
}