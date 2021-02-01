# Phalcon:

1. На своем сервере или виртуальной машине установить Phalcon framework 4 и установить базу данных PostgreSQL;
2. Создать таблицу с полями: Фамилия Имя Отчество и заполнить произвольными данными, не менее 1000 строк;
3. С помощью Phalcon создать REST Webservice c методами:
    
    3.1. Чтение записей из таблицы;
    
    3.2. Добавление записей в таблицу;
    
    3.3. Изменение записей в таблице;
    
    3.4. Удаление записей в таблице;
4. На отдельной странице вывести интерфейс для работы с таблицей;
5. Реализовать полнотекстовый поиск по данным из таблицы


#Сервисы:

###GET /api/install
- response:
200 - ok
404 - error

###GET /api/get/{id}
- response:
200 - ok
[
    {
        "id" : 1,
        "firstname" : "TEST",
        "secondname" : "TEST",
        "surname" : "TEST"
    }
]
404 - error

###GET  /api/list/{id}/{limit}
- response:
200 - ok
[
    {
        "id" : 1,
        "firstname" : "TEST",
        "secondname" : "TEST",
        "surname" : "TEST"
    }
]
404 - error

###GET /api/search/{find}/{limit}
- response:
200 - ok
[
    {
        "id" : 1,
        "firstname" : "TEST",
        "secondname" : "TEST",
        "surname" : "TEST"
    }
]
404 - error

###POST /api/post
- Body:
[
    {
        "firstname" : "TEST",
        "secondname" : "TEST",
        "surname" : "TEST"
    }
]
- response:
201 - ok
[
    {
        "id" : 1,
        "firstname" : "TEST",
        "secondname" : "TEST",
        "surname" : "TEST"
    }
]
404 - error

###PUT /api/put
- Body:
[
    {
        "id" : 1,
        "firstname" : "TEST2",
        "secondname" : "TEST2",
        "surname" : "TEST2"
    }
]
- response: 
201 - ok
404 - error

###DELETE /api/delete
- Body:
[
    {
        "id" : 1
    }
]
- response: 
201 - ok
404 - error


