<?php

namespace Steellg0ld\Core\listeners;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\level\Position;
use pocketmine\math\Vector3;
use Steellg0ld\Core\managers\Spells;
use Steellg0ld\Core\Player;
use Steellg0ld\Core\Plugin;

class LCombat implements Listener{
    /**
     * @param EntityDamageByEntityEvent $event
     */
    public function onDamage(EntityDamageByEntityEvent $event){
        $damager = $event->getDamager();
        $victim = $event->getEntity();
        $spells = new Spells();

        if($damager instanceof Player AND $victim instanceof Player){
            if($victim->protego == true) {
                $spells->Protecto($damager, $victim);
            }

            switch ($damager->spell_applied){
                case 0:
                    $spells->Reducto($victim->getInventory()->getItemInHand());
                    break;
            }
        }
    }

    /**
     * @param PlayerDeathEvent $event
     */
    public function onDeath(PlayerDeathEvent $event) {
        $cause = $event->getEntity()->getLastDamageCause();
        if ($cause instanceof EntityDamageByEntityEvent) {
            $killer = $cause->getDamager();
            $victim = $event->getPlayer();
            if($killer instanceof Player AND $victim instanceof Player){
                Plugin::getInstance()->getSQL()->update($killer->getName(), "xp",($killer->getStats()["xp"] + mt_rand(1,10)));
            }
        }
    }
}