<?php include $_SERVER['DOCUMENT_ROOT'] . '/header.php';

$instructors = R::findAll('instructor');

?>

<h1>Instructors</h1>
<ul>
<?php foreach($instructors as $instructor): ?>
    <li><?= $instructor->getListName() ?></li>
<?php endforeach; ?>
</ul>

<?php include 'partials/add-instructor-form.php' ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/footer.html' ?>
