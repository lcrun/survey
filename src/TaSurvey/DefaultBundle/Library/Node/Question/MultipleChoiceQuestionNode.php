<?php
namespace TaSurvey\DefaultBundle\Library\Node\Question;

/**
 * @author wendell.zheng <wxzheng@ustc.edu.cn>
 */
class MultipleChoiceQuestionNode extends AbstractChoiceQuestionNode
{
    public function getContent()
    {
        $id = "question-".$this->id;
        $html = '';
        foreach ($this->options as $i => $option) {
            $value = $i + 1;
            $html .= '<div class="checkbox"><label><input';
            if ($this->required) {
                $html .= ' class="required"';
            }
            $html .= ' type="checkbox" name="'.$id.'[]" id="'.$id.$value.'" value="'.$value.'"';
            if ($this->required) {
                $html .= ' required="required"';
            }
            $html .= '>'.chr($i + 65).'. '.$option.'</label></div>';
        }

        return $html;
    }
}
