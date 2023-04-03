<?php

namespace App\Form;

use App\Entity\Question;
use App\Entity\Film;
use App\Entity\Etape;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer;

class EtapesForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nometape', TextType::class, [
                'label' => 'Nouvelle étape',
            ])
            /*->add('idquestion', IntegerType::class, [
                'label' => 'Question',
            ])
            ->add('idfilm', IntegerType::class, [
                'label' => 'Film',
            ])*/
            ->add('idquestion', EntityType::class, [
                'class' => Question::class,
                'choice_label' => 'textequestion',
                'label' => 'Question',
                
            ])
            ->add('idfilm', EntityType::class, [
                'class' => Film::class,
                'choice_label' => 'nomfilm',
                'label' => 'Film',
            ])
            ->add('posxqrcode', IntegerType::class, [
                'label' => 'Position X',
            ])
            ->add('posyqrcode', IntegerType::class, [
                'label' => 'Position Y',
            ])
            ->add('Ajouter', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            //'data_class' => Etape::class,
        ]);
    }
}
