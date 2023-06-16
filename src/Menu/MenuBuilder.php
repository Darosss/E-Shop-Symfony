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

}