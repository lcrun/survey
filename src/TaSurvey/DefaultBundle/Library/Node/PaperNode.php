<?php
namespace TaSurvey\DefaultBundle\Library\Node;

use TaSurvey\DefaultBundle\Library\Node\Question\AbstractQuestionNode;

/**
 * @author wendell.zheng <wxzheng@ustc.edu.cn>
 */
class PaperNode implements NodeInterface
{
    public $title;

    public $questionNodes;

    public function addQuestionNode(AbstractQuestionNode $questionNode)
    {
        $this->questionNodes[] = $questionNode;
    }

    public function getHtml($id = null)
    {
        $html = '<div class="paper">';
        $html .= '<legend>'.$this->title.'</legend>';

        foreach ($this->questionNodes as $i => $questionNode) {
            $no = $i + 1;
            $html .= $questionNode->getHtml($no);
        }

        $html .= '</div>';

        return $html;
    }
}
