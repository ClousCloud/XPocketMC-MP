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

namespace xpocketmc\block;

use xpocketmc\block\utils\BlockEventHelper;
use xpocketmc\block\utils\DirtType;
use xpocketmc\item\Fertilizer;
use xpocketmc\item\Hoe;
use xpocketmc\item\Item;
use xpocketmc\item\Shovel;
use xpocketmc\math\Facing;
use xpocketmc\math\Vector3;
use xpocketmc\player\Player;
use xpocketmc\utils\Random;
use xpocketmc\world\generator\object\TallGrass as TallGrassObject;
use xpocketmc\world\sound\ItemUseOnBlockSound;
use function mt_rand;

class Grass extends Opaque{

	public function getDropsForCompatibleTool(Item $item) : array{
		return [
			VanillaBlocks::DIRT()->asItem()
		];
	}

	public function isAffectedBySilkTouch() : bool{
		return true;
	}

	public function ticksRandomly() : bool{
		return true;
	}

	public function onRandomTick() : void{
		$world = $this->position->getWorld();
		$lightAbove = $world->getFullLightAt($this->position->x, $this->position->y + 1, $this->position->z);
		if($lightAbove < 4 && $world->getBlockAt($this->position->x, $this->position->y + 1, $this->position->z)->getLightFilter() >= 2){
			//grass dies
			BlockEventHelper::spread($this, VanillaBlocks::DIRT(), $this);
		}elseif($lightAbove >= 9){
			//try grass spread
			for($i = 0; $i < 4; ++$i){
				$x = mt_rand($this->position->x - 1, $this->position->x + 1);
				$y = mt_rand($this->position->y - 3, $this->position->y + 1);
				$z = mt_rand($this->position->z - 1, $this->position->z + 1);

				$b = $world->getBlockAt($x, $y, $z);
				if(
					!($b instanceof Dirt) ||
					$b->getDirtType() !== DirtType::NORMAL ||
					$world->getFullLightAt($x, $y + 1, $z) < 4 ||
					$world->getBlockAt($x, $y + 1, $z)->getLightFilter() >= 2
				){
					continue;
				}

				BlockEventHelper::spread($b, VanillaBlocks::GRASS(), $this);
			}
		}
	}

	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null, array &$returnedItems = []) : bool{
		if($this->getSide(Facing::UP)->getTypeId() !== BlockTypeIds::AIR){
			return false;
		}
		$world = $this->position->getWorld();
		if($item instanceof Fertilizer){
			$item->pop();
			TallGrassObject::growGrass($world, $this->position, new Random(mt_rand()), 8, 2);

			return true;
		}
		if($face !== Facing::DOWN){
			if($item instanceof Hoe){
				$item->applyDamage(1);
				$newBlock = VanillaBlocks::FARMLAND();
				$world->addSound($this->position->add(0.5, 0.5, 0.5), new ItemUseOnBlockSound($newBlock));
				$world->setBlock($this->position, $newBlock);

				return true;
			}elseif($item instanceof Shovel){
				$item->applyDamage(1);
				$newBlock = VanillaBlocks::GRASS_PATH();
				$world->addSound($this->position->add(0.5, 0.5, 0.5), new ItemUseOnBlockSound($newBlock));
				$world->setBlock($this->position, $newBlock);

				return true;
			}
		}

		return false;
	}
}