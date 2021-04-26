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

        $timeG = floor($this->player->mana / 10);
        $timeR = 10 - $timeG;
        $this->player->sendTip(str_repeat(Plugin::MANA. "⬛", ($timeG <= 0 ? 0 : $timeG)) . str_repeat("§7⬛", ($timeR <= 0 ? 0 : $timeR)) . " §b(§7" . $this->player->mana . "§b)");
    }
}