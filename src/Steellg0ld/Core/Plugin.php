<?php

namespace Steellg0ld\Core;

use pocketmine\block\BlockFactory;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\Config;
use Steellg0ld\Core\blocks\EnchantmentTable;
use Steellg0ld\Core\data\SQL;
use Steellg0ld\Core\games\Combat;
use Steellg0ld\Core\listeners\LCombat;
use Steellg0ld\Core\listeners\LEnchantments;
use Steellg0ld\Core\listeners\LPlayers;
use Steellg0ld\Core\managers\Enchants;
use Steellg0ld\Core\packets\DataPacketReceives;
use Steellg0ld\Core\packets\DataPacketSends;

class Plugin extends PluginBase {

    const PREFIX = "§e-";
    const PREFIX_ERROR = "§c-";
    const BASE_COLOR = "§e";
    const SECOND_COLOR = "§f";
    const SERVER_NAME = "Arkanya";
    const MANA = "§b";
    const ERROR_COLOR = "§c";

    public static $instance;

    public function onEnable(){
        self::$instance = $this;

        $this->getEnchantments()->init();
        $this->getSQL()->init();
        $this->getLogger()->critical("Database has been loaded");

        $this->getServer()->getPluginManager()->registerEvents(new LPlayers(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new LCombat(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new LEnchantments(), $this);

        $this->getServer()->getPluginManager()->registerEvents(new DataPacketSends(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new DataPacketReceives(), $this);
        $this->getLogger()->critical("Listeners loaded");

        if(!file_exists($this->getDataFolder() . "Spawns.yml")){
            $this->saveResource("Spawns",true);
        }

        $this->getServer()->loadLevel("combat");

        // Disable the EnchantmentTable Inventory
        BlockFactory::registerBlock(new EnchantmentTable(),true);
        BlockFactory::init();
    }

    public function onDisable(){
        foreach (Server::getInstance()->getOnlinePlayers() as  $player){
            if($player instanceof Player){
                if($player->getSettings()["reconnect"] == 1){
                    $player->transfer("direct.justaven.xyz");
                }
            }
        }
    }

    /**
     * @param String $file
     * @return Config
     */
    public function getConfigFile(String $file): Config{
        return new Config($this->getDataFolder() . $file . ".yml",Config::YAML);
    }

    /**
     * @return SQL
     */
    public function getSQL(): SQL{
        return new SQL();
    }

    /**
     * @return Enchants
     */
    public function getEnchantments(): Enchants{
        return new Enchants();
    }

    /**
     * @return mixed
     */
    public static function getInstance() : Plugin {
        return self::$instance;
    }

    public function getGame(String $type) : Combat{
        switch ($type){
            case "COMBAT":
                return new Combat();
        }
    }
}
