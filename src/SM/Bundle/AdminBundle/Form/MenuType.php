<?php

namespace SM\Bundle\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use SM\Bundle\AdminBundle\Repository\MenuRepository;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use SM\Bundle\AdminBundle\Entity\Menu;

class MenuType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $container = \SM\Bundle\AdminBundle\SMAdminBundle::getContainer();
        $repMenu = $container->get("doctrine")->getRepository('SMAdminBundle:Menu');
        $options = $repMenu->buildMenuType();

        $optPosition = $repMenu->buildMenuPosition();

        $builder->add('position', 'choice', array(
                    'required' => true,
                    //'mapped' => false,      //This option will be created field on the form but no need to define property in entity
                    'choices' => $optPosition
                ))
//                ->add('parent', 'entity', array(
//                    'required' => false,
//                    'class' => 'SMAdminBundle:Menu',
//                    'query_builder' => function (MenuRepository $pRe) {
//                        return $pRe->createQueryBuilder('c')
//                                ->orderBy('c.lft', 'ASC')
//                                ->where('c.status = 1')
//                                ->andWhere('c.lft > 1');
//                    }
//                ))
                ->add('type', 'choice', array(
                    'required' => true,
                    //'mapped' => false,      //This option will be created field on the form but no need to define property in entity
                    'choices' => $options
                ))
//                ->add('param', 'choice', array(
//                    'required' => false
//                ))
                ->add('status', 'checkbox', array(
                    'required' => false
                ))
                ->add('url', 'url', array(
                    'required' => false
                ))
                ->add('menu_languages', 'collection', array('type' => new MenuLanguageType()))
        ;

        $ff = $builder->getFormFactory();
        $func = function (FormEvent $e) use ($ff, $repMenu) {
            $data = $e->getData();
            $form = $e->getForm();

            //Create element param
            if ($form->has('param')) {
                $form->remove('param');
            }
            $paramOptions = array();
            $type = '';
            if (is_array($data)) {
                $type = $data['type'];
            } else if ($data instanceof Menu) {
                $type = $data->getType();
            }

            if (!empty($type)) {
                $paramOptions = $repMenu->getOptionParam($type);
                if (is_array($paramOptions) && count($paramOptions) > 0) {
                    $rst = array();
                    foreach ($paramOptions as $opt) {
                        $rst[$opt->id] = $opt->name;
                    }
                    $paramOptions = $rst;
                }
            }

            $form->add($ff->createNamed('param', 'choice', null, array(
                'required' => false,
                'choices' => $paramOptions)
            ));

            //Create parent
            if ($form->has('parent')) {
                $form->remove('parent');
            }
            $parentOptions = array();
            $position = '0';
            if (is_array($data)) {
                $position = $data['position'];
            } else if ($data instanceof Menu) {
                $position = $data->getPosition();
            }

            if (!empty($position)) {
                $parentOptions = $repMenu->getOptionParent($position);
                if (is_array($parentOptions) && count($parentOptions) > 0) {
                    $rst = array();
                    foreach ($parentOptions as $opt) {
                        $rst[$opt->id] = $opt->name;
                    }
                    $parentOptions = $rst;
                }
            }

            $form->add($ff->createNamed('parent', 'entity', null, array(
                'required' => false,
                'class' => 'SMAdminBundle:Menu',
                'query_builder' => function (MenuRepository $pRe) use ($position){
                    $position = empty($position) ? '0' : $position;
                    return $pRe->createQueryBuilder('c')
                            ->orderBy('c.lft', 'ASC')
                            ->where('c.status = 1')
                            ->andwhere("c.position = $position")
                            ->andWhere('c.lft > 1');
                 })
            ));
        };

        $builder->addEventListener(FormEvents::PRE_BIND, $func);
        $builder->addEventListener(FormEvents::PRE_SET_DATA, $func);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SM\Bundle\AdminBundle\Entity\Menu'
        ));
    }

    public function getName()
    {
        return 'sm_bundle_adminbundle_menutype';
    }

}
