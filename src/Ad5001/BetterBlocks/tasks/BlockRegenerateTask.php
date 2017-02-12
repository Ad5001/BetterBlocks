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
use pocketmine\level\Level;
use pocketmine\block\Block;

use Ad5001\BetterBlocks\CustomBlockData;
use Ad5001\BetterBlocks\Main;


class BlockRegenerateTask extends PluginTask {




   public function __construct(Main $main, Block $block, Level $lvl) {
        parent::__construct($main);
        $this->main = $main;
        $this->server = $main->getServer();
        $this->block = $block;
        $this->lvl = $lvl;
    }




   public function onRun($tick) {
       $this->lvl->setBlock($this->block, $this->block); // Delays a the block setting.
       $this->lvl->setBlock($this->block, $this->block); // Levers are not deleting
       $this->main->getLogger()->debug($this->lvl->getBlock($this->block));
    }




}