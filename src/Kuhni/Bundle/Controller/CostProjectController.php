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

        $name = htmlspecialchars($request->get('0'));
        $phone = htmlspecialchars($request->get('1'));
        $email = htmlspecialchars($request->get('2'));
        $message = htmlspecialchars($request->get('3'));

        $entityManager = $this->get('doctrine.orm.default_entity_manager');

        $call = new CostProject();

        if (!empty($_FILES)){
            $formFile = $_FILES['files'];
            $nameImage = htmlspecialchars($formFile['name']);
            $sizeImage = htmlspecialchars($formFile['size']);
            $fileImage = htmlspecialchars($formFile['tmp_name']);
            $errorImage = htmlspecialchars($formFile['error']);
            $typeImage = htmlspecialchars($formFile['type']);

            $fileThumbnail = new UploadedFile($fileImage, $nameImage, $typeImage, $sizeImage, $errorImage, true);
            $call->setImageFile($fileThumbnail);
        }else{
            $call->setImageName('');
            $call->setImageSize(0);
        }

        if(isset($_SERVER['HTTP_REFERER'])){
            $call->setUrl($_SERVER['HTTP_REFERER']);
        }else{
            $call->setUrl('none');
        }
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