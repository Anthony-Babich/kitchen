<?php

namespace Kuhni\Bundle\Controller;

use Kuhni\Bundle\Entity\freeDesignProject;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class freeDesignProjectController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        //geoIP
        $ip = $_SERVER['REMOTE_ADDR'];
        $query = @unserialize(file_get_contents('http://ip-api.com/php/' . $ip));
        if ($query && $query['status'] == 'success') {
            $geo_info = $query['country'] . ', ' . $query['city'] . ', ' . $query['isp'] . ', ' . $query['query'];
        } else {
            $geo_info = "Не удалось определить координаты посетителя";
        }

        $form = $request->get('form');
        if ((isset($form['name']))&&(isset($form['phone']))){
            $name = htmlspecialchars($form['name']);
            $phone = htmlspecialchars($form['phone']);
            $email = htmlspecialchars($form['email']);
            $message = htmlspecialchars($form['message']);
        }else{
            return new Response(json_encode(array('success' => 'noData')));
        }

        $entityManager = $this->get('doctrine.orm.default_entity_manager');
        $call = new freeDesignProject();

        if ($_FILES['form']['error']['imageFile']['file'] == 0){
            $formFile = $_FILES['form'];
            $nameImage = htmlspecialchars($formFile['name']['imageFile']['file']);
            $sizeImage = htmlspecialchars($formFile['size']['imageFile']['file']);
            $fileImage = htmlspecialchars($formFile['tmp_name']['imageFile']['file']);
            $errorImage = htmlspecialchars($formFile['error']['imageFile']['file']);
            $typeImage = htmlspecialchars($formFile['type']['imageFile']['file']);

            $fileThumbnail = new UploadedFile($fileImage, $nameImage, $typeImage, $sizeImage, $errorImage, true);
            $call->setImageFile($fileThumbnail);
        }else{
            $call->setImageFile();
            $call->setImageName('');
            $call->setImageSize(0);
        }

        if(isset($_SERVER['HTTP_REFERER'])){
            $call->setUrl($_SERVER['HTTP_REFERER']);
        }else{
            $call->setUrl('none');
        }

        $salon = $this->getDoctrine()->getManager()
            ->getRepository('KuhniBundle:Salon')
            ->findOneBy(array('id' => $form['idSalon']));
        $call->setIdSalon($salon);

        $user = $this->getDoctrine()->getManager()
            ->getRepository('ApplicationSonataUserBundle:User')
            ->findOneBy(array('id' => $salon->getIdUser()));

        $call->setPhone($phone);
        $call->setMessage($message);
        $call->setName($name);
        $call->setEmail($email);
        $call->setGeoIP($geo_info);
        $entityManager->persist($call);
        $entityManager->flush();

        $message = \Swift_Message::newInstance()
            ->setSubject('Заявка зов.москва')
            ->setFrom('info@xn--b1ajv.xn--80adxhks')
            ->setTo($user->getEmail())
            ->setBody(
                $this->renderView(
                    'Emails/freedesignproject.html.twig',
                    array(
                        'sender_name' => $name,
                        'created' => new \DateTime(),
                        'geoIP' => $geo_info,
                        'phone' => $phone,
                        'message' => $message,
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