<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InfoC</title>
    <h1 id="name"></h1>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="path"></div>
    <button onclick="goBack()">Назад</button><br>
    <hr>
    <div id="content"></div>
    <hr>
    <div id="child_nodes">
        <button onclick="selectNodeById(1)">Корень</button>
    </div>

    <hr>
    <button onclick="openPopup('deleteForm')">Удалить</button>
    <button onclick="openPopup('sosForm')">SOS</button>
    <button onclick="openHistory()">История</button>
    <button onclick="openPopup('addForm')">Добавить</button>
    <button onclick="updateEditForm(); openPopup('editForm');">Редактировать</button>

    <div class="overlay" id="deleteForm"> <!-- DELETE FORM-->
      <div class="message-box">
        <span class="close-btn" onclick="closePopup('deleteForm')">×</span>
        <h2>Удалить текущую страницу?</h2>
        <p>!!! Все дочерние страницы будут также удалены !!!</p>
        <button onclick="deleteCurrentPage()">Удалить</button>
      </div>
    </div>

    <div class="overlay" id="sosForm"> <!-- SOS FORM-->
      <div class="message-box">
        <span class="close-btn" onclick="closePopup('sosForm')">×</span>
        <h2>Внесите данные для обратной связи</h2>
        <form onsubmit="submitSos(event); this.reset();">
          <label for="phoneNumberInput">Тел.</label>
          <input type="text" id="phoneNumberInput" required><br>
          <label for="fullNameInput">ФИО</label>
          <input type="text" id="fullNameInput" required><br>
          <label for="questionInput">Вопрос</label>
          <input type="text" id="questionInput" required><br>
          <button type="submit">Сохранить</button>
        </form>
      </div>
    </div>

    <div class="overlay" id="addForm"> <!-- ADD FORM-->
      <div class="message-box">
        <span class="close-btn" onclick="closePopup('addForm')">×</span>
        <h2>Новый узел будет добавлен к текущему</h2>
        <form onsubmit="submitAdd(event); this.reset();">
          <label for="nameInput">Название</label>
          <input type="text" id="nameInput" required><br>
          <label for="contentInput">Содержание</label>
          <input type="text" id="contentInput" required><br>
          <button type="submit">Добавить</button>
        </form>
      </div>
    </div>

    <div class="overlay" id="editForm"> <!-- EDIT FORM-->
      <div class="message-box">
        <span class="close-btn" onclick="closePopup('editForm')">×</span>
        <h2>Редактировать текущую страницу</h2>
        <form onsubmit="submitEdit(event); this.reset();">
          <label for="newNameInput">Название</label>
          <input type="text" id="newNameInput" required><br>
          <label for="newContentInput">Содержание</label>
          <input type="text" id="newContentInput" required><br>
          <button type="submit">Сохранить</button>
        </form>
      </div>
    </div>

    <div class="overlay" id="historyForm"> <!-- HISTORY FORM-->
      <div class="message-box">
        <span class="close-btn" onclick="closePopup('historyForm')">×</span>
        <h2>Звонки</h2>
        <table border="1" id="calls"></table>
      </div>
    </div>

    <script type="text/javascript" src="script.js"></script>
</body>
</html>