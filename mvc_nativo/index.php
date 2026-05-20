<?php
require_once __DIR__ . '/libs/Session.php';
require_once __DIR__ . '/libs/Router.php';

Session::start();
Router::route();