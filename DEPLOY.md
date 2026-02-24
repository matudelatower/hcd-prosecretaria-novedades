git pull
docker compose -f docker-compose.prod.yml up -d --build
docker exec -it novedades-internas-prod php artisan migrate --force
docker exec -it novedades-internas-prod php artisan config:cache
docker exec -it novedades-internas-prod php artisan route:cache || true
docker exec -it novedades-internas-prod php artisan view:cache || true