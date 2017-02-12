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
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\IntTag;

use Ad5001\BetterBlocks\CustomBlockData;




class VacuumTile extends CustomBlockData {
    
    public function __construct(Chunk $chunk, CompoundTag $nbt){
       if(!isset($nbt->AttractRadius)) $nbt->AttractRadius = new IntTag("AttractRadius", 5);
       parent::__construct($chunk, $nbt);
   }


   /*
   Sets the attracting radius of the vacuum hopper
   @param     $radius    int
   */
   public function setAttractRadius(int $radius) {
        $this->namedtag->AttractRadius->setValue($radius);
        return $this;
   }


   /*
   Get the radius of attractivity of the Vacuum Hopper.
   @return int
   */
   public function getAttractRadius() : int {
       return (int) $this->namedtag->AttractRadius->getValue();
   }

   /*
   Attracts all blocks in the defined radius.
   */
   public function attract() {
       foreach ($this->getLevel()->getEntities() as $et) {
           if($et->x < $this->x + $this->namedtag->AttractRadius->getValue() && $et->x > $this->x - $this->namedtag->AttractRadius->getValue() &&
           $et->y < $this->y + $this->namedtag->AttractRadius->getValue() && $et->y > $this->y - $this->namedtag->AttractRadius->getValue() &&
           $et->z < $this->z + $this->namedtag->AttractRadius->getValue() && $et->z > $this->z - $this->namedtag->AttractRadius->getValue()) {
               $et->teleport(new Vector3($this->x, $this->y + 1, $this->z));
           }
       }
   }




}