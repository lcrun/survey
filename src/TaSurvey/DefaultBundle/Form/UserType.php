<?php
namespace TaSurvey\DefaultBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\AbstractType;
use TaSurvey\DefaultBundle\Form\Common\ButtonsType;

/**
 * @author wendell.zheng <wxzheng@ustc.edu.cn>
 */
class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
            'label' => '姓名',
        ));
        $builder->add('code', 'text', array(
            'label' => '登录码',
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
