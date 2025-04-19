## Vending App

##### Clone Project
```
git clone https://github.com/ASNProject/vending-app.git
```
<b > Jika menggunakan xampp/ Windows, download file dan simpan di dalam C:/xampp/htdocs</b>

- Rename .env.example dengan .env dan sesuaikan pengaturan DB seperti dibawah
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_vending
DB_USERNAME=root
DB_PASSWORD=
```

- Download database di folder ```sql``` dan import di mysql

##### Run Project
- Run Composer
```
composer update
```

- Run server
```
php artisan serve
```
- Development
```
php artisan serve --host=0.0.0.0 --port=8000
```

#### Route
##### ITEMS
- Add Items
```
Route : http://127.0.0.1:8000/api/items

Body: 
{
    "name": "Kacamata"
}
```
- Get Items
```
Route : http://127.0.0.1:8000/api/items
```
- Get Items ByID
```
Route : http://127.0.0.1:8000/api/items/{id}
```
- Update Items
```
Route : http://127.0.0.1:8000/api/items/{id}

Body: 
{
    "name": "Kacamata"
}
```
- Delete Items
```
Route : http://127.0.0.1:8000/api/items/{id}
```

##### USER ITEM LIMITS
- Add User Item Limit
```
Route : http://127.0.0.1:8000/api/limits

Body: 
{
    "uid": "123456",
    "name": "Erick",
    "role": "Manager",
    "limit": 20,
}
```
- Get User Item Limit
```
Route : http://127.0.0.1:8000/api/limits
```
- Get User Item Limit ByID
```
Route : http://127.0.0.1:8000/api/limits/{id}
```
- Update User Item Limit
```
Route : http://127.0.0.1:8000/api/limits/{uid}

Body: 
{
    "limit": 123
}
```
- Delete User Item Limit
```
Route : http://127.0.0.1:8000/api/limits/{id}
```

##### DEVICE
- Add Device
```
Route : http://127.0.0.1:8000/api/devices

Body: 
{
    "device": "A",
    "items": [
        {
            "item_id": 1,
            "limit": 20
        },
        {
            "item_id": 2,
            "limit": 20
        }
    ]
}
```
- Get Device
```
Route : http://127.0.0.1:8000/api/devices
```
- Get Device ByID
```
Route : http://127.0.0.1:8000/api/devices?device=A
```
- Update Device
```
Route : http://127.0.0.1:8000/api/devices/{device}

Body: 
{
    "item_id": 2,
    "limit": 10
}
```
- Delete Device
```
Route : http://127.0.0.1:8000/api/devices/{device}/{id}
```

##### VENDING
- Add Vending
```
Route : http://127.0.0.1:8000/api/vendings

Body: 
{
  "uid": "123456",
  "device": "A",
  "item": 2
}
```
- Get Device
```
Route : http://127.0.0.1:8000/api/vendings
```

#### Postman
- Import postman example di folder postman