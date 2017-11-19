<?php

namespace Kuhni\Bundle\Controller;

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

        $entityManager = $this->get('doctrine.orm.default_entity_manager');

        $call = new RequestCall();

        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('id' => $form['idSalon']));
        $call->setIdSalon($user);

        $call->setUrl((string) $_SERVER['HTTP_REFERER']);
        $call->setName($name);
        $call->setGeoIP($geo_info);
        $call->setPhone($phone);
        $entityManager->persist($call);
        $entityManager->flush();

        $message = \Swift_Message::newInstance()
            ->setSubject('Contact enquiry from symblog')
            ->setFrom('info@a0170685.xsph.ru')
            ->setTo('antosha.1998.ru@mail.ru')
            ->setBody('1234324');
        $this->get('mailer')->send($message);

        $response = json_encode(array('success' => 'success'));
        return new Response($response);
    }
}