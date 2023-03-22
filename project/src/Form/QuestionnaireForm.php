<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulaire QuestionnaireForm pour le questionnaire d'une étape scannée
 */
class QuestionnaireForm extends \Symfony\Component\Form\AbstractType
{
    /**
     * Construit le formulaire pour le questionnaire d'une étape
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("reponse", TextType::class)
            ->add("idEtape", HiddenType::class, [
                'data' => $options["data"][0]])
            ->add("valider", SubmitType::class);
    }

    /**
     * Configure les options du form si besoin
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}