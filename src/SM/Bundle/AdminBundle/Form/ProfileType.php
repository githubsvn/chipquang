<?php

namespace SM\Bundle\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * profile form type
 */
class ProfileType extends AbstractType
{
    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder builder
     * @param array                                        $options options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('username', 'text', array('read_only' => true))
                ->add('fullname')
                ->add('currentPassword', 'password', array(
                    'label' => "Current password",
                    'required' => false,
                ))
                ->add('password', 'repeated', array(
                    'first_name' => 'password',
                    'second_name' => 'confirm',
                    'invalid_message' => 'Mật khẩu không giống nhau.',
                    'type' => 'password',
                    'required' => false,
                    'first_options' => array('label' => "New Password"),
                    'second_options' => array('label' => "Repeat New Password"),
                ))
                ->add('email')
                ->add('role_collection')
                ->add('group');
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SM\Bundle\AdminBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sm_bundle_adminbundle_profiletype';
    }
}
