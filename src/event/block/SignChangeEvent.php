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

use xpocketmc\block\BaseSign;
use xpocketmc\block\utils\SignText;
use xpocketmc\event\Cancellable;
use xpocketmc\event\CancellableTrait;
use xpocketmc\player\Player;

/**
 * Called when a sign's text is changed by a player.
 */
class SignChangeEvent extends BlockEvent implements Cancellable{
	use CancellableTrait;

	public function __construct(
		private BaseSign $sign,
		private Player $player,
		private SignText $text
	){
		parent::__construct($sign);
	}

	public function getSign() : BaseSign{
		return $this->sign;
	}

	public function getPlayer() : Player{
		return $this->player;
	}

	/**
	 * Returns the text currently on the sign.
	 */
	public function getOldText() : SignText{
		return $this->sign->getText();
	}

	/**
	 * Returns the text which will be on the sign after the event.
	 */
	public function getNewText() : SignText{
		return $this->text;
	}

	/**
	 * Sets the text to be written on the sign after the event.
	 */
	public function setNewText(SignText $text) : void{
		$this->text = $text;
	}
}