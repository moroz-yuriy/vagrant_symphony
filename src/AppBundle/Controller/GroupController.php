<?php
/**
 * Created by PhpStorm.
 * User: ymoroz
 * Date: 06.03.2019
 * Time: 12:44
 */

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Groups;

class GroupController extends AbstractFOSRestController
{
    /**
     *  Get All group
     * @Rest\Get("/api/group")
     */
    public function getAction()
    {
        $result = $this->getDoctrine()->getRepository('AppBundle:Groups')->findAll();
        if ($result === null) {
            return [];
        }
        return $result;
    }

    /**
     * @Rest\Get("/api/group/{id}")
     */
    public function idAction($id)
    {
        $result = $this->getDoctrine()->getRepository('AppBundle:Groups')->find($id);
        if ($result === null) {
            return new View("Group not found.", Response::HTTP_NOT_FOUND);
        }
        return $result;
    }

    /**
     * @Rest\Post("/api/group")
     */
    public function postAction(Request $request)
    {
        $data = new Groups();
        $name = $request->get('name');

        if (empty($name)) {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }
        $data->setName($name);

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($data);
        $manager->flush();
        return new View("Group Added Successfully.", Response::HTTP_CREATED);
    }

    /**
     * @Rest\Delete("/api/group/{id}")
     */
    public function deleteAction($id)
    {
        $manager = $this->getDoctrine()->getManager();
        $group = $this->getDoctrine()->getRepository('AppBundle:Groups')->find($id);

        if (empty($group)) {
            return new View("Group not found.", Response::HTTP_NOT_FOUND);
        } else {
            $manager->remove($group);
            $manager->flush();
        }
        return new View("Deleted successfully.", Response::HTTP_OK);
    }

    /**
     * @Rest\Put("/api/group/{id}")
     */
    public function updateAction($id, Request $request)
    {
        $name = $request->get('name');

        $manager = $this->getDoctrine()->getManager();
        $group = $this->getDoctrine()->getRepository('AppBundle:Groups')->find($id);

        if (empty($group)) {
            return new View("user not found", Response::HTTP_NOT_FOUND);
        } else {

            if (!empty($name)) {
                $group->setName($name);
                $manager->flush();
                return new View("Group Updated Successfully.", Response::HTTP_OK);
            } else {
                return new View("ALL PARAMETERS IS MANDATORY", Response::HTTP_NOT_ACCEPTABLE);
            }
        }
    }

    /**
     * @Rest\Get("/api/group/{id}/user")
     */
    public function usersInGroupAction($id)
    {
        $result = $this->getDoctrine()->getRepository('AppBundle:Groups')->find($id);
        if ($result === null) {
            return [];
        }
        return $result->getUsers();
    }

}