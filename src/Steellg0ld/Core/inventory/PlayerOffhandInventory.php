<?php

namespace Steellg0ld\Core\inventory;

use pocketmine\inventory\BaseInventory;
use pocketmine\item\Item;
use pocketmine\network\mcpe\protocol\MobEquipmentPacket;
use pocketmine\network\mcpe\protocol\types\ContainerIds;
use pocketmine\network\mcpe\protocol\types\inventory\ItemStackWrapper;
use Steellg0ld\Core\Player;

class PlayerOffhandInventory extends BaseInventory{
    public const SLOT_OFFHAND = 0;

    protected Player $holder;

    public function __construct(Player $holder){
        parent::__construct();
        $this->holder = $holder;
    }

    public function getName() : string{
        return "OffhandInventory";
    }

    public function getDefaultSize() : int{
        return 1;
    }

    public function getItemInOffhand() : Item{
        return $this->getItem(0);
    }

    public function setItemInOffhand(Item $item) : void{
        $this->setItem(self::SLOT_OFFHAND, $item);
    }

    public function onSlotChange(int $index, Item $before, bool $send) : void{
        parent::onSlotChange($index, $before, $send);
        $this->broadcastMobEquipment();
    }

    public function broadcastMobEquipment(array $players = []) : int{
        if(count($players) === 0){
            $players = $this->holder->getViewers() + [$this->holder]; // viewers dont have himself
        }
        $pk = new MobEquipmentPacket();
        $pk->item = ItemStackWrapper::legacy($this->getItemInOffhand());
        $pk->inventorySlot = $pk->hotbarSlot = 0;
        $pk->windowId = ContainerIds::OFFHAND;
        $pk->entityRuntimeId = $this->holder->getId();

        $this->holder->getServer()->broadcastPacket($players, $pk);
        return count($players);
    }
}