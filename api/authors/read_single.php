<?php
header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Author.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $post = new Author($db);

  //Get ID

  $post->id = isset($_GET['id']) ? $_GET['id'] : die();

  $post->read_single();

  $post_arr = array(
    'id' => $post ->id,
    
    
    'author' => $post->author,
  );

  print_r(json_encode($post_arr));