<?php

namespace SM\Bundle\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use SM\Bundle\AdminBundle\Repository\CompanyTypeRepository;

class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', 'entity', array(
                'required' => true,
                'class' => 'SMAdminBundle:CompanyType',
                'query_builder' => function (CompanyTypeRepository $pRe) {
                    return $pRe->createQueryBuilder('c')
                        ->where('c.status = 1');
                }
            ))
            ->add('charter_capital', null, array('required' => false))
            ->add('phone', null, array('required' => false))
            ->add('fax', null, array('required' => false))
            ->add('mst', null, array('required' => false))
            ->add('email', null, array('required' => false))
            ->add('website', null, array('required' => false))
            ->add('status', 'checkbox', array(
                'required' => false
            ))
            ->add('company_languages', 'collection', array('type' => new CompanyLanguageType()))
            ->add('logo', 'file', array(
                'required' => false,
                'data_class' => null
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SM\Bundle\AdminBundle\Entity\Company'
        ));
    }

    public function getName()
    {
        return 'sm_bundle_adminbundle_companytype';
    }
}
