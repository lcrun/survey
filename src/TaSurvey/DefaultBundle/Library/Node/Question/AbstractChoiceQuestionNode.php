<?php
namespace TaSurvey\DefaultBundle\Library\Node\Question;

/**
 * @author wendell.zheng <wxzheng@ustc.edu.cn>
 */
abstract class AbstractChoiceQuestionNode extends AbstractQuestionNode
{
    public $options;

    public function __construct()
    {
        $this->options = array();
    }

    public function parseData(array $data)
    {
        parent::parseData($data);

        foreach ($data['options'] as $option) {
            $this->options[] = $option;
        }
    }
}
