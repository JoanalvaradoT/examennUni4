# Usa una imagen base de PHP
FROM php:8.1-cli

# Establece el directorio de trabajo
WORKDIR /app

# Copia todos los archivos al contenedor
COPY . /app

# Expone el puerto para Render
EXPOSE 10000

# Comando para iniciar el servidor PHP
CMD ["php", "-S", "0.0.0.0:10000", "-t", "/app"]
