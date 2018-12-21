<?php
if ($user['status'] == 'admin') {
?>
	<div>
		<p><a href="<?= $_SERVER['SCRIPT_NAME'] ?>?model=<?= $this->requestObject->model ?>&command=create&page=<?= $this->requestObject->page ?>">Добавить товар</a>
		</p>
	</div>
<?php
}
?>
</div>
<div class="container">	
	<?php
foreach ($this->dataObject->dataArray as $item) {
?>
		<div class="item">
			<div class="image-box">
				<img src="images/<?= $item['picture'] ?>">
			</div>
			<p class="tovar_text">
				<?= $item['name'] ?><br>
				<?= $item['title'] ?><br>
				<?= $item['collor'] ?> <br><br>
				<?= $item['prise'] ?> Br<br>
			</p>
			
			<a href="<?= $_SERVER['SCRIPT_NAME'] ?>?model=<?= $this->requestObject->model ?>&command=about&page=<?= $this->requestObject->page ?>&id=<?= $item['id'] ?>">Подробнее</a>
				<?php
				if ($user['status'] == 'admin') {
				?>
				<br>
					<a href="<?= $_SERVER['SCRIPT_NAME'] ?>?model=<?= $this->requestObject->model ?>&command=update&page=<?= $this->requestObject->page ?>&id=<?= $item['id'] ?>">Редактировать</a> 
					<a href="<?= $_SERVER['SCRIPT_NAME'] ?>?model=<?= $this->requestObject->model ?>&command=delete&page=<?= $this->requestObject->page ?>&id=<?= $item['id'] ?>">Удалить</a>
				<?php
				}
				?>
				
				
				
				
		</div>
		<?php
}
?>
</div>