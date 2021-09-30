<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ProductController extends AbstractController
{
    /**
     * @Route("/{slug}", name="product_category")
     */
    public function category($slug, CategoryRepository $categoryRepository)
    {   
        $category = $categoryRepository->findOneBy([
            'slug' => $slug
        ]);

        if (!$category) {
            throw $this->createNotFoundException("La catégorie demandée n'existe pas");
        }

        return $this->render('product/category.html.twig', [
            'slug' => $slug,
            'category' => $category
        ]);
    }

    /**
     * @Route("/{category_slug}/{slug}", name="product_show")
     */
    public function show($slug, $category_slug, ProductRepository $productRepository)
    {
        $product = $productRepository->findOneBy([
            'slug' => $slug
        ]);

        if (!$product) {
            throw $this->createNotFoundException("Le produit demandé n'existe pas");
        }

        // On redirige vers la bonne url si l'url est corrompue au niveau du category_slug avec la méthode RedirectToRoute

        $category_slug_foundProduct = $product->getCategory()->getSlug();

        if ($category_slug_foundProduct !== $category_slug) {
            return $this->redirectToRoute("product_show", [
                "category_slug" => $category_slug_foundProduct,
                "slug" => $slug
            ]);
        }
       
        return $this->render('product/show.html.twig', [
            'slug' => $slug,
            'product' => $product,
        ]);
    }

    /**
     *@Route("/admin/product/create", name="product_create")
     */
    public function create(FormFactoryInterface $factory, Request $request) 
    {
        
        $builder = $factory->createBuilder();

        $builder->add('name', TextType::class, [
            'label' => 'Nom du produit',
            'attr' => [
                'placeholder' => 'Tapez le nom du produit'
            ]
        ])
                ->add('shortDescription', TextareaType::class, [
                    'label' => 'Description courte',
                    'attr' => [
                        'placeholder' => 'Tapez une description assez courte mais parlante pour le visiteur'
                    ]
                ])
                ->add('price', MoneyType::class, [
                    'label' => 'Prix du produit',
                    'attr' => [
                        'placeholder' => 'Tapez le prix du produit en €'
                    ]
                ])
                ->add('category', EntityType::class, [
                    'label' => 'Catégorie',
                    'attr' => ['class' => 'form-control'],
                    'placeholder' => 'Choisir une catégorie',
                    'class' => Category::class,
                    'choice_label' => function (Category $category) {
                        return strtoupper($category->getName());
                    }
                ]);

        $form = $builder->getForm();

        // On demande à notre formulaire de gérer la requête 
        $form->handleRequest($request);
        
        if($form->isSubmitted()) {
            $data = $form->getData();

            $product = new Product;
            $product->setName($data['name'])
                    ->setShortDescription($data['shortDescription'])
                    ->setPrice($data['price'])
                    ->setCategory($data['category']);
        }
        
        $formView = $form->createView();

        return $this->render('product/create.html.twig', [
            'formView' => $formView
        ]);
    }
}
