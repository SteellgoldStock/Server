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
                        // TODO: Settings for Premium/YT/Streamer rank
                        Plugin::getInstance()->getSQL()->update("players_settings", $p->getName(), "os", $data[1]);
                        Plugin::getInstance()->getSQL()->update("players_settings", $p->getName(), "receive_messages", $data[2]);
                        Plugin::getInstance()->getSQL()->update("players_settings", $p->getName(), "reconnect", $data[3]);
                        Plugin::getInstance()->getSQL()->update("players_settings", $p->getName(), "cps", $data[4]);
                        Plugin::getInstance()->getSQL()->update("players_settings", $p->getName(), "ping", $data[5]);
                        Plugin::getInstance()->getSQL()->update("players_settings", $p->getName(), "username", $data[6]);
                        Plugin::getInstance()->getSQL()->update("players_settings", $p->getName(), "size", $data[7]);
                        // TODO: Change skin
                        Plugin::getInstance()->getSQL()->update("players_settings", $p->getName(), "particles", $data[8]);
                        Plugin::getInstance()->getSQL()->update("players_settings", $p->getName(), "custom_os", $data[9]);
                        Plugin::getInstance()->getSQL()->update("players_settings", $p->getName(), "pet", $data[10]);
                    }
                }
            );

            $form->setTitle("- PRACTICE -");
            $form->addLabel(Plugin::PREFIX . Plugin::SECOND_COLOR . " Bienvenu(e) sur " . Plugin::BASE_COLOR . Plugin::SERVER_NAME . Plugin::SECOND_COLOR . ", voici les paramètres disponibles sur cette interface\n"); // 0
            $form->addToggle("Show your OS"); // 1
            $form->addToggle("Can receive private messages"); // 2
            $form->addToggle("Auto reconnect when server restart", $player->getSettings()["reconnect"]); // 3
            $form->addToggle("Show CPS"); // 4
            $form->addToggle("Show Ping"); // 5
            $form->addInput("Custom username"); // 6
            $form->addSlider("Custom size", 0.5, 2); // 7
            $form->addSlider("Particules", 0, 3); // 8
            $form->addDropdown("Custom OS", ["Windows", "Android"]); // 9
            $form->addDropdown("Choose pet", ["Cat", "Dog", "Squid", "Ghast", "Wither", "Skeleton", "Zombie", "Money"]); // 10
            $player->sendForm($form);
        }
    }
}