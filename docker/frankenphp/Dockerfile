FROM dunglas/frankenphp:latest

# Instala supervisord
RUN apt-get update && apt-get install -y supervisor

# Copia configuración supervisor
COPY supervisord.conf /etc/supervisord.conf

# Exponemos los puertos de ambas apps
EXPOSE 8001 8002 8003

# Comando por defecto: supervisor
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
