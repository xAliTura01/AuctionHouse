<?php
declare(strict_types=1);

namespace shock95x\auctionhouse\commands\subcommand;

use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\constraint\InGameRequiredConstraint;
use CortexPE\Commando\exception\ArgumentOrderException;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use shock95x\auctionhouse\commands\arguments\PlayerArgument;
use shock95x\auctionhouse\database\DataHolder;
use shock95x\auctionhouse\menu\ListingsMenu;
use shock95x\auctionhouse\menu\player\PlayerListingMenu;
use shock95x\auctionhouse\utils\Locale;

class ListingsCommand extends BaseSubCommand {

	/**
	 * @throws ArgumentOrderException
	 */
	protected function prepare(): void {
		$this->setPermission("auctionhouse.command.listings");
		$this->registerArgument(0, new PlayerArgument("player", true));
		$this->addConstraint(new InGameRequiredConstraint($this));
	}

	public function onRun(CommandSender $sender, string $aliasUsed, array $args): void {
		assert($sender instanceof Player);
		if(!isset($args["player"])) {
			new ListingsMenu($sender, false);
			return;
		}
		$player = strtolower($args["player"]);

		if(strtolower($sender->getName()) == $player) {
			Locale::sendMessage($sender, "player-listings-usage");
			return;
		}
		if(empty(DataHolder::getListingsByUsername($player))) {
			Locale::sendMessage($sender, "player-not-found");
			return;
		}
		new PlayerListingMenu($sender, $args["player"]);
	}
}