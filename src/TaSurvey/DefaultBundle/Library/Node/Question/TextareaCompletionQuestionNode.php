<?php
namespace TaSurvey\DefaultBundle\Library\Node\Question;

/**
 * @author wendell.zheng <wxzheng@ustc.edu.cn>
 */
class TextareaCompletionQuestionNode extends AbstractCompletionQuestionNode
{
    public function getContent()
    {
        $id = "question-".$this->id;
        $class = "form-control";
        if ($this->required) {
            $class .= " required";
        }
        $html = '<textarea class="'.$class.'" rows="4" id="'.$id.'" name="'.$id.'"';
        if ($this->required) {
            $html .= ' required';
        }
        $html .= '></textarea>';

        return $html;
    }
}
