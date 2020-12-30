<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app = new \Slim\App();

$app->add(function ($request, $response, $next) {

    session_start();
    // if ($_SESSION['user']) {
    //     echo 'session called';
    //     $result = array();
    //     $result['success'] = 'true';
    //     $response->getBody()->write(json_encode($result));
    //     return  $response->withHeader('Content-type', 'application/json');
    // } else {
    //     $response = $next($request, $response);
    //     return $response;
    // }

    $response = $next($request, $response);
    return $response;
});


//Add customer
$app->post('/auth/login', function (Request $req, Response $res) {

    $parsedBody = $req->getParsedBody();


    $username = $parsedBody['username'];
    $email = $parsedBody['email'];
    $password = $parsedBody['password'];


    $result = array();

    if ((strlen($username) > 0 || strlen($email) > 0) && strlen($password) > 0) {

        $sql = "";

        if (strlen($username)) {
            $sql = "SELECT * FROM user WHERE username = '$username' ";
        } else {
            $email = "SELECT * FROM user WHERE username = '$email' ";
        }

        try {
            $db = new Db();
            $db = $db->connect();

            $stmt = $db->query($sql);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);



            if ($user) {

                if ($user["password"] == $password) {
                    $_SESSION['user'] = $user["email"];

                    $sql = "SELECT * FROM user";
                    $stmt = $db->prepare($sql);
                    $stmt->execute();

                    $user_arr = array();
                    $user_arr['data'] = array();

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);

                        $user = array(
                            'id' => $id,
                            'name' => $name,
                            'username' => $username,
                            'email' => $email
                        );

                        // Push to "data"
                        array_push($user_arr['data'], $user);
                    }

                    $res->getBody()->write(json_encode($user_arr));
                    return  $res->withHeader('Content-type', 'application/json');
                } else {
                    $result['success'] = 'false';
                    $res->getBody()->write(json_encode($result));
                    return  $res->withHeader('Content-type', 'application/json');
                }
            } else {
                $result['success'] = 'false';
                $res->getBody()->write(json_encode($result));
                return  $res->withHeader('Content-type', 'application/json');
            }


            $db = null;
        } catch (PDOException $e) {
            echo '{"error" : {"text" : ' . $e->getMessage() . ' }}';
        }
    } else {
        $result['success'] = 'false';
        $res->getBody()->write(json_encode($result));
        return  $res->withHeader('Content-type', 'application/json');
    }
});


// piumika@omobio.net
//Clearly mention - Your Name| University| Practical Test Date