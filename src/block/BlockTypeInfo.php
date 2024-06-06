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

use function array_fill_keys;
use function array_keys;

final class BlockTypeInfo{
	/**
	 * @var true[]
	 * @phpstan-var array<string, true>
	 */
	private array $typeTags;

	/**
	 * @param string[] $typeTags
	 * @param string[] $enchantmentTags
	 */
	public function __construct(
		private BlockBreakInfo $breakInfo,
		array $typeTags = [],
		private array $enchantmentTags = []
	){
		$this->typeTags = array_fill_keys($typeTags, true);
	}

	public function getBreakInfo() : BlockBreakInfo{ return $this->breakInfo; }

	/** @return string[] */
	public function getTypeTags() : array{ return array_keys($this->typeTags); }

	public function hasTypeTag(string $tag) : bool{ return isset($this->typeTags[$tag]); }

	/**
	 * Returns tags that represent the type of item being enchanted and are used to determine
	 * what enchantments can be applied to the item of this block during in-game enchanting (enchanting table, anvil, fishing, etc.).
	 * @see ItemEnchantmentTags
	 * @see ItemEnchantmentTagRegistry
	 * @see AvailableEnchantmentRegistry
	 *
	 * @return string[]
	 */
	public function getEnchantmentTags() : array{
		return $this->enchantmentTags;
	}
}