<?php
/**
 * Created by PhpStorm.
 * User: ymoroz
 * Date: 06.03.2019
 * Time: 11:05
 */

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\User;

class UserController extends AbstractFOSRestController
{
    /**
     *  Get All users
     * @Rest\Get("/api/user")
     */
    public function getAction()
    {
        $result = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();
        if ($result === null) {
            //return new View("there are no users exist", Response::HTTP_NOT_FOUND);
            return [];
        }
        return $result;
    }

    /**
     * @Rest\Get("/api/user/{id}")
     */
    public function idAction($id)
    {
        $result = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
        if ($result === null) {
            return new View("User not found.", Response::HTTP_NOT_FOUND);
        }
        return $result;
    }

    /**
     * @Rest\Post("/api/user")
     */
    public function postAction(Request $request)
    {

        $name = $request->get('name');
        $email = $request->get('email');
        $group_id = $request->get('group');

        if (empty($name) || empty($email) || empty($group_id)) {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }

        $group = $this->getDoctrine()->getRepository('AppBundle:Groups')->find($group_id);

        $user = new User;
        $user->setName($name);
        $user->setEmail($email);
        $user->setGroup($group);

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($user);
        $manager->flush();
        return new View("User Added Successfully.", Response::HTTP_CREATED);
    }

    /**
     * @Rest\Delete("/api/user/{id}")
     */
    public function deleteAction($id)
    {
        $manager = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
        if (empty($user)) {
            return new View("User not found.", Response::HTTP_NOT_FOUND);
        } else {
            $manager->remove($user);
            $manager->flush();
        }
        return new View("Deleted successfully.", Response::HTTP_OK);
    }

    /**
     * @Rest\Put("/api/user/{id}")
     */
    public function updateAction($id, Request $request)
    {
        $name = $request->get('name');
        $email = $request->get('email');
        $group_id = $request->get('group');

        $manager = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
        if (empty($user)) {
            return new View("user not found", Response::HTTP_NOT_FOUND);
        } else {

            if (empty($name) || empty($email) || empty($group_id)) {
                return new View("ALL PARAMETERS IS MANDATORY", Response::HTTP_NOT_ACCEPTABLE);
            } else {
                $group = $this->getDoctrine()->getRepository('AppBundle:Groups')->find($group_id);
                $user->setName($name);
                $user->setEmail($email);
                $user->setGroup($group);
                $manager->flush();
                return new View("User Updated Successfully.", Response::HTTP_OK);
            }
        }
    }
}