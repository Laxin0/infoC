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
    <button onclick="goBack()">Назад</button><br>
    <hr>
    <div id="content"></div>
    <hr>
    <div id="child_nodes">
        <button onclick="selectNodeById(1)">Корень</button>
    </div>
    <div class="button-container">
    <button onclick="openPopup('deleteForm')">Удалить</button>

    <div class="overlay" id="deleteForm">
    <div class="message-box">
      <span class="close-btn" onclick="closePopup('deleteForm')">×</span>
      <h2>Удалить текущую страницу?</h2>
      <p>!!! Все дочерние страницы будут также удалены !!!</p>
      <button onclick="deleteCurrentPage()">Удалить</button>
    </div>
    </div>

  </div>
  <script type="text/javascript" src="script.js"></script>
</body>
</html>