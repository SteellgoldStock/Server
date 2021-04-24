<?php

namespace Steellg0ld\Core\games;

use Steellg0ld\Core\Player;
use Steellg0ld\Core\Plugin;

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
        $player->setGame("COMBAT");
    }

    public function getPlayers(): array{
        return $this->players;
    }

    public function delPlayer(Player $player){
        unset($this->players[array_search($player->getName(),$this->players)]);
        $player->setGame("NONE");
    }
}