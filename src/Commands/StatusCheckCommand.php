<?php

declare(strict_types=1);

namespace Nordsec\StatusChecker\Commands;

use Nordsec\StatusChecker\Services\StatusCheckerService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StatusCheckCommand extends Command
{
    private $statusCheckerService;

    public function __construct(StatusCheckerService $statusCheckerService)
    {
        $this->statusCheckerService = $statusCheckerService;

        parent::__construct('status:check');
    }

    public function configure(): void
    {
        parent::configure();

        $this->setDescription('Perform a status check of connections to database, rabbit-mq, other hosts etc');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $details = $this->statusCheckerService->getDetails();

        foreach ($details as $checkerName => $status) {
            $output->writeln(sprintf('%s: %s', $checkerName, $status));
        }
    }
}
