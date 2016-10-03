<?php

namespace Models;

use LegionLab\Troubadour\Persistence\Database;
use Respect\Validation\Validator as v;
use LegionLab\Utils\Language;

class Author extends Database
{
    protected $id;
    protected $name, $age;

    /**
     * Author constructor.
     * @param null $id
     * @param null $name
     * @param null $age
     */
    public function __construct($id = null, $name = null, $age = null)
    {
        parent::__construct('authors');
        $this
            ->id($id)
            ->name($name)
            ->age($age);
    }

    /**
     * @param string $id
     * @return $this
     * @throws \Exception
     */
    public function id($id = '@')
    {
        if($id !== '@') {
            if(v::intVal()->validate($id) or v::nullType()->validate($id))
                $this->id = $id;
            else
                throw new \Exception(Language::get('author', 'e-id'));
            return $this;
        } else {
            return $this->id;
        }
    }

    /**
     * @param string $name
     * @return $this
     * @throws \Exception
     */
    public function name($name = '@')
    {
        if($name !== '@') {
            if(v::stringType()->validate($name) or v::nullType()->validate($name))
                $this->name = $name;
            else
                throw new \Exception(Language::get('author', 'e-name'));
            return $this;
        } else {
            return $this->name;
        }
    }

    /**
     * @param string $age
     * @return $this
     * @throws \Exception
     */
    public function age($age = '@')
    {
        if($age !== '@') {
            if(v::intVal()->validate($age) or v::nullType()->validate($age))
                $this->age = $age;
            else
                throw new \Exception(Language::get('author', 'e-age'));
            return $this;
        } else {
            return $this->age;
        }
    }



}
