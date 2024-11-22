<?php
require_once __DIR__ . '/../config.php';

session_start();
session_destroy();
header("Location: /unidad4/examen/index.php");
exit();