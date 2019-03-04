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
    public function user($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('App\Entity\User')->find($id);
        $conversations = $em->getRepository('App\Entity\Conversation')->findBy(array("creator" => $user->getId()));
        if (empty($user)) {
            return new View(array("code" => 404, "message" => "User can not be found"), Response::HTTP_NOT_FOUND);
        }
        if (count($conversations) == 0) {
            return View::create(array("user" => $user, "conversations" => 0), Response::HTTP_OK, []);
        }
        else
        {
            return View::create(array("user" => $user, "conversations" => $conversations), Response::HTTP_OK, []);
        }
    }
}