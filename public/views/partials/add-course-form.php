<?php
$instructors = R::findAll('instructor');
?>

<h2>Add a course</h2>

<form method="POST" action="/routes/add-course.php">
  <div>
    <label>
      Course Name
    <input type="text" name="name" />
    </label>
  </div>
  <div>
    <label>
      Instructor
      <select name="instructor">
        <?php foreach($instructors as $instructor): ?>
          <option value="<?= $instructor->id ?>"><?= $instructor->getListName() ?></option>
        <?php endforeach; ?>
      </select>
    </label>
  </div>
  <div>
    <label>
      Days
      <select name="days[]" multiple>
        <option value="1">Sunday</option>
        <option value="2">Monday</option>
        <option value="3">Tuesday</option>
        <option value="4">Wednesday</option>
        <option value="5">Thursday</option>
        <option value="6">Friday</option>
        <option value="7">Saturday</option>
      </select>
    </label>
  </div>
  <div>
    <label>
      Start time
      <input type="time" name="start_time">  
    </label>
  </div>
  <div>
    <label>
      End time
      <input type="time" name="end_time">  
    </label>
  </div>
  <button>Submit</button>
</form>

