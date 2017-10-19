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
        $phone = htmlspecialchars($form['phone']);
        $message = htmlspecialchars($form['message']);

        $entityManager = $this->get('doctrine.orm.default_entity_manager');

        $call = new CallBack();
        $call->setUrl((string) $_SERVER['HTTP_REFERER']);
        $call->setEmail($email);
        $call->setName($name);
        $call->setGeoIP($geo_info);
        $call->setMessage($message);
        $call->setPhone($phone);
        $entityManager->persist($call);
        $entityManager->flush();

        $response = json_encode(array('success' => 'success'));
        return new Response($response);
    }
}