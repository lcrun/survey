<?php
namespace TaSurvey\DefaultBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\AbstractType;
use TaSurvey\DefaultBundle\Form\Common\ButtonsType;

/**
 * @author wendell.zheng <wxzheng@ustc.edu.cn>
 */
class ExamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', 'text', array(
            'label' => '名称',
        ));
        $builder->add('paper', 'entity', array(
            'label' => '试卷',
            'class' => 'TaSurveyDefaultBundle:Paper',
        ));
        $builder->add('deadline', 'date', array(
            'label' => '截至日期',
            'widget' => 'single_text',
        ));
        $builder->add('buttons', new ButtonsType(), array(
            'label' => ' ',
        ));
    }

    public function getName()
    {
        return 'exam';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TaSurvey\DefaultBundle\Entity\Exam',
        ));
    }
}
