<?php

namespace App\Controller;

use App\Entity\Products;
use App\Helpers\DateSerializer;
use App\Repository\CategoriesRepository;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ProductsController extends AbstractController
{
    private $dateSerializer;
    private $productsRepository;
    private $categoriesRepository;
    public function __construct(DateSerializer $dateSerializer, ProductsRepository $productsRepository, CategoriesRepository $categoriesRepository)
    {
        $this->dateSerializer = $dateSerializer;
        $this->productsRepository = $productsRepository;
        $this->categoriesRepository = $categoriesRepository;
    }

    #[Route('/products', name: 'app_products', methods:["GET"]) ]
    public function index(ProductsRepository $productsRepository, NormalizerInterface $normalizerInterface): Response
    {
        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getName();
            },  
            AbstractNormalizer::CALLBACKS => [
                'createdAt' => $this->dateSerializer->normalizerDateCallback(),
                'updatedAt' => $this->dateSerializer->normalizerDateCallback()
            ],
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

        $serializer = new Serializer([$normalizer], [$encoder]);
        $products = $serializer->serialize($productsRepository->findAll(), 'json');
        
        return $this->render('products/index.html.twig', array(
            'products' =>$products
        ));

        
 
    }
    #[Route('/products', name: 'app_products_create', methods:["POST"])]
    public function createProduct(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['name']) || !isset($data['price']) ||!isset($data['image']) || !isset($data['brand']) || !isset($data['quantity']) || !isset($data['category_id'])) {
            return new Response('Missing required data', Response::HTTP_BAD_REQUEST);
        }

        if(!isset($data["description"] )) {
            $data["description"] = "";
        }

        $product_category = $this->categoriesRepository->findOneBy(['id'=>$data["category_id"]]);
        $time = new \DateTimeImmutable();
        //TODO: make a dynamical updateAt + createdAt;
   
        //TODO: make a upload img with product(as required)
        // Image path will be set by server depends on image uploaded 
        $new_product = new Products();
        $new_product->setName($data["name"]);
        $new_product->setBrand($data["brand"]);
        $new_product->setDescription($data["description"] || "");
        $new_product->setImage($data["image"]);
        $new_product->setPrice($data["price"]);
        $new_product->setQuantity($data["quantity"]);
        $new_product->setCategory($product_category);
        $new_product->setUpdatedAt($time);
        $new_product->setCreatedAt($time);

         $this->productsRepository->save($new_product, true);
        
         return new Response('Product created successfully', Response::HTTP_CREATED);

    }

//TODO: add remove product
//TODO: add update product
}
