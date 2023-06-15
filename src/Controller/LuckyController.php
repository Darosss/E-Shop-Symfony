<?php 

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("lucky/")]
class LuckyController{
    
    
    #[Route('number', name: 'action')]
    public function number():Response{
        $number = random_int(0, 100);
        
        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }
}

