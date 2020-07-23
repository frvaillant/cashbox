<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    const COLORS = [
        'blue',
        'red',
        'cyan',
        'teal',
        'pink',
        'yellow',
        'amber',
        'orange',
        'deep-orange',
        'lime',
        'brown',
        'grey',
        'light-blue',
        'light-green',
        'green',
        'indigo',
        'purple',
    ];

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('color', ChoiceType::class, [
                'choices' => $this->getColors()
            ])
        ;
    }

    public function getColors()
    {
        $choices = [];
        foreach (self::COLORS as $color) {
            $choices[$color] = $color;
        }
        return $choices;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
