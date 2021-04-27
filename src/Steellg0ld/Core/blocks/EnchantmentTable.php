<?php

namespace Steellg0ld\Core\blocks;

use pocketmine\block\Block;
use pocketmine\block\BlockToolType;
use pocketmine\block\Transparent;
use pocketmine\inventory\EnchantInventory;
use pocketmine\item\Item;
use pocketmine\item\TieredTool;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\tile\EnchantTable as TileEnchantTable;
use pocketmine\tile\Tile;

class EnchantmentTable extends Transparent{

    protected $id = self::ENCHANTING_TABLE;

    public function __construct(int $meta = 0){
        $this->meta = $meta;
    }

    public function place(Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, Player $player = null) : bool{
        $this->getLevelNonNull()->setBlock($blockReplace, $this, true, true);

        Tile::createTile(Tile::ENCHANT_TABLE, $this->getLevelNonNull(), TileEnchantTable::createNBT($this, $face, $item, $player));

        return true;
    }

    public function getHardness() : float{
        return 5;
    }

    public function getBlastResistance() : float{
        return 6000;
    }

    public function getName() : string{
        return "Enchanting Table";
    }

    public function getToolType() : int{
        return BlockToolType::TYPE_PICKAXE;
    }

    public function getToolHarvestLevel() : int{
        return TieredTool::TIER_WOODEN;
    }

    public function onActivate(Item $item, Player $player = null) : bool{
        return true;
    }
}
