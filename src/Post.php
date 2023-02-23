<?php

namespace De\Idrinth\WAAAGHde;

use PDO;

class Post
{
    private PDO $database;
    private Twig $twig;

    public function __construct(PDO $database, Twig $twig) {
        $this->database = $database;
        $this->twig = $twig;
    }

    public function run($post, $slug): string
    {
        $stmt = $this->database->prepare("SELECT wa_posts.ID,wa_posts.post_date_gmt,wa_posts.post_content,wa_posts.post_title,wa_users.display_name AS author
FROM wa_posts
LEFT JOIN wa_users ON wa_users.ID=wa_posts.post_author
WHERE wa_posts.post_status='publish'
AND wa_posts.post_type='post'
AND wa_posts.post_name=:slug");
        $stmt->execute([':slug' => $slug]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$data) {
            header('Location: /', true, 303);
            return;
        }
        $stmt = $this->database->prepare('SELECT comment_author,comment_author_url,comment_date_gmt,comment_content
FROM wa_comments
WHERE wa_comments.comment_post_ID=:id
AND comment_approved=1');
        $stmt->execute([':id' => $data['ID']]);
        return $this->twig->render('home', ['post' => $data, 'comments' => $stmt->fetchAll(PDO::FETCH_ASSOC)]);
    }
}
