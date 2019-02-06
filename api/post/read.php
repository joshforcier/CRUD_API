<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

$database = new Database();
$db = $database->connect();

$post = new Post($db);

$result = $post->read();
$num = $result->rowcount();

if ($num > 0) {
    $postsArr = array();
    $postsArr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $postItem = array(
            'id' => $id,
            'title' => $title,
            'body' => html_entity_decode($body),
            'author' => $author,
            'category_id' => $category_id,
            '$category_name' => $category_name
        );

        array_push($postsArr['data'], $postItem);
    }

    echo json_encode($postsArr);

} else {
    echo json_encode(
        array('message' => 'No posts found.')
    );
}

