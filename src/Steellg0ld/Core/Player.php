<?php

namespace Steellg0ld\Core;

use pocketmine\entity\Entity;
use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\network\mcpe\protocol\types\ContainerIds;
use pocketmine\Server;
use pocketmine\utils\Config;
use Steellg0ld\Core\inventory\PlayerOffhandInventory;

class Player extends \pocketmine\Player {

    /** @var PlayerOffhandInventory[] */
    protected array $inventories = [];

    public int $cooldown = 0;
    public int $cooldown_spell = 0;

    public string $game = "NONE";
    public array $game_stats = [];
    public $spell_applied = null;
    public int $mana = 100;
    public bool $protego = false;

    public function getStats(): array{
        return Plugin::getInstance()->getSQL()->getPlayer($this->getName());
    }

    public function getSettings(): array{
        return Plugin::getInstance()->getSQL()->getSettings($this->getName());
    }

    public function getGame(): String {
        return $this->game;
    }

    public function setGame(String $identifier) {
        $this->game = $identifier;
    }

    public function dataCreation(){
        Plugin::getInstance()->getSQL()->getDatabase()->query("INSERT INTO players VALUES ('".$this->getName()."', 0,0)");
        Plugin::getInstance()->getSQL()->getDatabase()->query("INSERT INTO players_settings VALUES ('".$this->getName()."',0,0,1,0,0,0,1,0,0,0,1)");
    }

    public function getLevelByXP(Int $xp){
        if($xp < 500) return 0;
        return round($xp / 500);
    }

    public function getOffhandInventory() : PlayerOffhandInventory {
        if(isset($this->inventories[$this->getRawUniqueId()])){
            return $this->inventories[$this->getRawUniqueId()];
        }
        $inv = new PlayerOffhandInventory($this);
        if($this->namedtag->hasTag("offhand", CompoundTag::class)){
            $inv->setItemInOffhand(Item::nbtDeserialize($this->namedtag->getCompoundTag("offhand")));
        }
        $this->addWindow($inv, ContainerIds::OFFHAND, true);
        $this->getDataPropertyManager()->setByte(Entity::DATA_COLOR, 0);
        return $this->inventories[$this->getRawUniqueId()] = $inv;
    }

    public function teleportTo(String $world) {
        $config = Plugin::getInstance()->getConfigFile("Spawns")->get($world);
        $this->teleport(new Position($config["x"], $config["y"], $config["z"], Server::getInstance()->getLevelByName($config["world"])));
    }

    public function isAllowed(Int ...$ranks): bool{
        if(in_array($this->getStats()["rank"],$ranks)){
            return true;
        }else{
            return false;
        }
    }
}