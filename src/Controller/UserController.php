<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 04/03/2019
 * Time: 14:55
 */

namespace App\Controller;
use FOS\RestBundle\View\View;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;

class UserController extends AbstractController
{
    public function usersShow()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('App\Entity\User')->findAll();

        if (empty($users)) {
            return new View(array("code" => 404, "message" => "User can not be found"), Response::HTTP_NOT_FOUND);
        }
        return View::create($users, Response::HTTP_OK, []);
    }
}