<?php

namespace Steellg0ld\Core\data;

use Steellg0ld\Core\Player;
use Steellg0ld\Core\Plugin;

class SQL {
    public function getDatabase(): \SQLite3 {
        return new \SQLite3(Plugin::getInstance()->getDataFolder() . "Database.db");
    }

    public function init(){
        $this->getDatabase()->query("CREATE TABLE IF NOT EXISTS players (player TEXT, rank INT, xp INT)");
    }

    public function getPlayer($player): array {
        $data = array();
        $query = self::getDatabase()->query("SELECT * FROM players WHERE player = '$player'");
        while ($res = $query->fetchArray(1)){
            array_push($data,$res);
        }
        return $data[0];
    }

    public function update($whe, $col, $val)  {
        self::getDatabase()->query("UPDATE players SET '$col' = '$val'  WHERE player = '$whe'");
    }
}