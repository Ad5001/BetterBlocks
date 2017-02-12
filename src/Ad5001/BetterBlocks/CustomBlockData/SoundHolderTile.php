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



class SoundHolderTile extends CustomBlockData {

    const SOUNDS = [
        "AnvilBreakSound",
        "AnvilFallSound",
        "AnvilUseSound",
        "BatSound",
        "BlazeShootSound",
        "ClickSound",
        "DoorBumpSound",
        "DoorCrashSound",
        "EndermanTeleportSound",
        "FizzSound",
        "GhastShootSound",
        "GhastSound",
        "LaunchSound",
        "PopSound",
        "ZombieHealSound",
        "ZombieInfectSound"
    ];


   public function __construct(Chunk $chunk, CompoundTag $nbt){
       if(!isset($nbt->Sound)) $nbt->Sound = new StringTag("Sound", self::SOUND(rand(0, count(self::SOUNDS) - 1))); // TODO: Customize the sound
       parent::__construct($chunk, $nbt);
   }


   /*
   Sets the sound of the Block
   @param     $sound    string
   @return bool
   */
   public function setSound(string $sound) : bool {
       if(in_array($sound, self::SOUNDS)) {
            $this->namedtag->Sound->setValue($sound);
            return true;
       }
       return false;;
   }

   /*
   Gets the current used sound
   @return string
   */
   public function getSound() : string {
       return $this->namedtag->Sound->getValue();
   }


   /*
   Plays the sound
   */
   public function play() {
       $s = "\\pocketmine\\level\\sound\\" . $this->namedtag->Sound->getValue();
       $this->getLevel()->addSound(new $s($this));
   }



}