<?php

namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Bundle\SecurityBundle\Security;

class MenuBuilder
{
    private $factory;
    private $security;
    public function __construct(FactoryInterface $factory, Security $security, )
    {
        
        $this->factory = $factory;
        $this->security = $security;
    }

    public function createMainMenu(array $options): ItemInterface
    {   
        $logoutForm = "Logout  
             <form action='/logout' method='POST' id='logout-form'></form>";  

        $menu = $this->factory->createItem('root');

        $menu->setChildrenAttribute("id", "menu-wrapper");
        $menu->addChild('Home', ['route' => 'app_home']);
        $menu->addChild('Products', ['route' => 'app_products']);

        if($this->security->isGranted("ROLE_SUPER_ADMIN") || $this->security->isGranted("ROLE_ADMIN")){
            $admin_menu = $this->createAdminMenu($options);
            $menu->addChild($admin_menu)->setAttribute("class", "main-admin-menu");
        }

        if($this->security->isGranted('IS_AUTHENTICATED_FULLY')){
            $menu->addChild('Profile', ['route' => 'app_profile']);
            $menu->addChild('Logout')
            ->setUri('#')
            ->setAttribute('class', 'logout-link')
            ->setAttribute('onclick', 'event.preventDefault(); document.getElementById(\'logout-form\').submit();')
            ->setExtra('safe_label', true)
            ->setLabel($logoutForm);
            
            
        }else{
            $menu->addChild('Login', ['route' => 'app_login']);
            $menu->addChild('Register', ['route' => 'app_register']);
        }

      
        return $menu;
    }

    public function createAdminMenu(array $options):ItemInterface
    {
        $admin_menu = $this->factory->createItem("Admin menu", ["uri"=>"#"]);
        $admin_menu->setChildrenAttribute("class", "admin-menu-wrapper");
        if (isset($options['class'])) {
            $admin_menu->setChildrenAttribute("class", "admin-menu-wrapper ".$options["class"]);
        }
        
        if($this->security->isGranted("ROLE_SUPER_ADMIN")){
            $admin_menu->addChild("Users", ["route"=> "app_admin_users"]);
            $admin_menu->addChild("Roles", ["route"=> "app_admin_roles"]);
        }

        $admin_menu->addChild("Soon");
        $admin_menu->addChild("Soon2");

        return $admin_menu;
    }

}