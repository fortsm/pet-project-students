# Тестовое задание

Есть студенты, есть классы, и есть лекции.

У студента есть имя и email (уникальный).
У класса есть название (уникальное).
У лекции есть тема (уникальная) и описание.

Студент может состоять только в одном классе.
В классе может быть много студентов.
У каждого класса есть учебный план состоящий из разных лекций, в учебном плане лекции не могут повторяться.
Разные классы проходят лекции в разном порядке.

Сделать API, в котором будут реализованы следующие методы:

1. получить список всех студентов
2. получить информацию о конкретном студенте (имя, email + класс + прослушанные лекции)
3. создать студента
4. обновить студента (имя, принадлежность к классу)
5. удалить студента

6. получить список всех классов
7. получить информацию о конкретном классе (название + студенты класса)
8. получить учебный план (список лекций) для конкретного класса
9. создать/обновить учебный план (очередность и состав лекций) для конкретного класса
10. создать класс
11. обновить класс (название)
12. удалить класс (при удалении класса, привязанные студенты должны открепляться от класса, но не удаляться полностью из системы)

13. получить список всех лекций
14. получить информацию о конкретной лекции (тема, описание + какие классы прослушали лекцию + какие студенты прослушали лекцию)
15. создать лекцию
16. обновить лекцию (тема, описание)
17. удалить лекцию

Авторизацию делать не надо, фронт делать не надо, API должно быть публичным.

Технические требования:

1. Использовать везде строгую типизацию
2. В контроллерах не должно быть бизнес-логики. Контроллер должен только принимать объект реквеста, получать из него отвалидированные данные, вызывать метод модели или сервиса, отлавливать эксепшены и отдавать результат в формате JSON
3. Если есть сложная бизнес-логика, какие-то условия, которые выходят за рамки методов Eloquent, то их нужно вынести в сервисы. Сервис должен работать с моделью и реализовывать свои методы на основе методов модели или моделей с дополнением бизнес-логикой
4. Результат запроса к API должен возвращаться в формате JSON
5. Должна быть реализована валидация передаваемых в запросе к API данных, она должна быть вынесена в реквесты
6. В контроллерах и сервисах использовать Dependency Injection
7. Количество запросов должно быть оптимальным (использовать жадную загрузку для получения связанных данных)

## Установка пакетов

```sh
composer install
```

## Запуск контейнеров

```sh
./vendor/bin/sail up -d
```

## Запуск миграций

```sh
./vendor/bin/sail artisan migrate --seed
```

## Запросы к API

### 1 получить список всех студентов

[ссылка](http://localhost/api/students)

### 2 получить информацию о конкретном студенте (имя, email + класс + прослушанные лекции)

[ссылка](http://localhost/api/students/5)

### 3 создать студента

```sh
curl --location 'http://localhost/api/students' \
--header 'Content-Type: application/x-www-form-urlencoded' \
--data-urlencode 'name=Иван Иванов' \
--data-urlencode 'email=student@example.net' \
--data-urlencode 'classroom_id=1'
```

### 4 обновить студента (имя, принадлежность к классу)

```sh
curl --location --request PATCH 'http://localhost/api/students/5' \
--header 'Content-Type: application/x-www-form-urlencoded' \
--data-urlencode 'name=Обновлений Новиков' \
--data-urlencode 'classroom_id=1'
```

### 5 удалить студента

```sh
curl --location --request DELETE 'http://localhost/api/students/7'
```

### 6 получить список всех классов

[ссылка](http://localhost/api/classrooms)

### 7 получить информацию о конкретном классе (название + студенты класса)

[ссылка](http://localhost/api/classrooms/2)

### 8 получить учебный план (список лекций) для конкретного класса

[ссылка](http://localhost/api/classrooms/2/lectures)

### 9 создать/обновить учебный план (очередность и состав лекций) для конкретного класса

```sh
curl --location 'http://localhost/api/classrooms/1/setlectures' \
--header 'Content-Type: application/json' \
--data '{
    "1": "2024-07-21",
    "2": "2024-07-22",
    "3": "2024-07-23"
}'
```

### 10 создать класс

```sh
curl --location 'http://localhost/api/classrooms' \
--header 'Content-Type: application/x-www-form-urlencoded' \
--data-urlencode 'name=Класс C++'
```

### 11 обновить класс (название)

```sh
curl --location --request PATCH 'http://localhost/api/classrooms/4' \
--header 'Content-Type: application/x-www-form-urlencoded' \
--data-urlencode 'name=Класс С#'
```

### 12 удалить класс (при удалении класса, привязанные студенты должны открепляться от класса, но не удаляться полностью из системы)

```sh
curl --location --request DELETE 'http://localhost/api/classrooms/4'
```

### 13 получить список всех лекций

[ссылка](http://localhost/api/lectures)

### 14 получить информацию о конкретной лекции (тема, описание + какие классы прослушали лекцию + какие студенты прослушали лекцию)

[ссылка](http://localhost/api/lectures/1)

### 15 создать лекцию

```sh
curl --location 'http://localhost/api/lectures' \
--header 'Content-Type: application/x-www-form-urlencoded' \
--data-urlencode 'subject=Основы безопасности' \
--data-urlencode 'description=Лекция про безопасность при разработке ПО'
```

### 16 обновить лекцию (тема, описание)

```sh
curl --location --request PATCH 'http://localhost/api/lectures/1' \
--header 'Content-Type: application/x-www-form-urlencoded' \
--data-urlencode 'subject=Основы ООП' \
--data-urlencode 'description=Рассказывается об основах ООП'
```

### 17 удалить лекцию

```sh
curl --location --request DELETE 'http://localhost/api/lectures/4'
```

### остановка контейнеров

```sh
./vendor/bin/sail down
```