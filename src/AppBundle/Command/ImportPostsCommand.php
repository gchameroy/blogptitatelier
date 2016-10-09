<?php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Helper\ProgressBar;

class ImportPostsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
			->setName('app:import-posts')
			->setDescription('Import posts.')
			->setHelp("This command allows you to import posts")
			->addArgument('folder', InputArgument::REQUIRED, 'The folder of the posts file.')
		;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
		$folder = $input->getArgument('folder');

		$output->writeln('<comment>Script Import Posts');
		$start = new \DateTime();
		$output->writeln('<info>Folder : '.$folder);
		$output->writeln('<info>Start : ' . $start->format('d-m-Y H:i:s'));

		$this->import($input, $output);

		$end = new \DateTime();
		$output->writeln('<info>End : ' . $end->format('d-m-Y H:i:s'));
    }
	
	private function import(InputInterface $input, OutputInterface $output)
	{
		$data = $this->get($input, $output);
		$folder = $input->getArgument('folder');

		$em = $this->getContainer()->get('doctrine')->getManager();
		$em->getConnection()->getConfiguration()->setSQLLogger(null);
		
		$size = count($data);
		$batchSize = 20;
		$i = 1;
		
		$progress = new ProgressBar($output, $size);
		$progress->start();
		
		$step = new \DateTime();
		$output->writeln(' of posts imported | ' . $step->format('d-m-Y H:i:s'));
		
		foreach($data as $row){
			$post = $this->getContainer()->get('app.post.factory')->create();
			$post->setTitle($row['title']);
			$post->setDescription($row['description']);
			$image = $this->getContainer()->get('app.photo_uploader')->importPostImage(
				$this->getContainer()->getParameter('import_directory') . '/' . $folder . '/images/' . $row['image'],
				$this->getContainer()->getParameter('post_directory')
			);
			$post->setImage($image);

			$category = $em
				->getRepository('AppBundle:Category')
				->findOneByLabel($row['category']);
			if(!$category){
				$categories = $em
					->getRepository('AppBundle:Category')
					->findAll();
				$category = $this->getContainer()->get('app.category.factory')->create();
				$category->setLabel($row['category']);
				$category->setOrderId(count($categories) + 1);
				$em->persist($category);
				$em->flush();
			}
			$post->setCategory($category);
			
			$em->persist($post);

			if(($i % $batchSize) === 0){
				$em->flush();
				$em->clear();
				
				$progress->advance($batchSize);
				
				$step = new \DateTime();
				$output->writeln(' of posts imported | ' . $step->format('d-m-Y H:i:s'));
			}
			
			$i++;
		}

		$em->flush();
		$em->clear();
		
		$progress->finish();
		
		$step = new \DateTime();
		$output->writeln(' of posts imported | ' . $step->format('d-m-Y H:i:s'));
	}
	
	private function get(InputInterface $input, OutputInterface $output)
	{
		$folder = $input->getArgument('folder');
		$directory = $this->getContainer()->getParameter('import_directory') . '/' . $folder;
        $fileName = $directory . '/export.csv';
		
		$converter = $this->getContainer()->get('import.csvtoarray');
		$data = $converter->convert($fileName, ';');
		
		return $data;
	}
}