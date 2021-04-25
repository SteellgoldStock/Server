<?php

namespace Steellg0ld\Core\listeners;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerCreationEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\item\Item;
use pocketmine\Server;
use Steellg0ld\Core\forms\NaviguateUI;
use Steellg0ld\Core\forms\SpellsBookUI;
use Steellg0ld\Core\games\Combat;
use Steellg0ld\Core\Player;
use Steellg0ld\Core\Plugin;

class LPlayers implements Listener{
    /**
     * @param PlayerCreationEvent $event
     * Attribution de la classe personnalisé au joueur
     */
    public function onCreate(PlayerCreationEvent $event){
        $event->setPlayerClass(Player::class);
    }

    /**
     * @param PlayerJoinEvent $event
     * Evenements lors ce que le joueur ce connecte
     */
    public function onJoin(PlayerJoinEvent $event){
        $player = $event->getPlayer();
        if(!$player instanceof Player) return;

        if(!$player->hasPlayedBefore()){
            $player->dataCreation();
            Server::getInstance()->broadcastMessage(Plugin::PREFIX . Plugin::SECOND_COLOR . " " . $player->getName() . " c'est connecté(e) pour la première fois !");
        }

        $player->cooldown_spell = time();
        $player->cooldown = time();
        $player->teleport(Plugin::getSpawn());
        $player->getInventory()->setContents([]);
        $player->getInventory()->setItem(4,Item::get(345)); // TODO: Item custom :)
    }

    /**
     * @param PlayerItemHeldEvent $event
     * Annuler les déplacements d'items dans l'inventaire lors ce qu'il est au spawn
     */
    public function onHeld(PlayerItemHeldEvent $event){
        $player = $event->getPlayer();
        if(!$player instanceof Player) return;
        if(!$player->getLevel() === Server::getInstance()->getLevelByName("world")) return;
    }

    /**
     * @param PlayerInteractEvent $event
     * Intéraction avec les items de la barre d'inventaire
     */
    public function onInteract(PlayerInteractEvent $event){
        $player = $event->getPlayer();
        if(!$player instanceof Player) return;
        if(!$player->getLevel() === Server::getInstance()->getLevelByName("world")) return;

        if($player->cooldown < time()){
            $player->cooldown = time() + 1;

            switch ($event->getItem()->getId()){
                case Item::COMPASS:
                    NaviguateUI::openCompassUI($player);
                    break;
                case 1001:
                    if($player->getGame() !== Combat::IDENTIFIER) return;
                    SpellsBookUI::openBook($player);
                    break;
            }
        }
    }
}