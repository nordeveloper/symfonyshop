<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticlesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('active')
            ->add('title')
            ->add('sort')
            ->add('created_by')
            ->add('preview_text')
            ->add('preview_image', FileType::class, [
                'data_class'=>null, 'mapped'=>false, 'required' => false,
            ])
            ->add('detail_text')
            ->add('detail_image', FileType::class, [
                'data_class'=>null, 'mapped'=>false, 'required' => false,
            ])
            ->add('meta_title')
            ->add('meta_description')
            ->add('meta_keywords')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
