<?php

$passwords = $this->createAPI();

$categories = $passwords->listCategories();
$arraysort = array();
foreach($categories as $categorie){
  $arraysort[] = $categorie['category_name'];
}

array_multisort($arraysort, SORT_ASC, $categories);

echo '      <li id="ntPr-1" class="primary cat selected" aria-expanded="false" data-color="'.$item['category_colour'].'" role="treeitem" aria-level="1"><a onclick="passwords.list.load(\'-1\'); return false;">All</a></li>
';
foreach($categories as $item){
  echo '      <li id="ntPr'.$item['id'].'" class="cat" aria-expanded="false" data-color="'.$item['category_colour'].'" role="treeitem" aria-level="1"><a onclick="passwords.list.load(\''.$item['id'].'\'); return false;">'.$item['category_name'].'</a></li>
';
}

exit;