# About

Наработки для проекта.

  

### Disclaimer

Содержимое меняется как угодно и когда угодно. Изменения не фиксируются. Тут могут содержаться недоработанные мысли или отдельные файлы никак не использующиеся в проекте.

  

## Client

### `script.js`:

- `updatePage(data)`: Обновить информацию на странице по данным из data (путь, содержимое, кнопки для дальнейшего перехода)

- `selectNodeById(id)`: Перейти на узел по ИД
    Вызывается по нажатию кнопки перехода на другой узел
	GET запрос к `server.php `
	`updatePage(data)`

- `goBack()`: Вернуться на предыдущий узел
	Вызывается по нажатию кнопки *назад*
	`selectNodeById(id)`

- `openPopup(id)`: Открыть всплывающую форму по ИД
	Вызывается по нажатию кнопки *удалить*, *добавить*, *редактировать*, *СОС*, *история*

- `closePopup(id)`: Закрыть всплывающую форму по ИД
	Вызывается по нажатию крестика в форме

- `deleteCurrentPage()`: удалить текущую страницу и все дочерние рекурсивно
	Вызывается по нажатию кнопки *удалить* в форме *удаление страницы*
	POST запрос к `deletePage.php`
	`goBack()`

- `submitSos(event)`: Отправить данные из формы *СОС*
    Вызывается по нажатию кнопки *Сохранить* в форме *СОС*
    POST запрос к `saveSos.php`
  
- `submitAdd(event)`: Отправить данные из формы *добавить*
	Вызывается по нажатию кнопки *Сохранить* в форме *добавить*
    POST запрос к `addPage.php`

- `updateEditPopup()`: Обновить данные в форме *редактировать*
    Вызывается по нажатию кнопки *Редактировать*

- `submitEdit(event)`: Отправить данные из формы *редактировать*
    Вызывается по нажатию кнопки *Сохранить* в форме *редактировать*
    POST запрос к `editPage.php`

- `updateHistory()`: Обновить данные в форме *история звонков*
    Вызывается по нажатию кнопки *История*
    GET запрос к `history.php`

- `toggleCallStatusById(callId)`: Переключить статус звонка (решено / не решено) по ИД
    Вызывается по нажатию кнопки *Решено* / *Не решено* в форме *история звонков*
    POST запрос к `toggleCallStatus.php`

### Server

#### `addPage.php`:

Принимает:
```
{
	name: ...
	content: ...
	parentId: ...
}
```

```sql
INSERT INTO pages (name, parent_id, content) VALUES ('$name', '$parent_id', '$content')
```

Возвращает:
```
{
	status: "ok" | "err"
}
```

#### `db_connection.php`:

`loadEnv($path)`: Загрузить переменные из файла `.env` в переменные среды

#### `delete.php`:

Принимает:
```
{
	id: ...
}
```

`delete_by_id($connection, $id)`: удалить страницу по ИД и рекурсивно все дочерние
```SQL
SELECT id FROM pages WHERE parent_id=$id
DELETE FROM pages WHERE id=$id
```

Возвращает:
```
{
	status: "ok" | "err"
}
```

#### `editPage.php`:

Принимает:
```
{
	id: ...
	name: ...
	content: ...
}
```
```SQL
UPDATE pages SET name='$name', content='$content' WHERE id=$id
```

Возвращает:
```
{
status: "ok" | "err"
}
```
#### `history.php`:

Принимает:
```
{}
```

`numerate($indexedArray)`: Сделать массив ассоциативным
```SQL
SELECT calls.id, phone_number, full_name, question, pages.name AS source_page_name, is_solved FROM calls JOIN pages ON calls.source_page_id=pages.id
```

Возвращает:
```
{
	0: {
		id: ...
		phoneNumber: ...
		fullName: ...
		question: ...
		sourcePage: ...
		isSolved: ...
	}, ...
}
```

#### `saveSos.php`:

Принимает:
```
{
	phoneNumber: ...
	fullName: ...
	question: ...
	sourcePageId: ...
}
```

```SQL
INSERT INTO calls (phone_number, full_name, question, source_page_id) VALUES ('$phone_number', '$full_name', '$question', '$source_page_id')
```
Возвращает:
```
{
	status: "ok" | "err"
}
```

#### `server.php`:

Принимает:
```
{
	id: ...
}
```

`db_get_data_by_id($connection, $id)`: Вернуть данные для ответа из БД по ИД
`numerate($indexedArray)`: Сделать массив ассоциативным

```SQL
SELECT name, content FROM pages WHERE id=$id
SELECT id, name FROM pages WHERE parent_id=$id
```

Возвращает:
```
{
	name: имя_узла,
	content: содержимое_узла,
	child_nodes: {
		0: {
			id: ид_дочернего_узла,
			name: имя_дочернего_узла,
		},
		1: {
			id: ид_дочернего_узла,
			name: имя_дочернего_узла,
		}, и т.д.
	}
}
```

#### `toggleCallStatus.php`:

Принимает:
```
{
	id: ...
}
```

```SQL
UPDATE calls SET is_solved=!is_solved WHERE id=$id
```

Возвращает:
```
{
	status: "ok" | "err"
}
```