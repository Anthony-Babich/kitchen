<?php

namespace Kuhni\Bundle\Controller;

use Kuhni\Bundle\Entity\CostProject;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CostProjectController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function indexAction(Request $request){
        //geoIP
        $ip = $_SERVER['REMOTE_ADDR'];
        $query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
        if($query && $query['status'] == 'success') {
            $geo_info = $query['country'].', '.$query['city'].', '.$query['isp'].', '.$query['query'];
        } else { $geo_info = "Не удалось определить координаты посетителя"; }

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

        $call = new CostProject();

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

        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('id' => $form['idSalon']));
        $call->setIdSalon($user);

        $call->setPhone($phone);
        $call->setMessage($message);
        $call->setName($name);
        $call->setEmail($email);
        $call->setGeoIP($geo_info);
        $entityManager->persist($call);
        $entityManager->flush();

        return new Response(json_encode(array('success' => 'success')));
    }
}