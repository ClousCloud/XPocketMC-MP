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

namespace xpocketmc\crafting;

use xpocketmc\data\bedrock\ItemTagToIdMap;
use xpocketmc\item\Item;
use xpocketmc\world\format\io\GlobalItemDataHandlers;

/**
 * Recipe ingredient that matches items whose ID falls within a specific set. This is used for magic meta value
 * wildcards and also for ingredients which use item tags (since tags implicitly rely on ID only).
 *
 * @internal
 */
final class TagWildcardRecipeIngredient implements RecipeIngredient{

	public function __construct(
		private string $tagName
	){}

	public function getTagName() : string{ return $this->tagName; }

	public function accepts(Item $item) : bool{
		if($item->getCount() < 1){
			return false;
		}

		return ItemTagToIdMap::getInstance()->tagContainsId($this->tagName, GlobalItemDataHandlers::getSerializer()->serializeType($item)->getName());
	}

	public function __toString() : string{
		return "TagWildcardRecipeIngredient($this->tagName)";
	}
}