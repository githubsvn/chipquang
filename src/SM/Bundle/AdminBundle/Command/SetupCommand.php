<?php

namespace SM\Bundle\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Setup Init to create base group, role and user admin
 */
class SetupCommand extends ContainerAwareCommand
{

    protected $_entityManager;

    /**
     * configure
     */
    protected function configure()
    {
        $this->setName('rss:refesh');
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface   $input  input
     * @param \Symfony\Component\Console\Output\OutputInterface $output output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->_entityManager = $this->getContainer()->get('doctrine')->getEntityManager();

        $output->writeln('<comment>Refesh Rss Feed</comment>');
        $this->_refeshRss($input, $output);
        $output->writeln('');
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface   $input  input
     * @param \Symfony\Component\Console\Output\OutputInterface $output output
     */
    private function _refeshRss(InputInterface $input, OutputInterface $output)
    {
        $currentTime = date('G', time());
        $timeRunCron = $this->getContainer()->getParameter('time_cron');

        $repRssFeed = $this->_entityManager->getRepository("SMAdminBundle:RssFeed");
        $listRss = $repRssFeed->getList();
        if (is_array($listRss) && count($listRss) > 0) {
            foreach ($listRss as $rssFeed) {
                $autoRefesh = $rssFeed->getAutomaticRefesh();

                if ($autoRefesh) {
                    $beginTimeRefesh = $rssFeed->getBeginRefesh();
                    $endTimeRefesh = $rssFeed->getEndRefesh();

                    if ($beginTimeRefesh <= $currentTime && $currentTime <= $endTimeRefesh) {
                        $timeCron = $rssFeed->getTimeCron() - $timeRunCron;
                        if ($timeCron <= 0) {
                            $output->writeln('Refesh for Rss item id '. $rssFeed->getId());
                            //Refesh to get xml file
                            $repRssFeed->refeshRss($rssFeed);
                            //Update time cron that to run next time
                            $timeCron = $rssFeed->getTimeRefesh();
                        }

                        $rssFeed->setTimeCron($timeCron);
                        $this->_entityManager->persist($rssFeed);
                        $this->_entityManager->flush();
                    }
                }
            }
        }

    }



}
