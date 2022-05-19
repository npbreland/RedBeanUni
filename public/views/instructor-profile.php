<h1>Instructor Profile</h1>
<p><?= $instructor->first_name ?> <?= $instructor->last_name ?></p>
<p><?= $instructor->date_of_birth ?></p>

<h2>Current Term Schedule</h2>
<table>
  <thead>
    <th>Course</th>
    <th>Days & Time</th>
  </thead>
  <tbody>
    <?php foreach($instructor->ownClassList as $class): ?>
      <tr>
        <td><?= $class->course->name ?></td>
        <td><?= $class->listDayTimeFormat() ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
