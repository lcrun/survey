<?php
namespace TaSurvey\DefaultBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author wendell.zheng <wxzheng@ustc.edu.cn>
 */
class GenerateCodeCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('app:generate:code')->setDescription('generate codes');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $appPath = $container->get('kernel')->getRootDir();
        $dataPath = $appPath."/../data";

        $codes = array();
        for ($i = 1; $i <= 800; $i ++) {
            $random = substr(md5(mt_rand()), 0, 8);
            if (! in_array($random, $codes)) {
                $codes[] = $random;
            }
        }

        $codeJson = $dataPath."/codes.json";
        file_put_contents($codeJson, json_encode($codes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}
