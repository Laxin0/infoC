function updatePage(data){
    document.getElementById("path").innerText = namesPath.join("/");
    document.getElementById("content").innerHTML = data.content;

    document.getElementById("name").innerHTML = data.name;

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
            alert("Страница удалена");
        }else{
            alert("Не удалось удалить страницу.");
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
            alert("Вопрос добавлен.");
        }else{
            alert("Не удалось добавить вопрос.");
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
            alert("Страница добавлена.");
        }else{
            alert("Не удалось добавить страницу.");
        }
    })
    .catch(error => console.error("Error:", error));
}

function updateEditPopup(){
    fetch(`server.php?id=${path[path.length-1]}`)
    .then(response => response.json())
    .then(data => {
        if (data.error){
            alert("Что-то пошло не так...");
            return;
        }
        document.getElementById("newNameInput").value = data.name;
        document.getElementById("newContentInput").value = data.content;
    })
    .catch(error => console.error("Error:", error));
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
            alert("Новые данные сохранены.");
        }else{
            alert("Не удалось редактировать страницу.");
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
            <th>Тел.</th>
            <th>ФИО</th>
            <th>Вопрос</th>
            <th>Источник</th>
            <th>Cтатус</th>
        </tr>`;

        data.forEach(row => {
            html += `
            <tr>
            <td>${row.phoneNumber}</td>
            <td>${row.fullName}</td>
            <td>${row.question}</td>
            <td>${row.sourcePage}</td>
            <td>${row.isSolve ? "Решено" : "Не решено"}</td>
            </tr>`;
        });

        document.getElementById("calls").innerHTML = html;
    }).catch(error => console.error("Error: ", error));
}

selectNodeById(1);