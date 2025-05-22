function updatePage(data){
    document.getElementById("path").innerText = namesPath.join("/");
    document.getElementById("content").innerHTML = data.content;

    let buttons = document.getElementById("child_nodes");
    buttons.replaceChildren();

    data.child_nodes.forEach(node => {
        let newButton = document.createElement("button");
        newButton.textContent = node.name;
        newButton.onclick = (() => selectNodeById(node.id));
        buttons.appendChild(newButton);
    });
}

function selectNodeById(id){
    fetch(`server.php?id=${id}`)
    .then(response => response.json())
    .then( data => {
        if (data.error){
            console.error("Error:", error);
            return;
        }
        if (path[path.length-1] != id){
             path.push(id);
             namesPath.push(data.name);
        }
        updatePage(data);
    })
    .catch(error => console.error("Error:", error));
}

let path = []
let namesPath = []

function goBack(){
    if(path.length < 2) return;
    path.pop();
    namesPath.pop();
    selectNodeById(path[path.length-1]);
}

function openPopup(id) {
    document.getElementById(id).style.display = 'flex';
}

function closePopup(id) {
    document.getElementById(id).style.display = 'none';
}

function deleteCurrentPage(){ //TODO: root can't be deleted
    const currentId = path[path.length-1];
    if (currentId === 1){
        showMessage("Начальная страница не может быть удалена!");
        return;
    }
    fetch('delete.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({id: currentId})
    })
    .then(response => response.json())
    .then( data => {
        if (data.status === "ok"){
            goBack();
            closePopup('deletePopup');
            showMessage("Страница удалена");
        }else{
            showMessage("Не удалось удалить страницу.");
        }
    })
    .catch(error => console.error("Error:", error));
}

function submitSos(event){
    event.preventDefault();
    const bodyData = {
        phoneNumber: document.getElementById("phoneNumberInput").value,
        fullName: document.getElementById("fullNameInput").value,
        question: document.getElementById("questionInput").value,
        sourcePageId: path[path.length-1]
    }

    fetch('savesos.php',{
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(bodyData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "ok"){
            closePopup('sosPopup');
            showMessage("Вопрос добавлен.");
        }else{
            showMessage("Не удалось добавить вопрос.");
        }
    })
    .catch(error => console.error("Error:", error));
}

function submitAdd(event){
    event.preventDefault();

    const bodyData = {
        name: document.getElementById("nameInput").value,
        content: document.getElementById("contentInput").value,
        parentId: path[path.length-1]
    }

    fetch("addPage.php", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(bodyData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "ok"){
            closePopup('addPopup');
            showMessage("Страница добавлена.");
            selectNodeById(path[path.length-1]);
        }else{
            showMessage("Не удалось добавить страницу.");
        }
    })
    .catch(error => console.error("Error:", error));
}

function updateEditPopup(){
    document.getElementById("newNameInput").value = namesPath[namesPath.length-1];
    document.getElementById("newContentInput").value = document.getElementById("content").innerHTML;
}

function submitEdit(event){
    event.preventDefault();

    const bodyData = {
        id: path[path.length-1],
        name: document.getElementById("newNameInput").value,
        content: document.getElementById("newContentInput").value,
    }

    fetch("editPage.php", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(bodyData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "ok"){
            closePopup('editPopup');
            showMessage("Новые данные сохранены.");
            selectNodeById(path[path.length-1]);
        }else{
            showMessage("Не удалось редактировать страницу.");
        }
    })
    .catch(error => console.error("Error:", error));
}

function updateHistory(){
    fetch("history.php")
    .then(response => response.json())
    .then(data => {
        let html = `
        <tr>
            <th></th>
            <th>Тел.</th>
            <th>ФИО</th>
            <th>Вопрос</th>
            <th>Источник</th>
            <th>Cтатус</th>
        </tr>`;

        data.forEach(row => {
            html += `
            <tr>
            <td><span class='status-unresolved' onclick='deleteCallById(${row.id})'>🗑</span></td>
            <td>${row.phoneNumber}</td>
            <td>${row.fullName}</td>
            <td>${row.question}</td>
            <td>${row.sourcePage}</td>
            <td><span class='${row.isSolved == true ? "status-resolved" : "status-unresolved"}' onclick='toggleCallStatusById(${row.id})'>${row.isSolved == true ? "Решено" : "Не решено"}</span></td>
            </tr>`;
        });

        document.getElementById("calls").innerHTML = html;
    }).catch(error => console.error("Error: ", error));
}

function deleteCallById(callId){
    if (!isAdmin()){
        showMessage("Нет прав администратора.");
        return;
    }
    fetch("deleteCall.php", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({id: callId})
    })
    .then(response => response.json())
    .then(data => {
        if (data.status !== "ok"){
            showMessage("Не удалось удалить звонок.");
        }else{
            updateHistory();
            showMessage("Звонок удален.");
        }
        
    })
    .catch(error => console.error("Error: ", error))
}

function toggleCallStatusById(callId){ //TODO: optimize
    fetch("toggleCallStatus.php", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({id: callId})
    })
    .then(response => response.json())
    .then(data => {
        if (data.status !== "ok"){
            showMessage("Не удалось изменить статус звонка.");
        }
        updateHistory();
    })
    .catch(error => console.error("Error: ", error))
}

function checkPswd(event) {
    event.preventDefault();
    const passwordInput = document.getElementById('admin-password').value;

    fetch('checkAdmin.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json' },
        body: JSON.stringify({password: passwordInput})
    })
    .then(response => {
        if (response.ok) {
            showMessage('Администрирование активно');
            updateSideButtons();
            closePopup('askPassword');
        } else {
            showMessage('Неверный пароль!');
        }
    }).catch(error => console.error("Error: ", error));
}

function isAdmin(){
    return document.cookie.includes("isAdmin=true");
}

function updateSideButtons(){
    document.getElementById('admin-btn').textContent = isAdmin() ? "Выйти" : "Войти";
    document.getElementById('add-btn').disabled = !isAdmin();
    document.getElementById('edit-btn').disabled = !isAdmin();
    document.getElementById('delete-btn').disabled = !isAdmin();
}

function toggleUserStatus(){
    if (isAdmin()){
        document.cookie = "isAdmin=; Max-Age=0; path=/";
        showMessage("Администрирование отключено");
        updateSideButtons();
    }else{
        openPopup('askPassword');
    }
}

function showMessage(msg) {
    const messageEl = document.getElementById('message');
    messageEl.innerText = msg;
    messageEl.classList.add('show');

    setTimeout(() => {
        messageEl.classList.remove('show');
    }, 3000);
  }

selectNodeById(1);
updateSideButtons();