<?php

namespace ErkamKahriman\ClientInfo;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat as C;

class ClientInfoCommand extends PluginCommand {

    public $plugin;

    const CINFO = C::GRAY."=> ".C::BLUE . "Client Info" .C::GRAY. " <=" .C::RESET;
    const USAGE = C::WHITE . "- /cinfo (player)";
    const NOPREM = C::RED . "You don't have permissions to do that.";
    const PLAYERNOTON = C::RED . "Player is not Online!";
    const PLAYERNOTEXIST = C::RED . "Player doesn't exists!";

    public function __construct(string $name, ClientInfo $plugin){
        $this->plugin = $plugin;
        parent::__construct($name, $plugin);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if ($sender->hasPermission("cinfo.use")) {
            if (!empty($args[0])) {
                if (file_exists(Server::getInstance()->getDataPath() . "players/" . strtolower($args[0]) . ".dat")) {
                    $spieler = $this->plugin->getServer()->getPlayer(strtolower($args[0]));
                    if ($spieler->isOnline()) {
                        $sender->sendMessage(self::CINFO);
                        $sender->sendMessage(C::YELLOW . "Username: " . C::WHITE . $spieler->getName());
                        $sender->sendMessage(C::YELLOW . "NameTag: " . C::RESET . $spieler->getNameTag());
                        $sender->sendMessage(C::YELLOW . "SystemOS: " . C::WHITE . $this->getOS($spieler));
                        $sender->sendMessage(C::YELLOW . "Device: " . C::WHITE . $spieler->getDeviceModel());
                        $sender->sendMessage(C::YELLOW . "Language: " . C::WHITE . $spieler->getLocale());
                        $sender->sendMessage(C::YELLOW . "IP: " . C::WHITE . $spieler->getAddress());
                    } else {
                        $sender->sendMessage(self::PLAYERNOTON);
                    }
                } else {
                    $sender->sendMessage(self::PLAYERNOTEXIST);
                }
            } else {
                $sender->sendMessage(self::USAGE);
            }
        } else {
            $sender->sendMessage(self::USAGE);
        }
    }

    public function getOS(Player $player){
        switch ($player->getDeviceOS()){
            case 1:
                return "Android";
            case 2:
                return "IOS";
            case 3:
                return "Mac";
            case 4:
                return "FireOS";
            case 7:
                return "Windows";
            default:
                return "Unknown";
        }
    }
}
