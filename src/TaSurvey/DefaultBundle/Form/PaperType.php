<?php
namespace TaSurvey\DefaultBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\AbstractType;
use TaSurvey\DefaultBundle\Form\Common\ButtonsType;

/**
 * @author wendell.zheng <wxzheng@ustc.edu.cn>
 */
class PaperType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', 'text', array(
            'label' => '名称',
        ));
        $builder->add('detail', 'textarea', array(
            'label' => '试卷',
        ));
        $builder->add('buttons', new ButtonsType(), array(
            'label' => ' ',
        ));
    }

    public function getName()
    {
        return 'paper';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TaSurvey\DefaultBundle\Entity\Paper',
        ));
    }
}
