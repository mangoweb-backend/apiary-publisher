<?php

namespace Mangoweb\ApiaryPublisher\Bridges\SymfonyConsole;

use Mangoweb\ApiaryPublisher\ApiaryPublisher;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class ApiaryPublishCommand extends Command
{

	/**
	 * @return void
	 */
	protected function configure()
	{
		$this->setName('apiary:publish');
		$this->setDescription('Publishes Blueprint to Apiary');
		$this->addOption('name', NULL, InputOption::VALUE_REQUIRED, 'API name (e.g. \'pollsapi\' for docs.pollsapi.apiary.io)');
		$this->addOption('token', NULL, InputOption::VALUE_REQUIRED, 'API token (see https://login.apiary.io/tokens)');
		$this->addArgument('path', InputArgument::REQUIRED, 'path to blueprint');
	}


	/**
	 * @param  InputInterface  $input
	 * @param  OutputInterface $output
	 * @return void
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		if (!$input->getOption('name')) {
			$output->writeln("Option <name> is required.");
			exit(1);
		}

		if (!$input->getOption('token')) {
			$output->writeln("Option <token> is required.");
			exit(1);
		}

		$path = $input->getArgument('path');
		$code = @file_get_contents($path);
		if ($code === FALSE) {
			$detail = error_get_last()['message'];
			$output->writeln("Failed to load file '$path' ($detail)");
			exit(2);
		}

		$publisher = new ApiaryPublisher($input->getOption('name'), $input->getOption('token'));
		$publisher->publish($code);
	}

}
