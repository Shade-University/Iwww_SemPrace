<?php
require_once './classes/Helpers.php';
require_once './classes/dao/RoomDaoImpl.php';

class RoomsController
{
    protected $_roomDao;

    public function __construct()
    {
        $this->_roomDao = new RoomDaoImpl();
    }

    public function createRoomTable()
    {
        $headers = array('ID', 'Name', 'Capacity', 'Actions');
        $rooms = $this->_roomDao->getAllRooms();

        echo '<table id="roomsTable">';
        echo '<tr>';
        foreach ($headers as $header) {
            echo '<th>' . $header . '</th>';
        }
        echo '</tr>';

        foreach ($rooms as $room) {
            echo '<tr>';
            echo '<td>' . $room['id'] . '</td>';
            echo '<td>' . $room['name'] . '</td>';
            echo '<td>' . $room['capacity'] . '</td>';

            echo '<td><a href="index.php?page=AdministrationPage&crud=Rooms&deleteRoom=' . $room['id'] . '" class="action-btn ab-delete" data-tooltip="Delete"
                        data-modal-anchor="delete-grade"><img src="./img/delete.svg" alt="Delete"></a>
                  <a href="index.php?page=AdministrationPage&crud=Rooms&editRoom=' . $room['id'] . '" class="action-btn ab-edit" data-tooltip="Edit" data-modal-anchor="room-user">
                        <img src="./img/edit.svg" alt="Edit"></a></td>';

            echo '</tr>';
        }

        echo '</table';
    }

    public function createRoom($data)
    {
        $errorMsg = "";
        if($this->validate($data, $errorMsg)) {
            $this->_roomDao->insertRoom($data['name'], $data['capacity']);
        } else {
            Helpers::alert($errorMsg);
        }
    }

    public function deleteRoom($roomId)
    {
        $this->_roomDao->deleteRoom($roomId);
    }

    public function getRoom($roomId)
    {
        return $this->_roomDao->getRoomById($roomId);
    }

    public function updateRoom($data)
    {
        $errorMsg = "";
        if($this->validate($data, $errorMsg))
        {
            $this->_roomDao->updateRoom($data['id'], $data['name'], $data['capacity']);
        } else {
            Helpers::alert($errorMsg);
        }
    }

    private function validate($data, &$msg)
    {
        if(empty($data['name']) ||
            empty($data['capacity'])) {
            $msg = "Cannot be empty";
            return false;
        }
        if(!is_numeric($data['capacity'])) {
            $msg = "Capacity must be number";
            return false;
        }

        return true;
    }




}