<?php

namespace SM\Bundle\AdminBundle\Twig;

/**
 * Twig extendsion for media popup
 */
class SMTwigMediaExtension extends \Twig_Extension
{

    private $environment;

    /**
     * Return name of extendsion
     *
     * @return string Name of extendsion
     */
    public function getName()
    {
        return 'sm.twig.media_extension';
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
            'smmedia' => new \Twig_Function_Method($this, 'selectMedia'),
        );
    }

    /**
     * Generate options for render new template
     *
     * @param type $optMedias  Options
     * @param type $selectName Name of media
     * @param type $mediaPath  Media path
     * @param type $options    Options for medias
     *
     * @return type
     */
    public function selectMedia($optMedias, $optMediaTypes, $selectName = 'media_id', $mediaPath = '' , $options = array())
    {
        return $this->environment->render(
            'SMAdminBundle:Twig:media.html.twig', array(
            'optMedias' => $optMedias,
            'mediaName' => $selectName,
            'mediaPath' => $mediaPath,
            'options' => $options,
            'optMediaTypes' => $optMediaTypes
        ));
    }

}

