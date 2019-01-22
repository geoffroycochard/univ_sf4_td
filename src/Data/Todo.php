<?php
namespace App\Data;

class Todo
{
    private $todos = [
        1 => [
            'title' => 'todo1',
            'description' => 'description1'
        ],
        2 => [
            'title' => 'todo2',
            'description' => 'description2'
        ],
        3 => [
            'title' => 'todo3',
            'description' => 'description3'
        ],
    ];

    public function getAll()
    {
        return $this->todos;
    }

    public function get($id)
    {
        if (!array_key_exists($id, $this->todos)) {
            return false;
        }

        return $this->todos[$id];
    }

}