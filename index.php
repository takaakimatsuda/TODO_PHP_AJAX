<?php

session_start();

require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/functions.php');
require_once(__DIR__ . '/Todo.php');

// get todos
$todoApp = new \MyApp\Todo();
$todos = $todoApp->getAll();

// var_dump($todos);
// exit;

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
  <link rel="stylesheet" href="asset/css/main.scss">
  <title>TO DO LIST</title>
</head>
<body>
  <div class="app-title text-center">
      <h2>TO DO LIST</h2>
      <form action="" id="new_todo_form">
        <input type="text" id="new_todo" placeholder="Enter the task">
      </form>
  </div>
  <ul id="todos" class="mx-auto">
  <?php foreach ($todos as $todo) : ?>
    <li id="todo_<?= h($todo->id); ?>" data-id="<?= h($todo->id); ?>">
      <input type="checkbox" class="delete_todo"?>
      <span class="todo_title"><?= h($todo->title); ?></span>
    </li>
  <?php endforeach; ?>
    <li id="todo_template" data-id="" class="mx-auto">
      <input type="checkbox" class="delete_todo">
      <span class="todo_title"></span>
    </li>
  </ul>
  <input type="hidden" id="token" value="<?= h($_SESSION['token']); ?>">
  <script 
  src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
  <script src="todo.js"></script>
</body>
</html>