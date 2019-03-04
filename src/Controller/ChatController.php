<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 04/03/2019
 * Time: 15:35
 */

namespace App\Controller;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Conversation;
use App\Entity\Message;

class ChatController extends AbstractController
{
    public function addConversation(Request $request)
    {
        $conversation = new Conversation();
        $title = $request->get('title');
        $creator = $this->getUser();
        $send_to = $this->getDoctrine()->getRepository('App\Entity\User')->find($request->get('send_to'));
        $date = new \DateTime();
        if ($this->conversationExist($creator->getId(),$send_to->getId())) {
            $conversation = $this->getDoctrine()->getRepository('App\Entity\Conversation')->findBy(array('creator' => $creator->getId(), 'send_to' => $send_to->getId()));
            return View::create($conversation, Response::HTTP_CREATED, []);
        }
        else
        {
            if(empty($title))
            {
                return View::create(array("code" => 406, "message" => "NULL VALUES ARE NOT ALLOWED"), Response::HTTP_NOT_ACCEPTABLE);
            }
            else {
                $conversation->setTitle($title);
                $conversation->setCreatedAt($date);
                $conversation->setCreator($creator);
                $conversation->setSendTo($send_to);

                $em = $this->getDoctrine()->getManager();
                $em->persist($conversation);
                $em->flush();

                return View::create($conversation, Response::HTTP_CREATED, []);
            }
        }
    }

    public function addMessage(Request $request)
    {
        $message = new Message();
        $content = $request->get('content');
        $conversation = $this->getDoctrine()->getRepository('App\Entity\Conversation')->find($request->get('conversation'));
        $sender = $this->getUser();
        $date = new \DateTime();

        if(empty($content) && empty($conversation))
        {
            return View::create(array("code" => 406, "message" => "NULL VALUES ARE NOT ALLOWED"), Response::HTTP_NOT_ACCEPTABLE);
        }
        else {
            $message->setContent($content);
            $message->setConversation($conversation);
            $message->setCreatedAt($date);
            $message->setSender($sender);

            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            return View::create($message, Response::HTTP_CREATED, []);
        }
    }
    public function conversationExist($idCreator,$idTo)
    {
        $criteria = array('creator' => $idCreator, 'send_to' => $idTo);
        $conversation = $this->getDoctrine()->getRepository('App\Entity\Conversation')->findOneBy($criteria);
        return (!empty($conversation))?true:false;
    }
}