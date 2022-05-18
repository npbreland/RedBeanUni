<?php include $_SERVER['DOCUMENT_ROOT'] . '/header.php'; 
$courses = R::findAll('course');
?>

<h1>Courses</h1>
<table>
  <thead>
    <th>Name</th>
    <th>Instructor</th>
    <th>Days</th>
    <th>Times</th>
  </thead>
  <tbody>
    <?php foreach($courses as $course): ?>
      <tr>
        <td><?= $course->name ?></td>
        <td><?= $course->instructor->getListName() ?></td>
        <td><?= $course->listDayFormat() ?></td>
        <td><?= "$course->start_time-$course->end_time" ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php include 'partials/add-course-form.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/footer.html'; ?>
