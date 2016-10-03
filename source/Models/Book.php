<?php

namespace Models;

use LegionLab\Troubadour\Persistence\Database;
use LegionLab\Utils\Language;
use Respect\Validation\Validator as v;


class Book extends Database
{
    protected $id;
    protected $name;
    protected $price;
    protected $author;

    /**
     * Book constructor.
     * @param null $id
     * @param null $name
     * @param null $price
     * @param null $author
     */
    public function __construct($id = null, $name = null, $price = null, $author = null)
    {
        parent::__construct("books");
        $this
            ->id($id)
            ->name($name)
            ->price($price)
            ->author($author);
    }

    /**
     * @param string $id
     * @return $this
     * @throws \Exception
     */
    public function id($id = "@")
    {
        if($id === "@")
            return $this->id;
        else {
            if(v::intVal()->validate($id) or v::nullType()->validate($id)) {
                $this->id = $id;
            }
            else {
                throw new \Exception(Language::get('book', 'e-id'));
            }
            return $this;
        }
    }

    /**
     * @param string $name
     * @return $this
     * @throws \Exception
     */
    public function name($name = "@")
    {
        if($name === "@")
            return $this->name;
        else {
            if(v::stringType()->validate($name) or v::nullType()->validate($name)) {
                $this->name = $name;
            }
            else {
                throw new \Exception(Language::get('book', 'e-name'));
            }
            return $this;
        }
    }

    /**
     * @param string $price
     * @return $this
     * @throws \Exception
     */
    public function price($price = "@")
    {
        if($price === "@")
            return $this->price;
        else {
            if(v::floatVal()->validate($price) or v::nullType()->validate($price)) {
                $this->price = $price;
            }
            else {
                throw new \Exception(Language::get('book', 'e-price'));
            }
            return $this;
        }
    }

    /**
     * @param string $author
     * @return $this
     * @throws \Exception
     */
    public function author($author = "@")
    {
        if($author === "@")
            return $this->author;
        else {
            if(v::objectType()->validate($author) and $author instanceof Author) {
                $this->author = $author;
            }
            elseif (v::intVal()->validate($author) ||  v::nullType()->validate($author)) {
                $this->author = new Author($author);
                $this->author->get();
            }
            else {
                throw new \Exception(Language::get('book', 'e-author'));
            }
            return $this;
        }
    }

}