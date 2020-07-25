<?php

namespace App\Form;

use App\Entity\Refund;
use App\Repository\ProductRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RefundType extends AbstractType
{
    private $productRepository;
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount')
            ->add('product', ChoiceType::class, [
                'choices'  => $this->getProductsChoices(),
                'mapped'   => false,
                'required' => false,
            ])
            ->add('quantity', NumberType::class, [
                'mapped'   => false,
                'required' => false,
            ])
        ;
    }

    public function getProductsChoices()
    {
        $products = $this->productRepository->findBy([], ['name' => 'ASC']);
        $choices = [];
        $choices['Choisir un produit'] = '';
        foreach ($products as $product) {
            $choices[$product->getName()] = $product->getId();
        }
        return $choices;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Refund::class,
        ]);
    }
}
