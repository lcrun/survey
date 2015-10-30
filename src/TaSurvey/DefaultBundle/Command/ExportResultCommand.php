<?php
namespace TaSurvey\DefaultBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TaSurvey\DefaultBundle\Entity\ExamStudent;

/**
 * @author wendell.zheng <wxzheng@ustc.edu.cn>
 */
class ExportResultCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('app:export:result')->setDescription('export result');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $em = $container->get('doctrine')->getManager();
        $results = $em->getRepository("TaSurveyDefaultBundle:ExamStudent")->findBy(array(
            'exam' => 1,
            'status' => ExamStudent::STATUS_DONE,
        ));
        $fp = fopen('result.csv', 'w');
        foreach ($results as $result) {
            $answers = array_column($result->getAnswer(), 'answer');
            array_unshift($answers, $result->getStudent()->getNumber());
            fputcsv($fp, $answers);
        }
    }
}
