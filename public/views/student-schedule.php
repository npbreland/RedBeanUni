<?php include $_SERVER['DOCUMENT_ROOT'] . '/header.php'; 
$student = R::load('student', $_GET['student']);
?>

<h1>Student Schedule</h1>
<table>
  <thead>
    <th>Name</th>
    <th>Instructor</th>
    <th>Days & Time</th>
  </thead>
  <tbody>
    <?php foreach($student->sharedCourseList as $course): ?>
      <tr>
        <td><?= $course->name ?></td>
        <td><?= $course->instructor->getListName() ?></td>
        <td><?= $course->listDayTimeFormat() ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/footer.html'; ?>
