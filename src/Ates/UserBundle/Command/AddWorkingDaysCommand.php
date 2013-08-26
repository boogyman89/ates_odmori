<?php
namespace Ates\UserBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Ates\VacationBundle\Entity\VacationRequest;


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
            
            //send slava request for this year
            $thisYear = new \DateTime("now");   
            $date_of_slava = $user->getDateOfSlava();
            $this_year_slava_date = $thisYear->format("Y").'-'.$date_of_slava->format("m").'-'.$date_of_slava->format("d");
            
            $vacationRequest = new VacationRequest();
            $date_of_slava = new \DateTime($this_year_slava_date);
            $date_of_slava_ends = new \DateTime($this_year_slava_date);
            $date_of_slava_ends->modify('+1 day');
            
            $today = new \DateTime("now");
            $vacationRequest->setStartDate($date_of_slava); 
            $vacationRequest->setEndDate($date_of_slava_ends);
            $vacationRequest->setIdUser($user->getId());
            $vacationRequest->setSubmitted($today);
            $vacationRequest->setState("approved");
            $vacationRequest->setEditTime($today);

            
            $em->persist($vacationRequest);

            //$em->flush();
            
        }
        
        $em->flush();
        
        $output->writeln('Users successfully updated!');
    }
}