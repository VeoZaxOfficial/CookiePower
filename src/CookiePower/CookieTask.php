<?php

namespace CookiePower;

use pocketmine\scheduler\PluginTask;
use pocketmine\level\particle\FlameParticle;
use pocketmine\math\Vector3;

class CookieTask extends PluginTask {

    public function __construct(Main $plugin){
		parent::__construct($plugin);
	}
	
	public function onRun($currentTick){
		$plugin = $this->getOwner();
		
		foreach($plugin->active as $name => $time){
			$player = $plugin->getServer()->getPlayer($name);
			
			if($player === null || !$player->isOnline()){
				unset($plugin->active[$name]);
				continue;
			}
			
			for($i = 0; $i < 40; $i++){
					$x = $player->getX() + mt_rand(-10, 10) / 10;
					$y = $player->getY() + mt_rand(0, 20) / 10;
					$z = $player->getZ() + mt_rand(-10, 10) / 10;
					
					$player->getLevel()->addParticle(
					    new FlameParticle(new Vector3($x, $y, $z))
						);
				}
				
				$plugin->active[$name]--;
				
				if($plugin->active[$name] <= 0){
					unset($plugin->active[$name]);
				}
		}
	}
}
		