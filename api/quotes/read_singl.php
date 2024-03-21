<?php
header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Quote.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $post = new Quote($db);

  //Get ID

  $post->id = isset($_GET['author_id']) ? $_GET['author_id'] : die();

  $post->read_single();

  $post_arr = array(
    'id' => $post ->id,
    'quote' => $post->quote,
    'author_id' => $post->author_id,
    
    'category_id' => $post->category_id,
  );

  print_r(json_encode($post_arr));