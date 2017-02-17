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
use Ad5001\BetterBlocks\CustomBlockData\StickTile;
use Ad5001\BetterBlocks\Main;







class StickTask extends PluginTask {




   public function __construct(Main $main) {
        parent::__construct($main);
        $this->main = $main;
        $this->server = $main->getServer();
    }




   public function onRun($tick) {
       foreach($this->server->getOnlinePlayers() as $player) {
            $v3Under = $player->round();
            $v3Under->y--;
            $v3Upper = $player->round();
            $v3Upper->y += 2;
            $tileUnder = $player->getLevel()->getTile($v3Under);
            $tileUpper = $player->getLevel()->getTile($v3Upper);
            if($tileUnder instanceof StickTile){
                $player->setMotion(new \pocketmine\math\Vector3($player->getMotion()->x, -0.5, $player->getMotion()->z));
            } 
            if($tileUpper instanceof StickTile) {
                $player->setMotion(new \pocketmine\math\Vector3($player->getMotion()->x, 0.5, $player->getMotion()->z));
            }
       }
    }




}