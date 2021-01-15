<?php
require_once './controller/RoomsController.php';

$controller = new RoomsController();

if($_GET['deleteRoom']) {
    $controller->deleteRoom($_GET['deleteRoom']);
    header("Location: index.php?page=AdministrationPage&crud=Rooms"); //To remove get parameter
} elseif ($_GET['editRoom']) {
    $editRoom = $controller->getRoom($_GET['editRoom']); //Parameter removed in javascript on modal close
}

if($_POST['action'] == "addRoom") {
    $controller->createRoom($_POST);
} elseif($_POST['action'] == "editRoom") {
    $controller->updateRoom($_POST);
}

?>

<div class="card" data-page="rooms">
    <h2>Rooms</h2>
    <div class="control-row">
        <div class="search-form-wrap">
            <form class="search-form flex-box">
                <div class="input-box">
                    <input id="roomsSearchBar" type="search" placeholder="Search" name="Search" onkeyup="searchTable('roomsSearchBar', 'roomsTable', 1)">
                </div>
                <div class="search-btn">
                    <button><img src="./img/search.svg" alt="Search icon"></button>
                </div>
            </form>
        </div>
        <button class="btn-add" data-modal-anchor="create-room">
            <span class="icon"></span>
            <span>Create new room</span>
        </button>
    </div>
    <div class="table-wrap">
        <? $controller->createRoomTable(); ?>
    </div>
</div>

<div class="modal-window <? if ($_GET['editRoom']) echo 'show'; ?>">
    <div class="layer-hide"></div>
    <div class="modal-box edit-add">
        <p>Edit room: <strong><? echo $editRoom['id'] ?></strong></p>
        <form id="editRoomForm" class="edit-form flex-box" method="post" action="index.php?page=AdministrationPage&crud=Rooms">
            <input type="hidden" name="id" value="<? echo $editRoom['id'] ?>">
            <div class="input-box">
                <label for="name">Name</label>
                <input type="text" name="name" placeholder="Room name *" required
                       value="<? echo $editRoom['name'] ?>">
            </div>
            <div class="input-box">
                <label for="capacity">Capacity</label>
                <input type="text" name="capacity" placeholder="Room capacity *" required pattern="[0-9]*"
                       value="<? echo $editRoom['capacity'] ?>">
            </div>
            <input type="hidden" value="editRoom" name="action">
            <div class="input-box ib-placeholder"></div>
            <div class="input-box">
                <button type="submit" form="editRoomForm" >Save</button>
            </div>
            <div class="input-box">
                <button type="reset" class="hide-modal">Storno</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-window" data-modal="create-room">
    <div class="layer-hide"></div>
    <div class="modal-box edit-add">
        <p>Create room</p>
        <form id="createRoomForm" class="edit-form flex-box" method="post" action="index.php?page=AdministrationPage&crud=Rooms">
            <div class="input-box">
                <label for="name">Name</label>
                <input type="text" name="name" placeholder="Room name *" required>
            </div>
            <div class="input-box">
                <label for="capacity">Capacity</label>
                <input type="text" name="capacity" placeholder="Room capacity *" required pattern="[0-9]*">
            </div>
            <div class="input-box ib-placeholder"></div>
            <input type="hidden" name="action" value="addRoom">
            <div class="input-box">
                <button type="submit" form="createRoomForm">Create</button>
            </div>
            <div class="input-box">
                <button type="reset" form="createRoomForm" class="hide-modal">Storno</button>
            </div>
        </form>
    </div>
</div>