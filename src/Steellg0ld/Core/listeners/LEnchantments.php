<?php

namespace Steellg0ld\Core\listeners;

use pocketmine\entity\Living;
use pocketmine\entity\projectile\Arrow;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use Steellg0ld\Core\games\Combat;
use Steellg0ld\Core\Player;

class LEnchantments implements Listener
{
    /**
     * @param EntityDamageByEntityEvent $event
     */
    public function onDamage(EntityDamageByEntityEvent $event) {
        $damager = $event->getDamager();
        $victim = $event->getEntity();

        if ($damager instanceof Player && $victim instanceof Player) {
            if ($damager->getInventory()->getItemInHand()->hasEnchantment(100)) {
                if (!$damager->game == Combat::IDENTIFIER) return;
                if (mt_rand(0, 3) == 2) {
                    if ($damager->mana !== 100) {
                        $mana = mt_rand(0, 30);
                        if ($victim->mana >= $mana) {
                            $damager->mana = $damager->mana + $mana;
                            $victim->mana = $victim->mana - $mana;
                        }
                    }
                }
            }
        }
    }

    /**
     * @param EntityDamageEvent $ev
     */
    public function onEntityDamage(EntityDamageEvent $ev) {
        if (($dm = $ev->getDamager()) instanceof Arrow && ($p = $ev->getEntity()) instanceof Player) {
            /** @var $dm Living */
            $dm = $dm->shootingEntity;
            var_dump($dm);
        }
    }
}