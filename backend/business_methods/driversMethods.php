<?php

require_once 'DriversRepository.php';

function getAllDrivers($connection){
    $driversRepository = new DriversRepository($connection);

    $allDrivers = json_encode($driversRepository->getAllDrivers());

    print_r($allDrivers);
}
function getDriverById($connection,$id){

    $driversRepository = new DriversRepository($connection);
    $driver = $driversRepository->getDriverById($id);
    if($driver){
        echo(json_encode($driver));
    }else{
        http_response_code(404);
        $res = [
          'status' => false,
          'message' => "Driver not found",
        ];
        echo(json_encode($res));
    }
}
function createDriver($connection, $data)
{
    $driversRepository = new DriversRepository($connection);
    $driver = $driversRepository->createDriver($data);
    if($driver === 'Неверные данные'){
        $res = [
          'status' => false,
          'message' => 'Bad Request',
        ];
        http_response_code(400);
        echo(json_encode($res));
    }else if($driver === 'Введите уникальный номер телефона'){
        $res = [
            'status' => false,
            'message' => 'Enter unique phone number'
        ];
        http_response_code(400);
        echo(json_encode($res));
    }else{
        $id = json_decode($driver);
        $res = [
            'status' => true,
            'message' => "Водителей добавлен под номером $id"
        ];
        http_response_code(201);
        echo(json_encode($res));
    }
}
function updateDriver($connection,$data,$id)
{
    $driversRepository = new DriversRepository($connection);
    $driver = $driversRepository->updateDriver($data,$id);
    if($driver === 'Неверные данные'){
        $res = [
            'status' => false,
            'message' => 'Driver not found'
        ];
        http_response_code(404);
        echo(json_encode($res));
    }else if($driver === 'Введите уникальный номер телефона'){
        $res = [
            'status' => false,
            'message' => 'Enter unique phone number'
        ];
        http_response_code(400);
        echo(json_encode($res));
    }else{
        $id = json_decode($driver);
        $res = [
            'status' => true,
            'message' => "Driver $id updated"
        ];
        echo(json_encode($res));
    }
}
function deleteDriver($connection,$id)
{
    $driverRepository = new DriversRepository($connection);
    $driver = $driverRepository->deleteDriver($id);
    if($driver === 'Водитель не найден'){
        $res = [
          'status' => false,
          'message' => "Driver not fount"
        ];
        http_response_code('404');
        echo(json_encode($res));
    }else{
        $res = [
          'status' => true,
          'message' => "Driver $id deleted"
        ];
        echo (json_encode($res));
    }
}



















//function getPosts($connect){
//    $posts = pg_query($connect,"SELECT * FROM posts");
//    $postsList = [];
//    while($post = pg_fetch_assoc($posts)){
//        $postsList[] = $post;
//    }
//    print_r(json_encode($postsList));
//}
//function getPost($connect,$id){
//    $post = pg_query($connect,"SELECT * FROM posts WHERE id = $id");
//    if(pg_num_rows($post) === 0){
//        http_response_code(404);
//        $res = [
//            'status' => false,
//            'message' => 'Post not found'
//        ];
//        echo json_encode($res);
//    }else{
//        $post = pg_fetch_assoc($post);
//        echo json_encode($post);
//    }
//}
//function addPosts($connect,$data){
//    $title = $data['title'];
//    $description = $data['description'];
//    http_response_code(201);
//    $query = "INSERT INTO posts (title, description) VALUES ($1, $2) RETURNING id";
//    $result = pg_query_params($connect, $query, array($title, $description));
//    if(pg_num_rows($result) === 0){
//        http_response_code(400);
//        $res = [
//
//            'status' => false,
//            'message' => 'Bad request'
//        ];
//        echo json_encode($res);
//        return;
//    }
//    $row = pg_fetch_assoc($result);
//    $post_id = $row['id'];
//    $res = [
//        'status' => true,
//        'Post_id' => $post_id,
//    ];
//    echo json_encode($res);
//}
function updatePosts($connect,$data,$id){
    if (empty($data['title']) || empty($data['description'])) {
        http_response_code(400);
        $res = [
            'status' => false,
            'message' => 'Title and description are required'
        ];
        echo json_encode($res);
        return;
    }
    $post = pg_query($connect,"SELECT * FROM posts WHERE id = $id");
    if(pg_num_rows($post) === 0){
        $res = [
            'status' => false,
            'message' => 'Post not found'
        ];
        echo json_encode($res);
        return;
    }
    $title = $data['title'];
    $description = $data['description'];
    $query = "UPDATE posts SET title = $1, description = $2 WHERE id = $3";
    $result = pg_query_params($connect, $query, array($title, $description, $id));
    if(!$result){
        http_response_code(500);
        $res = [
          'status' => false,
          'message' => "Server_error"
        ];
        echo json_encode($res);
        return;
    }

    http_response_code(200);
    $res = [
        'status' => true,
        'message' => 'Post_is_updated'
    ];
    echo json_encode($res);
}
function deletePost($connect,$id){
    $query = "DELETE FROM posts WHERE id = $1";
    $result = pg_query_params($connect, $query, array($id));
    $rows_affected = pg_affected_rows($result);
    if ($rows_affected === 0) {

        http_response_code(404);
        echo json_encode(['status' => false, 'message' => 'Post not found']);
        return;
    }
    if (!$result) {
        http_response_code(500);
        echo json_encode(['status' => false, 'message' => 'Failed to delete post: ' . pg_last_error($connect)]);
        return;
    }
    http_response_code(200);
    echo json_encode(['status' => true, 'message' => 'Post deleted successfully']);
}
