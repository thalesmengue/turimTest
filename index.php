<?php
include_once('process.php');
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="/dist/output.css" rel="stylesheet">
    <link href="assets/jQuery-Plugin-For-Easily-Readable-JSON-Data-Viewer/json-viewer/jquery.json-viewer.css"
          rel="stylesheet">
    <script
            src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
            crossorigin="anonymous"></script>
    <script src="assets/jQuery-Plugin-For-Easily-Readable-JSON-Data-Viewer/json-viewer/jquery.json-viewer.js"></script>


    <script>
        $(document).ready(function () {
            $("body").on("click", ".addSon", function () {
                let idParent = $(this).data("id");
                let nameSon = $("#input_son_" + idParent).val();
                $("#input_son_" + idParent).val('');

                addSon(idParent, nameSon);
            });

            $("body").on("click", ".removePerson", function () {
                let idParent = $(this).data("id");

                deletePeople(idParent);

                console.log(idParent);
            });

            $("body").on("click", ".removeSon", function () {
                let idParent = $(this).data("id");
                let idSon = $(this).data("son-id");

                deleteSon(idParent, idSon);

                console.log(idParent);
            });

            $("body").on("click", "#recordButton", function () {
                let storageData = localStorage.getItem("peoples");
                $.post("process.php", {peoples: storageData})
                    .done(function (data) {
                        alert("Data Loaded: " + data);
                    });
            });
        });

        let peoples = [];
        let person = {
            name: "",
            children: []
        };


        function mapPeople(peopleList) {
            let peopleListTable = document.getElementById("peopleList");
            peopleListTable.innerHTML = '';

            peopleList.forEach((people, index) => {

                // Elements
                let personElement = document.createElement("div");
                let personTextNameElement = document.createElement("h1");
                let personButtonDeleteElement = document.createElement("button");
                let personInputSonElement = document.createElement("input");
                let personButtonAddSonElement = document.createElement("button");
                let personChildrenElement = document.createElement("div");
                let line = document.createElement("hr");
                let line2 = document.createElement("hr");

                // Attributes
                personInputSonElement.setAttribute("name", "input_son_" + index);
                personInputSonElement.setAttribute("id", "input_son_" + index);
                personInputSonElement.setAttribute("class", 'p-1 border-1 border-slate-500')
                personButtonAddSonElement.setAttribute("class", "addSon bg-blue-600 text-white p-1 rounded-md m-2");
                personButtonAddSonElement.setAttribute("data-id", index);
                personChildrenElement.setAttribute("class", 'bg-blue-300 w-full');
                personTextNameElement.innerHTML = people.name;
                personButtonAddSonElement.innerHTML = "Add Filho";
                personButtonDeleteElement.innerHTML = "Excluir";
                personTextNameElement.setAttribute("class", 'text-2xl text-blue-600');
                personButtonDeleteElement.setAttribute("class", 'bg-red-600 text-white p-1 rounded-md removePerson');
                personButtonDeleteElement.setAttribute("data-id", index);
                line.setAttribute("class", 'w-full border-2 border-gray-600 m-1');
                line2.setAttribute("class", 'w-full border-2 border-blue-600 m-1');


                // Make Default Element
                personElement.appendChild(personTextNameElement);
                personElement.appendChild(personButtonDeleteElement);
                personElement.appendChild(line);
                personElement.appendChild(personInputSonElement);
                personElement.appendChild(personButtonAddSonElement);
                personChildrenElement.appendChild(line2);


                people.children.forEach((son, indexSon) => {
                    let childrenParagraphElement = document.createElement("p");

                    let sonDeleteButtonElement = document.createElement("button");

                    sonDeleteButtonElement.setAttribute("data-id", index);
                    sonDeleteButtonElement.setAttribute("data-son-id", indexSon.toString());
                    sonDeleteButtonElement.setAttribute("class", 'bg-red-600 text-white p-1 rounded-md mx-8 removeSon');

                    sonDeleteButtonElement.innerHTML = "Remove Son";
                    childrenParagraphElement.appendChild(document.createTextNode(son.name));
                    childrenParagraphElement.appendChild(sonDeleteButtonElement);

                    personChildrenElement.appendChild(childrenParagraphElement);
                });

                peopleListTable.appendChild(personElement);
                peopleListTable.appendChild(personChildrenElement);
            });
        }

        function addPerson() {
            person.name = $("#name").val();
            $("#name").val('');
            let name = Object.assign({}, person);
            peoples.push(name);
            person.children = [];
            localStorage.setItem("peoples", JSON.stringify(peoples));

            mapPeople(peoples);

            $('#textArea').jsonViewer(peoples);
        }

        function addSon(parentIndex, name) {
            let son = Object.assign({}, {
                name: name
            });

            peoples[parentIndex].children.push(son);
            mapPeople(peoples);

            localStorage.setItem("peoples", JSON.stringify(peoples));
            $('#textArea').jsonViewer(peoples);
        }

        function deletePeople(parentIndex) {
            delete peoples[parentIndex];

            peoples = peoples.filter(function (n) {
                return n;
            });

            mapPeople(peoples);
            $('#textArea').jsonViewer(peoples);
            localStorage.setItem("peoples", JSON.stringify(peoples));
            console.log(peoples);
        }

        function deleteSon(parentIndex, sonIndex) {
            delete peoples[parentIndex].children[sonIndex];

            peoples[parentIndex].children = peoples[parentIndex].children.filter(function (n) {
                return n;
            });

            mapPeople(peoples);
            $('#textArea').jsonViewer(peoples);
            localStorage.setItem("peoples", JSON.stringify(peoples));
            console.log(peoples);
        }
    </script>
</head>
<body class="p-8">
<div class="flex">
    <button class="bg-blue-600 text-white p-1 rounded-md mx-8" id="recordButton">Gravar</button>
    <button class="bg-blue-600 text-white p-1 rounded-md" onclick="location.href='index.php?ler=true';"> Ler</button>
</div>
<div>
    <input type="text" name="name" placeholder="nome" id="name">
    <button onclick="addPerson()" class="bg-blue-600 text-white p-1 rounded-md mx-4">salvar</button>
</div>
<div>
    <div>
        <div>
            <h3 class="text-xl text-blue-800">pessoas</h3>
        </div>
        <div>
            <div class="grid gap-4 grid-cols-2">
                <div>
                    <table class="bg-gray-200 p-2" id="peopleList">
                        <?php
                        if ($_GET['ler'] === "true"):
                            foreach ($people as $person):
                                ?>
                                <tr>
                                    <td><?= $person['name'] ?></td>
                                </tr>
                            <?php
                            endforeach;
                        endif;
                        ?>
                    </table>
                </div>
                <div>
                    <pre id="textArea">
                    </pre>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
