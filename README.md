клонируем репозиторий:
```shell script
git clone git@github.com:vdmkbu/tora_smmreports.git .
```

поднимаем docker:
```shell script
make docker-build
```

копируем настройки:
````shell script
cp .env.example .env
````

добавляем в .env API-ключ для VK:
```
APP_VK = 123
```

инициализируем приложение (устанавливаем пакеты, запускаем миграции и добавляем тестовые данные):
```shell script
make init
```

открываем:
```
http://localhost:8080
```

логинимся:
```
admin@admin.loc:admin
user@user.loc:user
```
