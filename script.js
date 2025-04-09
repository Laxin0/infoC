let id_by_name = []

function updateText(button) {
    if (path[path.length-1] == button.textContent) return;
    selectNodeByName(button.textContent);
    path.push(button.textContent);
}

function updatePage(data){
    document.getElementById("content").innerHTML = data.content;

    document.getElementById("name").innerHTML = data.name;

    let buttons = document.getElementById("child_nodes");
    buttons.replaceChildren();

    data.child_names.forEach((id, name) => {
        let newButton = document.createElement("button");
        newButton.textContent = ch_name;
        newButton.onclick = (() => updateText(id));
        buttons.appendChild(newButton);
    });
    
    document.getElementById("path").innerHTML = path.join("/");
}

function selectNodeByName(name){
    fetch(`server.php?name=${name}`)
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

function selectNodeByName(id){
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
    selectNodeByName(path[path.length-1]);
}