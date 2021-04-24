<?php

namespace Steellg0ld\Core\data;

use Steellg0ld\Core\Plugin;

class SQL {
    public function getDatabase(): \SQLite3 {
        return new \SQLite3(Plugin::getInstance()->getDataFolder() . "Database.db");
    }

    public function init(){
        $this->getDatabase()->query("CREATE TABLE IF NOT EXISTS players (player VARCHAR(255) PRIMARY KEY, rank INT)");
    }

    public function getPlayer(): array {
        $data = array();
        while ($res = self::getDatabase()->query("SELECT * FROM players")->fetchArray(1)){
            array_push($data,$res);
        }
        return $data[0];
    }
}