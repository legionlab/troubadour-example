<?php
namespace Controllers;

use LegionLab\Troubadour\Control\Controller;
use LegionLab\Troubadour\Control\Errors;
use LegionLab\Utils\Language as lang;
use LegionLab\Utils\Post;
use Models\Author;
use Models\Book;

class BookController extends Controller
{
    public function homeDeed()
    {
        $this
            ->title(lang::get('book', 't-home'))
            ->attr('books', $this->toArray((new Book())->listAll()))
            ->display();
    }

    public function createDeed()
    {
        $this
            ->title(lang::get('book', 't-create'))
            ->attr('authors', $this->toArray((new Author())->listAll()))
            ->display();
    }

    public function createPosted()
    {
        try {
            $book = new Book(null, Post::get('name'), Post::get('price'), Post::get('author'));
            $book->insert(function() {
                $this->to('Book', 'home');
            }, function() {
                Errors::display(lang::get('book', 'e-create'), $_SERVER['HTTP_REFERER']);
            });
        } catch (\Exception $e) {
            Errors::display($e->getMessage(), $_SERVER['HTTP_REFERER']);
        }
    }

    public function editDeed()
    {
        $this->param(0, function($success) {
            $this
                ->view('book', 'create')
                ->title(lang::get('book', 't-edit'))
                ->attr('authors', $this->toArray((new Author())->listAll()))
                ->attr('book', (new Book($success))->get())
                ->display();
        }, function($error) {
            Errors::display(lang::get('global', 'notfound'), $_SERVER['HTTP_REFERER']);
        });

    }

    public function editPosted()
    {
        try {
            $this->param(0, function($success) {
                $book = new Book(Post::get('id'), Post::get('name'), Post::get('price'), Post::get('author'));

                $book->update('id', function() {
                    $this->to('Book', 'home');
                }, function() {
                    Errors::display(lang::get('book', 'e-edit'), $_SERVER['HTTP_REFERER']);
                });

            }, function($error) {
                Errors::display(lang::get('global', 'notfound'), $_SERVER['HTTP_REFERER']);
            });

        } catch (\Exception $e) {
            Errors::display($e->getMessage(), $_SERVER['HTTP_REFERER']);
        }
    }

    public function deleteDeed()
    {
        try {

            $this->param(0, function($success) {
                $book = new Book($success);

                $book->delete('id', function()
                {
                    $this->to('Book', 'home');
                }, function()
                {
                    Errors::display(lang::get('book', 'e-delete'), $_SERVER['HTTP_REFERER']);
                });
            }, function($error) {
                Errors::display(lang::get('global', 'notfound'), $_SERVER['HTTP_REFERER']);
            });

        } catch (\Exception $e) {
            Errors::display($e->getMessage(), $_SERVER['HTTP_REFERER']);
        }
    }

}