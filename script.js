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

function submitSos(event){
    event.preventDefault();
    const bodyData = {
        phoneNumber: document.getElementById("phoneNumberInput").value,
        fullName: document.getElementById("fullNameInput").value,
        question: document.getElementById("questionInput").value,
        sourcePage: path[path.length-1]
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
            closePopup('sosForm');
            alert("Вопрос добавлен.");
        }else{
            alert("Не удалось добавить вопрос.");
        }
    })
    .catch(error => console.error("Error:", error));
}

selectNodeById(1);