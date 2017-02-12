<?php

#  ____           _     _                   ____    _                  _          
# | __ )    ___  | |_  | |_    ___   _ __  | __ )  | |   ___     ___  | | __  ___ 
# |  _ \   / _ \ | __| | __|  / _ \ | '__| |  _ \  | |  / _ \   / __| | |/ / / __|
# | |_) | |  __/ | |_  | |_  |  __/ | |    | |_) | | | | (_) | | (__  |   <  \__ \
# |____/   \___|  \__|  \__|  \___| |_|    |____/  |_|  \___/   \___| |_|\_\ |___/
#
# Extends your Minecraft PE blocks palette ! For PocketMine.

namespace Ad5001\BetterBlocks;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\tile\Tile;
use pocketmine\item\Item;
use pocketmine\inventory\ShapedRecipe;
use pocketmine\math\Vector3;
use pocketmine\block\Block;
use pocketmine\event\block\BlockBreakEvent;

use pocketmine\nbt\NBT;
use pocketmine\nbt\tag\ListTag;

use Ad5001\BetterBlocks\CustomBlockData\FallableTile;
use Ad5001\BetterBlocks\CustomBlockData\GraveTile;
use Ad5001\BetterBlocks\CustomBlockData\RedstonePoweringTile;
use Ad5001\BetterBlocks\CustomBlockData\SoundHolderTile;
use Ad5001\BetterBlocks\CustomBlockData\StickTile;
use Ad5001\BetterBlocks\CustomBlockData\VacuumTile;

use Ad5001\BetterBlocks\tasks\AttractTask;
use Ad5001\BetterBlocks\tasks\BlockRegenerateTask;
use Ad5001\BetterBlocks\tasks\Drop2CraftTask;

class Main extends PluginBase implements Listener {

    static $instance;


   public function onEnable(){
       self::$instance = $this;

       // Registering recipes
       $ep = Item::get(368, 0);
       // Sticky Slime block
       $ssb = Item::get(165, 0);
       $ssb->setCustomName("§rSticky Slime Block");
       $ssb->setNamedTag(NBT::parseJSON('{"isStickable":"true"}'));
       $this->getServer()->getCraftingManager()->registerRecipe((new ShapedRecipe($ssb, 3, 3))->addIngredient(1, 1, $ep)->addIngredient(1, 2, Item::get(165, 0)));
       // Vacuum Hopper
       $vh = Item::get(410, 0);
       $vh->setNamedTag(NBT::parseJSON('{"isVacuum":"true"}'));
       $vh->setCustomName("§rVacuum Item Hopper");
       $this->getServer()->getCraftingManager()->registerRecipe((new ShapedRecipe($vh, 3, 3))->addIngredient(1, 0, $ep)->addIngredient(0, 0, Item::get(410, 0))->addIngredient(0, 1, Item::get(49, 0)));
       // Trappers (used to create trap blocks)
       $vh = Item::get(69, 0);
       $vh->setNamedTag(NBT::parseJSON('{"isTrapper":"true"}'));
       $vh->setCustomName("§rTrapper");
       $this->getServer()->getCraftingManager()->registerRecipe((new ShapedRecipe($vh, 3, 3))->addIngredient(1, 1, Item::get(70, 0))->addIngredient(0, 0, Item::get(331, 0)));
       // Hammes (for fallable blocks)
       // Wooden
       $wt = Item::get(271, 0);
       $wt->setNamedTag(NBT::parseJSON('{"isHammer":"true"}'));
       $wt->setCustomName("§rWooden Hammer");
       $this->getServer()->getCraftingManager()->registerRecipe((new ShapedRecipe($wt, 3, 3))->addIngredient(2, 0, Item::get(280, 0))->addIngredient(1, 1, Item::get(280, 0))->addIngredient(0, 1, Item::get(5, 0))->addIngredient(0, 2, Item::get(5, 0))->addIngredient(1, 2, Item::get(5, 0)));
       // Stone
       $wt = Item::get(275, 0);
       $wt->setNamedTag(NBT::parseJSON('{"isHammer":"true"}'));
       $wt->setCustomName("§rStone Hammer");
       $this->getServer()->getCraftingManager()->registerRecipe((new ShapedRecipe($wt, 3, 3))->addIngredient(2, 0, Item::get(280, 0))->addIngredient(1, 1, Item::get(280, 0))->addIngredient(0, 1, Item::get(4, 0))->addIngredient(0, 2, Item::get(4, 0))->addIngredient(1, 2, Item::get(4, 0)));
       // Iron
       $wt = Item::get(258, 0);
       $wt->setNamedTag(NBT::parseJSON('{"isHammer":"true"}'));
       $wt->setCustomName("§rIron Hammer");
       $this->getServer()->getCraftingManager()->registerRecipe((new ShapedRecipe($wt, 3, 3))->addIngredient(2, 0, Item::get(280, 0))->addIngredient(1, 1, Item::get(280, 0))->addIngredient(0, 1, Item::get(265, 0))->addIngredient(0, 2, Item::get(265, 0))->addIngredient(1, 2, Item::get(265, 0)));
       // Gold
       $wt = Item::get(286, 0);
       $wt->setNamedTag(NBT::parseJSON('{"isHammer":"true"}'));
       $wt->setCustomName("§rGold Hammer");
       $this->getServer()->getCraftingManager()->registerRecipe((new ShapedRecipe($wt, 3, 3))->addIngredient(2, 0, Item::get(280, 0))->addIngredient(1, 1, Item::get(280, 0))->addIngredient(0, 1, Item::get(266, 0))->addIngredient(0, 2, Item::get(266, 0))->addIngredient(1, 2, Item::get(266, 0)));
       // Diamond
       $wt = Item::get(279, 0);
       $wt->setNamedTag(NBT::parseJSON('{"isHammer":"true"}'));
       $wt->setCustomName("§rDiamond Hammer");
       $this->getServer()->getCraftingManager()->registerRecipe((new ShapedRecipe($wt, 3, 3))->addIngredient(2, 0, Item::get(280, 0))->addIngredient(1, 1, Item::get(280, 0))->addIngredient(0, 1, Item::get(264, 0))->addIngredient(0, 2, Item::get(264, 0))->addIngredient(1, 2, Item::get(264, 0)));


       // Registering tiles
       Tile::registerTile(FallableTile::class);
       Tile::registerTile(GraveTile::class);
       Tile::registerTile(RedstonePoweringTile::class);
       Tile::registerTile(SoundHolderTile::class);
       Tile::registerTile(StickTile::class);
       Tile::registerTile(VacuumTile::class);

        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->saveDefaultConfig();
    }



    /*
    When a custom block item is placed (Sticcky Slime Blocks, Vaccum hoppers and for Trap Blocks)
    @param     $event    \pocketmine\event\block\BlockPlaceEvent
    @retu
    */
    public function onBlockPlace(\pocketmine\event\block\BlockPlaceEvent $event) {
        if(isset($event->getItem()->getNamedTag()->isStickable) && $event->getItem()->getNamedTag()->isStickable->getValue() == "true") {
            Tile::createTile("StickTile", $event->getBlock()->getLevel()->getChunk($event->getBlock()->x >> 4, $event->getBlock()->z >> 4), NBT::parseJSON(json_encode([$event->getBlock()->x, $event->getBlock()->y, $event->getBlock()->z], JSON_FORCE_OBJECT)));
        } elseif(isset($event->getItem()->getNamedTag()->isVacuum) && $event->getItem()->getNamedTag()->isVacuum->getValue() == "true") {
            Tile::createTile("VacuumTile", $event->getBlock()->getLevel()->getChunk($event->getBlock()->x >> 4, $event->getBlock()->z >> 4), NBT::parseJSON(json_encode([$event->getBlock()->x, $event->getBlock()->y, $event->getBlock()->z], JSON_FORCE_OBJECT)));
        } elseif(isset($event->getItem()->getNamedTag()->isTrapper) && $event->getItem()->getNamedTag()->isTrapper->getValue() == "true") {
            Tile::createTile("TrapTile", $event->getBlock()->getLevel()->getChunk($event->getBlock()->x >> 4, $event->getBlock()->z >> 4), NBT::parseJSON(json_encode([$event->getBlock()->x, $event->getBlock()->y - 1, $event->getBlock()->z], JSON_FORCE_OBJECT)));
            $this->getServer()->getScheduler()->scheduleDelayedTask(new BlockRegenerateTask($this, Block::get(0, 0), $event->getBlock()->getLevel()), 30); // Clears the lever
        }
    }


    /*
    Checks when a block breaks to drop the item if custom block.
    @param     $event    BlockBreakEvent
    */
    public function onBlockBreak(BlockBreakEvent $event) {
        //1
        $block = $event->getBlock();
        if($event->getBlock()->getLevel()->getTile($block) instanceof CustomBlockData && !$event->isCancelled()) {
            switch(substr(get_class($event->getBlock()->getLevel()->getTile($block)), 36)) {
                case "GraveTile":
                $event->getBlock()->getLevel()->getTile($block)->drop();
                break;
                case "RedstonePoweringTile":
                $redstoneblock = Item::get(152, 0);
                $event->setDrops(array_merge([$redstoneblock], $event->getDrops()));
                break;
                case "SoundHolderTile":
                $noteblock = Item::get(25, 0);
                $event->setDrops(array_merge([$noteblock], $event->getDrops()));
                break;
                case "StickTile":
                $ssb = Item::get(165, 0);
                $ssb->setCustomName("§rSticky Slime Block");
                $ssb->setNamedTag(NBT::parseJSON('{"isStickable":"true"}'));
                $event->setDrops([$ssb]);
                break;
                case "TrapTile":
                break;
                case "VacuumTile":
                $vh = Item::get(410, 0);
                $vh->setNamedTag(NBT::parseJSON('{"isVacuum":"true"}'));
                $vh->setCustomName("§rVacuum Item Hopper");
                $event->setDrops([$vh]);
                break;
            }
        }
    }



    /*
    Check if a player touches a block. Check if he right clicks ill a hammer.
    @param     $event    \pocketmine\event\player\PlayerInteractEvent
    */
    public function onInteract(\pocketmine\event\player\PlayerInteractEvent $event) {
        if(isset($event->getItem()->getNamedTag()->isHammer) && $event->getItem()->getNamedTag()->isHammer == "true" && !($event->getBlock() instanceof \pocketmine\block\Fallable) && !($event->getBlock()->getLevel()->getTile($event->getBlock()) instanceof Tile)) {
            Tile::createTile("FallableTile", $event->getBlock()->getLevel()->getChunk($event->getBlock()->x >> 4, $event->getBlock()->z >> 4), NBT::parseJSON('{"x":"'.$event->getBlock()->x.'","y":"' .$event->getBlock()->y.'","z":"'. $event->getBlock()->z . '"}'));
            $event->getPlayer()->sendPopup("This block seems now unstable... You shouldn't walk on it...");
        }
    }


    /*
    Detects when a player drops an item to set it as "Droped by the player" to build some custom blocks.
    @param     $event    \pocketmine\event\player\PlayerDropItemEvent
    */
    public function onPlayerItemDrop(\pocketmine\event\player\PlayerDropItemEvent $event) {
        $event->getItem()->setNamedTag(NBT::parseJSON('{"isDropedByPlayer":"true"}'));
    }


    /*
    Checks when a player death to set up a grave.
    @param     $event    \pocketmine\event\player\PlayerDeathEvent
    */
    public function onPlayerDeath(\pocketmine\event\player\PlayerDeathEvent $event) {
        $player = $event->getPlayer();
        $cause = $player->getLastDamageCause();
        $nbt = NBT::parseJSON(json_encode([
            "x" => $player->x,
            "y" => $player->y, 
            "z" => $player->z, 
            "Player" => $player->getName(), 
            "DeathCause" => $cause == null ? 14 : $cause->getCause(),
            "Params" => $event->getDeathMessage()->getParameters()
        ], JSON_FORCE_OBJECT));
        $nbt->Items = new ListTag("Items", []);
	    $nbt->Items->setTagType(NBT::TAG_Compound);
        foreach($event->getDrops() as $index => $content) {
            $nbt->Items[$index] = $content->nbtSerialize();
        }
        $event->setDrops([]);
        Tile::createTile("GraveTile", $player->getLevel()->getChunk($player->x >> 4, $player->z >> 4), $nbt);
    }


    /*
    Checks when a player moves to 1) Trigger traps blocks, 2) Set person as sticky 3) Makes fallable block fall if a player walks on it.
    @param     $event    \pocketmine\event\player\PlayerMoveEvent
    */
    public function onPlayerMove(\pocketmine\event\player\PlayerMoveEvent $event) {
        $v3Under = $event->getPlayer()->round();
        $v3Under->y--;
        $v3Upper = $event->getPlayer()->round();
        $v3Upper->y += 2;
        $tileUnder = $event->getPlayer()->getLevel()->getTile($v3Under);
        $tileUpper = $event->getPlayer()->getLevel()->getTile($v3Upper);

        // 1)
        if($tileUnder instanceof TrapTile) {
            $block = clone $event->getPlayer()->getLevel()->getBlock($v3Under);
            $event->getPlayer()->getLevel()->setBlock($v3Under, Block::get(0, 0));
            $this->getServer()->getScheduler()->scheduleDelayedTask(new BlockRegenerateTask($this, $block, $event->getPlayer()->getLevel()), 30);
        }
        // 2)
        if($tileUnder instanceof StickTile || $tileUpper instanceof StickTile) {
            $event->getPlayer()->setMotion($event->getPlayer()->getMotion()->x, 0, $event->getPlayer()->getMotion()->z);
        }
        // 3)
        if($tileUnder instanceof FallableTile) {
            $tileUnder->fall();
        }
    }


}