<?php
namespace TaSurvey\DefaultBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\AbstractType;
use TaSurvey\DefaultBundle\Form\Common\ButtonsType;

/**
 * @author wendell.zheng <wxzheng@ustc.edu.cn>
 */
class CodeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('number', 'text', array(
            'label' => '请先填写学号',
        ));
        $builder->add('code', 'boolean', array(
            'label' => '是否参加过上次培训',
        ));
        $builder->add('buttons', new ButtonsType(), array(
            'label' => ' ',
        ));
    }

    public function getName()
    {
        return 'user';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TaSurvey\DefaultBundle\Entity\User',
        ));
    }
}
