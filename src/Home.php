<?php

namespace De\Idrinth\WAAAGHde;

use PDO;

class Home
{
    private PDO $database;
    private Twig $twig;

    public function __construct(PDO $database, Twig $twig) {
        $this->database = $database;
        $this->twig = $twig;
    }

    public function run(): string
    {
        $stmt = $this->database->query("SELECT wa_posts.post_date_gmt,wa_posts.post_excerpt,wa_posts.post_title,wa_users.display_name AS author,wa_posts.post_name AS slug
FROM wa_posts
LEFT JOIN wa_users ON wa_users.ID=wa_posts.post_author
WHERE wa_posts.post_status='publish'
AND wa_posts.post_type='post'
ORDER BY wa_posts.post_date_gmt DESC");
        return $this->twig->render('home', ['title' => 'Home', 'posts' => $stmt->fetchAll(PDO::FETCH_ASSOC)]);
    }
}
