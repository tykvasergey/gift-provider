<?php

namespace RealThanks\GiftProvider\Console\Command;

use RealThanks\GiftProvider\Model\SyncLogManagement;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ClearOldSyncCommand extends Command
{
    const NAME_ARGUMENT = 'number_of_records';

    /**
     * @var SyncLogManagement
     */
    private $syncManager;

    /**
     * @param SyncLogManagement $syncManager
     */
    public function __construct(SyncLogManagement $syncManager)
    {
        $this->syncManager = $syncManager;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('rt:giftprovider:clear-old-syncs')
            ->setDescription('Cleared old sync records from DB command')
            ->setDefinition([
                new InputArgument(
                    self::NAME_ARGUMENT,
                    InputArgument::OPTIONAL,
                    'Number of Sync records to remove'
                )
            ]);

        parent::configure();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>Clearing is started</info>');
        $this->syncManager->cleanSyncLogs($input->getArgument(self::NAME_ARGUMENT));
        $output->writeln('<info>Clearing was finished</info>');
    }
}
