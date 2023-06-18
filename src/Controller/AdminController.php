<?php

namespace App\Controller;

use App\Helpers\DateSerializer;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    private $security;
    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    #[Route('/admin/users', name: 'app_admin_users')]
    public function admin_users(): Response
    {
        return $this->render('admin/users.html.twig');
    }
    #[Route('/admin/roles', name: 'app_admin_roles')]
    public function admin_roles(): Response
    {
        return $this->render('admin/roles.html.twig');
    }
   
}
