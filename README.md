# About
Наработки для проекта.

### Disclaimer
Содержимое меняется как угодно и когда угодно. Изменения не фиксируются. Тут могут содержаться недоработанные мысли или отдельные файлы никак не использующиеся в проекте.

#### Переход на другую страницу
`GET id=<id>` to `server.php`
returns:
```
{
	name: <имя страницы>,
	content: <содержимое>,
	child_nodes: {
		0: {
			id: <ид1>,
			name: <имя1>
		},
		1: {
			id: <ид2>,
			name: <имя2>
		}
		...
	}
}
```
Отрисовка страницы

#### Кнопка SOS
Открывает форму (телефон, ФИО, вопрос)
На подтверждение отправляет
`POST` to `saveSos.php`
```
body{
	    phoneNumber: <Телефон>,
        fullName: <ФИО>,
        question: <Вопрос>,
        sourcePage: <ид текущей страницы>
}
```

`saveSos.php`

```
INSERT INTO calls (phone_number, full_name, question, source_page_id) VALUES (<phoneNumber>, <fullName>, <question>, <sourcePage>)
```

returns
```
{
	status: <"ok" | "err">
}
```

Выдаем alert

#### кнопка удалить
предупреджение (будет удалено + все дочерние)

sends `POST` to `delete.php`
```
{
    id: <id>
}
```

returns
```
{
    status: <"ok" | "err">
}
```

corresponding alert

#### Add button
Opens form (page name, content)

Sends `POST` to `addPage.php`
```
body{
    pageName: <name>,
    content: <text>,
    parent+id: <current id>
}
```

#### Edit button
Opens form (page name, new)