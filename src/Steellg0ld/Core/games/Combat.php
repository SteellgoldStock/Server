<?php

namespace Steellg0ld\Core\games;

use pocketmine\item\Item;
use Steellg0ld\Core\Player;
use Steellg0ld\Core\Plugin;
use Steellg0ld\Core\tasks\ManaBarTask;

class Combat {

    const IDENTIFIER = "COMBAT";
    const NAME = "Magie & Combat";
    public array $players = [];

    public function __construct(){
        $this->players = [];
    }

    public function addPlayer(Player $player){
        array_push($this->players, $player->getName());
        $player->sendMessage(Plugin::PREFIX . Plugin::SECOND_COLOR . " Vous avez rejoint le mode de jeu: " . Plugin::BASE_COLOR . self::NAME . Plugin::SECOND_COLOR . " !");
        $player->setGame(self::IDENTIFIER);
        Plugin::getInstance()->getScheduler()->scheduleRepeatingTask(new ManaBarTask($player), 20);
        $player->mana = 100;
        $player->getArmorInventory()->setContents([]);
        $player->getInventory()->setContents([]);
        $this->gameInventory($player);
        $player->teleportTo("combat");
        $player->setScale(1);
    }

    public function getPlayers(): array{
        return $this->players;
    }

    public function delPlayer(Player $player){
        unset($this->players[array_search($player->getName(), $this->players)]);
        $player->setGame("NONE");
        $player->setScale($player->getSettings()["size"]);
    }

    public function gameInventory(Player $player){
        $player->getArmorInventory()->setHelmet(Item::get(Item::IRON_HELMET));
        $player->getArmorInventory()->setChestplate(Item::get(Item::DIAMOND_CHESTPLATE));
        $player->getArmorInventory()->setLeggings(Item::get(Item::IRON_LEGGINGS));
        $player->getArmorInventory()->setBoots(Item::get(Item::DIAMOND_BOOTS));

        $player->getInventory()->setItem(0, Item::get(Item::DIAMOND_SWORD));
        $player->getInventory()->setItem(1, Item::get(Item::GOLDEN_APPLE,0,16));
        $player->getInventory()->setItem(2, Item::get(Item::BOW));
        $player->getInventory()->setItem(3, Item::get(Item::ARROW,0,16));
        $player->getInventory()->setItem(8, Item::get(1001));
    }
}