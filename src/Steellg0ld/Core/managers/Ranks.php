<?php

namespace Steellg0ld\Core\managers;

class Ranks{
    const RANKS = [
        0 => "§f[§7Joueur§f] §f{NAME} §7§l» §r{MESSAGE}", // PLAYER
        1 => "§f[§gPremium§f] §g{NAME} §g§l» §r{MESSAGE}", // PREMIUM
        2 => "§f[§4YouTube§f] §4{NAME} §4§l» §r{MESSAGE}", // YOUTUBE
        3 => "§f[§5Streamer§f] §5{NAME} §5§l» §r{MESSAGE}", // STREAMER
        4 => "§f[§cStaff§f] §c{NAME} §c§l» §r{MESSAGE}", // STAFF
    ];

    const COLORS = [
        0 => [
            "PRIMARY" => "§7",
            "SECONDARY" => "§f"
        ],
        1 => [
            "PRIMARY" => "§g",
            "SECONDARY" => "§f"
        ],
        2 => [
            "PRIMARY" => "§4",
            "SECONDARY" => "§f"
        ],
        3 => [
            "PRIMARY" => "§d",
            "SECONDARY" => "§f"
        ],
        4 => [
            "PRIMARY" => "§c",
            "SECONDARY" => "§f"
        ],
    ];

    CONST GAMES = [
        "COMBAT" => "{PRIMARY}{NAME} {SECONDARY}[{PRIMARY}{KILLS}kD{SECONDARY}] §l{PRIMARY}» §r{SECONDARY}{MESSAGE}"
    ];
}