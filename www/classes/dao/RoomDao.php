<?php


interface RoomDao
{
    public function getAllRooms(): array;

    public function insertRoom($name, $capacity);

    public function deleteRoomById($roomId);

    public function getRoomById($roomId);

    public function updateRoom($id, $name, $capacity);
}