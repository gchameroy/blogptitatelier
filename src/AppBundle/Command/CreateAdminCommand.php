<?php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Helper\ProgressBar;

class CreateAdminCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
			->setName('app:create-admin')
			->setDescription('Create admin user.')
			->setHelp("This command allows you to create admin user")
			->addArgument('username', InputArgument::REQUIRED, 'The username\'s user.')
			->addArgument('email', InputArgument::REQUIRED, 'The email\'s user.')
			->addArgument('password', InputArgument::REQUIRED, 'The password\'s user.')
		;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
		$username = $input->getArgument('username');
		$email = $input->getArgument('email');
		$password = $input->getArgument('password');

		$output->writeln('<comment>Script Create User');
		$start = new \DateTime();
		$output->writeln('<info>Username : '.$username);
		$output->writeln('<info>Email : '.$email);
		$output->writeln('<info>Password : '.$password);
		$output->writeln('<info>Start : ' . $start->format('d-m-Y H:i:s'));

		$this->createAdmin($input, $output);

		$end = new \DateTime();
		$output->writeln('<info>End : ' . $end->format('d-m-Y H:i:s'));
    }
	
	private function createAdmin(InputInterface $input, OutputInterface $output)
	{
		$username = $input->getArgument('username');
		$email = $input->getArgument('email');
		$password = $input->getArgument('password');

		$em = $this->getContainer()->get('doctrine')->getManager();
		$em->getConnection()->getConfiguration()->setSQLLogger(null);

		$user = $this->getContainer()->get('app.user.factory')->createAdmin()
            ->setUsername($username)
            ->setEmail($email)
            ->setPlainPassword($password)
            ->setSalt(md5(random_bytes(15)));
        $password = $this->getContainer()
            ->get('security.password_encoder')
            ->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($password)
            ->eraseCredentials();

		$em->persist($user);
		$em->flush();
		$em->clear();
	}
}