<?php

namespace Steellg0ld\Core\packets;

use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketSendEvent;
use pocketmine\network\mcpe\protocol\AddPlayerPacket;
use Steellg0ld\Core\Player;

class DataPacketSends implements Listener{
    public function onDataPacketSend(DataPacketSendEvent $event) : void{
        $packet = $event->getPacket();
        $player = $event->getPlayer();
        if(!$player instanceof Player) return;

        if($packet instanceof AddPlayerPacket){
            $inv = $player->getOffhandInventory();
            $inv->broadcastMobEquipment();
        }
    }
}