function sendRequest()
{
    var xhr = new XMLHttpRequest();
    //данные формы
    var requestData = {
        login : document.getElementById("login").value,
        password : document.getElementById("password").value
    }
    //преобразуем их в JSON
    var requestJSON = JSON.stringify(requestData);
    
    xhr.open('POST', 'index.php?model=user&command=login', true);
    //устанавливаем заголовок формата данных json
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onreadystatechange = updateDocument; //имя функции обработки ответа сервера

    function updateDocument() {
		
        if (xhr.readyState == 4) { //проверяем статус завершения запроса - 4
            if (xhr.status == 200) { //проверяем код состояния 200 - OK
                var answer = JSON.parse(xhr.responseText);
				
                if (answer.error) {
                    document.getElementById("loginerror").innerHTML = answer.error;
                } else {
					window.location.reload();
                    document.getElementById("loginerror").innerHTML = "";
                    document.getElementById("user").innerHTML = document.getElementById("login").value;
                    document.getElementById("password").value = "";
                    document.getElementById("loginform").style = "display: none";
                    document.getElementById("logout").style = "display: block";
					
                }
            }
        }
    }
    xhr.send(requestJSON); //посылаем данные методом POST
	
} 