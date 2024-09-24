
# Metricalo test

To start this project run

```
RUN cp  .env.example .env
RUN composer install
RUN symfony server:start --port=8000

```

To try the endpoints
```
curl --location 'http://localhost:8000/app/pay/shift4' \
--header 'Content-Type: application/json' \
--data '{
    "amount": 100,
    "currency": "EUR",
    "cardNumber": "4200000000000000",
    "cardExpYear": "2034",
    "cardExpMonth": "05",
    "cardCvv": "123"
}
'
You can tweak the last parameter as like 
```


To run from console

```
php bin/console app:card-payment provider amount currency cardnumber expirymonth expiryyear cvv

Example
php bin/console app:card-payment shift4 100 EUR 4200000000000000 05 2034 123

 
