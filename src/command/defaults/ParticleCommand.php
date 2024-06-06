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

use xpocketmc\block\BlockTypeIds;
use xpocketmc\color\Color;
use xpocketmc\command\CommandSender;
use xpocketmc\command\utils\InvalidCommandSyntaxException;
use xpocketmc\item\StringToItemParser;
use xpocketmc\item\VanillaItems;
use xpocketmc\lang\KnownTranslationFactory;
use pocketmine\math\Vector3;
use xpocketmc\permission\DefaultPermissionNames;
use xpocketmc\player\Player;
use xpocketmc\utils\Random;
use xpocketmc\utils\TextFormat;
use xpocketmc\world\particle\AngryVillagerParticle;
use xpocketmc\world\particle\BlockForceFieldParticle;
use xpocketmc\world\particle\BubbleParticle;
use xpocketmc\world\particle\CriticalParticle;
use xpocketmc\world\particle\DustParticle;
use xpocketmc\world\particle\EnchantmentTableParticle;
use xpocketmc\world\particle\EnchantParticle;
use xpocketmc\world\particle\EntityFlameParticle;
use xpocketmc\world\particle\ExplodeParticle;
use xpocketmc\world\particle\FlameParticle;
use xpocketmc\world\particle\HappyVillagerParticle;
use xpocketmc\world\particle\HeartParticle;
use xpocketmc\world\particle\HugeExplodeParticle;
use xpocketmc\world\particle\HugeExplodeSeedParticle;
use xpocketmc\world\particle\InkParticle;
use xpocketmc\world\particle\InstantEnchantParticle;
use xpocketmc\world\particle\ItemBreakParticle;
use xpocketmc\world\particle\LavaDripParticle;
use xpocketmc\world\particle\LavaParticle;
use xpocketmc\world\particle\Particle;
use xpocketmc\world\particle\PortalParticle;
use xpocketmc\world\particle\RainSplashParticle;
use xpocketmc\world\particle\RedstoneParticle;
use xpocketmc\world\particle\SmokeParticle;
use xpocketmc\world\particle\SplashParticle;
use xpocketmc\world\particle\SporeParticle;
use xpocketmc\world\particle\TerrainParticle;
use xpocketmc\world\particle\WaterDripParticle;
use xpocketmc\world\particle\WaterParticle;
use xpocketmc\world\World;
use function count;
use function explode;
use function max;
use function microtime;
use function mt_rand;
use function strtolower;

class ParticleCommand extends VanillaCommand{

	public function __construct(){
		parent::__construct(
			"particle",
			KnownTranslationFactory::xpocketmc_command_particle_description(),
			KnownTranslationFactory::xpocketmc_command_particle_usage()
		);
		$this->setPermission(DefaultPermissionNames::COMMAND_PARTICLE);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		if(count($args) < 7){
			throw new InvalidCommandSyntaxException();
		}

		if($sender instanceof Player){
			$senderPos = $sender->getPosition();
			$world = $senderPos->getWorld();
			$pos = new Vector3(
				$this->getRelativeDouble($senderPos->getX(), $sender, $args[1]),
				$this->getRelativeDouble($senderPos->getY(), $sender, $args[2], World::Y_MIN, World::Y_MAX),
				$this->getRelativeDouble($senderPos->getZ(), $sender, $args[3])
			);
		}else{
			$world = $sender->getServer()->getWorldManager()->getDefaultWorld();
			$pos = new Vector3((float) $args[1], (float) $args[2], (float) $args[3]);
		}

		$name = strtolower($args[0]);

		$xd = (float) $args[4];
		$yd = (float) $args[5];
		$zd = (float) $args[6];

		$count = isset($args[7]) ? max(1, (int) $args[7]) : 1;

		$data = $args[8] ?? null;

		$particle = $this->getParticle($name, $data);

		if($particle === null){
			$sender->sendMessage(KnownTranslationFactory::commands_particle_notFound($name)->prefix(TextFormat::RED));
			return true;
		}

		$sender->sendMessage(KnownTranslationFactory::commands_particle_success($name, (string) $count));

		$random = new Random((int) (microtime(true) * 1000) + mt_rand());

		for($i = 0; $i < $count; ++$i){
			$world->addParticle($pos->add(
				$random->nextSignedFloat() * $xd,
				$random->nextSignedFloat() * $yd,
				$random->nextSignedFloat() * $zd
			), $particle);
		}

		return true;
	}

	private function getParticle(string $name, ?string $data = null) : ?Particle{
		switch($name){
			case "explode":
				return new ExplodeParticle();
			case "hugeexplosion":
				return new HugeExplodeParticle();
			case "hugeexplosionseed":
				return new HugeExplodeSeedParticle();
			case "bubble":
				return new BubbleParticle();
			case "splash":
				return new SplashParticle();
			case "wake":
			case "water":
				return new WaterParticle();
			case "crit":
				return new CriticalParticle();
			case "smoke":
				return new SmokeParticle((int) ($data ?? 0));
			case "spell":
				return new EnchantParticle(new Color(0, 0, 0, 255)); //TODO: colour support
			case "instantspell":
				return new InstantEnchantParticle(new Color(0, 0, 0, 255)); //TODO: colour support
			case "dripwater":
				return new WaterDripParticle();
			case "driplava":
				return new LavaDripParticle();
			case "townaura":
			case "spore":
				return new SporeParticle();
			case "portal":
				return new PortalParticle();
			case "flame":
				return new FlameParticle();
			case "lava":
				return new LavaParticle();
			case "reddust":
				return new RedstoneParticle((int) ($data ?? 1));
			case "snowballpoof":
				return new ItemBreakParticle(VanillaItems::SNOWBALL());
			case "slime":
				return new ItemBreakParticle(VanillaItems::SLIMEBALL());
			case "itembreak":
				if($data !== null){
					$item = StringToItemParser::getInstance()->parse($data);
					if($item !== null && !$item->isNull()){
						return new ItemBreakParticle($item);
					}
				}
				break;
			case "terrain":
				if($data !== null){
					$block = StringToItemParser::getInstance()->parse($data)?->getBlock();
					if($block !== null && $block->getTypeId() !== BlockTypeIds::AIR){
						return new TerrainParticle($block);
					}
				}
				break;
			case "heart":
				return new HeartParticle((int) ($data ?? 0));
			case "ink":
				return new InkParticle((int) ($data ?? 0));
			case "droplet":
				return new RainSplashParticle();
			case "enchantmenttable":
				return new EnchantmentTableParticle();
			case "happyvillager":
				return new HappyVillagerParticle();
			case "angryvillager":
				return new AngryVillagerParticle();
			case "forcefield":
				return new BlockForceFieldParticle((int) ($data ?? 0));
			case "mobflame":
				return new EntityFlameParticle();
			case "iconcrack":
				if($data !== null && ($item = StringToItemParser::getInstance()->parse($data)) !== null && !$item->isNull()){
					return new ItemBreakParticle($item);
				}
				break;
			case "blockcrack":
				if($data !== null && ($block = StringToItemParser::getInstance()->parse($data)?->getBlock()) !== null && $block->getTypeId() !== BlockTypeIds::AIR){
					return new TerrainParticle($block);
				}
				break;
			case "blockdust":
				if($data !== null){
					$d = explode("_", $data);
					if(count($d) >= 3){
						return new DustParticle(new Color(
							((int) $d[0]) & 0xff,
							((int) $d[1]) & 0xff,
							((int) $d[2]) & 0xff,
							((int) ($d[3] ?? 255)) & 0xff
						));
					}
				}
				break;
		}

		return null;
	}
}