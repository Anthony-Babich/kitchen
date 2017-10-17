<?php

namespace Kuhni\Bundle\Controller;

use Kuhni\Bundle\Entity\CallBack;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CallBackController extends Controller
{
    public function indexAction(Request $request){
        //geoIP
        $ip = $_SERVER['REMOTE_ADDR'];
        $query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
        if($query && $query['status'] == 'success') {
            $geo_info = $query['country'].', '.$query['city'].', '.$query['isp'].', '.$query['query'];
        } else { $geo_info = "Не удалось определить координаты посетителя"; }

        $form = $request->get('form');
        $name = htmlspecialchars($form['name']);
        $email = htmlspecialchars($form['email']);
        $number = htmlspecialchars($form['phone']['number']);
        $country = htmlspecialchars($form['phone']['country']);
        $message = htmlspecialchars($form['message']);

        switch ($country){
            case 'RU': $country = '7'; break;
            case 'BY': $country = '375'; break;
            case 'KZ': $country = '7'; break;
            case 'LV': $country = '370'; break;
            case 'PL': $country = '48'; break;
            case 'UA': $country = '380'; break;
            default : $country = '7';
        }

        $number = $country.$number;
        $entityManager = $this->get('doctrine.orm.default_entity_manager')->getRepository(CallBack::class);

        $cat1 = new CallBack();
        $cat1->setUrl('123');
        $cat1->setEmail($email);
        $cat1->setName($name);
        $cat1->setGeoIP($geo_info);
        $cat1->setMessage($message);
        $cat1->setPhone($number);
        $entityManager->persist($cat1);
        $entityManager->flush();

        $response = json_encode(array('success' => 'success'));
        return new Response($response);
    }
}