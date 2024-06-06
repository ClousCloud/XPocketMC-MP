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

namespace xpocketmc\world\format\io;

use xpocketmc\world\format\io\exception\CorruptedChunkException;

interface WorldProvider{
	/**
	 * Returns the lowest buildable Y coordinate of this world
	 */
	public function getWorldMinY() : int;

	/**
	 * Gets the build height limit of this world
	 */
	public function getWorldMaxY() : int;

	public function getPath() : string;

	/**
	 * Loads a chunk (usually from disk storage) and returns it. If the chunk does not exist, null is returned.
	 *
	 * @throws CorruptedChunkException
	 */
	public function loadChunk(int $chunkX, int $chunkZ) : ?LoadedChunkData;

	/**
	 * Performs garbage collection in the world provider, such as cleaning up regions in Region-based worlds.
	 */
	public function doGarbageCollection() : void;

	/**
	 * Returns information about the world
	 */
	public function getWorldData() : WorldData;

	/**
	 * Performs cleanups necessary when the world provider is closed and no longer needed.
	 */
	public function close() : void;

	/**
	 * Returns a generator which yields all the chunks in this world.
	 *
	 * @return \Generator|LoadedChunkData[]
	 * @phpstan-return \Generator<array{int, int}, LoadedChunkData, void, void>
	 * @throws CorruptedChunkException
	 */
	public function getAllChunks(bool $skipCorrupted = false, ?\Logger $logger = null) : \Generator;

	/**
	 * Returns the number of chunks in the provider. Used for world conversion time estimations.
	 */
	public function calculateChunkCount() : int;
}