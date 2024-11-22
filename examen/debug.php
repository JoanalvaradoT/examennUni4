<?php
echo "Archivos en el directorio actual:<br>";
print_r(scandir(getcwd()));
echo "<br><br>Archivos en /app/app:<br>";
print_r(scandir(__DIR__ . '/app'));
echo "<br><br>Archivos en /app/tpm:<br>";
print_r(scandir(__DIR__ . '/tpm'));
?>
