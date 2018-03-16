<?php snippet('header') ?>
  
  <?= css('assets/plugins/mailman/mailman.css') ?>
  
  <main class="main" role="main">

    <header class="wrap">
      <h1><?= $page->title()->html() ?></h1>
      <div class="intro text">
        <?= $page->intro()->kirbytext() ?>
      </div>
      <hr />
    </header>
      
    <div class="text wrap">
      <form action="<?php echo $page->url() ?>" method="POST">
         <label for="email">Meine E-Mail</label>
         <input name="email" id="email" type="email" value="<?php echo $form->old('email'); ?>">
         <?php echo csrf_field(); ?>
         <?php echo honeypot_field(); ?>
         <input type="submit" value="Eintragen">
      </form>
      <?php if ($form->success()): ?>
         Success!
      <?php else: ?>
         <?php snippet('uniform/errors', ['form' => $form]); ?>
      <?php endif; ?>
    </div>

  </main>

<?php snippet('footer') ?>