<?php $title = 'Student Profile'; ?>
<?php include 'partials/header.php'; ?>
<h1>Student Profile</h1>
<p><?= $student->first_name ?> <?= $student->last_name?></p>
<p>DOB: <?= $student->getDateOfBirthString() ?></p>
<p>Current GPA: <?= $student->getGradePointAverage() ?></p>

<h2>Current Term Schedule</h2>
<table>
  <thead>
    <th>Course</th>
    <th>Instructor</th>
    <th>Days & Time</th>
  </thead>
  <tbody>
    <?php foreach($student->getCurrentTermOfferings() as $offering): ?>
      <tr>
        <td><?= $offering->course->name ?></td>
        <td><?= $offering->instructor->getListName() ?></td>
        <td><?= $offering->listDayFormat() ?> <?= $offering->start_time ?>-<?= $offering->end_time ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<h2>Today's Schedule</h2>
<table>
  <thead>
    <th>Course</th>
    <th>Instructor</th>
    <th>Time</th>
  </thead>
  <tbody>
    <?php foreach($student->getTodaysOfferings() as $offering): ?>
      <tr>
        <td><?= $offering->course->name ?></td>
        <td><?= $offering->instructor->getListName() ?></td>
        <td><?= $offering->start_time ?>-<?= $offering->end_time ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<h2>All Grades</h2>
<table>
  <thead>
    <th>Course</th>
    <th>Instructor</th>
    <th>Grade</th>
  </thead>
  <tbody>
    <?php foreach($student->getAllGrades() as $grade): ?>
      <tr>
        <td><?= $grade->offering->course->name ?></td>
        <td><?= $grade->offering->instructor->getListName() ?></td>
        <td><?= $grade->score_100 ?>%</td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
