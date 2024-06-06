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

namespace xpocketmc\network\mcpe\convert;

use xpocketmc\entity\InvalidSkinException;
use xpocketmc\entity\Skin;
use xpocketmc\network\mcpe\protocol\types\skin\SkinData;

/**
 * Used to convert new skin data to the skin entity or old skin entity to skin data.
 */
interface SkinAdapter{

	/**
	 * Allows you to convert a skin entity to skin data.
	 */
	public function toSkinData(Skin $skin) : SkinData;

	/**
	 * Allows you to convert skin data to a skin entity.
	 * @throws InvalidSkinException
	 */
	public function fromSkinData(SkinData $data) : Skin;
}