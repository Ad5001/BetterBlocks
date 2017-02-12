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
use pocketmine\item\Item;
use pocketmine\tile\Tile;
use pocketmine\nbt\NBT;
use pocketmine\level\format\Chunk;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\tile\Container;
use pocketmine\math\Vector3;
use pocketmine\event\entity\EntityDamageEvent as EDE;

use Ad5001\BetterBlocks\CustomBlockData;
use Ad5001\BetterBlocks\Main;
use Ad5001\BetterBlocks\tasks\SetTextTimeoutTask;



class GraveTile extends CustomBlockData implements Container {

    const MESSAGES = [ 
        EDE::CAUSE_CONTACT => "Didn't saw the cactus in his path",
        EDE::CAUSE_ENTITY_ATTACK => "Slain by %1",
        EDE::CAUSE_PROJECTILE => "Shot by %1",
        EDE::CAUSE_SUFFOCATION => "Suffocated in a wall",
        EDE::CAUSE_FALL => "Failed his MLG",
        EDE::CAUSE_FIRE => "Went up in flames",
        EDE::CAUSE_FIRE_TICK => "Burnt to death",
        EDE::CAUSE_LAVA => "Tried to swim in lava",
        EDE::CAUSE_BLOCK_EXPLOSION => "Trapped with TNT",
        EDE::CAUSE_ENTITY_EXPLOSION => "Blown up by a failed pig",
        EDE::CAUSE_VOID => "You shouldn't see this sign...",
        EDE::CAUSE_SUICIDE => "Suicided",
        EDE::CAUSE_MAGIC => "Messed with a witch",
        EDE::CAUSE_CUSTOM => "Unknown",
        EDE::CAUSE_STARVATION => "Was to hungry to even eat"
    ];

   public function __construct(Chunk $chunk, CompoundTag $nbt){
       if(!isset($nbt->Items)) {
            $nbt->Items = new ListTag("Items", []);
	        $nbt->Items->setTagType(NBT::TAG_Compound);
            foreach(Server::getInstance()->getPlayer($nbt->Player->getValue())->getInventory()->getContents() as $key => $content) {
                $nbt->Items[$index] = $content->nbtSerialize();
            }
       }
       parent::__construct($chunk, $nbt);
       if(isset($nbt->Params)) {
          $this->level->setBlock($this, \pocketmine\block\Block::get(4, 0));
          $v3 = $this->getSide(Vector3::SIDE_NORTH);
          $this->level->setBlock($v3, \pocketmine\block\Block::get(68, 2));
          $dm = self::MESSAGES[$nbt->DeathCause];
          if(isset($nbt->Params[1])) $dm = str_ireplace("%1", $nbt->Params[1], $dm);
          $t = Tile::createTile("Sign", $this->level->getChunk($v3->x >> 4, $v3->z >> 4), NBT::parseJSON(json_encode(["x" => $v3->x, "y" => $v3->y, "z" => $v3->z, "Text1" => "§a-=<>=-", "Text2" => "R.I.P", "Text3" => $nbt->Player, "Text4" => $dm], JSON_FORCE_OBJECT)));
          $t->setText("§a-=<>=-", "R.I.P", $nbt->Player, $dm);
          unset($nbt->Params);
       }
   }
   

   /*
   Return the item from it's index.
   @param     $index    int
   @return Item
   */
   public function getItem($index) {
       return isset($this->namedtag->Items->{$index}) ? $this->namedtag->Items->{$index} : Item::get(0, 0);
   }
   

   /*
   Sets an item to it's index.
   @param     $index    int
   @param     $item    \pocketmine\item\Item
   */
   public function setItem($index, \pocketmine\item\Item $item) {
       $this->namedtag->Items->{$index} = $item;
       return $this;
   }

   /*
   Returns the size of the Inventory
   */
   public function getSize() {
       return 40;
   }



   /*
   Drops all the contents of the grave on the ground (when a player goes on it)
   */
   public function drop() {
       foreach($this->namedtag->Items as $item) {
           $item = Item::nbtDeserialize($item);
           $this->getLevel()->dropItem($this, $item, new \pocketmine\math\Vector3(0, 0.001, 0), 0);
       }
   }
}