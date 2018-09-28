<?php

namespace Iad\Bundle\FilerTechBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ResizeParametersType
 * @package Iad\Bundle\FilerTechBundle\Form\Type
 */
class ResizeParametersType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('filter', 'text', ['required' => false])
            ->add('size', null, ['required' => false])
            ->add('quality', null, ['required' => false])
            ->add('mode', 'text', ['required' => false])
            ->add('disposition', 'text', ['required' => false]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'resize_parameters';
    }
}
