#!/bin/bash

set -e

read -p 'Please enter your database host: ' -r DATABASE_HOST

read -p 'Please enter your database username: ' -r DATABASE_USERNAME

read -p 'Please enter your database password (your password will not be displayed!): ' -sr DATABASE_PASSWORD

echo ''

read -p 'Please enter your database name: ' -r DATABASE_NAME

read -p 'Please enter your database port: ' -r DATABASE_PORT

echo -n "Writing vars/main.yml file... "

cat > vars/main.yml<< EOF
---
server: "$DATABASE_HOST"
username: "$DATABASE_USERNAME"
password: "$DATABASE_PASSWORD"
dbname: "$DATABASE_NAME"
port: $DATABASE_PORT
EOF

echo -n "... done!"

echo 'Please enter your CA certificate (once pasted press ctrl-d to save!): ' 

CA_CERT="$(</dev/stdin)"

echo "$CA_CERT" > files/ovh-db.crt
