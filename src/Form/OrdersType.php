<?php

namespace App\Form;

use App\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrdersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userId')
            ->add('fio')
            ->add('phone')
            ->add('email')
            ->add('address')
            ->add('deliveryPrice')
            ->add('deliveryDate')
            ->add('comments')
            ->add('payed')
            ->add('canceled')
            ->add('payedDate')
            ->add('status_id')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
