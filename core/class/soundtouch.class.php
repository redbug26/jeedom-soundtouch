<?php

/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

/* * ***************************Includes********************************* */
require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';
require_once dirname(__FILE__) . '/../../3rdparty/soundtouch.inc.php';

class soundtouch extends eqLogic {

	/*     * *************************Attributs****************************** */

	/*     * ***********************Methode static*************************** */

	/*
	 * Fonction exécutée automatiquement toutes les minutes par Jeedom
	public static function cron() {

	}
	 */

	/*
	 * Fonction exécutée automatiquement toutes les heures par Jeedom
	public static function cronHourly() {

	}
	 */

	/*
	 * Fonction exécutée automatiquement tous les jours par Jeedom
	public static function cronDayly() {

	}
	 */

	/*     * *********************Méthodes d'instance************************* */

	public function preInsert() {

	}

	public function postInsert() {

	}

	public function preSave() {

	}

	public function postSave() {

	}

	public function preUpdate() {

	}

	function addCommandVolume($icon = "", $visible = true) {

		$logicalId = "SET_VOLUME";

		$ZeebaseCmd = "";
		foreach ($this->getCmd() as $liste_cmd) {
			if ($liste_cmd->getLogicalId() == $logicalId) {
				$ZeebaseCmd = $liste_cmd;
				break;
			}
		}

		if (!is_object($ZeebaseCmd)) {
			$ZeebaseCmd = new soundtouchCmd();
			$ZeebaseCmd->setLogicalId($logicalId);

			$ZeebaseCmd->setName("Volume");
			$ZeebaseCmd->setType('action');
			$ZeebaseCmd->setSubType('slider');

			$ZeebaseCmd->setConfiguration('maxValue', 100);
			$ZeebaseCmd->setConfiguration('minValue', 0);

			$ZeebaseCmd->setUnite('%');

			$ZeebaseCmd->setOrder($this->cmd_order);

			$ZeebaseCmd->setEqLogic_id($this->getId());

			$ZeebaseCmd->setConfiguration('commandType', "volume");
			$ZeebaseCmd->setConfiguration('nparams', 1);

			$ZeebaseCmd->setIsVisible($visible ? 1 : 0);

			if ($icon != "") {
				$ZeebaseCmd->setDisplay('icon', '<i class="fa ' . $icon . '"></i>');
			}

			$ZeebaseCmd->save();
		}

		$this->cmd_order++;
	}

	function addCommandSay($icon = "", $visible = true) {

		$logicalId = "SAY";

		$ZeebaseCmd = "";
		foreach ($this->getCmd() as $liste_cmd) {
			if ($liste_cmd->getLogicalId() == $logicalId) {
				$ZeebaseCmd = $liste_cmd;
				break;
			}
		}

		if (!is_object($ZeebaseCmd)) {
			$ZeebaseCmd = new soundtouchCmd();
			$ZeebaseCmd->setLogicalId($logicalId);

			$ZeebaseCmd->setName("Say");
			$ZeebaseCmd->setType('action');
			$ZeebaseCmd->setSubType('other');

			$ZeebaseCmd->setOrder($this->cmd_order);

			$ZeebaseCmd->setEqLogic_id($this->getId());

			$ZeebaseCmd->setConfiguration('commandType', "say");
			$ZeebaseCmd->setConfiguration('nparams', 1);

			$ZeebaseCmd->setIsVisible($visible ? 1 : 0);

			if ($icon != "") {
				$ZeebaseCmd->setDisplay('icon', '<i class="fa ' . $icon . '"></i>');
			}

			$ZeebaseCmd->save();
		}

		$this->cmd_order++;
	}

	function addCommandKey($key, $name, $icon = "", $visible = true) {

		$logicalId = "KEY_" . $key;

		$ZeebaseCmd = "";
		foreach ($this->getCmd() as $liste_cmd) {
			if ($liste_cmd->getLogicalId() == $logicalId) {
				$ZeebaseCmd = $liste_cmd;
				break;
			}
		}

		if (!is_object($ZeebaseCmd)) {
			log::add('soundtouch', "debug", "cmd not found");

			$ZeebaseCmd = new soundtouchCmd();
			$ZeebaseCmd->setLogicalId($logicalId);

			log::add('soundtouch', "debug", "name: " . $name);
			log::add('soundtouch', "debug", "logicalId: " . $logicalId);

			$ZeebaseCmd->setName($name);
			$ZeebaseCmd->setType('action');
			$ZeebaseCmd->setSubType('other');

			$ZeebaseCmd->setOrder($this->cmd_order);

			$ZeebaseCmd->setEqLogic_id($this->getId());

			$ZeebaseCmd->setConfiguration('commandType', "key");
			$ZeebaseCmd->setConfiguration('commandName', $key);

			$ZeebaseCmd->setIsVisible($visible ? 1 : 0);

			if ($icon != "") {
				$ZeebaseCmd->setDisplay('icon', '<i class="fa ' . $icon . '"></i>');
			}

			$ZeebaseCmd->save();
		}

		$this->cmd_order++;
	}

	public function postUpdate() {

/*
PLAY
PAUSE
STOP
PREV_TRACK
NEXT_TRACK
THUMBS_UP
THUMBS_DOWN
BOOKMARK
POWER
MUTE
VOLUME_UP
VOLUME_DOWN
PRESET_1
PRESET_2
PRESET_3
PRESET_4
PRESET_5
PRESET_6
AUX_INPUT
SHUFFLE_OFF
SHUFFLE_ON
REPEAT_OFF
REPEAT_ONE
REPEAT_ALL
PLAY_PAUSE
ADD_FAVORITE
REMOVE_FAVORITE
INVALID_KEY
 */

		$this->cmd_order = 0;

		$this->addCommandKey("POWER", "power", "fa-power-off");
		$this->addCommandKey("AUX_INPUT", "aux");

		$this->addCommandKey("PRESET_1", "1");
		$this->addCommandKey("PRESET_2", "2");
		$this->addCommandKey("PRESET_3", "3");
		$this->addCommandKey("PRESET_4", "4");
		$this->addCommandKey("PRESET_5", "5");
		$this->addCommandKey("PRESET_6", "6");

		$this->addCommandKey("PLAY", "play", "fa-play");
		$this->addCommandKey("PAUSE", "pause", "fa-pause");
		//  $this->addCommandKey("PLAY_PAUSE","play");

		$this->addCommandKey("VOLUME_UP", "vol up", "");
		$this->addCommandKey("VOLUME_DOWN", "vol down", "");
		//  $this->addCommandKey("PLAY_PAUSE","play");

		$this->addCommandKey("PREV_TRACK", "prev track", "fa-fast-backward");
		$this->addCommandKey("NEXT_TRACK", "next track", "fa-fast-forward");

		$this->addCommandKey("ADD_FAVORITE", "add favorite", "fa-smile-o");
		$this->addCommandKey("REMOVE_FAVORITE", "remove favorite", "fa-frown-o");

		$this->addCommandVolume("", false);
		//	$this->addCommandSay("");

	}

	public function preRemove() {

	}

	public function postRemove() {

	}

	/*     * **********************Getteur Setteur*************************** */
}

class soundtouchCmd extends cmd {
	/*     * *************************Attributs****************************** */

	/*     * ***********************Methode static*************************** */

	/*     * *********************Methode d'instance************************* */

	/*
	 * Non obligatoire permet de demander de ne pas supprimer les commandes même si elles ne sont pas dans la nouvelle configuration de l'équipement envoyé en JS
	public function dontRemoveCmd() {
	return true;
	}
	 */

	public function execute($_options = array()) {
		$soundTouch = $this->getEqLogic();

//		log::add('soundtouch', "debug", print_r($_options, true));

		$soundTouch_ip = $soundTouch->getConfiguration('addr');

		$commandType = $this->getConfiguration('commandType');
		$commandName = $this->getConfiguration('commandName');
		$parameters = $this->getConfiguration('parameters');

//		log::add('soundtouch', "debug", "cmd: " . $commandType);

		if ($commandType == "key") {
			sendKeyCommand($soundTouch_ip, $commandName);

			return;
		}

		if ($commandType == "volume") {

			if ($_options["slider"] != "") {
				$volume = $_options["slider"];
			} else {
				$volume = $parameters; // entre 0 et 100
			}
			sendVolumeCommand($soundTouch_ip, $volume);

//			log::add('soundtouch', "debug", "set volume to " . $volume);

			return $volume;
		}

		if ($commandType == "say") {
			$text = $parameters;
			sendSayCommand($soundTouch_ip, $text);

			return;
		}

	}

	/*     * **********************Getteur Setteur*************************** */
}

?>
