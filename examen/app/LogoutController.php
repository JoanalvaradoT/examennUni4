<?php
session_start();
session_destroy();
header("Location: /unidad4/examen/index.php");
exit();