<?php

use LegionLab\Troubadour\Persistence\Migration;
use LegionLab\Troubadour\Collections\Settings;

$table = new Migration();

$table
    ->database(Settings::get('default_dbname'))
    ->name('authors')
    ->column('id','int', 11, false)
    ->pk('id')
	->autoincrement('id')
    ->column('name', 'varchar', 50, false)
    ->column('age', 'int', 3)
    ->make();

$table
    ->clear()
    ->database(Settings::get('default_dbname'))
    ->name('books')
    ->column('id','int', 11, false)
    ->pk('id')
	->autoincrement('id')
    ->column('name', 'varchar', 50, false)
    ->column('price', 'double', 0)
    ->column('author', 'int', 11, false)
    ->addFK('author', array('authors', 'id'))
    ->make();

/*
* To insert default data in database, use:
*
* $d_model = new DefaultModel(); | Instace of default model
*
* Verify if table is empty
* $result = $d_model->sql("SELECT COUNT(*) as cnt FROM category;")[0]['cnt'];
*
* if($result <= 1) | if is empty
* {
*    run this sql, array() is params  to bind, false to development
*    $d_model->sql
*    (
*        "SQL Query", array(), false
*    );
* }
*/
