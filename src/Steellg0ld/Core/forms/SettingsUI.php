<?php

namespace Steellg0ld\Core\forms;

use jojoe77777\FormAPI\CustomForm;
use Steellg0ld\Core\Player;
use Steellg0ld\Core\Plugin;

class SettingsUI
{
    public static function openSettings(Player $player)
    {
        {
            $form = new CustomForm(
                function (Player $p, $data) {
                    if ($data === null) {
                    } else {
                        if ($data[3] == true){
                            Plugin::getInstance()->getSQL()->update("players_settings",$p->getName(),"reconnect",1);
                        }
                    }
                }
            );

            $form->setTitle("- PRACTICE -");
            $form->addLabel(Plugin::PREFIX . Plugin::SECOND_COLOR . " Bienvenu(e) sur " . Plugin::BASE_COLOR . Plugin::SERVER_NAME . Plugin::SECOND_COLOR . ", voici les paramètres disponibles sur cette interface\n");
            $form->addToggle("Show your OS");
            $form->addToggle("Can receive private messages");
            $form->addToggle("Auto reconnect when server restart");
            $form->addToggle("Show CPS");
            $form->addToggle("Show Ping");
            $form->addInput("Custom username");
            $form->addSlider("Custom size", 0.5, 2);
            $form->addSlider("Particules",0,3);
            $form->addDropdown("Custom OS", ["Windows", "Android"]);
            $form->addDropdown("Choose pet", ["Cat", "Dog", "Squid", "Ghast", "Wither", "Skeleton", "Zombie", "Money"]);
            $player->sendForm($form);
        }
    }
}