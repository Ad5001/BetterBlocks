<?php

#  ____           _     _                   ____    _                  _          
# | __ )    ___  | |_  | |_    ___   _ __  | __ )  | |   ___     ___  | | __  ___ 
# |  _ \   / _ \ | __| | __|  / _ \ | '__| |  _ \  | |  / _ \   / __| | |/ / / __|
# | |_) | |  __/ | |_  | |_  |  __/ | |    | |_) | | | | (_) | | (__  |   <  \__ \
# |____/   \___|  \__|  \__|  \___| |_|    |____/  |_|  \___/   \___| |_|\_\ |___/
#
# Extends your Minecraft PE blocks palette ! For PocketMine.



namespace Ad5001\BetterBlocks\CustomBlockData;

use pocketmine\Server;
use pocketmine\Player;
use pocketmine\level\format\Chunk;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\StringTag;

use Ad5001\BetterBlocks\CustomBlockData;



class TrapTile extends CustomBlockData {


   public function __construct(Chunk $chunk, CompoundTag $nbt){
       if(!isset($nbt->TrapActive)) $nbt->TrapActive = new StringTag("TrapActive", "true");
       parent::__construct($chunk, $nbt);
   }


   /*
   Sets if the trap is active
   @param     $trapActive    bool
   */
   public function setTrapActive(bool $trapActive) {
       if($trapActive) {
            $this->namedtag->TrapActive->setValue("true");
       } else {
            $this->namedtag->TrapActive->setValue("false");
       }
       return $this;
   }


   /*
   Check if the trap is active.
   @return bool
   */
   public function isTrapActive() : bool {
       if($this->namedtag->TrapActive->getValue() == "false") {
           return false;
       }
       return true;
   }




}