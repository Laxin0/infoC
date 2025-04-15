<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InfoC</title>
    <h1 id="name"></h1>
    <script type="text/javascript" src="script.js"></script>
    <style>
    button{
        border: none;
        padding: 10px;
        background-color: #F1ECCE;
        border-radius: 10px;
    }
    </style>
</head>
<body>
    <button onclick="goBack()">Назад</button><br>
    <hr>
    <div id="content"></div>
    <hr>
    <div id="child_nodes">
        <button onclick="selectNodeById(1)">Корень</button>
    </div>
</body>
</html>