<?php

namespace SM\Bundle\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use SM\Bundle\AdminBundle\Repository\CategoryRepository;

class NewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', 'entity', array(
                'required' => true,
                'class' => 'SMAdminBundle:Category',
                'query_builder' => function (CategoryRepository $pRe) {
                    return $pRe->createQueryBuilder('c')
                        ->orderBy('c.lft', 'ASC')
                        ->where('c.status = 1');
                }
            ))
            ->add('status', 'checkbox', array(
                'required' => false
            ))
            ->add('image', 'file', array(
                    'required' => false,
                    'data_class' => null
                ))
            ->add('news_languages', 'collection', array('type' => new NewsLanguageType()))
            ->add('media_id', null, array(
                'required' => false,
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SM\Bundle\AdminBundle\Entity\News'
        ));
    }

    public function getName()
    {
        return 'sm_bundle_adminbundle_newstype';
    }
}
