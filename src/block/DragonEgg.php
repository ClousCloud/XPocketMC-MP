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

use xpocketmc\block\utils\Fallable;
use xpocketmc\block\utils\FallableTrait;
use xpocketmc\block\utils\SupportType;
use xpocketmc\event\block\BlockTeleportEvent;
use xpocketmc\item\Item;
use xpocketmc\math\Vector3;
use xpocketmc\player\GameMode;
use xpocketmc\player\Player;
use xpocketmc\world\particle\DragonEggTeleportParticle;
use xpocketmc\world\World;
use function max;
use function min;
use function mt_rand;

class DragonEgg extends Transparent implements Fallable{
	use FallableTrait;

	public function getLightLevel() : int{
		return 1;
	}

	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null, array &$returnedItems = []) : bool{
		$this->teleport();
		return true;
	}

	public function onAttack(Item $item, int $face, ?Player $player = null) : bool{
		if($player !== null && $player->getGamemode() !== GameMode::CREATIVE){
			$this->teleport();
			return true;
		}
		return false;
	}

	public function teleport() : void{
		$world = $this->position->getWorld();
		for($tries = 0; $tries < 16; ++$tries){
			$block = $world->getBlockAt(
				$this->position->x + mt_rand(-16, 16),
				max(World::Y_MIN, min(World::Y_MAX - 1, $this->position->y + mt_rand(-8, 8))),
				$this->position->z + mt_rand(-16, 16)
			);
			if($block instanceof Air){
				$ev = new BlockTeleportEvent($this, $block->position);
				$ev->call();
				if($ev->isCancelled()){
					break;
				}

				$blockPos = $ev->getTo();
				$world->addParticle($this->position, new DragonEggTeleportParticle($this->position->x - $blockPos->x, $this->position->y - $blockPos->y, $this->position->z - $blockPos->z));
				$world->setBlock($this->position, VanillaBlocks::AIR());
				$world->setBlock($blockPos, $this);
				break;
			}
		}
	}

	public function getSupportType(int $facing) : SupportType{
		return SupportType::NONE;
	}
}