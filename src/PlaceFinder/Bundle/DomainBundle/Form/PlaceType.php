<?php

namespace PlaceFinder\Bundle\DomainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class PlaceType
 *
 * @package PlaceFinder\Bundle\DomainBundle\Form
 */
class PlaceType extends AbstractType
{
    /** @var string */
    protected $classPath;

    /**
     * Construct
     *
     * @param string $classPath
     */
    public function __construct($classPath)
    {
        $this->classPath = $classPath;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('latitude')
            ->add('longitude');
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'      => $this->classPath,
            'csrf_protection' => false,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'placefinder_bundle_domainbundle_place';
    }
}
