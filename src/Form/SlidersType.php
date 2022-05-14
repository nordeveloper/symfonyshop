<?php

namespace App\Form;

use App\Entity\Sliders;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class SlidersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('active')
            ->add('title')
            ->add('previewImage', FileType::class, [
                'data_class'=>null, 'mapped'=>false, 'required' => false,
             ])
             ->add('previewText')
             ->add('detailImage', FileType::class,[
                 'data_class'=>null, 'mapped'=>false,'required' => false,
             ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sliders::class,
        ]);
    }
}
