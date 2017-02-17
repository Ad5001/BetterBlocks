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
use pocketmine\nbt\tag\ShortTag;


use Ad5001\BetterBlocks\Main;
use Ad5001\BetterBlocks\CustomBlockData;







class SetVacuumTask extends PluginTask {

    protected $block;
    protected $main;
    protected $server;




   public function __construct(Main $main, \pocketmine\block\Block $block) {
        parent::__construct($main);
        $this->main = $main;
        $this->block = $block;
        $this->server = $main->getServer();
    }




    public function onRun($tick) {
        $tile = $this->block->getLevel()->getTile($this->block);
        if(get_class($tile) == "pocketmine\\tile\\Hopper") { // For software like pocketmine that haven't implemented Hoppers.
            $tile->namedtag->isVacuum = new ShortTag("isVacuum", 1);
        }
    }




}