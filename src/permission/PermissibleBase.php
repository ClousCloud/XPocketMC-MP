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

namespace xpocketmc\permission;

final class PermissibleBase implements Permissible{
	use PermissibleDelegateTrait;

	private PermissibleInternal $permissibleBase;

	/**
	 * @param bool[] $basePermissions
	 * @phpstan-param array<string, bool> $basePermissions
	 */
	public function __construct(array $basePermissions){
		$this->permissibleBase = new PermissibleInternal($basePermissions);
		$this->perm = $this->permissibleBase;
	}

	public function __destruct(){
		//permission subscriptions need to be cleaned up explicitly
		$this->permissibleBase->destroyCycles();
	}
}