<?php echo $header; ?>
  <div id="content">
 <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
 
	<div class="accountWrap">

    <h1><?php echo $heading_title; ?></h1>
    <div class="content"><?php echo $text_error; ?></div>
    <div class="buttons">
      <div class="right"><a href="<?php echo $continue; ?>" class="button"><span><?php echo $button_continue; ?></span></a></div>
    </div>
    </div>
    <?php echo $column_right; ?>
    <div class="clear">
    </div>
</div>
<?php echo $footer; ?>