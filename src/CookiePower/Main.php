<?php

namespace CookiePower;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemConsumeEvent;
use pocketmine\item\Item;
use pocketmine\entity\Effect;
use pocketmine\level\particle\FlameParticle;
use pocketmine\math\Vector3;
use pocketmine\level\sound\BlazeShootSound;
use pocketmine\scheduler\PluginTask;

class Main extends PluginBase implements Listener {
	
	public $active = [];
	
	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		
		$this->getServer()->getScheduler()->scheduleRepeatingTask(
		 new CookieTask($this), 1
		 );
		 
		 $this->getLogger()->info("Cookie Power pluginhas successfully Activated!");
	}
	
	public function onEat(PlayerItemConsumeEvent $event){
		$player = $event->getPlayer();
		$item = $event->getItem();
		
		if($item->getId() === Item::COOKIE){
			
			$player->setHealth(min(
			    $player->getHealth() + 6,
				$player->getMaxHealth()
				));
				
				$effect = Effect::getEffect(Effect::SPEED);
				if($effect !== null){
					$effect->setDuration(20* 5);
					$effect->setAmplifier(1);
					$player->addEffect($effect);
				}
				
				$player->sendPopup("§6Cookie Power Activated!§r");
				
				$player->getLevel()->addSound(new BlazeShootSound($player));
				
				for($i = 0; $i < 40; $i++){
					$x = $player->getX() + mt_rand(-15, 15) / 10;
					$y = $player->getY() + mt_rand(0, 25) / 10;
					$z = $player->getZ() + mt_rand(-15, 15) / 10;
					
					$player->getLevel()->addParticle(
					    new FlameParticle(new Vector3($x, $y, $z))
						);
				}
				
				$this->active[$player->getName()] = 20 * 5;
		}
	}
}