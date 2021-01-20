<?php
require_once './classes/dao/SubjectDaoImpl.php';
require_once './classes/dao/ScheduleUserDaoImpl.php';
require_once './classes/dao/ScheduleDaoImpl.php';
require_once './classes/dao/GradeDaoImpl.php';


class StudentPageController
{
    protected $_subjectDao;
    protected $_scheduleUserDao;
    protected $_scheduleDao;
    protected $_gradeDao;

    public function __construct()
    {
        $this->_subjectDao = new SubjectDaoImpl();
        $this->_scheduleUserDao = new ScheduleUserDaoImpl();
        $this->_scheduleDao = new ScheduleDaoImpl();
        $this->_gradeDao = new GradeDaoImpl();
    }

    public function createSubjectTable()
    {
        $headers = array('ID', 'Name', 'Description', 'Register lesson');
        $scheduleUser = $this->_scheduleUserDao->getScheduleUserByUserId($_SESSION['id']);
        $schedules = $this->_scheduleDao->getAllSchedules();

        $filtered = array_values(array_filter($schedules, function ($element) use ($scheduleUser) {
            foreach ($scheduleUser as $item) {
                if ($item['id_schedule'] == $element['id'])
                    return false;
            }
            return true;
        }));

        echo ' <h3>Other subjects</h3>
                <div class="table-wrap">
                    <table>
                        <tr>';
        foreach ($headers as $header) {
            echo '<th>' . $header . '</th>';
        }
        echo '</tr>';
        foreach ($filtered as $item) {
            $subject = $this->_subjectDao->getSubjectById($item['id_subject']);
            echo '<tr>';
            echo '<td>' . $item['id'] . '</td>';
            echo '<td>' . $subject['name'] . '</td>';
            echo '<td><span class="line-overflow">' . $subject['description'] . '</span></td>';
            echo '<td class="register-box">';
            echo '<a href="?page=StudentPage&registerSchedule=' . $item['id'] . '" class="view-btn" data-modal-anchor="confirm-subject">'
                . $item['day'] . " " . $item['lesson_start'] . " - " . $item['lesson_end'] . '</a>';
            echo '</td>';
            echo '</tr>';
        }

        echo '</table></div>';
    }

    public function createScheduleTable()
    {
        $scheduleUser = $this->_scheduleUserDao->getScheduleUserByUserId($_SESSION['id']);
        $schedules = array();
        foreach ($scheduleUser as $item) {
            array_push($schedules, $this->_scheduleDao->getScheduleById($item['id_schedule']));
        }

        $days = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday");
        $hours = array("07:00", "08:00", "09:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00", "17:00",
            "18:00", "19:00", "20:00", "21:00");

        echo ' <h2>My schedule</h2> 
                <div class="schedule">
                    <div class="schedule-inner">
                        <div class="schedule-table">
                            <div class="st-head flex-box">
                                <div class="col-1">
                                    <span class="time-span">From</span>
                                    <span class="time-span">To</span>
                             </div>';

        for ($i = 0; $i < count($hours) - 1; $i++) {
            echo '<div class="col-1">';
            echo '<span class="time-span"> ' . $hours[$i] . '</span > ';
            echo '<p class="hour-id"> ' . ($i + 1) . '</p > ';
            echo '<span class="time-span"> ' . $hours[$i + 1] . '</span > ';
            echo '</div > ';
        }
        echo '</div > '; //Create table header with times


        foreach ($days as $day) {
            echo '<div class="st-row flex-box" > ';
            echo '<div class="col-1" ><span class="day" > ' . $day . '</span ></div > ';
            foreach ($hours as $hour) {
                $filtered = null;
                $filtered = array_values(array_filter($schedules, function ($element) use ($hour, $day) {
                    $startTime = substr($element['lesson_start'], 0, -3); //From 12:00:00 format to 12:00
                    return $startTime === $hour && $element['day'] === $day;
                }));

                if ($filtered != null) {
                    $start = strtotime($filtered[0]['lesson_start']);
                    $end = strtotime($filtered[0]['lesson_end']);
                    $hourDiff = ($end - $start) / (60 * 60);
                    $subject = $this->_subjectDao->getSubjectById($filtered[0]['id_subject']);
                    echo '<div class="col-' . $hourDiff . ' col-subject practice"> ';
                    echo '<a href = "?page=StudentPage&editSchedule=' . $filtered[0]['id'] . '" class="line-overflow" > ' . $subject['name'] . ' </a ></div > ';
                } else {
                    echo '<div class="col-1" ><span ></span ></div > ';
                } //Check if schedule for this date exists, calculte how long and draw. Otherwise empty div
            }
            echo '</div > ';
        }
        echo '</div></div > ';
    }

    public function createStudentGradesList($scheduleId)
    {
        echo '<h3 class="ms-title">
            Grades list
           </h3>';
        $headers = array('Task name', 'Grade');
        $grades = $this->_scheduleUserDao->getScheduleUserByScheduleIdAndUserId($scheduleId, $_SESSION['id']);
        echo '
          <div class="student-list flex-box">
            <div class="col col-100">
              <div class="grades">
                <div class="grade-box">
                  <table>';
        echo '<tr>';
        foreach ($headers as $header) {
            echo '<th>' . $header . '</th>';
        };
        echo '</tr>';
        foreach ($grades as $gradeId) {
            $grade = $this->_gradeDao->getGradeById($gradeId['id_grade']);
            if ($grade != null) {
                echo '<tr>';
                echo '<td>' . $grade['type'] . '</td>';
                echo '<td>' . $grade['grade'] . '</td>';
                echo '</tr>';
            }
        }
        echo '                  </table>
                </div>
              </div>
            </div>
          </div>';
    }

    public function registerUserToSchedule($registerSchedule)
    {
        $this->_scheduleUserDao->insertScheduleUser($registerSchedule, $_SESSION['id'], null);
    }
}