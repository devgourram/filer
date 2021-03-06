<?php

namespace Iad\Bundle\FilerTechBundle\Form;

use Iad\Bundle\FilerTechBundle\Entity\BasePicture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class PictureType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('originalFile', FileType::class, [
                    'required' => true,
                    'label' => false,
                    'attr' => [
                        'accept' => 'image/*',
                        'required' => 'required',
                    ],
                ])
                ->add('rank', HiddenType::class, [
                    'attr' => [
                        'class' => 'real_estate_picture_rank',
                    ],
                ])
                ->add('id', HiddenType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'iadfilertech_picture';
    }
}
