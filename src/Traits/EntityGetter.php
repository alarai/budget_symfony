<?php

namespace App\Traits;

trait EntityGetter
{
    public function getEntity($id, $class)
    {
        if ($id !== null) {
            $entity = $this->repository->find($id);
        } else {
            $entity = new $class();
        }

        return $entity;
    }
}
