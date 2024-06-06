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

namespace xpocketmc\plugin;

use xpocketmc\utils\LegacyEnumShimTrait;
use function mb_strtolower;

/**
 * TODO: These tags need to be removed once we get rid of LegacyEnumShimTrait (PM6)
 *  These are retained for backwards compatibility only.
 *
 * @method static PluginEnableOrder POSTWORLD()
 * @method static PluginEnableOrder STARTUP()
 */
enum PluginEnableOrder{
	use LegacyEnumShimTrait;

	case STARTUP;
	case POSTWORLD;

	public static function fromString(string $name) : ?self{
		/**
		 * @var self[]|null $aliasMap
		 * @phpstan-var array<string, self>|null $aliasMap
		 */
		static $aliasMap = null;

		if($aliasMap === null){
			$aliasMap = [];
			foreach(self::cases() as $case){
				foreach($case->getAliases() as $alias){
					$aliasMap[$alias] = $case;
				}
			}
		}
		return $aliasMap[mb_strtolower($name)] ?? null;
	}

	/**
	 * @return string[]
	 * @phpstan-return list<string>
	 */
	public function getAliases() : array{
		return match($this){
			self::STARTUP => ["startup"],
			self::POSTWORLD => ["postworld"]
		};
	}
}