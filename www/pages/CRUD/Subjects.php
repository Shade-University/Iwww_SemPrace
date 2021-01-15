<?php
require_once './controller/SubjectsController.php';

$controller = new SubjectsController();

if($_GET['deleteSubject']) {
    $controller->deleteSubject($_GET['deleteSubject']);
    header("Location: index.php?page=AdministrationPage&crud=Subjects"); //To remove get parameter
} elseif ($_GET['editSubject']) {
    $editSubject = $controller->getSubject($_GET['editSubject']); //Parameter removed in javascript on modal close
}

if($_POST['action'] == "addSubject") {
    $controller->createSubject($_POST);
} elseif($_POST['action'] == "editSubject") {
    $controller->updateSubject($_POST);
}

?>

<div class="card" data-page="subjects">
    <h2>Subjects</h2>
    <div class="control-row">
        <div class="search-form-wrap">
            <form class="search-form flex-box">
                <div class="input-box">
                    <input id="subjectSearchBar" type="search" placeholder="Search" name="Search" onkeyup="searchTable('subjectSearchBar', 'subjectsTable', 1)">
                </div>
                <div class="search-btn">
                    <button><img src="./img/search.svg" alt="Search icon"></button>
                </div>
            </form>
        </div>
        <button class="btn-add" data-modal-anchor="create-subject">
            <span class="icon"></span>
            <span>Create new Subject</span>
        </button>
    </div>
    <div class="table-wrap">
        <? $controller->createSubjectTable(); ?>
    </div>
</div>

<div class="modal-window <? if ($_GET['editSubject']) echo 'show'; ?>">
    <div class="layer-hide"></div>
    <div class="modal-box edit-add">
        <p>Edit subject: <strong><? echo $editSubject['id'] ?></strong></p>
        <form id="editSubjectForm" class="edit-form flex-box" method="post" action="index.php?page=AdministrationPage&crud=Subjects">
            <input type="hidden" name="id" value="<? echo $editSubject['id'] ?>">
            <div class="input-box">
                <label for="name">name</label>
                <input type="text" name="name" placeholder="Name *" required
                       value="<? echo $editSubject['name'] ?>">
            </div>
            <div class="input-box">
                <label for="description">Description *</label>
                <input type="text" name="description" placeholder="Description *" value="<? echo $editSubject['description'] ?>">
            </div>
            <input type="hidden" value="editSubject" name="action">
            <div class="input-box ib-placeholder"></div>
            <div class="input-box">
                <button type="submit" form="editSubjectForm" >Save</button>
            </div>
            <div class="input-box">
                <button type="reset" class="hide-modal">Storno</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-window" data-modal="create-subject">
    <div class="layer-hide"></div>
    <div class="modal-box edit-add">
        <p>Create subject</p>
        <form id="createSubjectForm" class="edit-form flex-box" method="post" action="index.php?page=AdministrationPage&crud=Subjects">
            <div class="input-box">
                <label for="name">Name *</label>
                <input type="text" name="name" placeholder="Name *" required>
            </div>
            <div class="input-box">
                <label for="description">Description *</label>
                <input type="text" name="description" placeholder="Description *">
            </div>
            <div class="input-box ib-placeholder"></div>
            <input type="hidden" name="action" value="addSubject">
            <div class="input-box">
                <button type="submit" form="createSubjectForm">Create</button>
            </div>
            <div class="input-box">
                <button type="reset" form="createUserForm" class="hide-modal">Storno</button>
            </div>
        </form>
    </div>
</div>