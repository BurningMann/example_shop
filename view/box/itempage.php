<div class="container">

<div class="item_left">
	<p class="tovar_text">
				<?=$this->dataObject->dataArray['name']?><br><br>
				<?=$this->dataObject->dataArray['title']?><br><br>
				<?=$this->dataObject->dataArray['collor']?> <br><br>
				<?=$this->dataObject->dataArray['description']?> <br><br>
				Состав: <?=$this->dataObject->dataArray['material']?> <br><br>
				<?=$this->dataObject->dataArray['prise']?> Br<br>
			</p>

</div>

<div class="item_right">
	<div class="image-box">
		<img src="images/<?=$this->dataObject->dataArray['picture']?>">
	</div>
</div>



</div>