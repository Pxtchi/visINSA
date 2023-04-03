<?php

namespace App\Form;

use App\Entity\Question;
use App\Entity\Film;
use App\Entity\Etape;
use App\Entity\Aventure;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer;

class AventureForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomaventure', TextType::class, [
                'label' => 'Nouvelle aventure',
            ])
            ->add('texteaventure', TextType::class, [
                'label' => 'Text aventure',
            ])
            ->add('Ajouter', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Aventure::class,
        ]);
    }
}
