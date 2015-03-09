
<?php
// module/gutscheincode/view/gutscheincode/gutscheincode/delete.phtml:

$title = 'Delete gutscheincode';
$this->headTitle($title);
?>
 <h1><?php echo $this->escapeHtml($title); ?></h1>

 <p>Are you sure that you want to delete
     '<?php echo $this->escapeHtml($gutscheincode->id); ?>' by
     '<?php echo $this->escapeHtml($gutscheincode->status); ?>'?
     '<?php echo $this->escapeHtml($gutscheincode->wert); ?>'?
 </p>
 <?php
 $url = $this->url('gutscheincode', array(
     'action' => 'delete',
     'id'     => $this->id,
 ));
 ?>
 <form action="<?php echo $url; ?>" method="post">
 <div>
     <input type="hidden" name="id" value="<?php echo (int) $gutscheincode->id; ?>" />
     <input type="submit" name="del" value="Yes" />
     <input type="submit" name="del" value="No" />
 </div>
 </form>