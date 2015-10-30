<?php
namespace TaSurvey\DefaultBundle\Form\Common;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author wendell.zheng <wxzheng@ustc.edu.cn>
 */
class ButtonsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('save', 'submit', array(
            'label' => '提交',
            'attr' => array(
                'class' => 'btn btn-primary',
            ),
        ));
        $builder->add('back', 'button', array(
            'label' => '返回',
            'attr' => array(
                'class' => 'btn btn-link back',
            ),
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'inherit_data' => true,
        ));
    }

    public function getName()
    {
        return 'buttons';
    }
}
