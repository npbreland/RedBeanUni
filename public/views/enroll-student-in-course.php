<?php include $_SERVER['DOCUMENT_ROOT'] . '/header.php';

$students = R::findAll('student');
$courses = R::findAll('course');

?>
<h2>Enroll student in a course</h2>

<form method="POST" action="/routes/enroll-student-in-course.php">
  <div>
    <label>
      Student
      <select name="student">
        <?php foreach($students as $student): ?>
          <option value="<?= $student->id ?>"><?= $student->getListName() ?></option>
        <?php endforeach; ?>
      </select>
    </label>
  </div>
  <div>
    <label>
      Course
      <select name="course">
        <?php foreach($courses as $course): ?>
          <option value="<?= $course->id ?>"><?= $course->name ?></option>
        <?php endforeach; ?>
      </select>
    </label>
  </div>
  <button>Submit</button>
</form>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/footer.html' ?>
