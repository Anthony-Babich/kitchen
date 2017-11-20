<?php

namespace Kuhni\Bundle\Controller;

use Kuhni\Bundle\Entity\freeDesignProject;
use Kuhni\Bundle\Entity\ZayavkaRazmer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class zayavkaRazmerController extends Controller
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
        $message = htmlspecialchars($form['message']);

        $entityManager = $this->get('doctrine.orm.default_entity_manager');

        $call = new ZayavkaRazmer();

        $salon = $this->getDoctrine()->getManager()
            ->getRepository('KuhniBundle:Salon')
            ->findOneBy(array('id' => $form['idSalon']));
        $call->setIdSalon($salon);

        $user = $this->getDoctrine()->getManager()
            ->getRepository('ApplicationSonataUserBundle:User')
            ->findOneBy(array('id' => $salon->getIdUser()));

        $call->setPhone($phone);
        $call->setMessage($message);
        $call->setUrl($_SERVER['HTTP_REFERER']);
        $call->setName($name);
        $call->setGeoIP($geo_info);
        $entityManager->persist($call);
        $entityManager->flush();

        $message = \Swift_Message::newInstance()
            ->setSubject('Заявка зов.москва')
            ->setFrom('info@xn--b1ajv.xn--80adxhks')
            ->setTo($user->getEmail())
            ->setBody(
                $this->renderView(
                    'Emails/zayavkaRazmer.html.twig',
                    array(
                        'sender_name' => $name,
                        'created' => new \DateTime(),
                        'geoIP' => $geo_info,
                        'phone' => $phone,
                        'email' => $user->getEmail(),
                        'ref' => $_SERVER['HTTP_REFERER'],
                    )
                ),
                'text/html'
            );
        $this->get('mailer')->send($message);

        $response = json_encode(array('success' => 'success'));
        return new Response($response);
    }
}