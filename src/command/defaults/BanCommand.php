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

use xpocketmc\command\Command;
use xpocketmc\command\CommandSender;
use xpocketmc\command\utils\InvalidCommandSyntaxException;
use xpocketmc\lang\KnownTranslationFactory;
use xpocketmc\permission\DefaultPermissionNames;
use xpocketmc\player\Player;
use function array_shift;
use function count;
use function implode;

class BanCommand extends VanillaCommand{

	public function __construct(){
		parent::__construct(
			"ban",
			KnownTranslationFactory::xpocketmc_command_ban_player_description(),
			KnownTranslationFactory::commands_ban_usage()
		);
		$this->setPermission(DefaultPermissionNames::COMMAND_BAN_PLAYER);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		if(count($args) === 0){
			throw new InvalidCommandSyntaxException();
		}

		$name = array_shift($args);
		$reason = implode(" ", $args);

		$sender->getServer()->getNameBans()->addBan($name, $reason, null, $sender->getName());

		if(($player = $sender->getServer()->getPlayerExact($name)) instanceof Player){
			$player->kick($reason !== "" ? KnownTranslationFactory::xpocketmc_disconnect_ban($reason) : KnownTranslationFactory::xpocketmc_disconnect_ban_noReason());
		}

		Command::broadcastCommandMessage($sender, KnownTranslationFactory::commands_ban_success($player !== null ? $player->getName() : $name));

		return true;
	}
}