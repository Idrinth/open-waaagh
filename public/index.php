<?php

use De\Idrinth\WAAAGHde\Application;
use De\Idrinth\WAAAGHde\Home;
use De\Idrinth\WAAAGHde\Post;
use Twig\Loader\FilesystemLoader;

require dirname(__DIR__) . '/vendor/autoload.php';

(new Application())
    ->register(new PDO('mysql:host=' . $_ENV['DATABASE_HOST'] . ';dbname=' . $_ENV['DATABASE_DATABASE'], $_ENV['DATABASE_USER'], $_ENV['DATABASE_PASSWORD']))
    ->register(new FilesystemLoader(dirname(__DIR__) . '/templates'))
    ->get('/', Home::class)
    ->get('/{slug}', Post::class)
    ->run();