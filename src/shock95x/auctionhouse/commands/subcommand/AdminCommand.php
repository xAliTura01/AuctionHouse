<?php
declare(strict_types=1);

namespace shock95x\auctionhouse\commands\subcommand;

use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\constraint\InGameRequiredConstraint;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use shock95x\auctionhouse\menu\admin\AdminMenu;

class AdminCommand extends BaseSubCommand {

	protected function prepare(): void {
		$this->setPermission("auctionhouse.command.admin");
		$this->addConstraint(new InGameRequiredConstraint($this));
	}

	public function onRun(CommandSender $sender, string $aliasUsed, array $args): void {
		assert($sender instanceof Player);
		new AdminMenu($sender, false);
	}
}