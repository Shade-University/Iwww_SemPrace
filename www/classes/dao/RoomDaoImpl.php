<?php
require_once("./classes/dao/RoomDao.php");
require_once("./classes/Connection.php");

class RoomDaoImpl implements RoomDao
{
    protected $_db;

    public function __construct()
    {
        $this->_db = Connection::getPdoInstance();
    }

    public function getAllRooms(): array
    {
        $stmt = $this->_db->prepare("SELECT * FROM Room");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function insertRoom($name, $capacity)
    {
        $stmt = $this->_db->prepare("INSERT INTO Room(name, capacity)
         VALUES(:name, :capacity)");
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":capacity", $capacity);
        $stmt->execute();
    }

    public function deleteRoomById($roomId)
    {
        $stmt = $this->_db->prepare("DELETE FROM Room WHERE id = :id");
        $stmt->bindParam(":id", $roomId);
        $stmt->execute();
    }

    public function getRoomById($roomId)
    {
        $stmt = $this->_db->prepare("SELECT * FROM Room WHERE id = :id");
        $stmt->bindParam(":id", $roomId);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function updateRoom($id, $name, $capacity)
    {
        $stmt = $this->_db->prepare("UPDATE Room SET
                name = :name,
                capacity = :capacity WHERE id = :id");

        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":capacity", $capacity);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
    }
}