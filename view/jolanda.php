<style scoped>
 
</style>
<div class=jolanda>
 <h2><?php echo($_JOLANDA['nadpis']); ?></h2>
 <p><?php echo($_JOLANDA['zprava']); ?></p>
 <?php if($_JOLANDA['obrazek']){ ?>
  <img src="http://<?php echo $_SERVER['HTTP_HOST'] ?>/img/jolanda.png"/>
 <?php } ?>
</div>
