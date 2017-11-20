<?php

namespace Kuhni\Bundle\Controller;

use DateTime;
use Kuhni\Bundle\Entity\RequestCall;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RequestCallController extends Controller
{
    public function indexAction(Request $request){
        //geoIP
//        $ip = $_SERVER['REMOTE_ADDR'];
//        $query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
//        if($query && $query['status'] == 'success') {
//            $geo_info = $query['country'].', '.$query['city'].', '.$query['isp'].', '.$query['query'];
//        } else { $geo_info = "Не удалось определить координаты посетителя"; }
//
//        $form = $request->get('form');
//        $name = htmlspecialchars($form['name']);
//        $phone = htmlspecialchars($form['phone']);
//
//        $entityManager = $this->get('doctrine.orm.default_entity_manager');
//
//        $call = new RequestCall();
//        $salon = $this->getDoctrine()->getManager()
//            ->getRepository('KuhniBundle:Salon')
//            ->findOneBy(array('id' => $form['idSalon']));
//        $user = $this->getDoctrine()->getManager()->getRepository('ApplicationSonataUserBundle:User')
//            ->createQueryBuilder('n')
//            ->select('n, m')
//            ->innerjoin('n.salons', 'm')
//            ->where('m.id = :id')
//            ->setParameter('id', $salon->getId())
//            ->setMaxResults(1)
//            ->getQuery()
//            ->getResult();
//
//        $call->setIdSalon($user);
//
//        $call->setUrl((string) $_SERVER['HTTP_REFERER']);
//        $call->setName($name);
//        $call->setGeoIP($geo_info);
//        $call->setPhone($phone);
//        $entityManager->persist($call);
//        $entityManager->flush();

        $message = \Swift_Message::newInstance()
            ->setSubject('Contact enquiry from symblog')
            ->setFrom('info@зов.москва')
            ->setTo('antosha.1998.ru@mail.ru')
            ->setBody('123'
//                $this->renderView(
//                    'Emails/requestCall.html.twig',
//                    array(
//                        'sender_name' => $name,
//                        'created' => new \DateTime(),
//                        'geoIP' => $geo_info,
//                        'phone' => $phone,
//                        'email' => $user->getEmail(),
//                    )
//                ),
//                'text/html'
            );
        $this->get('mailer')->send($message);

        $response = json_encode(array('success' => 'success'));
        return new Response($response);
    }
}