### Запуск проекта на локальном PC

требуемые приложения 
- git
- php7.2
- composer
- virtualbox
- vagrant

склонировать репозитарий в **домашнем каталоге** пользователя в директорию back.mediastorage.test
```
$ cd back.mediastorage.test
$ git init
$ git pull https://github.com/domatskiy/back.mediastorage.test
```  

#### установка зависимостей

```
$ composer install
```

#### запуск виртуфльной машины

```
$ vagrant up
```

подключимся по ssh 
```
$ vagrant ssh
```

скопировать .env.example в .env

сгенерим ключ
```
$ php artisan key:generate
```

выполним миграции базы (с заполенением --seed)
```
$ php artisan migrate --seed
```

для windows прописать в **c:\Windows\System32\drivers\etc\hosts** строку
```
192.168.20.20 back.mediastorage.test
```

open http://back.mediastorage.test

для доступа к редактированию использовать email и пароль:
```
admin@admin.ru | admin
```

for mail use http://localhost:8025