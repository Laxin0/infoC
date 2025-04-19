function updatePage(data){
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
    if (path[path.length-1] != id) path.push(id);
    fetch(`server.php?id=${id}`)
    .then(response => response.json())
    .then( data => {
        if (data.error){
            console.error("Error:", error);
            return;
        }
        updatePage(data);
    })
    .catch(error => console.error("Error:", error));
}

let path = []

function goBack(){
    if(path.length < 2) return;
    path.pop();
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
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: JSON.stringify({id: currentId})
    })
    .then(response => response.json())
    .then( data => {
        if (data.status === "ok"){
            goBack();
            closePopup('deleteForm');
            alert("Страница удалена");
        }else{
            alert("Не удалось удалить страницу.");
        }
    })
    .catch(error => console.error("Error:", error));
}