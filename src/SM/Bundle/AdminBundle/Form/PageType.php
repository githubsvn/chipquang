<?php

namespace SM\Bundle\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('status', 'checkbox', array(
                'required' => false
            ))
            ->add('image', 'file', array(
                    'required' => false,
                    'data_class' => null
                ))
            ->add('page_languages', 'collection', array('type' => new PageLanguageType()))
            ->add('media_id', null, array(
                'required' => false,
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SM\Bundle\AdminBundle\Entity\Page'
        ));
    }

    public function getName()
    {
        return 'sm_bundle_adminbundle_pagetype';
    }
}
