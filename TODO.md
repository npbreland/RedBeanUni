* Sessions (instances of Offerings)
  * Attendance (has parent Student and Session)

* Add department field to instructor
* Add degree program / major field to student

* Add prerequisites to courses

* Add degree requirements (how to structure this?)

* Departments
  * Has parent department

* URLs in REST response objects?
  * /students 
    * grades_url 
    * current_schedule_url 
    * todays_schedule_url
  * /instructors
    * current_schedule_url
    * todays_schedule_url

* Redbean enum for days?

* Business logic in models

* Single environment seeding (simulation) script

* Unit tests (connect to separate DB, nuke DB after tests) - not sure it's worth
it to try to separate business logic from data access layer

* Could I bring in a library for response helpers? (prevent having to roll my own exception classes)
* Validation (Symfony validation library?)
* Authorization (Symfony auth library or other?)
