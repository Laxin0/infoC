<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InfoC</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="breadcrumb" id="path"></div>
    <button class="back-button" onclick="selectNodeById(1); path.splice(1); namesPath.splice(1); ">В начало</button>
    <button class="back-button" onclick="goBack()">⤺</button><br>
    <div class="main-container">
      <div class="main-box" id="content"></div>
      <div class="side-buttons">
        <button id="admin-btn" class="getAdmin" onclick="toggleUserStatus()">Войти</button>
        <button class="sos" onclick="openPopup('sosPopup')">SOS</button>
        <button class="history" onclick="updateHistory(); openPopup('historyPopup');">История</button>
        <button id="add-btn" class="add" onclick="openPopup('addPopup');">+</button>
        <button id="edit-btn" class="edit" onclick="updateEditPopup(); openPopup('editPopup');">✎</button>
        <button id="delete-btn" class="delete" onclick="openPopup('deletePopup')">🗑</button>
      </div>
    </div>

    <div class="bottom-buttons" id="child_nodes"></div>

    <div class="overlay" id="deletePopup"> <!-- DELETE FORM-->
      <div class="message-box">
        <span class="close-btn" onclick="closePopup('deletePopup')">×</span>
        <h2>Удалить текущую страницу?</h2>
        <p>!!! Все дочерние страницы будут также удалены !!!</p>
        <button class="delete-btn" onclick="deleteCurrentPage()">Удалить</button>
      </div>
    </div>

    <div class="overlay" id="sosPopup"> <!-- SOS FORM-->
      <div class="message-box">
        <span class="close-btn" onclick="closePopup('sosPopup')">×</span>
        <h2>Внесите данные для обратной связи</h2>
        <form onsubmit="submitSos(event); this.reset();">
          <input type="text" id="phoneNumberInput" placeholder="Телефон" required><br>
          <input type="text" id="fullNameInput" placeholder="ФИО" required><br>
          <textarea id="questionInput" rows="10" cols="50" placeholder="Вопрос" required></textarea><br>
          <button class="save-btn" type="submit">Сохранить</button>
        </form>
      </div>
    </div>

    <div class="overlay" id="addPopup"> <!-- ADD FORM-->
      <div class="message-box">
        <span class="close-btn" onclick="closePopup('addPopup')">×</span>
        <h2>Новый узел будет добавлен к текущему</h2>
        <form onsubmit="submitAdd(event); this.reset();">
          <input type="text" id="nameInput" placeholder="Название" required><br>
          <textarea id="contentInput" rows="10" cols="50" placeholder="Содержание" required></textarea><br>
          <button class="save-btn" type="submit">Добавить</button>
        </form>
      </div>
    </div>

    <div class="overlay" id="editPopup"> <!-- EDIT FORM-->
      <div class="message-box">
        <span class="close-btn" onclick="closePopup('editPopup')">×</span>
        <h2>Редактировать текущую страницу</h2>
        <form onsubmit="submitEdit(event); this.reset();">
          <input type="text" id="newNameInput" placeholder="Название" required><br>
          <textarea id="newContentInput" placeholder="Содержание" required></textarea><br>
          <button class="save-btn" type="submit">Сохранить</button>
        </form>
      </div>
    </div>

    <div class="overlay" id="historyPopup"> <!-- HISTORY FORM-->
      <div class="message-box">
        <span class="close-btn" onclick="closePopup('historyPopup')">×</span>
        <h2>Звонки</h2>
        <table border="1" id="calls"></table>
      </div>
    </div>

  <div class="overlay" id="askPassword">
    <div class="message-box">
      <span class="close-btn" onclick="closePopup('askPassword')">×</span><br>
      <form id="admin-login-form" onsubmit="checkPswd(event)">
        <input type="password" id="admin-password" placeholder="Пароль" required />
        <button class="save-btn" type="submit">Получить права администратора</button>
      </form>
    </div>
  </div>
  <div id="message"></div>

  <script type="text/javascript" src="script.js"></script>
</body>
</html>