<?php
  require __DIR__ . '/vendor/autoload.php';

  $options = array(
    'cluster' => 'ap1',
    'useTLS' => true
  );
  $pusher = new Pusher\Pusher(
    '2e583e2d2163c77de2b2',
    'c152089953fcf28c5732',
    '837809',
    $options
  );



?>