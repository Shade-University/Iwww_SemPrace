<?php
require_once './controller/GradesController.php';

$controller = new GradesController();

if($_GET['deleteGrade']) {
    $controller->deleteGrade($_GET['deleteGrade']);
    header("Location: index.php?page=AdministrationPage&crud=Grades"); //To remove get parameter
} elseif ($_GET['editGrade']) {
    $editGrade = $controller->getGrade($_GET['editGrade']); //Parameter removed in javascript on modal close
}

if($_POST['action'] == "addGrade") {
    $controller->createGrade($_POST);
} elseif($_POST['action'] == "editGrade") {
    $controller->updateGrade($_POST);
}

?>

<div class="card" data-page="grades">
    <h2>Grades</h2>
    <div class="control-row">
        <div class="search-form-wrap">
            <form class="search-form flex-box">
                <div class="input-box">
                    <input id="gradesSearchBar" type="search" placeholder="Search" name="Search" onkeyup="searchTable('gradesSearchBar', 'gradesTable', 1)">
                </div>
                <div class="search-btn">
                    <button><img src="./img/search.svg" alt="Search icon"></button>
                </div>
            </form>
        </div>
        <button class="btn-add" data-modal-anchor="create-grade">
            <span class="icon"></span>
            <span>Create new grade</span>
        </button>
    </div>
    <div class="table-wrap">
        <? $controller->createGradeTable(); ?>
    </div>
</div>

<div class="modal-window <? if ($_GET['editGrade']) echo 'show'; ?>">
    <div class="layer-hide"></div>
    <div class="modal-box edit-add">
        <p>Edit grade: <strong><? echo $editGrade['id'] ?></strong></p>
        <form id="editGradeForm" class="edit-form flex-box" method="post" action="index.php?page=AdministrationPage&crud=Grades">
            <input type="hidden" name="id" value="<? echo $editGrade['id'] ?>">
            <div class="input-box">
                <label for="name">Grade</label>
                <input type="text" name="grade" placeholder="A/B/C/D/E/F *" pattern="[ABCDEF]"
                       value="<? echo $editGrade['grade'] ?>">
            </div>
            <div class="input-box">
                <label for="date_created">Date created *</label>
                <input type="date" name="date_created" disabled value="<? echo $editGrade['date_created'] ?>">
            </div>
            <div class="input-box">
                <label for="type">Type</label>
                <input type="text" name="type" placeholder="Type *" required
                       value="<? echo $editGrade['type'] ?>">
            </div>
            <input type="hidden" value="editGrade" name="action">
            <div class="input-box ib-placeholder"></div>
            <div class="input-box">
                <button type="submit" form="editGradeForm" >Save</button>
            </div>
            <div class="input-box">
                <button type="reset" class="hide-modal">Storno</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-window" data-modal="create-grade">
    <div class="layer-hide"></div>
    <div class="modal-box edit-add">
        <p>Create grade</p>
        <form id="createGradeForm" class="edit-form flex-box" method="post" action="index.php?page=AdministrationPage&crud=Grades">
            <div class="input-box">
                <label for="grade">Grade</label>
                <input type="text" name="grade" placeholder="A/B/C/D/E/F *" required pattern="[ABCDEF]">
            </div>
            <div class="input-box">
                <label for="type">Type</label>
                <input type="text" name="type" placeholder="Type *" required>
            </div>
            <div class="input-box ib-placeholder"></div>
            <input type="hidden" name="action" value="addGrade">
            <div class="input-box">
                <button type="submit" form="createGradeForm">Create</button>
            </div>
            <div class="input-box">
                <button type="reset" form="createGradeForm" class="hide-modal">Storno</button>
            </div>
        </form>
    </div>
</div>