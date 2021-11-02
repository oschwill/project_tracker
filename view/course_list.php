<?php include 'view/header.php'?>

<?php if ($courses) {?>
  <section id="list" class="list">
    <header class="list__row list__header">
      <h1>Kurs Liste</h1>
    </header>

    <?php foreach ($courses as $course): ?>
      <div class="list__row">
        <div class="list__item">
          <p class="bold"><?=$course['courseName']?></p>
        </div>
        <div class="list__removeItem">
          <form action="." method="post">
            <input type="hidden" name="action" value="delete_course">
            <input type="hidden" name="course_id" value="<?=$course['id']?>">
            <button class="remove-button">❌</button>
          </form>
        </div>
      </div>
      <?php endforeach?>
  </section>
<?php } else {?>
  <p>Es existieren momentan keine Kurse.</p>
<?php }?>

<section id="add" class="add">
  <h2>Erstelle Kurs</h2>
  <form action="." method="post" id="add__form" class="add__form">
    <input type="hidden" name="action" value="add_course">
    <div class="add__inputs">
      <label>Name</label>
      <input type="text" name="course_name" maxlength="50" placeholder="Name" autofocus required>
    </div>
    <div class="add__addItem">
      <button class="add-button bold">Erstellen</button>
    </div>
  </form>
</section>
<br>
<p><a href=".">Assignments ansehen &amp; erstellen</a></p>
<?php include 'view/footer.php'?>