<?php
namespace TaSurvey\DefaultBundle\Library\Node\Question;

/**
 * @author wendell.zheng <wxzheng@ustc.edu.cn>
 */
class SingleChoiceQuestionNode extends AbstractChoiceQuestionNode
{
    public function getContent()
    {
        $id = "question-".$this->id;
        $html = '';
        foreach ($this->options as $i => $option) {
            $value = $i + 1;
            $html .= '<div class="radio"><label><input';
            if ($this->required) {
                $html .= ' class="required"';
            }
            $html .= ' type="radio" name="'.$id.'" id="'.$id.$value.'" value="'.$value.'"';
            if ($this->required) {
                $html .= ' required="required"';
            }
            $html .= '>'.chr($i + 65).'. '.$option.'</label></div>';
        }

        return $html;
    }
}
