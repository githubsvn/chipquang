<?php

namespace SM\Bundle\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use SM\Bundle\AdminBundle\Repository\MediaCategoryRepository;

/**
 * Media type form
 */
class MediaType extends AbstractType
{
    private $_option;

    /**
     * constructor
     *
     * @param type $options the option
     */
    public function __construct($options = array())
    {
        $this->_option = $options;
    }

    /**
     * build form
     *
     * @param \Symfony\Component\Form\FormBuilderInterface $builder builder
     * @param array                                        $options options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (isset($this->_option['requiredFile'])) {
            //Show form edit
            $builder->add('file', 'file', array('required' => false));
        } else {
            $builder->add('file', 'file', array('required' => true));
        }

        $builder->add('name')
            ->add('width')
            ->add('height')
            ->add('active')
            ->add('category', 'entity', array(
                'required' => false,
                'class' => 'SMAdminBundle:MediaCategory',
                'query_builder' => function (MediaCategoryRepository $pRe) {
                    return $pRe->createQueryBuilder('c')
                        ->orderBy('c.lft', 'ASC')
                        ->where('c.status = 1');
                }
            ));
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SM\Bundle\AdminBundle\Entity\Media'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sm_bundle_adminbundle_mediatype';
    }

}
