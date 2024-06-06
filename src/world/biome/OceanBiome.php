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

namespace xpocketmc\world\biome;

use xpocketmc\block\VanillaBlocks;
use xpocketmc\world\generator\populator\TallGrass;

class OceanBiome extends Biome{

	public function __construct(){
		$this->setGroundCover([
			VanillaBlocks::GRAVEL(),
			VanillaBlocks::GRAVEL(),
			VanillaBlocks::GRAVEL(),
			VanillaBlocks::GRAVEL(),
			VanillaBlocks::GRAVEL()
		]);

		$tallGrass = new TallGrass();
		$tallGrass->setBaseAmount(5);

		$this->addPopulator($tallGrass);

		$this->setElevation(46, 58);

		$this->temperature = 0.5;
		$this->rainfall = 0.5;
	}

	public function getName() : string{
		return "Ocean";
	}
}