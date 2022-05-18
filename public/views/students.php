<?php include $_SERVER['DOCUMENT_ROOT'] . '/header.php';

$students = R::findAll('student');

?>

<h1>Students</h1>
<ul>
<?php foreach($students as $student): ?>
    <li><?= $student->getListName() ?></li>
<?php endforeach; ?>
</ul>

<?php include 'partials/add-student-form.php' ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/footer.html' ?>
