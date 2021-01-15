<?php


interface RoomDao
{
    function getAllRooms();
    public function insertRoom($name, $capacity);
    public function deleteRoom($roomId);
    public function getRoomById($roomId);
    public function updateRoom($id, $name, $capacity);
}