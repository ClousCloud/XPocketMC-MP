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

namespace xpocketmc\player;

use xpocketmc\nbt\tag\CompoundTag;

/**
 * Handles storage of player data. Implementations must treat player names in a case-insensitive manner.
 */
interface PlayerDataProvider{

	/**
	 * Returns whether there are any data associated with the given player name.
	 */
	public function hasData(string $name) : bool;

	/**
	 * Returns the data associated with the given player name, or null if there is no data.
	 * TODO: we need an async version of this
	 *
	 * @throws PlayerDataLoadException
	 */
	public function loadData(string $name) : ?CompoundTag;

	/**
	 * Saves data for the give player name.
	 *
	 * @throws PlayerDataSaveException
	 */
	public function saveData(string $name, CompoundTag $data) : void;
}