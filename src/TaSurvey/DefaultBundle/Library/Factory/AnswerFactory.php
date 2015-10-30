<?php
namespace TaSurvey\DefaultBundle\Library\Factory;

use TaSurvey\DefaultBundle\Library\Node\AnswerNode;

/**
 * @author wendell.zheng <wxzheng@ustc.edu.cn>
 */
class AnswerFactory
{
    public static function createAnswerNodeFromArray(array $data)
    {
        $answerNode = new AnswerNode();
        $answerNode->answers = array();
        foreach ($data as $id => $answer) {
            $answerNode->answers[$id] = $answer;
        }

        return $answerNode;
    }
}
