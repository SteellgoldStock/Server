<?php

namespace Steellg0ld\Core\listeners;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\Server;
use Steellg0ld\Core\games\Combat;
use Steellg0ld\Core\managers\Ranks;
use Steellg0ld\Core\managers\Spells;
use Steellg0ld\Core\Player;
use Steellg0ld\Core\Plugin;

class LCombat implements Listener{
    public function onRespawn(PlayerRespawnEvent $event){
        $player = $event->getPlayer();
        if($player instanceof Player){
            switch ($player->game){
                case Combat::IDENTIFIER:
                    $player->teleportTo("combat");
                    break;

            }
        }
    }

    /**
    public function playerShoot(EntityShootBowEvent $ev){
        $arrow = $ev->getProjectile();

        if ($arrow !== null and $arrow::NETWORK_ID == Entity::ARROW){
            $ev->setForce($ev->getForce() + SQLData::getServerData("shootArrowDamage"));
        }
    }
     **/

    public function onDeath(EntityDamageByEntityEvent $event){
        $damager = $event->getDamager();
        $victim = $event->getEntity();
        $spells = new Spells();

        if($damager instanceof Player AND $victim instanceof Player){
            if($victim->protego == true) {
                $spells->Protecto($damager, $victim);
            }

            if($damager->spell_applied === null) return;

            if(!$damager->isSneaking()) return;
            if($damager->cooldown_spell < time()) {
                $damager->cooldown_spell = time() + 1;

                if($damager->mana >= Spells::SPELLS[$damager->spell_applied]["mana_cost"]){
                    switch ($damager->spell_applied){
                        case 0:
                            $damager->mana = $damager->mana - Spells::SPELLS[0]["mana_cost"];
                            $victim->getInventory()->setItemInHand($spells->Reducto($victim->getInventory()->getItemInHand()));
                            $damager->sendPopup(Plugin::PREFIX . Plugin::SECOND_COLOR . " Reducto " . Plugin::PREFIX);
                            break;
                        case 1:
                            $damager->mana = $damager->mana - Spells::SPELLS[1]["mana_cost"];
                            $victim->setOnFire(30);
                            $damager->sendPopup(Plugin::PREFIX . Plugin::SECOND_COLOR . " Incendio " . Plugin::PREFIX);
                            break;
                        case 2:
                            $damager->mana = $damager->mana - Spells::SPELLS[2]["mana_cost"];
                            $victim->addEffect(new EffectInstance(Effect::getEffect(Effect::SLOWNESS),20 * 2,10,true));
                            $damager->sendPopup(Plugin::PREFIX . Plugin::SECOND_COLOR . " Immobilis " . Plugin::PREFIX);
                            break;
                    }
                }else{
                    $damager->sendPopup(Plugin::PREFIX_ERROR . Plugin::SECOND_COLOR . " Vous n'avez pas assez de mana, vous avez besoin de §b" . (Spells::SPELLS[$damager->spell_applied]["mana_cost"] - $damager->mana) . " manas §fsupplémentaires" . Plugin::PREFIX_ERROR);
                }
            }else{
                $damager->sendPopup(Plugin::PREFIX_ERROR . Plugin::SECOND_COLOR . " Votre sort se recharge, veuillez attendre " . Plugin::ERROR_COLOR . ($damager->cooldown_spell - time()) . Plugin::SECOND_COLOR . " secondes " . Plugin::PREFIX_ERROR);
            }
        }

        $victim->getPlayer()->getOffhandInventory()->clearAll();
        Plugin::getInstance()->getSQL()->update("players", $damager->getName(), "xp",($damager->getStats()["xp"] + mt_rand(1,10)));
    }


    public function onQuit(PlayerQuitEvent $event) {
        $player = $event->getPlayer();
        if(!$player instanceof Player) return;
        if($player->game !== "NONE"){
            switch ($player->game){
                case "COMBAT":
                    Plugin::getInstance()->getGame(Combat::IDENTIFIER)->delPlayer($player);
                    break;
            }
        }
    }

    /**
     * @param PlayerChatEvent $event
     */
    public function onChat(PlayerChatEvent $event){
        $player = $event->getPlayer();
        if(!$player instanceof Player) return;
        $message = $event->getMessage();
        $event->setCancelled();

        if($player->game !== "NONE") {
            Server::getInstance()->broadcastMessage(str_replace(array("{PRIMARY}", "{NAME}", "{SECONDARY}", "{KILLS}", "{MESSAGE}"), array(Ranks::COLORS[$player->getStats()["rank"]]["PRIMARY"], $player->getName(), Ranks::COLORS[$player->getStats()["rank"]]["SECONDARY"], 0, $message), Ranks::GAMES[$player->game]));
        }
    }
}