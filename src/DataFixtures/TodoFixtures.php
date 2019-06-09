<?php

namespace App\DataFixtures;

use App\Entity\Todo;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TodoFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 10; $i < 20; $i++) {
            // set the user
            $user = new User();
            $user->setName('Aloui ' . $i)
                ->setEmail('alouimohamedhabib@yahoo.com' . $i);

            // set the todo
            $todo = new Todo();
            $todo->setTitle("This is another todo with id ".$i)
                ->setDescription("Lorem ipsum dolor simet")
                ->setUser($user)
                ->setStatus('pending')
                ->setCreatedDate(new \DateTime())
                ->setPriority('low')
                ->setDueDate(new \DateTime());
            $user->setTodo($todo);
            $manager->persist($todo);
            $manager->persist($user);

        }
        $manager->flush();
    }
}
