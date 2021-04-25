<?php

namespace Steellg0ld\Core\packets;

use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\MobEquipmentPacket;
use pocketmine\network\mcpe\protocol\types\ContainerIds;
use pocketmine\Server;
use Steellg0ld\Core\Player;

class DataPacketReceives implements Listener{
    public function onDataPacketReceive(DataPacketReceiveEvent $event) : void{
        $player = $event->getPlayer();
        $packet = $event->getPacket();

        if(!$player instanceof Player) return;

        if($packet instanceof MobEquipmentPacket){
            if($packet->windowId === ContainerIds::OFFHAND){
                $event->setCancelled();
                if($packet->entityRuntimeId === $player->getId()){
                    $inv = $player->getOffhandInventory();
                    if(!$inv->getItem($packet->hotbarSlot)->equalsExact($packet->item->getItemStack())){
                        Server::getInstance()->getLogger()->debug("Tried to equip {$packet->item->getItemStack()} to {$player->getName()}, but have {$inv->getItem($packet->hotbarSlot)} in target slot");
                        return;
                    }
                    $inv->setItemInOffhand($packet->item->getItemStack());
                }
            }
        }
    }
}