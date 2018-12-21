<div>
    <p><a href="index.php?model=<?=$this->requestObject->model?>&command=create&page=<?=$this->requestObject->page?>">Добавить пользователя</a></p>
<?php
foreach ($this->dataObject->dataArray as $item) {
?>
<div>
    <p><?=$item['login']?> <?=$item['status']?><br>
    <a href="index.php?model=<?=$this->requestObject->model?>&command=update&page=<?=$this->requestObject->page?>&id=<?=$item['id']?>">Редактировать</a> 
    <a href="index.php?model=<?=$this->requestObject->model?>&command=delete&page=<?=$this->requestObject->page?>&id=<?=$item['id']?>">Удалить</a></p>
</div>
<?php
}
?>
<hr>
</div>
