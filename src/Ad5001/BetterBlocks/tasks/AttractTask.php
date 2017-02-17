<?php

#  ____           _     _                   ____    _                  _          
# | __ )    ___  | |_  | |_    ___   _ __  | __ )  | |   ___     ___  | | __  ___ 
# |  _ \   / _ \ | __| | __|  / _ \ | '__| |  _ \  | |  / _ \   / __| | |/ / / __|
# | |_) | |  __/ | |_  | |_  |  __/ | |    | |_) | | | | (_) | | (__  |   <  \__ \
# |____/   \___|  \__|  \__|  \___| |_|    |____/  |_|  \___/   \___| |_|\_\ |___/
#
# Extends your Minecraft PE blocks palette ! For PocketMine.

namespace Ad5001\BetterBlocks\tasks;


use pocketmine\Server;
use pocketmine\scheduler\PluginTask;
use pocketmine\Player;


use Ad5001\BetterBlocks\CustomBlockData;
use Ad5001\BetterBlocks\Main;







class AttractTask extends PluginTask {




   public function __construct(Main $main) {
        parent::__construct($main);
        $this->main = $main;
        $this->server = $main->getServer();
    }




   public function onRun($tick) {
       foreach($this->server->getLevels() as $level) {
           foreach($level->getTiles() as $tile) {
               if(get_class($tile) == "pocketmine\\tile\\Hopper" && isset($tile->namedtag->isVacuum) && $tile->namedtag->isVacuum->getValue() == 1) {
                   for($i = 0; $i < 10; $i++) { // Particles
                        $level->addParticle(new \pocketmine\level\particle\PortalParticle(new \pocketmine\math\Vector3($tile->x + rand(-70, 170) / 100, $tile->y + rand(-70, 130) / 100, $tile->z + rand(-70, 170) / 100)));
                   }
                    foreach($level->getEntities() as $et) {
                        if($et instanceof \pocketmine\entity\Item && $et->distance($tile) < 3) {
                            $tile->getInventory()->addItem($et->getItem());
                            $et->close();
                        }
                    }
               }
           }
       }
    }




}