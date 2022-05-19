<h1>Student Profile</h1>
<p><?= $student->first_name ?> <?= $student->last_name?></p>
<p><?= $student->date_of_birth ?></p>

<h2>Current Term Schedule</h2>
<table>
  <thead>
    <th>Course</th>
    <th>Instructor</th>
    <th>Days & Time</th>
  </thead>
  <tbody>
    <?php foreach($student->sharedClassList as $class): ?>
      <tr>
        <td><?= $class->course->name ?></td>
        <td><?= $class->instructor->getListName() ?></td>
        <td><?= $class->listDayTimeFormat() ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
