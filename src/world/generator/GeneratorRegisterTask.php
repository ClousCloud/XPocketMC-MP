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

namespace xpocketmc\world\generator;

use xpocketmc\scheduler\AsyncTask;
use xpocketmc\world\World;

class GeneratorRegisterTask extends AsyncTask{
	public int $seed;
	public int $worldId;
	public int $worldMinY;
	public int $worldMaxY;

	/**
	 * @phpstan-param class-string<Generator> $generatorClass
	 */
	public function __construct(
		World $world,
		public string $generatorClass,
		public string $generatorSettings
	){
		$this->seed = $world->getSeed();
		$this->worldId = $world->getId();
		$this->worldMinY = $world->getMinY();
		$this->worldMaxY = $world->getMaxY();
	}

	public function onRun() : void{
		/**
		 * @var Generator $generator
		 * @see Generator::__construct()
		 */
		$generator = new $this->generatorClass($this->seed, $this->generatorSettings);
		ThreadLocalGeneratorContext::register(new ThreadLocalGeneratorContext($generator, $this->worldMinY, $this->worldMaxY), $this->worldId);
	}
}