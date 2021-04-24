<?php

namespace Steellg0ld\Core\listeners;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerMoveEvent;
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
                $victim->protego = false;
                $victim->sendTip(Plugin::PREFIX . " Votre protection à été détruite, car un utilisateur de sort à essayé d'en éxécuté un sur vous");
                $damager->sendTip($victim->getName() . " était protégé(e), vous n'avez donc pas pu utiliser votre sort sur cette personne");
                $damager->setMotion(new Vector3(5, 0, 5));
            }

            switch($damager->spell_applied) {
                case 1:
                    $victim->getInventory()->setItemInHand($spells->Reducto($victim->getInventory()->getItemInHand()));
                    $damager->sendTip(Plugin::PREFIX . Plugin::SECOND_COLOR . " Reducto " . Plugin::PREFIX);
                    break;
                case 2:
                    $victim->setOnFire(30);
                    $damager->sendTip(Plugin::PREFIX . Plugin::SECOND_COLOR . " Incendio " . Plugin::PREFIX);
                    break;
                case 3:
                    $damager->sendTip(Plugin::PREFIX . Plugin::SECOND_COLOR . " Protego " . Plugin::PREFIX);
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