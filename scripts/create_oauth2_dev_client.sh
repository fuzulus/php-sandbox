source .env.dev
php bin/console league:oauth2-server:create-client \
 "$OAUTH2_CLIENT_NAME" \
 "$OAUTH2_CLIENT_IDENTIFIER" \
 "$OAUTH2_CLIENT_SECRET" \
 --grant-type "authorization_code" \
 --redirect-uri "http://localhost:8129"