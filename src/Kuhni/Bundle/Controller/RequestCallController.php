<?php

namespace Kuhni\Bundle\Controller;

use Kuhni\Bundle\Entity\CallBack;
use Kuhni\Bundle\Entity\RequestCall;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RequestCallController extends Controller
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
        $phone = htmlspecialchars($form['phone']);

        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        $phoneNumber = new \libphonenumber\PhoneNumber();
        $phoneUtil->format($phoneNumber->setNationalNumber($phone), \libphonenumber\PhoneNumberFormat::NATIONAL);

        $entityManager = $this->get('doctrine.orm.default_entity_manager');

        $call = new RequestCall();
        $call->setUrl((string) $_SERVER['HTTP_REFERER']);
        $call->setName($name);
        $call->setGeoIP($geo_info);
        $call->setPhone($phoneNumber);
        $entityManager->persist($call);
        $entityManager->flush();

        $response = json_encode(array('success' => 'success'));
        return new Response($response);
    }
}