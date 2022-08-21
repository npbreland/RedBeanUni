<?php $title = 'Instructor Profile'; ?>
<?php include 'partials/header.php'; ?>
<h1>Instructor Profile</h1>
<p><?= $instructor->first_name ?> <?= $instructor->last_name ?></p>
<p><?= $instructor->getDateOfBirthString() ?></p>

<h2>Current Term Schedule</h2>
<table>
  <thead>
    <th>Course</th>
    <th>Days & Time</th>
  </thead>
  <tbody>
    <?php foreach($instructor->getCurrentTermOfferings() as $offering): ?>
      <tr>
        <td><?= $offering->course->name ?></td>
        <td><?= $offering->listDayFormat() ?> <?= $offering->start_time ?>-<?= $offering->end_time ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<h2>Today's Schedule</h2>
<table>
  <thead>
    <th>Course</th>
    <th>Time</th>
  </thead>
  <tbody>
    <?php foreach($instructor->getTodaysOfferings() as $offering): ?>
      <tr>
        <td><?= $offering->course->name ?></td>
        <td><?= $offering->start_time ?>-<?= $offering->end_time ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
