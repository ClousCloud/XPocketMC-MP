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

namespace xpocketmc\event\player;

use xpocketmc\event\Cancellable;
use xpocketmc\event\CancellableTrait;
use xpocketmc\lang\Translatable;
use xpocketmc\player\Player;

/**
 * Called when a player is kicked (forcibly disconnected) from the server, e.g. if an operator used /kick.
 */
class PlayerKickEvent extends PlayerEvent implements Cancellable{
	use CancellableTrait;
	use PlayerDisconnectEventTrait;

	public function __construct(
		Player $player,
		protected Translatable|string $disconnectReason,
		protected Translatable|string $quitMessage,
		protected Translatable|string|null $disconnectScreenMessage
	){
		$this->player = $player;
	}

	/**
	 * Sets the quit message broadcasted to other players.
	 */
	public function setQuitMessage(Translatable|string $quitMessage) : void{
		$this->quitMessage = $quitMessage;
	}

	/**
	 * Returns the quit message broadcasted to other players, e.g. "Steve left the game".
	 */
	public function getQuitMessage() : Translatable|string{
		return $this->quitMessage;
	}
}