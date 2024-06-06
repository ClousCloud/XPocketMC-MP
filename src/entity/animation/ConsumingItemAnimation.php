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

namespace xpocketmc\entity\animation;

use xpocketmc\entity\Living;
use xpocketmc\item\Item;
use xpocketmc\network\mcpe\convert\TypeConverter;
use xpocketmc\network\mcpe\protocol\ActorEventPacket;
use xpocketmc\network\mcpe\protocol\types\ActorEvent;

final class ConsumingItemAnimation implements Animation{

	public function __construct(
		private Living $entity,
		private Item $item
	){}

	public function encode() : array{
		[$netId, $netData] = TypeConverter::getInstance()->getItemTranslator()->toNetworkId($this->item);
		return [
			//TODO: need to check the data values
			ActorEventPacket::create($this->entity->getId(), ActorEvent::EATING_ITEM, ($netId << 16) | $netData)
		];
	}
}