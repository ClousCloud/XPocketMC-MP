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

namespace xpocketmc\crash;

final class CrashDumpData implements \JsonSerializable{

	public int $format_version;

	public float $time;

	public float $uptime;

	/** @var mixed[] */
	public array $lastError = [];

	/** @var mixed[] */
	public array $error;

	public string $thread;

	public string $plugin_involvement;

	public string $plugin = "";

	/** @var string[] */
	public array $code = [];

	/** @var string[] */
	public array $trace;

	/**
	 * @var CrashDumpDataPluginEntry[]
	 * @phpstan-var array<string, CrashDumpDataPluginEntry>
	 */
	public array $plugins = [];

	/** @var string[] */
	public array $parameters = [];

	public string $serverDotProperties = "";

	public string $xpocketmcDotYml = "";

	/**
	 * @var string[]
	 * @phpstan-var array<string, string>
	 */
	public array $extensions = [];

	public ?int $jit_mode = null;

	public string $phpinfo = "";

	public CrashDumpDataGeneral $general;

	/**
	 * @return mixed[]
	 */
	public function jsonSerialize() : array{
		$result = (array) $this;
		unset($result["serverDotProperties"]);
		unset($result["xpocketmcDotYml"]);
		$result["xpocketmc.yml"] = $this->xpocketmcDotYml;
		$result["server.properties"] = $this->serverDotProperties;
		return $result;
	}
}