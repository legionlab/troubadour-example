<?php

/**
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 25/07/2016
 * Time: 12:48
 */
namespace Controllers;

use LegionLab\Troubadour\Control\Controller;
use LegionLab\Troubadour\Control\Errors;
use LegionLab\Utils\Language;
use LegionLab\Utils\Post;
use Models\Author;

class AuthorController extends Controller
{
    public function homeDeed()
    {
        $this
            ->title( Language::get('author', 't-home') )
            ->attr( 'authors', $this->toArray( (new Author())->listAll() ) )
            ->display();
    }

    public function createDeed()
    {
        $this
            ->title( Language::get('author', 't-create') )
            ->display();
    }

    public function createPosted()
    {
        try {
            $author = new Author(Post::get('id'), Post::get('name'), Post::get('age'));

            $author->insert(function() {
                $this->to('Author', 'home');
            }, function() {
                Errors::display(Language::get('author', 'e-create'), $_SERVER['HTTP_REFERER']);
            });

        } catch (\Exception $e) {
            Errors::display($e->getMessage(), $_SERVER['HTTP_REFERER']);
        }
    }

    public function editDeed()
    {
        $this->param(0, function($success) {
            $this
                ->title(Language::get('author', 't-edit'))
                ->view('author', 'create')
                ->attr('author', (new Author($success))->get())
                ->display();
        }, function($error) {
            Errors::display(Language::get('global', 'notfound'), $_SERVER['HTTP_REFERER']);
        });
    }

    public function editPosted()
    {
        try {
            $author = new Author(Post::get('id'), Post::get('name'), Post::get('age'));

            $author->update('id', function() {
                $this->to('Author', 'home');
            }, function() {
               Errors::display(Language::get('author', 'e-edit'), $_SERVER['HTTP_REFERER']);
            });

        } catch (\Exception $e) {
            Errors::display($e->getMessage(), $_SERVER['HTTP_REFERER']);
        }
    }

    public function deleteDeed()
    {
        try {

            $this->param(0, function($success) {
                $author = new Author($success);

                $author->delete('id', function()
                {
                    $this->to('Author', 'home');
                }, function()
                {
                    Errors::display(Language::get('author', 'e-delete'), $_SERVER['HTTP_REFERER']);
                });
            }, function($error) {
                Errors::display(Language::get('global', 'notfound'), $_SERVER['HTTP_REFERER']);
            });



        } catch (\Exception $e) {
            Errors::display($e->getMessage(), $_SERVER['HTTP_REFERER']);
        }
    }
}
