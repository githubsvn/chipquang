<?php

namespace SM\Bundle\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * language type form
 */
class LanguageType extends AbstractType
{
    private $isDefault;

    public function __construct($isDefault = 0)
    {
        $this->isDefault = $isDefault;
    }
    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder builder
     *
     * @param array                                        $options options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('lang_key');
        if ($this->isDefault) {
            $builder->add('is_default', 'checkbox', array('required' => false, 'disabled' => 'disabled'));
        } else {
            $builder->add('is_default', 'checkbox', array('required' => false));
        }
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SM\Bundle\AdminBundle\Entity\Language'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sm_bundle_adminbundle_languagetype';
    }
}
