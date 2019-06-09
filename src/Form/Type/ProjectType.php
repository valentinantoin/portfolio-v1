<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $option)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre'
            ])
            ->add('imageFile', FileType::class, [
                'label' => 'Image',
                'required' => 'false'
            ])
            ->add('imageName', TextType::class, [
                'label' => 'Nom du l\'image'
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'name' => "content"
                ]
            ])
            ->add('link', TextType::class, [
                'label' => 'Lien'
            ])
            ->add('send', SubmitType::class, [
                'label' => 'Enregistrer'
            ]);
    }
}