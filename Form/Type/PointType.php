<?php

namespace DCS\Form\PointFormFieldBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use DCS\Form\PointFormFieldBundle\DataTransformer\TextToPointTransformer;

class PointType extends AbstractType
{
    private $parentType;

    public function __construct($parentType)
    {
        $this->parentType = $parentType;
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars = array_merge($view->vars, array(
            'functionFillFromGoogleResult' => $options['functionFillFromGoogleResult'],
            'functionEmptyWhenNoDigit' => $options['functionEmptyWhenNoDigit'],
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addViewTransformer(new TextToPointTransformer(), true);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'functionFillFromGoogleResult' => null,
            'functionEmptyWhenNoDigit' => null,
        ));

        $resolver->setAllowedTypes('functionFillFromGoogleResult', array('string', 'null'));
        $resolver->setAllowedTypes('functionEmptyWhenNoDigit', array('string', 'null'));
    }

    public function getParent()
    {
        return $this->parentType;
    }

    public function getBlockPrefix()
    {
        return $this->getName();
    }
    
    public function getName()
    {
        return 'point';
    }
}