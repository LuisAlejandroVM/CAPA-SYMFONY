var app = angular.module('user', []);
const url = "http://localhost/symfonyApp/public/index.php";

app.controller('UserController', function($scope, $http){

    const findAll = () => {
        
        return $http.get(window.location.href + "?slug=findAll").then((res) => {
            let listUsers = res.data.listUsers;
            
            listUsers.forEach((user, index) => {
                let row = document.createElement("tr");
                row.innerHTML = `
                    <td>${ index + 1 }</td>
                    <td>${ user.name }</td>
                    <td>${ user.lastname }</td>
                    <td>${ user.email }</td>
                    <td>${ user.status }</td>
                    <td>
                        <a href="${ url }/user/update/${ user.idUser }" class="btn btn-primary">Modificar</a>
                        <a href="${ url }/user/delete/${ user.idUser }" class="btn btn-danger">Eliminar</a>
                    </td>
                `;
                document.getElementById("fillUsers").appendChild(row);
            });
        
        }, (error) => {
            console.log(error);
        });

    };

    findAll();
});






