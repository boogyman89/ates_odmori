<?php
namespace Ates\UserBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;


class AddWorkingDaysCommand extends ContainerAwareCommand
{
    
    protected function configure()
    {
        $this->setName('employees:adddays')
            ->setDescription('Add number of days off')
            ->addArgument(
                'nbr_days_off',
                InputArgument::OPTIONAL,
                'Number of days for adding to all employees'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $nbr_days_off = $input->getArgument('nbr_days_off');
        if (!$nbr_days_off) {
           $nbr_days_off = 20;
        }
        
        $em = $this->getContainer()->get('doctrine')->getManager();
        $users = $em->getRepository('AtesUserBundle:User')->findAll();
        
        foreach( $users as $user)
        {
            $user->setNoDaysOffLastYear($user->getNoDaysOff());
            $user->setNoDaysOff($nbr_days_off);
            
           // $em->persist($user);
           // $em->flush();
        }
        
        $em->flush();
        
        $output->writeln('Users successfully updated!');
    }
}