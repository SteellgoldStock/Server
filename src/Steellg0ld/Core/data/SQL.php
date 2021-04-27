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
        $this->getDatabase()->query("CREATE TABLE IF NOT EXISTS players_settings (player TEXT, show_os INT, receive_messages INT, reconnect INT, cps INT, ping INT, username TEXT, size INT, particles INT, custom_os INT, pet INT, auto_respawn INT)");
    }

    public function getPlayer($player): array {
        $data = array();
        $query = self::getDatabase()->query("SELECT * FROM players WHERE player = '$player'");
        while ($res = $query->fetchArray(1)){
            array_push($data,$res);
        }
        return $data[0];
    }

    public function getSettings($player): array {
        $data = array();
        $query = self::getDatabase()->query("SELECT * FROM players_settings WHERE player = '$player'");
        while ($res = $query->fetchArray(1)){
            array_push($data,$res);
        }
        return $data[0];
    }

    public function update($dat, $whe, $col, $val)  {
        self::getDatabase()->query("UPDATE '$dat' SET '$col' = '$val'  WHERE player = '$whe'");
    }
}