<?php

namespace Steellg0ld\Core\Plugin;

use pocketmine\plugin\PluginBase;

class Plugin extends PluginBase {

    public static $instance;

    public function onEnable(){
        self::$instance = $this;
    }

    /**
     * @return mixed
     */
    public static function getInstance(): self{
        return self::$instance;
    }
}
