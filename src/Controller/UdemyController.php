<?php

namespace App\Controller;


use App\Entity\Todo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UdemyController extends AbstractController
{
    /**
     * @Route("/udemy", name="udemy")
     */
    public function index()
    {

        $em = $this->getDoctrine()->getManager();
        $todo = new Todo();
        $todo->setName("publish YouTube videos")
            ->setPriority("Low")
            ->setStatus("in progress");

        $em->persist($todo);
        $em->flush();

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UdemyController.php',
        ]);
    }

    /**
     * load todos from databases
     * @Route("/todo/{name}" , name="todo")
     */

    public function todo(String $name)
    {
        return $this->render('udemy/todo.html.twig', array(
            'name' => $name
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



}
