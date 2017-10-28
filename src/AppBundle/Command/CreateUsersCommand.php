<?php

namespace AppBundle\Command;

use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class CreateUsersCommand
 * @package AppBundle\Command
 */
class CreateUsersCommand extends Command
{
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var UserManagerInterface
     */
    private $userManager;

    public function __construct(LoggerInterface $logger, EntityManagerInterface $em, UserManagerInterface $userManager)
    {
        parent::__construct();

        $this->logger = $logger;
        $this->em = $em;
        $this->userManager = $userManager;
    }

    /**
     * Configure
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     */
    protected function configure()
    {
        $this
            ->setName('crv:create-users')
            ->setDescription('Create expected users for demo')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Starting up, beep, boop...');

        $this->dropTable();

        // being lazy
        exec('php bin/console -e=dev doctrine:schema:update --force');

        $this->createUsers();

        $io->success('Demo Application Setup Sequence Complete');
    }

    private function dropTable()
    {
        try {
            $connection = $this->em->getConnection();
            $sql = 'SET foreign_key_checks = 0;';
            $stmt = $connection->prepare($sql);
            $stmt->execute();
            $sql = sprintf('DROP TABLE %s;', 'user');
            $stmt = $connection->prepare($sql);
            $stmt->execute();
            $sql = 'SET foreign_key_checks = 1;';
            $stmt = $connection->prepare($sql);
            $stmt->execute();
            $stmt->closeCursor();
        } catch (\Exception $e) {
            $this->logger->critical('Failed', [
                'msg' => $e->getMessage()
            ]);
        }
    }

    private function createUsers()
    {
        $this->em->persist(
            $this
                ->userManager
                ->createUser()
                ->setUsername('admin')
                ->setEmail('admin@example.com')
                ->addRole('ROLE_SUPER_ADMIN')
                ->setPlainPassword('admin')
                ->setEnabled(true)
        );

        $this->em->persist(
            $this
                ->userManager
                ->createUser()
                ->setUsername('bob')
                ->setEmail('bob@example.com')
                ->setPlainPassword('testpass')
                ->setEnabled(true)
        );

        $this->em->persist(
            $this
                ->userManager
                ->createUser()
                ->setUsername('dave')
                ->setEmail('dave@example.com')
                ->setPlainPassword('davepass')
                ->setEnabled(true)
        );

        $this->em->flush();
    }
}
