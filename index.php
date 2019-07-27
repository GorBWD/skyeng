<?php

require __DIR__ . '/vendor/autoload.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require __DIR__ . '/app/store.php';
}

include __DIR__ . '/public/index.html';