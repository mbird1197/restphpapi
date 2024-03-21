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

  $post->quote = isset($_GET['quote']) ? $_GET['quote'] : die();

  $post->read_single();

  $post_arr = array(
    'id' => $post ->id,
    'quote' => $post->quote,
    'author_id' => $post->author_id,
    'author' => $post->author,
    'category_id' => $post->category_id,
    'category' => $post->category
  );

  print_r(json_encode($post_arr));