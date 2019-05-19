<?php

namespace App\Controller;


use App\Entity\Todo;
use App\Form\TodoType;

use mysql_xdevapi\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UdemyController extends AbstractController
{
    /**
     * @Route("/", name="udemy")
     */
    public function index()
    {

        $em = $this->getDoctrine()->getManager();
        $todos = $em->getRepository(Todo::class)->findAll();

        return $this->render('udemy/index.html.twig', [
            'todos' => $todos,
        ]);
    }

    /**
     * load todos from databases
     * @Route("/add" , name="add-todo")
     */

    public function todo(Request $request)
    {

        $form = $this->createForm(TodoType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try {

                $todTmp = $form->getData();

                $em = $this->getDoctrine()->getManager();

                $this->addFlash(
                    'notice',
                    'Your todo is record'
                );

                $em->persist($todTmp);
                $em->flush();

            } catch (\Exception $Exception) {

            }
        }
        return $this->render('udemy/todo.html.twig', array(

            'form' => $form->createView()
        ));
    }


    /**
     * @Route("/udemy/details" , name="todo_details")
     */

    public function getDetails()
    {
        $todo = $this->getDoctrine()->getRepository(Todo::class)->findByName('YouTube');

        if (!$todo) {
            throw $this->createNotFoundException(
                'No record for the todo with the id :' . 10
            );
        }
        for ($x = 0; $x < count($todo); $x++) {
            echo "<p>", $todo[$x]->getName(), "<p>";
        }
        return new Response('we have this todo;: ');
    }


    /**
     * @Route("/updatetodo/{id}" , name="update_todo")
     */

    public function updateTodo($id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $todo = $entityManager->getRepository(Todo::class)->find($id);

        if (!$todo) {
            throw $this->createNotFoundException(
                'No record for the todo with the id :' . $id
            );
        }
        // update the fields
        $todo->setPriority('Medium')
            ->setName('Updated  ,' . $todo->getName());

        $entityManager->flush();

        return new Response('we have this todo;: ', $id);

    }

    /**
     * @Route("deletetodo/{id}" , name="delete_todo")
     */
    public function deleteTodo($id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $todo = $entityManager->getRepository(Todo::class)->find($id);
        if (!$todo) {
            throw $this->createNotFoundException(
                'No record for the todo with the id :' . $id
            );
        }
        $entityManager->remove($todo);
        $entityManager->flush();
        return new Response("Todo with $id is removed correctly!");
    }

    /**
     * Edit todo
     * @Route("/todo-edit/{id}" , name="todo")
     */

    public function EditTodo(String $id, Request $request)
    {

        $todo = $this->getDoctrine()->getRepository(Todo::class)->find($id);

        $form = $this->createForm(TodoType::class);
        $form->setData($todo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $todTmp = $form->getData();

            $em = $this->getDoctrine()->getManager();


            $em->persist($todTmp);
            $em->flush();
        }
        return $this->render('udemy/todo.html.twig', array(

            'form' => $form->createView()
        ));
    }
}



