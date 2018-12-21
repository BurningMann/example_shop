<div class="pagination">
<?php
for ($i = 1; $i <= $this->dataObject->pagesCount; $i++)
{
    if ($i==$this->dataObject->currentPage)
    {
        echo $i.' ';
    }
    else
    {
        echo '<a href="index.php?model=' . $this->requestObject->model . 
                '&page=' . $i . '">' . $i . '</a> ';
    }
}
?>
    </hr>
</div>