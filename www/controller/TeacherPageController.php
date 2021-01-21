<?php
require_once './classes/dao/SubjectDaoImpl.php';
require_once './classes/dao/RoomDaoImpl.php';
require_once './classes/dao/ScheduleDaoImpl.php';
require_once './classes/dao/ScheduleUserDaoImpl.php';
require_once './classes/dao/UserDaoImpl.php';
require_once './classes/dao/GradeDaoImpl.php';

require_once './classes/validators/GradeValidator.php';
require_once './classes/validators/ScheduleValidator.php';
require_once './classes/validators/SubjectValidator.php';

require_once './classes/Helpers.php';

class TeacherPageController
{
    protected $_subjectDao;
    protected $_roomDao;
    protected $_scheduleDao;
    protected $_scheduleUserDao;
    protected $_userDao;
    protected $_gradesDao;

    protected $_gradeValidator;
    protected $_subjectValidator;
    protected $_scheduleValidator;

    public function __construct()
    {
        $this->_subjectDao = new SubjectDaoImpl();
        $this->_roomDao = new RoomDaoImpl();
        $this->_scheduleDao = new ScheduleDaoImpl();
        $this->_scheduleUserDao = new ScheduleUserDaoImpl();
        $this->_userDao = new UserDaoImpl();
        $this->_gradesDao = new GradeDaoImpl();

        $this->_gradeValidator = new GradeValidator();
        $this->_scheduleValidator = new ScheduleValidator($this->_subjectDao, $this->_roomDao);
        $this->_subjectValidator = new SubjectValidator($this->_subjectDao);
    }

    public function createSubjectTable()
    {
        $headers = array('ID', 'Name', 'Description', 'View', 'Actions');
        $subjects = $this->_subjectDao->getAllSubjects();

        echo '<table id="subjectsTable">';
        echo '<tr>';
        foreach ($headers as $header) {
            echo '<th>' . $header . '</th>';
        }
        echo '</tr>';

        foreach ($subjects as $subject) {
            echo '<tr class="clickable-row" data-subject-id="' . $subject['id'] . '">';
            echo '<td>' . $subject['id'] . '</td>';
            echo '<td>' . $subject['name'] . '</td>';
            echo '<td>' . $subject['description'] . '</td>';

            echo '<td>
                     <a href="?page=TeacherPage&addSchedule=' . $subject['id']
                . '" class="view-btn" data-modal-anchor="create-schedule">Create schedule</a>
                  </td>';

            echo '<td><a href="index.php?page=TeacherPage&deleteSubject=' . $subject['id'] . '" class="action-btn ab-delete" data-tooltip="Delete"
                        data-modal-anchor="delete-subject"><img src="./img/delete.svg" alt="Delete"></a>
                  <a href="index.php?page=TeacherPage&editSubject=' . $subject['id'] . '" class="action-btn ab-edit" data-tooltip="Edit" data-modal-anchor="subject-user">
                        <img src="./img/edit.svg" alt="Edit"></a></td>';
            echo '</tr>';
        }

        echo '</table';
    }

    public function createScheduleTable($view)
    {
        $subject = $this->_subjectDao->getSubjectById($view);
        $schedules = $this->_scheduleDao->getSchedulesBySubjectId($subject['id']);

        $days = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday");
        $hours = array("07:00", "08:00", "09:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00", "17:00",
            "18:00", "19:00", "20:00", "21:00");

        echo '
        <div class="schedule-inner">
                        <h3 class="sch-title">
                            Schedule
                            <br/><br/>
                            Subject:<br/><span>' . $subject['name'] . '</span>
                        </h3>
                        <div class="schedule-table">
                            <div class="st-head flex-box">
                                <div class="col-1">
                                    <span class="time-span">From</span>
                                    <span class="time-span">To</span>
                                </div>';

        for ($i = 0; $i < count($hours) - 1; $i++) {
            echo '<div class="col-1">';
            echo '<span class="time-span">' . $hours[$i] . '</span>';
            echo '<p class="hour-id">' . ($i + 1) . '</p>';
            echo '<span class="time-span">' . $hours[$i + 1] . '</span>';
            echo '</div>';
        }
        echo '</div>'; //Create table header with times


        foreach ($days as $day) {
            echo '<div class="st-row flex-box">';
            echo '<div class="col-1" ><span class="day">' . $day . '</span ></div>';
            foreach ($hours as $hour) {
                $filtered = null;
                foreach ($schedules as $schedule) {
                    if (Helpers::convertDbTime($schedule['lesson_start']) === $hour && $schedule['day'] === $day) {
                        $filtered = $schedule;
                        break;
                    }
                }

                if ($filtered != null) {
                    $start = strtotime($filtered['lesson_start']);
                    $end = strtotime($filtered['lesson_end']);
                    $hourDiff = ($end - $start) / (60 * 60); //Get time diff in hours which will be used as col-size
                    echo '<div class="col-' . $hourDiff . ' col-subject practice">';
                    echo '<a href="?page=TeacherPage&view=' . $subject['id'] .
                        '&editSchedule=' . $filtered['id'] . '" class="line-overflow">' . $subject['name'] . '</a ></div>';
                } else {
                    echo '<div class="col-1"><span></span></div>'; //If no schedule, empty col
                }
            }
            echo '</div>';
        }
        echo '</div></div>';
    }

    public function createStudentsListForSchedule($scheduleId)
    {
        $students = array_unique($this->_scheduleUserDao->getScheduleUserByScheduleId($scheduleId), SORT_REGULAR);
        $students = array_intersect_key($students, array_unique(array_map(function ($el) {
            return $el['id_user'];
        }, $students))); //return only uniques users

        echo '<div class="student-list flex-box">
                    <div class="col">
                        <div class="list">';
        foreach ($students as $student) {
            $user = $this->_userDao->getUserById($student['id_user']);
            $url = '?page=TeacherPage&view='
                . $_GET['view'] . '&editSchedule=' . $_GET['editSchedule'];
            echo '<a href="' . $url . '&student=' . $user['id'] . '" class="item ';
            if ($_GET['student'] == $user['id']) echo 'active';
            echo '">' . $user['firstname'] . ' ' . $user['lastname'] . '</a>';

        }
        echo '</div></div>';

    }

    public function createStudentGrades($studentId, $scheduleId)
    {
        $student = $this->_userDao->getUserById($studentId);
        $studentGrades = $this->_scheduleUserDao->getScheduleUserByScheduleIdAndUserId($scheduleId, $studentId);
        echo '<div class="col">
                        <div class="grades">';
        echo '<a href="?page=TeacherPage&view='
            . $_GET['view'] . '&editSchedule=' . $_GET['editSchedule'] . '&student=' . $_GET['student'] .
            '&expell=' . $student['id'] . '"class="expell" data-modal-anchor="expell-student">Expell the student</a>';
        //Build expell student url from GET parameters

        echo '<p>Name: <span>' . $student['firstname'] . ' ' . $student['lastname'] . '</span>';
        echo '</br></br>Grades:</p>
                            <div class="grade-box">
                                <button class="add-new-grade" data-modal-anchor="create-grade">Add new grade +</button>
                                <table>
                                    <tr>
                                        <th>Task name</th>
                                        <th>Grade</th>
                                        <th>Actions</th>
                                    </tr>
                                ';
        //Header

        foreach ($studentGrades as $studentGrade) {
            $grade = $this->_gradesDao->getGradeById($studentGrade['id_grade']);
            if ($grade != null) {
                echo '<tr><td>' . $grade['type'] . '</td><td>' . $grade['grade'] . '</td>';
                echo '<td><a href="' . $_SERVER['REQUEST_URI'] . '&removeGrade=' . $studentGrade['id'] . '">Delete</a></td></tr>';
                //Build url to remove grade without losing get parameters
            }
        }
        echo '    </table>
                </div>
              </div>
             </div>
            </div>';
    }

    public function createRoomOptions()
    {
        foreach ($this->_roomDao->getAllRooms() as $room) {
            echo '<option value="' . $room['id'] . '"';
            echo '>' . $room['name'] . '</option>';
        }
    }

    public function createSubject($data)
    {
        $errorMsg = "";
        if ($this->_subjectValidator->validate($data, $errorMsg)) {
            $this->_subjectDao->insertSubject($data['name'], $data['description']);
        } else {
            Helpers::alert($errorMsg);
        }
    }

    public function createSchedule($data)
    {
        $errorMsg = "";
        if ($this->_scheduleValidator->validate($data, $errorMsg)) {
            $this->_scheduleDao->insertSchedule($data['day'], $data['lesson_start'], $data['lesson_end'], $data['subject'], $data['room']);
        } else {
            Helpers::alert($errorMsg);
        }
    }

    public function createGrade($data)
    {
        $errorMsg = "";
        if ($this->_gradeValidator->validate($data, $errorMsg)) {
            $id = $this->_gradesDao->insertGrade($data['grade'], $data['type']);
            $this->_scheduleUserDao->insertScheduleUser($data['schedule'], $data['student'], $id);
        } else {
            Helpers::alert($errorMsg);
        }
    }

    public function deleteSubject($subjectId)
{
    $this->_subjectDao->deleteSubjectById($subjectId);
}

    public function deleteSchedule($scheduleId)
    {
        $this->_scheduleDao->deleteScheduleById($scheduleId);
    }

    public function deleteGradeFromSchedule($id)
    {
        $this->_scheduleUserDao->deleteScheduleUserById($id);
    }

    public function getSubject($subjectId)
    {
        return $this->_subjectDao->getSubjectById($subjectId);
    }

    public function updateSubject($data)
    {
        $errorMsg = "";
        if ($this->_subjectValidator->validate($data, $errorMsg)) {
            $this->_subjectDao->updateSubject($data['id'], $data['name'], $data['description']);
        } else {
            Helpers::alert($errorMsg);
        }
    }

    public function getSchedule($editSchedule)
    {
        return $this->_scheduleDao->getScheduleById($editSchedule);
    }

    public function expellStudent($editSchedule, $expell)
    {
        $this->_scheduleUserDao->deleteScheduleUserByScheduleIdAndUserId($editSchedule, $expell);
    }




}