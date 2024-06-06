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

namespace xpocketmc\event\block;

use xpocketmc\block\Block;
use xpocketmc\event\Cancellable;
use xpocketmc\event\CancellableTrait;
use xpocketmc\event\Event;
use xpocketmc\item\Item;
use xpocketmc\player\Player;
use xpocketmc\world\BlockTransaction;

/**
 * Called when a player initiates a block placement action.
 * More than one block may be changed by a single placement action, for example when placing a door.
 */
class BlockPlaceEvent extends Event implements Cancellable{
	use CancellableTrait;

	public function __construct(
		protected Player $player,
		protected BlockTransaction $transaction,
		protected Block $blockAgainst,
		protected Item $item
	){
		$world = $this->blockAgainst->getPosition()->getWorld();
		foreach($this->transaction->getBlocks() as [$x, $y, $z, $block]){
			$block->position($world, $x, $y, $z);
		}
	}

	/**
	 * Returns the player who is placing the block.
	 */
	public function getPlayer() : Player{
		return $this->player;
	}

	/**
	 * Gets the item in hand
	 */
	public function getItem() : Item{
		return clone $this->item;
	}

	/**
	 * Returns a BlockTransaction object containing all the block positions that will be changed by this event, and the
	 * states they will be changed to.
	 *
	 * This will usually contain only one block, but may contain more if the block being placed is a multi-block
	 * structure such as a door or bed.
	 */
	public function getTransaction() : BlockTransaction{
		return $this->transaction;
	}

	public function getBlockAgainst() : Block{
		return $this->blockAgainst;
	}
}