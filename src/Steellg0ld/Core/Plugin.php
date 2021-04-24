<?php

namespace Steellg0ld\Core;

use pocketmine\level\Position;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use Steellg0ld\Core\data\SQL;
use Steellg0ld\Core\games\Combat;
use Steellg0ld\Core\listeners\LPlayers;

class Plugin extends PluginBase {

    const PREFIX = "§e-";
    const BASE_COLOR = "§e";
    const SECOND_COLOR = "§f";
    const SERVER_NAME = "Arkanya";

    public static $instance;

    public function onEnable(){
        self::$instance = $this;

        $this->getSQL()->init();
        $this->getLogger()->critical("Database has been loaded");

        $this->getServer()->getPluginManager()->registerEvents(new LPlayers(), $this);
        $this->getLogger()->critical("Listeners loaded");
    }

    /**
     * @return SQL
     */
    public function getSQL(): SQL{
        return new SQL();
    }

    public static function getSpawn(): Position{
        return new Position(0,256,0,Server::getInstance()->getLevelByName("world"));
    }

    /**
     * @return mixed
     */
    public static function getInstance() : self {
        return self::$instance;
    }

    public function getGame(String $type) : Combat{
        switch ($type){
            case "COMBAT":
                return new Combat();
        }
    }
}
