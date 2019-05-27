<?php

/**

 * Created by PhpStorm.

 * User: paula

 * Date: 25.05.2019

 * Time: 21:19

 */

namespace SoartexHD;

use pocketmine\command\Command;

use pocketmine\command\CommandSender;

use pocketmine\event\Listener;

use pocketmine\level\Position;

use pocketmine\Player;

use pocketmine\plugin\PluginBase;

use pocketmine\utils\Config;

class hub extends PluginBase implements Listener

{

    public $prefix = "§8| §bHUB §7> ";

    public function onEnable(){

        $this->getServer()->getPluginManager()->registerEvents($this, $this);

        $this->getLogger()->info("§7> §aAktiviert...");

        if(!file_exists($this->getDataFolder() . "config.yml")){

            $cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML);

            $cfg->set("Spawn", "");

            $cfg->save();

        }

    }

    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {

        if($sender instanceof Player){

            if($cmd->getName() == "sethub"){

                if($sender->isOp() OR $sender->hasPermission("hub.setspawn.use")){

                    $x = $sender->getX();

                    $y = $sender->getY();

                    $z = $sender->getZ();

                    $pitch = $sender->getPitch();

                    $yaw = $sender->getYaw();

                    $cfg = new Config($this->getDataFolder() . "config.yml");

                    $cfg->set("Spawn", array(

                        "X" => $x,

                        "Y" => $y,

                        "Z" => $z,

                        "PITCH" => $pitch,

                        "YAW" => $yaw));

                    $cfg->save();

                    $sender->sendMessage($this->prefix . "§aDu hast erfolgreich den Spawn gesetzt!");

                }

            }

            if($cmd->getName() == "hub"){

                $sender->addTitle("§7> §bLobby", "", 20, 20);

                $cfg = new Config($this->getDataFolder() . "config.yml");

                $sender->teleport(new Position($cfg->get("Spawn")["X"], $cfg->get("Spawn")["Y"], $cfg->get("Spawn")["Z"], $this->getServer()->getLevelByName("Spawn")), $cfg->get("Spawn")["YAW"], $cfg->get("Spawn")["PITCH"]);

            }

        }

        return true;

    }

}
