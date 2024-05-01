# symfony-sample
Broadcast product

- api request
curl --location --request POST '{your domain}/api/v1/broadcast-listener/product' \
--header 'Authorization: Basic cGltOjEyMzQ1Ng==' \
--header 'Content-Type: application/json' \
--data-raw '{
"sku": "p1",
"name": "Product 1",
"description": "this is a description",
"isSellable": 1,
"stock": 99,
"listPrice": {
"salePrice": 9.99,
"specialPrice": 8.99,
"specialFrom": "2024-05-05 00:00:00",
"specialTo": "2024-05-05 23:59:59"
},
"updatedAt": "2024-05-01 10:30:00"
}'

- consume queue:
bin/console messenger:consume listener-product --time-limit=1