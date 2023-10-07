<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Sale;
use App\Entity\SaleLine;
use App\Form\SearchType;
use App\Model\SearchData;
use App\Repository\ProductRepository;
use App\Repository\SaleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CheckoutController extends AbstractController
{
    #[Route('/checkout', name: 'checkout')]
    public function index(
        ProductRepository $productRepository,
        Request $request,
        SessionInterface $session
    ): Response
    {
        $searchData = new SearchData();
        $form = $this->createForm(SearchType::class, $searchData);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $product = $productRepository->findBySearch($searchData);
            $id =  $product->getId();
            //dd($product);
            $cart = $session->get('cart', []);
            if(!empty($cart[$id])){

                $cart[$id]['quantity']++;
            }else{
                $cart[$id] =[
                    'product' => $product,
                    'quantity' => 1,
                ];
            }
            $session->set('cart', $cart);

            return $this->render('checkout/index.html.twig', [
                'form' => $form->createView(),
            ]);

        }
        return $this->render('checkout/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/remove/basket', name: 'remove_basket')]
    public function remove_cart(SessionInterface $session):Response
    {

        $session->remove('cart');
        return $this->redirectToRoute('checkout');
    }

    #[Route('/remove/product/{id}', name: 'remove_product')]
    public function remove_product(SessionInterface $session, Product $product):Response
    {
        $cart = $session->get('cart');
        if(isset($cart[$product->getId()])){
            unset($cart[$product->getId()]);
        }
        $session->set('cart', $cart);
        return $this->redirectToRoute('checkout');
    }

    #[Route('/checkout/save/', name: 'checkout_save')]
    public function save_checkout(SessionInterface $session, SaleRepository $saleRepository, EntityManagerInterface $manager): Response
    {
        $count = $saleRepository->count([])+1;
        $cart = $session->get('cart');
        if(!empty($cart)){
            $sale = new Sale();
            $sale->setClientName("CLT-0".$count);
            $sale->setAuthor($this->getUser())
                ->setReference('VNT-0'.$count)
            ;
            /*foreach ($cart as $item){
                dump($item);
            }
            die();*/
            foreach($cart  as $item){
                $product = $manager->getRepository(Product::class)->find($item['product']->getId());
                $saleLine = new SaleLine();
                $saleLine->setProduct($product);
                $saleLine->setQte($item['quantity']);
                $saleLine->setSale($sale);
                //dd($item ,$item['product'],$item['quantity'], $saleLine);
                $manager->persist($saleLine);
            }
            $manager->persist($sale);
            $manager->flush();
            $session->remove('cart');
            $this->addFlash('success', "la vente {$sale->getReference()} a bien été enregistrer");
            return $this->redirectToRoute('checkout_sale');
        }else{
            $this->addFlash('danger', "Une erreur est sur venu la vente n'a pas été enregistrer, Recommencer");
            $session->remove('cart');
            return $this->redirectToRoute('checkout');
        }
    }

    #[Route('/checkout/sales/', name: 'checkout_sale')]
    public function list(SaleRepository $saleRepository) :Response
    {

        return $this->render('checkout/list.html.twig', [
            'data' => $saleRepository->findAll(),
        ]);
    }
}
