<?php include $_SERVER['DOCUMENT_ROOT'] . '/header.php';

$students = R::findAll('student');

print_r( R::dump($students) );



?>

<h1>Students</h1>
<ul>
<?php foreach($students as $student): ?>
    <li><?= $student->last_name ?></li>
<?php endforeach; ?>
</ul>

<?php include 'partials/add-student-form.php' ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/footer.html' ?>
