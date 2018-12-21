<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>
      <?=$this->requestObject->model?>
  </title>
  <link href="css/style.css" rel="stylesheet" type="text/css">
  <script src="js/login.js"></script>
</head>
<body>
	<header class="codrops-header">
	<div id="logo">MAGAZINE</div>
		<div id="menu">
			<div class="nav-toggle">
				<span></span>
			</div>
			<ul>
				<li>
					<a href="index.php?model=Guestbook&page=1">Страница №1</a>
				</li>
				<li>
					<a  href="index.php?model=Blueth&page=1">Страница №2</a>
				</li>
				<li>
					<a  href="index.php?model=Shirt&page=1">Страница №3</a>
				</li>			
			</ul>		
		</div>		
  
	</header>
	<h1>
        <?=$this->requestObject->model?>
    </h1>
<?php
$user = $this->dataObject->session->getUser();
if ($user['id']) {
    $f = 'none';
    $r = 'block';
} else {
    $f = 'block';
    $r = 'none';
}
?>
    <div>
        <form id="loginform" style="display: <?=$f?>">
            <p id="loginerror"></p><!-- для сообщения об ошибке -->
            <p>Логин<br><input name="login" id="login" value=""/></p>
            <p>Пароль<br><input type="password" name="password" id="password" value=""/></p>
            <input type="button" value="Вход" onClick="sendRequest();"/><br />
        </form>
        <p id="logout" style="display: <?=$r?>"><span id="user"><?=$user['login']?></span> <a href="<?=$_SERVER['SCRIPT_NAME']?>?model=user&command=logout">Выход</a></p>
        <hr>
    </div>
    <div>
        
           
<?php
if ($user['status'] == 'admin') {
?>
            <a href="<?=$_SERVER['SCRIPT_NAME']?>?model=users">Пользователи</a>
<?php
}
?>