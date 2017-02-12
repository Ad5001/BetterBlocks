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



class StickTile extends CustomBlockData {


   public function __construct(Chunk $chunk, CompoundTag $nbt){
       if(!isset($nbt->Stickable)) $nbt->Stickable = new StringTag("Stickable", "true");
       parent::__construct($chunk, $nbt);
   }


   /*
   Sets if the block can stick when a player walks on it.
   @param     $stickable    bool
   */
   public function setStickable(bool $stickable) {
       if($stickable) {
            $this->namedtag->Stickable->setValue("true");
       } else {
            $this->namedtag->Stickable->setValue("false");
       }
       return $this;
   }


   /*
   Check if the block is stickable.
   @return bool
   */
   public function isStickable() : bool {
       if($this->namedtag->Stickable->getValue() == "false") {
           return false;
       }
       return true;
   }




}