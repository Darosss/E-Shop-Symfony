<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Products;
use App\Helpers\DateSerializer;
use App\Repository\CategoriesRepository;
use App\Repository\ProductsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CategoriesController extends AbstractController
{
    private $categoriesRepository;
    public function __construct(CategoriesRepository $categoriesRepository)
    {
        $this->categoriesRepository = $categoriesRepository;
    }

    #[Route('/categories', name: 'app_categories', methods:["GET"]) ]
    public function index(NormalizerInterface $normalizerInterface): Response
    {
        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getName();
            },  
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

        $serializer = new Serializer([$normalizer], [$encoder]);
        $categories = $serializer->serialize($this->categoriesRepository->findAll(), 'json');
        
        return $this->render('categories/index.html.twig', array(
            'categories' =>$categories
        ));

        
 
    }
    #[Route('/categories', name: 'app_categories_create', methods:["POST"])]
    public function createProduct(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['name']) ) {
            return new Response('Missing required data', Response::HTTP_BAD_REQUEST);
        }

        if(!isset($data["description"] )) {
            $data["description"] = "";
        }
        if(!isset($data["parent_id"] )) {
            $data["parent_id"] = null;
        }
        if(!isset($data["children_ids"] )) {
            $data["children_ids"] = [];
        }
        $parent_category = $this->categoriesRepository->findOneBy(["id"=>$data["parent_id"]]);

        $children_categories = new ArrayCollection();
        for ($idx = 1; $idx < count($data["children_ids"]); $idx++) {
            $new_child = $this->categoriesRepository->findOneBy(["id"=>$data["children_ids"][$idx]]);
            $children_categories->add($new_child);
            
        }
   
        $new_category = new Categories();
        $new_category->setName($data["name"]);
        $new_category->setParent($parent_category);
        
        $new_category->setChildren($children_categories);
        $new_category->setDescription($data["description"]);

         $this->categoriesRepository->save($new_category, true);
        
         return new Response('Category created successfully', Response::HTTP_CREATED);

    }

//TODO: add remove product
//TODO: add update product
}
