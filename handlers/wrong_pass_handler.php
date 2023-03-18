<!DOCTYPE html>

<html>
<head>    
    <title>Восстановление пароля</title>
<meta charset='utf-8' />
<link rel = "stylesheet" href = "../css/normalize.css"  type = "text/css" />
<style>
body {
    width: 100%;
    height: 100%;
    min-height:100%;
    background-color:black;
    border-radius: 7px;
}

main {
    width:70%;
    min-width:70%;
    height:inherit;
    padding: 10px;
    margin:0 auto;
    border-left: 2px double blue;
 }

table {
    border-collapse:separate;
    border-spacing: 7px 5px;
    }    
td {
color:white;
width:60px;
}    
</style>
</head>

<body>
    <main>
    <h3 style = "color: yellow"> Хуево быть забывчивым </h3>   
<form action = "forgot_pass_handler.php" method = "POST" onsubmit = "return restore_pass();">
    <table>
    <tr>
        <td>Логин:</td> 
        <td><input style = "color:black" type = "text" name = "login" id = "login" required = "required" /></td>
    </tr>
        <tr>
        <td>Email:</td> 
            <td><input style = "color:black" type = "email" name = "email" id = "email" required = "required"/></td>
        </tr>    
    <tr>
        <td>ID:</td> 
        <td><input style = "color:black" type = "text" name = "id" id = "id" required = "required" pattern = "[0-9]{1,20}"/></td>   
    </tr>
    </table>
    <p style = "color:red; display:block; margin-top:0px; margin-bottom:1px">Указаны неверные данные</p>
    <input type = "submit" value = "Восстановить" style = "cursor: pointer"><br />    
     <p style = "color:red;display:block; margin-top:0" id = "errors"></p>
    </form>
   
</main>          
<script>
var login = document.getElementById("login");
var email = document.getElementById("email");
var id = document.getElementById("id");
var pattern_id = "/\d{1,20}/g";       
var submit_form = true;
var show_errors = document.getElementById("errors");

function restore_pass(){
var txt_count = "";        
    if(login.value === "" || login === null ){
    submit_form = false;
    txt_count += "Введите логин<br />";
    }

if(email.value === "" || email === null ){
    submit_form = false;
    txt_count += "Введите email<br />";
    }
    
if(id.value === "" || id === null){
    submit_form = false;
    txt_count += "Введите ID<br />";
    }    

show_errors.innerHTML = txt_count;    
    
return submit_form;
}
</script>    
</body>    
    
</html>    