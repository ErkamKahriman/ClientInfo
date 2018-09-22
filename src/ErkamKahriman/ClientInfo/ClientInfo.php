<?php

namespace ErkamKahriman\ClientInfo;

use pocketmine\plugin\PluginBase;

class ClientInfo extends PluginBase {

    /** @var ClientInfo $instance */
    public static $instance;

    public function onEnable(){
        self::$instance = $this;
        $this->getServer()->getCommandMap()->register("ClientInfo", new ClientInfoCommand($this));
    }

    public static function getInstance() : ClientInfo{
        return self::$instance;
    }
}