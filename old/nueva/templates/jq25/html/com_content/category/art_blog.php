
<?php
if (isset($this->items[0])){
   $this->item = &$this->items[0];
   echo $this->loadTemplate('item');
}
?>
<?php
if (isset($this->items[1])){
   $this->item = &$this->items[1];
   echo $this->loadTemplate('item');
}
?>
<?php
if (isset($this->items[2])){
   $this->item = &$this->items[2];
   echo $this->loadTemplate('item');
}
?>
<?php
if (isset($this->items[3])){
   $this->item = &$this->items[3];
   echo $this->loadTemplate('item');
}
?>
