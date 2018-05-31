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

для подключения по ssh 
```
$ vagrant ssh
```

для windows прописать в **c:\Windows\System32\drivers\etc\hosts** строку
```
192.168.20.20 back.mediastorage.test
```

open http://back.mediastorage.test

for mail use http://localhost:8025