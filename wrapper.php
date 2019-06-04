<?php
    include 'database.php';

    error_log('post value = '.json_encode($_POST), 0);

    $result = new stdClass();
    
    if(!empty($_POST))
    {

        if(!empty($_POST['get']) && $_POST['get'] == 'true')
        {
            error_log('tabke value = '.json_encode($_POST['table']), 0);
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
            error_log('tabke value = '.json_encode($_POST['table']), 0);
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
                error_log('time value = '.json_encode($data['time']), 0);
                $error = $prepare->execute($data);
                error_log('db value = '.print_r($error), 0);
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

        
        echo json_encode($result);
        
    }
    else
    {
        $result->code = '400';
        $result->content = "bad request";
        
        echo json_encode($result);
        
    }
?>
