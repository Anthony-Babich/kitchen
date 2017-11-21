<?php

namespace Kuhni\Bundle\Controller;

use Kuhni\Bundle\Entity\DesignProjectShag;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DesignProjectShagController extends Controller
{
    public function indexAction(Request $request){
        //geoIP
        $ip = $_SERVER['REMOTE_ADDR'];
        $query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
        if($query && $query['status'] == 'success') {
            $geo_info = $query['country'].', '.$query['city'].', '.$query['isp'].', '.$query['query'];
        } else { $geo_info = "Не удалось определить координаты посетителя"; }

        $form = $request->get('form');
        $polisity = htmlspecialchars($request->get('privacy-politycs'));
        if ((isset($form['name']))&&(isset($form['phone']))&&(!empty($polisity))){
            $name = htmlspecialchars($form['name']);
            $phone = htmlspecialchars($form['phone']);
            $email = htmlspecialchars($form['email']);
            $style = htmlspecialchars($request->get('kitchen-style'));
            $config = htmlspecialchars($request->get('kitchen-config'));
        }else{
            return new Response(json_encode(array('success' => 'noData')));
        }

        $entityManager = $this->get('doctrine.orm.default_entity_manager');

        $salon = $this->getDoctrine()->getManager()
            ->getRepository('KuhniBundle:Salon')
            ->findOneBy(array('id' => $form['idSalon']));

        $user = $this->getDoctrine()->getManager()
            ->getRepository('ApplicationSonataUserBundle:User')
            ->findOneBy(array('id' => $salon->getIdUser()));

        $call = new DesignProjectShag();
        $call->setIdSalon($salon);
        $call->setPhone($phone);
        $call->setEmail($email);
        $call->setName($name);
        $call->setConfig($config);
        $call->setStyle($style);
        $call->setUrl($_SERVER['HTTP_REFERER']);
        $call->setGeoIP($geo_info);
        $entityManager->persist($call);
        $entityManager->flush();

        $message = \Swift_Message::newInstance()
            ->setSubject('Заявка зов.москва')
            ->setFrom('info@xn--b1ajv.xn--80adxhks')
            ->setTo($user->getEmail())
            ->setBody(
                $this->renderView(
                    'Emails/freedesignshag.html.twig',
                    array(
                        'sender_name' => $name,
                        'created' => new \DateTime(),
                        'geoIP' => $geo_info,
                        'phone' => $phone,
                        'styleKitchen' => $style,
                        'configKitchen' => $config,
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