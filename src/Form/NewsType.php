<?php

namespace App\Form;

use App\Entity\News;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class NewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('active')
            ->add('title')
            ->add('preview_image', FileType::class, [
                'data_class'=>null, 'mapped'=>false, 'required' => false,
             ])
            ->add('preview_text')
            ->add('detail_image', FileType::class, [
                'data_class'=>null, 'mapped'=>false, 'required' => false,
             ])            
            ->add('detail_text')
            ->add('metaTitle')
            ->add('metaDescription')
            ->add('metaKeywords');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => News::class,
        ]);
    }
}
 