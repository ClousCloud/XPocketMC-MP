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

namespace xpocketmc\command\defaults;

use xpocketmc\command\CommandSender;
use xpocketmc\lang\KnownTranslationFactory;
use xpocketmc\permission\DefaultPermissionNames;
use Symfony\Component\Filesystem\Path;
use function date;

class DumpMemoryCommand extends VanillaCommand{

	public function __construct(){
		parent::__construct(
			"dumpmemory",
			KnownTranslationFactory::xpocketmc_command_dumpmemory_description(),
			"/dumpmemory [path]"
		);
		$this->setPermission(DefaultPermissionNames::COMMAND_DUMPMEMORY);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		$sender->getServer()->getMemoryManager()->dumpServerMemory($args[0] ?? (Path::join($sender->getServer()->getDataPath(), "memory_dumps", date("D_M_j-H.i.s-T_Y"))), 48, 80);
		return true;
	}
}