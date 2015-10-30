<?php
namespace TaSurvey\DefaultBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author wendell.zheng <wxzheng@ustc.edu.cn>
 */
class TestCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('survey:test')->setDescription('test');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $em = $container->get('doctrine')->getManager();
    }
}
