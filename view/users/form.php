<h2><?=$caption?></h2>
<div>
    <form action="<?=$url?>" method="POST">
        <?= $this->dataObject->error?"<p>{$this->dataObject->error}</p>":''?>
        <p>Логин<br><input type="text" size="40" name="login" value="<?=$this->dataObject->dataArray['login']?>" maxlength="40" required></p>
        <p>Статус (admin, user)<br><input type="text" size="40" name="status" value="<?=$this->dataObject->dataArray['status']?>" maxlength="40" required></p>
        <p>Пароль (чтобы оставить текущий пароль без изменения, не заполняется)<br><input type="password" size="40" name="password" value="" maxlength="40"></p>
        <p>Подтверждение пароля<br><input type="password" size="40" name="password1" value="" maxlength="40"></p>
        <p><input type="submit" value="Отправить"></p>
    </form>
    <p><a href="<?=$_SERVER['SCRIPT_NAME']?>?model=users&page=<?=$this->requestObject->page?>">Отмена</a></p>
</div>
