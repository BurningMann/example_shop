<h2 style="margin-left:40%;"><?=$caption?></h2>
<div class="container" style="padding:50px 20%;">
    <form action="<?=$url?>" method="POST" style="text-align:center;">
        <?= $this->dataObject->error?"<p>{$this->dataObject->error}</p>":''?>
		
		
        <p>Название<br><input type="text" size="40" name="name" value="<?=$this->dataObject->dataArray['name']?>" maxlength="40" required></p>
		
        <p>Заголовок<br><input type="text" size="40" name="title" value="<?=$this->dataObject->dataArray['title']?>" maxlength="40" required></p>
		
		<p>Цвет<br><input type="text" size="40" name="collor" value="<?=$this->dataObject->dataArray['collor']?>" maxlength="40" required></p>
		
		<p>Цена<br><input type="text" size="40" name="prise" value="<?=$this->dataObject->dataArray['prise']?>" maxlength="40" required></p>
		
		<p>Картинка<br><input type="text" size="40" name="picture" value="<?=$this->dataObject->dataArray['picture']?>" maxlength="40" required></p>
		
		<p>Описание<br><textarea name="description" rows="10" cols="40"  maxlength="1000" required><?=$this->dataObject->dataArray['description']?></textarea></p>
		
		<p>Материал<br><input type="text" size="40" name="material" value="<?=$this->dataObject->dataArray['material']?>" maxlength="40" required></p>
		
        <p><input type="submit" value="Отправить"></p>
		
		
    </form>
    <p><a href="<?=$_SERVER['SCRIPT_NAME']?>?model=<?= $this->requestObject->model ?>&page=<?=$this->requestObject->page?>">Отмена</a></p>
</div>
