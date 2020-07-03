<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class InsertUserCommand extends Command
{
    protected static $defaultName = 'app:insert-user';

    protected $em;
    protected $userPasswordEncoder;

    public function __construct(string $name = null, EntityManagerInterface $em, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        parent::__construct($name);

        $this->em = $em;
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    protected function configure()
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $user = new User();
        $user->setEmail('foo@bar.com');
        $user->setPassword(
            $this->userPasswordEncoder->encodePassword($user, 'foo@bar.com')
        );

        $this->em->persist($user);
        $this->em->flush();

        $io->success('User added successfully');

        return 0;
    }
}
