<?php

class Post
{
    private $dgh;

    function __construct()
    {
        $dbname = 'test_db';
        $user = 'root';
        $pass = 'pass';
        $this->dbh = new PDO('mysql:host=localhost;dbname=' . $dbname, $user, $pass);


    }

    public function add($title, $content)
    {
        $sth = $this->dbh->prepare("INSERT INTO posts (title, content) VALUES (:title, :content)");
        $sth->execute(array(
            'title' => $title,
            'content' => $content,
        ));
    }

}

