<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Data\Todo;

/**
* @Route("/todo")
*/
class TodoController extends AbstractController
{
    /**
     * @Route("/", name="todo_list")
     */
    public function list(Todo $todo)
    {
        return $this->render('todo/list.html.twig', [
            'todos' => $todo->getAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="todo_single")
     */
    public function single($id, Todo $todo)
    {
    	$single = $todo->get($id);

    	if (!$single) {
    		throw $this->createNotFoundException(sprintf('Unable to retrieve todo with id : %s', $id));    		
    	}

        return $this->render('todo/single.html.twig', [
            'todo' => $single,
        ]);
    }
}
