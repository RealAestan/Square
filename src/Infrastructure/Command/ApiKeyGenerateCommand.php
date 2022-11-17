<?php

namespace App\Infrastructure\Command;

use App\Infrastructure\Security\ApiKey\Repository\ApiKeyRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:api-key:generate',
    description: 'This command generates a new api key and returns it',
)]
class ApiKeyGenerateCommand extends Command
{
    public function __construct(private readonly ApiKeyRepository $apiKeyRepository)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $apiKey = $this->apiKeyRepository->createNewApiKey();
        $io->success(sprintf('Your key has beeen successfully generated : %s This key has a quota of %d', $apiKey->getKey()));
        $io->success(sprintf('This key has a quota of %d', $apiKey->getQuota()));

        return Command::SUCCESS;
    }
}
