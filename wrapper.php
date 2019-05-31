<?php
    include 'database.php';

    if(!empty($_POST))
    {
        echo '<pre>';
        var_dump($_POST);
        echo '<pre>';
        $result = new stdClass();

        if(!empty($_POST['get']) && $_POST['get'] == 'true')
        {
            if($_POST['table'] == 'user')
            {
                $prepare = $pdo->prepare('SELECT * FROM users WHERE id = :equalTo');
                $data =[
                    "equalTo" => $_POST['equalTo']
                ];
                $prepare->execute($data);
                $user = $prepare->fetchAll();
                if(empty($user))
                {
                    $result->code = '404';
                    $result->content = "No user found";
                } 
                else
                {
                    $result->code = '200';
                    $result->user = $user;
                }
            }

            else if($_POST['table'] == 'party')
            {
                $prepare = $pdo->prepare('SELECT * FROM parties WHERE id = :equalTo');
                $data =[
                    "equalTo" => $_POST['equalTo']
                ];
                $prepare->execute($data);
                $party = $prepare->fetchAll();

                if(empty($party))
                {
                    $result->code = '404';
                    $result->content = "No party found";
                } 
                else
                {
                    $result->code = '200';
                    $result->party = $party;
                }
            }

            else if($_POST['table'] == 'music')
            {
                $prepare = $pdo->prepare('SELECT * FROM musics WHERE id = :equalTo');
                $data =[
                    "equalTo" => $_POST['equalTo']
                ];
                $prepare->execute($data);
                $music = $prepare->fetchAll();
                $prepare->debugDumpParams();

                if(empty($music))
                {
                    $result->code = '404';
                    $result->content = "No music found";
                } 
                else
                {
                    $result->code = '200';
                    $result->music = $music;
                }
            }

            else if($_POST['table'] == 'product')
            {
                $prepare = $pdo->prepare('SELECT * FROM products WHERE id = :equalTo');
                $data =[
                    "equalTo" => $_POST['equalTo']
                ];
                $prepare->execute($data);
                $product = $prepare->fetchAll();

                if(empty($product))
                {
                    $result->code = '404';
                    $result->content = "No product found";
                } 
                else
                {
                    $result->code = '200';
                    $result->product = $product;
                }
            }
        }
        else if(!empty($_POST['post']) && $_POST['post'] == 'true')
        {
            if($_POST['table'] == 'user')
            {
                $prepare = $pdo->prepare('INSERT INTO users (login, password, avatar_id, id_party) VALUES (:login, :password, :avatar_id, :id_party)');
                $data =[
                    "login" => $_POST['login'],
                    "password" => password_hash($_POST['password'], PASSWORD_DEFAULT),
                    "avatar_id" => $_POST['avatar_id'],
                    "id_party" => $_POST['id_party'],
                ];
                $prepare->execute($data);
            }

            else if($_POST['table'] == 'party')
            {
                $prepare = $pdo->prepare('INSERT INTO parties (name, password, time, description, adress, phone) VALUES (:name, :password, :time, :description, :adresse, :telephone)');
                $data =[
                    "name" => $_POST['name'],
                    "password" => password_hash($_POST['password'], PASSWORD_DEFAULT),
                    "time" => strtotime($_POST['time']),
                    "description" => $_POST['description'],
                    "adresse" => $_POST['adresse'],
                    "telephone" => $_POST['telephone']
                ];
                $prepare->execute($data);
            }

            else if($_POST['table'] == 'music')
            {
                $prepare = $pdo->prepare('INSERT INTO musics (id_party, content) VALUES (:id_party, :content)');
                $data =[
                    "id_party" => $_POST['id_party'],
                    "content" => $_POST['content']
                ];
                $prepare->execute($data);
            }

            else if($_POST['table'] == 'product')
            {
                $prepare = $pdo->prepare('INSERT INTO products (id_party, content) VALUES (:id_party, :content)');
                $data =[
                    "id_party" => $_POST['id_party'],
                    "content" => $_POST['content']
                ];
                $prepare->execute($data);
            }
        }

        echo '<pre>';
        var_dump($result);
        echo '<pre>';
    }
    else
    {
        $result->code = '400';
        $result->content = "bad request";
        echo '<pre>';
        var_dump($result);
        echo '<pre>';
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Get content</h1>
    <form action="#" method="post">
        <input type="type" name="get" id="" value="true" readonly="readonly">
        <input type="text" name="table" id="" placeholder="table">
        <input type="text" name="equalTo" id="" placeholder="equalTo">
        <input type="submit" value="crawl">
    </form>

    <h1>Put user</h1>
    <form action="#" method="post">
        <input type="type" name="post" id="" value="true" readonly="readonly">
        <input type="text" name="table" id="" value="user" readonly="readonly">
        <input type="text" name="login" id="" placeholder="login">
        <input type="text" name="password" id="" placeholder="password">
        <input type="number" name="avatar_id" id="" placeholder="id avatar">
        <input type="text" name="id_party" id="" placeholder="id party">
        <input type="submit" value="put user">
    </form>

    <h1>Put party</h1>
    <form action="#" method="post">
        <input type="type" name="post" id="" value="true" readonly="readonly">
        <input type="text" name="table" id="" value="party" readonly="readonly">
        <input type="text" name="name" id="" placeholder="name">
        <input type="text" name="password" id="" placeholder="password">
        <input type="date" name="time" id="" placeholder="time">
        <input type="text" name="description" id="" placeholder="description">
        <input type="text" name="adresse" id="" placeholder="adresse">
        <input type="number" name="telephone" id="" placeholder="telephone">
        <input type="submit" value="put party">
    </form>

    <h1>Put music</h1>
    <form action="#" method="post">
        <input type="type" name="post" id="" value="true" readonly="readonly">
        <input type="text" name="table" id="" value="music" readonly="readonly">
        <input type="text" name="id_party" id="" placeholder="id party">
        <input type="text" name="content" id="" placeholder="json content">
        <input type="submit" value="put music">
    </form>

    <h1>Put products</h1>
    <form action="#" method="post">
        <input type="type" name="post" id="" value="true" readonly="readonly">
        <input type="text" name="table" id="" value="product" readonly="readonly">
        <input type="text" name="id_party" id="" placeholder="id party">
        <input type="text" name="content" id="" placeholder="json content">
        <input type="submit" value="put product">
    </form>
</body>
</html>