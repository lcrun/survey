<?php
namespace TaSurvey\DefaultBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TaSurvey\DefaultBundle\Library\Node\Question\AbstractQuestionNode;

/**
 * @author wendell.zheng <wxzheng@ustc.edu.cn>
 */
class ReadPaperCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('app:read:paper')->setDescription('read paper');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $appPath = $container->get('kernel')->getRootDir();
        $dataPath = $appPath."/../data";
        $source = $dataPath."/paper.txt";
        $lines = explode("\n\n", file_get_contents($source));

        $questions = array();
        foreach ($lines as $line) {
            // echo $line;
            $datas = preg_split("/\s+/", $line);
            // print_r($datas);
            $options = array();
            $title = $datas[1];
            foreach ($datas as $i => $data) {
                if ($i > 1 && $data != '') {
                    $options[] = mb_substr($data, 2, null, 'utf-8');
                }
            }
            $type = count($options) ? AbstractQuestionNode::TYPE_SINGLE_CHOICE : AbstractQuestionNode::TYPE_TEXTAREA;
            $question = array(
                'type' => $type,
                'required' => true,
                'title' => $title,
            );
            if ($type == AbstractQuestionNode::TYPE_SINGLE_CHOICE) {
                $question['options'] = $options;
            }
            $questions[] = $question;
        }

        $paper = array(
            'title' => '王秀槐教学工作坊反馈建议调查',
            'questions' => $questions,
        );
        $paperJson = $dataPath."/paper.json";
        file_put_contents($paperJson, json_encode($paper, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}
