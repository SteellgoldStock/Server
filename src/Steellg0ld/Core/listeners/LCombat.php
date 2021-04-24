<?php

namespace Steellg0ld\Core\listeners;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\ItemIds;
use pocketmine\Server;
use Steellg0ld\Core\games\Combat;
use Steellg0ld\Core\Player;

class LCombat implements Listener{
    public function onInteract(PlayerInteractEvent $event){
        $player = $event->getPlayer();
        if(!$player instanceof Player) return;
        if(!$player->getGame() == Combat::IDENTIFIER) return;

        if($player->cooldown < time()){
            $player->cooldown = time() + 1;
            switch ($event->getItem()->getId()){
                case 1001:
                    // TODO: Ouvrir livre des sorts
                    break;
                case ItemIds::WOODEN_SWORD:
                case ItemIds::STONE_SWORD:
                case ItemIds::IRON_SWORD:
                case ItemIds::GOLDEN_SWORD:
                case ItemIds::DIAMOND_SWORD: // TODO: Netherite Sword
                break;
            }
        }
    }
}