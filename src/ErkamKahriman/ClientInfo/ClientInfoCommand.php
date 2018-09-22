<?php

namespace ErkamKahriman\ClientInfo;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\network\mcpe\protocol\types\CommandParameter;
use pocketmine\Player;
use pocketmine\utils\TextFormat as C;

class ClientInfoCommand extends PluginCommand {

    const CINFO = C::GRAY."=> ".C::BLUE . "Client Info" .C::GRAY. " <=" .C::RESET;

    public function __construct(ClientInfo $plugin){
        parent::__construct("clientinfo", $plugin);
        $this->setPermission("clientinfo");
        $this->setDescription("Get Informations about a Client.");
        if(ClientInfo::getInstance()->getServer()->getName() == "Altay"){
            $this->setParameter(new CommandParameter("player", CommandParameter::ARG_TYPE_TARGET, false), 0);
        }
        $this->setAliases(["cinfo"]);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if($sender->hasPermission("clientinfo")){
            if(!empty($args[0]) && isset($args[0])){
                $spieler = ClientInfo::getInstance()->getServer()->getPlayer($args[0]);
                if($spieler != null){
                    $sender->sendMessage(self::CINFO);
                    $sender->sendMessage(C::YELLOW."Username: ".C::WHITE.$spieler->getName());
                    $sender->sendMessage(C::YELLOW."NameTag: ".C::RESET.$spieler->getNameTag());
                    $sender->sendMessage(C::YELLOW."DeviceOS: ".C::WHITE.$this->getOS($spieler));
                    $sender->sendMessage(C::YELLOW."DeviceModel: ".C::WHITE.$spieler->getDeviceModel());
                    $sender->sendMessage(C::YELLOW."Language: ".C::WHITE.$spieler->getLocale());
                    $sender->sendMessage(C::YELLOW."IP: ".C::WHITE.$spieler->getAddress());
                } else{
                    $sender->sendMessage("§cPlayer couldn't be found.");
                }
            } else{
                $sender->sendMessage("§eYou need to specify a player.");
            }
        } else{
            $sender->sendMessage("§cYou don't have permissions to do that.");
        }
    }

    public function getOS(Player $player){
        switch ($player->getDeviceOS()){
            case Player::OS_ANDROID:
                return "Android";
            case Player::OS_IOS:
                return "IOS";
            case Player::OS_MAC:
                return "Mac";
            case Player::OS_FIREOS:
                return "FireOS";
            case Player::OS_WINDOWS:
                return "Windows";
            case Player::OS_DEDICATED:
                return "Dedicated";
            default:
                return "Unknown";
        }
    }
}
