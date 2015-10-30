<?php
namespace TaSurvey\DefaultBundle\Library\Factory;

use TaSurvey\DefaultBundle\Library\Node\PaperNode;

/**
 * @author wendell.zheng <wxzheng@ustc.edu.cn>
 */
class PaperFactory
{
    public static function createPaperNodeFromArray(array $data, array $questions = null)
    {
        $paperNode = new PaperNode();
        $paperNode->title = $data['title'];
        foreach ($data['questions'] as $i => $questionData) {
            $no = $i + 1;
            if ($questions) {
                if (in_array($no, $questions)) {
                    $questionNode = QuestionFactory::createQuestionNodeFromArray($no, $questionData);
                    $paperNode->addQuestionNode($questionNode);
                }
            } else {
                $questionNode = QuestionFactory::createQuestionNodeFromArray($no, $questionData);
                $paperNode->addQuestionNode($questionNode);
            }
        }

        return $paperNode;
    }
}
