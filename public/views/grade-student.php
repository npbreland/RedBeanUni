<?php include $_SERVER['DOCUMENT_ROOT'] . '/header.php'; 
$student = R::load('student', $_GET['student']);

?>

<h1>Grade Student</h1>
<strong>Student: <?= $student->getListName() ?></strong>

<form method="POST" action="/routes/add-course-grade.php">
   <input type="hidden" name="student" value="<?= $student->id ?>">
  <div>
    <label>
      Course
      <select name="course">
        <?php foreach($student->sharedCourseList as $course): ?>
          <option value="<?= $course->id ?>"><?= $course->name ?></option>
        <?php endforeach; ?>
      </select>
    </label>
  </div>
  <div>
    <label>
      Grade
        <input type="number" name="grade_100" min="0" max="100">
    </label>
  </div>
  <button>Submit</button>
</form>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/footer.html' ?>
