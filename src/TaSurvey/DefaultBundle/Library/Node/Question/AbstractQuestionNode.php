<?php
namespace TaSurvey\DefaultBundle\Library\Node\Question;

use TaSurvey\DefaultBundle\Library\Node\NodeInterface;

/**
 * @author wendell.zheng <wxzheng@ustc.edu.cn>
 */
abstract class AbstractQuestionNode implements NodeInterface
{
    const TYPE_SINGLE_CHOICE = 'SingleChoice';
    
    const TYPE_MULTIPLE_CHOICE = 'MultipleChoice';

    const TYPE_TEXTAREA = 'TextareaCompletion';

    public $id;

    public $required;

    public $title;

    public function parseData(array $data)
    {
        $this->required = $data['required'];
        $this->title = $data['title'];
    }

    abstract public function getContent();

    public function getHtml($no)
    {
        $class = "form-group";
        if ($this->required) {
            $class .= " required";
        }
        $html = '<div class="'.$class.'"><label>第'.$no."题：".$this->title;
        if ($this->required) {
            $html .= ' <span class="text-danger">*</span>';
        }
        $html .= '</label>';

        $html .= static::getContent();

        $html .= '</div>';

        return $html;
    }
}
