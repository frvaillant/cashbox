<?php

namespace App\Form;

use App\Entity\Stock;
use App\Repository\ProductRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StockType extends AbstractType
{
    private $productRepositoty;
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepositoty = $productRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('product', ChoiceType::class, [
                'choices' => $this->getProducts()
            ])
            ->add('quantity')

        ;
    }

    public function getProducts()
    {
        $choices = [];
        $products = $this->productRepositoty->findBy([], ['name' => 'ASC']);
        foreach ($products as $product) {
            $choices[$product->getName()] = $product;
        }
        return $choices;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stock::class,
        ]);
    }
}
