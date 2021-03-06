<?php

namespace App\Controller;


use App\customEvent\todoEvent;
use App\Entity\Citizen;
use App\Entity\City;
use App\Entity\Todo;

use App\Form\TodoType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
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
//
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
            ->setTitle('Updated  ,' . $todo->getName());

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
        $this->addFlash(
            'notice',
            'Todo deleted correctly'
        );

        return $this->redirectToRoute('udemy');
    }


    /**
     * @Route("closeTodo/{id}" , name="close_todo")
     */
    public function closeTodo($id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $todo = $entityManager->getRepository(Todo::class)->find($id);
        if (!$todo) {
            throw $this->createNotFoundException(
                'No record for the todo with the id :' . $id
            );
        }
        $todo->setStatus('done');
        $entityManager->flush();
        $this->addFlash(
            'notice',
            "Todo $id upadted correctly"
        );

        return $this->redirectToRoute('udemy');
    }


    /**
     * Edit todo
     * @Route("/todo-edit/{id}" , name="todo")
     */

    public function EditTodo(String $id, Request $request, EventDispatcherInterface $eventDispatcher)
    {
//
//        $eventDispatcher = new EventDispatcher();
        $todo = $this->getDoctrine()->getRepository(Todo::class)->find($id);

        $todoEvent = new \App\customEvents\TodoEvent($todo);
        $eventDispatcher->dispatch(\App\customEvents\TodoEvent::NAME, $todoEvent);


        $form = $this->createForm(TodoType::class);
        $form->setData($todo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $todTmp = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $this->addFlash(
                'notice',
                'Your todo is record'
            );
            $em->persist($todTmp);
            $em->flush();
        }
        return $this->render('udemy/todo.html.twig', array(
            'form' => $form->createView()
        ));
    }


    /**
     * @Route("/relation" , name="Relation")
     */

    public function relation()
    {
        /**
         * one to one relation
         */
        $entityManager = $this->getDoctrine()->getManager();
        /*$user = new User();
        $todo = new Todo();
        $user->setName('Aloui');

        $todo->setName('one to one with user')
            ->setPriority('high')
            ->setStatus('pending')
            ->setCreatedData(new \DateTime())
            ->setDateDue(new \DateTime())
            ->setDescription("Random description")
            ->setUser($user);

        $entityManager->persist($todo);
        $entityManager->flush();*/

        /**
         * many to one
         */
        /*$category = new Category();
        $category->setName('Symfony courses');
        $entityManager->persist($category);
        for ($i = 0; $i < 4; $i++) {
            $product = new Product();
            $product->setName('product ' . $i)
                ->setRelation($category);
            $entityManager->persist($product);
        }*/

        /**
         * many to many
         */

        $city = new City();
        $citizen = new Citizen();

        $city->setName('Tunis')
            ->addCitizen($citizen);

        $citizen->setName('Aloui Mohamed ')
            ->addCity($city);

        $entityManager->persist($city);
        $entityManager->persist($citizen);

        $entityManager->flush();
        return new Response("All went well");
    }
}



