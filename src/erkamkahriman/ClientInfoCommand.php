<?php

namespace erkamkahriman;

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
                        $sender->sendMessage(C::YELLOW . "Language: " . C::WHITE . $this->getLanguage($spieler));
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

    public function getLanguage(Player $player){
        switch ($player->getLocale()){
            case "af_ZA":
                return "Afrikaans";
            case "ar_SA":
                return "Arabic";
            case "ast_ES":
                return "Asturian";
            case "az_AZ":
                return "Azerbaijani";
            case "be_BY":
                return "Belarusian";
            case "bg_BG":
                return "Bulgarian";
            case "br_FR":
                return "Breton";
            case "ca_ES":
                return "Catalan";
            case "cs_CZ":
                return "Czech";
            case "cy_GB":
                return "Welsh";
            case "da_DK":
                return "Danish";
            case "de_AT":
                return "Austrian German";
            case "de_DE":
                return "German";
            case "el_GR":
                return "Greek";
            case "en_AU":
                return "Australian English";
            case "en_CA":
                return "Canadian English";
            case "en_GB":
                return "British English";
            case "en_NZ":
                return "New Zealand English";
            case "en_UD":
                return "British English (upside down)";
            case "en_7S":
                return "Pirate English";
            case "en_US":
                return "American English";
            case "eo_UY":
                return "Esperanto";
            case "es_AR":
                return "Argentinian Spanish";
            case "es_ES":
                return "Spanish";
            case "es_MX":
                return "Mexican Spanish";
            case "es_UY":
                return "Uruguayan Spanish";
            case "es_VE":
                return "Venezuelan Spanish";
            case "et_EE":
                return "Estonian";
            case "eu_ES":
                return "Basque";
            case "fa_IR":
                return "Persian";
            case "fi_FI":
                return "Finnish";
            case "fil_PH":
                return "Filipino";
            case "fo_FO":
                return "Faroese";
            case "fr_FR":
                return "French";
            case "fr_CA":
                return "Canadian French";
                //TODO More Languages
            default:
                return "Unknown";
        }
    }
}
