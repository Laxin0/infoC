let id_by_name = []

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
    }); //IDEA: show current path
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