<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use App\Entity\Etape;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QrForm extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('etape', EntityType::class, [
                'class' => Etape::class,
                'choice_label' => 'nometape',
                'label' => 'Etape',                
            ])
        ;
    }
}