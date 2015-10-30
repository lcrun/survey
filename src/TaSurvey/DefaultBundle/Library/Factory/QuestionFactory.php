<?php
namespace TaSurvey\DefaultBundle\Library\Factory;

/**
 * @author wendell.zheng <wxzheng@ustc.edu.cn>
 */
class QuestionFactory
{
    public static function createQuestionNodeFromArray($id, array $data)
    {
        $reflectionClass = new \ReflectionClass("TaSurvey\\DefaultBundle\\Library\\Node\\Question\\".$data['type']."QuestionNode");
        $questionNode = $reflectionClass->newInstance();
        $questionNode->id = $id;
        $questionNode->parseData($data);

        return $questionNode;
    }
}
