<?php

namespace App\Form;

use App\Entity\Product;
use App\Repository\CategoryRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('price')
            ->add('category', ChoiceType::class, [
                'choices' => $this->getCategories()
            ])
        ;
    }

    public function getCategories()
    {
        $categories = $this->categoryRepository->findBy([], ['name' => 'ASC']);
        $choices = [];
        foreach ($categories as $category) {
            $choices[$category->getName()] = $category->getId();
        }
        return $choices;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
