<div class="paginationjs-pages">
  <ul>
    <?
    if ($this->NavPageNomer > 1) {
      echo '<li class="beginning act" data-pagenum="1"><span>' . $sBegin . '</span></li>';
      echo  '<li class="previous act" data-pagenum="' . ($this->NavPageNomer - 1) . '"><span>' . $sPrev . '</span></li>';
    } else {
      echo '<li class="beginning">' . $sBegin . '</li>';
      echo '<li class="previous">' . $sPrev . '</li>';
    }
    $NavRecordGroup = $nStartPage;
    while ($NavRecordGroup <= $nEndPage) {
      if ($NavRecordGroup == $this->NavPageNomer)
        echo ('<li class="paginationjs-page active" data-pagenum="' . $NavRecordGroup . '"><span>' . $NavRecordGroup . '</span></li>');
      else
        echo ('<li class="paginationjs-page" data-pagenum="' . $NavRecordGroup . '"><span>' . $NavRecordGroup . '</span></li>');
      $NavRecordGroup++;
    }

    if ($this->NavPageNomer < $this->NavPageCount) {
      echo '<li class="end act" data-pagenum="' . $this->NavPageCount . '"><span>' . $sEnd . '</span></li>';
      echo '<li class="next act" data-pagenum="' . ($this->NavPageNomer + 1) . '"><span>' . $sNext . '</span></li>';
    } else {
      echo '<li class="end">' . $sEnd . '</li>';
      echo '<li class="next">' . $sNext . '</li>';
    }
    ?>
  </ul>
</div>