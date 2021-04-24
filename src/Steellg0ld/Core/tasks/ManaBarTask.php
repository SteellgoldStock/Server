<?php

namespace Steellg0ld\Core\tasks;

use pocketmine\scheduler\Task;
use pocketmine\Server;
use Steellg0ld\Core\Player;
use Steellg0ld\Core\Plugin;

class ManaBarTask extends Task{

    public $player;

    public function __construct(Player $player){
        $this->player = $player;
    }

    public function onRun(int $currentTick){
        if($this->player->getLevel() !== Server::getInstance()->getLevelByName("world") OR $this->player->game == "NONE"){
            Plugin::getInstance()->getScheduler()->cancelTask($this->getTaskId());
        }

        if($this->player->mana >= 100){
            $timeG = 10;
            $timeR = 0;
        }elseif($this->player->mana >= 90){
            $timeG = 9;
            $timeR = 1;
        }elseif($this->player->mana >= 80){
            $timeG = 8;
            $timeR = 2;
        }elseif($this->player->mana >= 70){
            $timeG = 7;
            $timeR = 3;
        }elseif($this->player->mana >= 60){
            $timeG = 6;
            $timeR = 4;
        }elseif($this->player->mana >= 50){
            $timeG = 5;
            $timeR = 5;
        }elseif($this->player->mana >= 40){
            $timeG = 4;
            $timeR = 6;
        }elseif($this->player->mana >= 30){
            $timeG = 3;
            $timeR = 7;
        }elseif($this->player->mana >= 20){
            $timeG = 2;
            $timeR = 8;
        }elseif($this->player->mana >= 10){
            $timeG = 1;
            $timeR = 9;
        }else{
            $timeG = 0;
            $timeR = 10;
        }

        $this->player->sendTip(str_repeat("§a⬛", $timeG) . str_repeat("§c⬛", $timeR));
    }
}