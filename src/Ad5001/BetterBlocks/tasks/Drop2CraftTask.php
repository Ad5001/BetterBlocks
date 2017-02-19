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
use pocketmine\nbt\NBT;
use pocketmine\tile\Tile;
use pocketmine\item\Item;
use pocketmine\entity\Item as EtItem;

use Ad5001\BetterBlocks\CustomBlockData;
use Ad5001\BetterBlocks\CustomBlockData\FallableTile;
use Ad5001\BetterBlocks\CustomBlockData\RedstonePoweringTile;
use Ad5001\BetterBlocks\CustomBlockData\SoundHolderTile;

use Ad5001\BetterBlocks\Main;



class Drop2CraftTask extends PluginTask {




   public function __construct(Main $main) {
        parent::__construct($main);
        $this->main = $main;
        $this->server = $main->getServer();
    }




   public function onRun($tick) {
       foreach($this->server->getLevels() as $level) {
           foreach($level->getEntities() as $et) {
                if($et instanceof EtItem && isset($et->getItem()->getNamedTag()->isDropedByPlayer)) {
                    switch($et->getItem()->getId()) {
                        case 152: // Redstone block: For the Redstone Powering Block
                        $v3 = $et->round();
                        $v3->y--;
                        if($et->getLevel()->getBlock($v3)->isSolid()) {
                            Tile::createTile("RedstonePoweringTile", $et->getLevel()->getChunk($et->x >> 4, $et->z >> 4), NBT::parseJSON(json_encode(["x" => $v3->x, "y" => $v3->y, "z" => $v3->z], JSON_FORCE_OBJECT)));
                            $et->close();
                        }
                        break;
                        case 25: // Note block: For the Sound Holding block.
                        $v3 = $et->round();
                        $v3->y--;
                        if($et->getLevel()->getBlock($v3)->isSolid()) {
                            Tile::createTile("SoundHolderTile", $et->getLevel()->getChunk($et->x >> 4, $et->z >> 4), NBT::parseJSON(json_encode(["x" => $v3->x, "y" => $v3->y, "z" => $v3->z], JSON_FORCE_OBJECT)));
                            $et->close();
                        }
                        break;
                        case 69: // Levers drops
                        $v3 = $et->round();
                        $v3->y--;
                        if(isset($et->getItem()->getNamedTag()->isTrapper)) $this->main->getLogger()->debug("Found trapper");
                        if($et->getLevel()->getBlock($v3)->isSolid() && isset($et->getItem()->getNamedTag()->isTrapper)) {
                            Tile::createTile("TrapTile", $et->getLevel()->getChunk($v3->x >> 4, $v3->z >> 4), NBT::parseJSON(json_encode(["x" => $v3->x, "y" => $v3->y - 1, "z" => $v3->z], JSON_FORCE_OBJECT)));
                            $et->close();
                        }
                        break;
                    }
                }
           }
       }
    }




}