<?php

namespace Steellg0ld\Core;

class Player extends \pocketmine\Player {

    public string $cooldown = "0";
    public string $game = "NONE";
    public array $game_stats = [];
    public int $spell_applied = 0;

    public function getGame(): String {
        return $this->game;
    }

    public function setGame(String $identifier) {
        $this->game = $identifier;
    }

    public function dataCreation(){
        Plugin::getInstance()->getSQL()->getDatabase()->query("INSERT INTO players VALUES ('".$this->getName()."', 0)");
    }
}