<?php

namespace SM\Bundle\AdminBundle\Twig;

/**
 * Twig extendsion for media popup
 */
class MTxTwigShowImageExtension extends \Twig_Extension
{

    private $environment;

    /**
     * Return name of extendsion
     *
     * @return string Name of extendsion
     */
    public function getName()
    {
        return 'mtx.twig.show_image_extension';
    }

    /**
     * Init environment
     *
     * @param \Twig_Environment $environment
     */
    public function initRuntime(\Twig_Environment $environment)
    {
        $this->environment = $environment;
    }
    
    /**
     * Get Functions
     *
     * @return type
     */
    public function getFunctions()
    {
        return array(
            'mtxshowimg' => new \Twig_Function_Method($this, 'showImages'),
        );
    }

    /**
     * Generate options for render new template
     *
     * @param type $optMedias      $selectedMedias
     * @param type $selectedMedias $selectedMedias
     * @param type $selectName     $selectedMedias
     * @param type $multiple       $selectedMedias
     * @param type $required       $selectedMedias
     * @param type $mediaPath      $selectedMedias
     *
     * @return type
     */
    public function showImages($arrImgs, $imgPath = '' , $options = array())
    {
        return $this->environment->render(
            'SMAdminBundle:Twig:showimg.html.twig',
            array(
                'arrImgs' => $arrImgs,
                'imgPath' => $imgPath,
                'options' => $options,
        ));
    }
}