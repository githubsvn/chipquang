<?php

namespace SM\Bundle\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use SM\Bundle\AdminBundle\Entity\CompanyType;

class CompanyTypeType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('status', 'checkbox', array(
                'required' => false
            ))
            ->add('companytype_languages', 'collection', array('type' => new CompanyTypeLanguageType()));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SM\Bundle\AdminBundle\Entity\CompanyType'
        ));
    }

    public function getName()
    {
        return 'sm_bundle_adminbundle_companytypetype';
    }

}
