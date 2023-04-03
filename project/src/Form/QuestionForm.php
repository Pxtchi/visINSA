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

class QuestionForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('textequestion', TextType::class, [
                'label' => 'Nouvelle question',
            ])
            ->add('pointsquestion', IntegerType::class, [
                'label' => 'Nombre de points',
            ])
            ->add('creer', SubmitType::class, [
                'label' => 'Créer',
            ]);
            
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
