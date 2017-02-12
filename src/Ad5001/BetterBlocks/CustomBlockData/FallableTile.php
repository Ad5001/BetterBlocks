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
use pocketmine\nbt\tag\StringTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\FloatTag;

use Ad5001\BetterBlocks\CustomBlockData;



class FallableTile extends CustomBlockData {


   public function __construct(Chunk $chunk, CompoundTag $nbt){
       if(!isset($nbt->Fallable)) $nbt->Fallable = new StringTag("Fallable", "true");
       parent::__construct($chunk, $nbt);
   }


   /*
   Sets if the block can fall when a  player walks on it.
   @param     $fallable    bool
   */
   public function setFallable(bool $fallable) {
       if($fallable) {
            $this->namedtag->Fallable->setValue("true");
       } else {
            $this->namedtag->Fallable->setValue("false");
       }
       return $this;
   }


   /*
   Check if the block is fallable.
   @return bool
   */
   public function isFallable() : bool {
       if($this->namedtag->Fallable->getValue() == "false") {
           return false;
       }
       return true;
   }


   /*
   Makes the block fall
   */
   public function fall() {
        if($this->level->getBlock($this->getSide(Vector3::SIDE_DOWN))->getId() == 0 || $this->level->getBlock($this->getSide(Vector3::SIDE_DOWN)) instanceof \pocketmine\block\Liquid) {
				$fall = \pocketmine\entity\Entity::createEntity("FallingSand", $this->getLevel()->getChunk($this->x >> 4, $this->z >> 4), new CompoundTag("", [
					"Pos" => new ListTag("Pos", [
						new DoubleTag("", $this->x + 0.5),
						new DoubleTag("", $this->y),
						new DoubleTag("", $this->z + 0.5)
					]),
					"Motion" => new ListTag("Motion", [
						new DoubleTag("", 0),
						new DoubleTag("", 0),
						new DoubleTag("", 0)
					]),
					"Rotation" => new ListTag("Rotation", [
						new FloatTag("", 0),
						new FloatTag("", 0)
					]),
					"TileID" => new IntTag("TileID", $this->getBlock()->getId()),
					"Data" => new ByteTag("Data", $this->getBlock()->getDamage()),
				]))->spawnToAll();
                // $this->getLevel()->setBlock($this, Block::get(0, 0));
            }
   }




}