<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
// use Symfony\Bridge\Doctrine\Form\Type\EntityType;
// use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
// use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
// use Symfony\Component\Form\ChoiceList\ChoiceList;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('active')
            ->add('title')
            ->add('category_id')            
            ->add('previewImage', FileType::class, [
               'data_class'=>null, 'mapped'=>false, 'required' => false,
            ])
            ->add('previewText')
            ->add('detailImage', FileType::class,[
                'data_class'=>null, 'mapped'=>false,'required' => false,
            ])
            ->add('detailText')

            ->add('price')
            ->add('discountPrice')            
            ->add('metaTitle')
            ->add('metaDescription')
            ->add('metaKeywords')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
