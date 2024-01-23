<?php
session_start();
if (!isset($_SESSION['member_id'])) {
    header("Location: login.php");
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION);
    header("Location: login.php");
}

$user_type = $_SESSION['user_type'];

if ($user_type != "system administrator") {
    header("Location: index.php");
}
?>
<?php include('include/header_sidebar.php'); ?>
<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <?php
    if (isset($_SESSION['message'])) {
        echo '<div id="alert" class="alert alert-' . $_SESSION["msg_type"] . '">' . $_SESSION["message"] . '</div>';
        unset($_SESSION['message']);
    }
    ?>
    <div class="page-heading">
        <h1 class="page-title">Department List</h1>
    </div>
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title"></div>
                <span class="pr-3">
                    <button type="button" id="btn_add_dept" name="btn_add_dept" class="btn btn-success" data-toggle="modal" data-target="#departmentModal">
                        <i class="fa fa-plus"></i> Add Department
                    </button>
                </span>
            </div>
            <div class="ibox-body" style="overflow-x: scroll;">
                <ul class="nav nav-tabs tabs-line">
                    <li class="nav-item">
                        <a class="nav-link active" href="#tab-7-1" data-toggle="tab" id="btnActive"><i class="fa fa-caret-right"></i> Active Departments</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tab-7-2" data-toggle="tab" id="btnInactive"><i class="fa fa-caret-right"></i> Inactive Departments</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-7-1">
                        <div id="active_departments">
                            <table class="table table-striped table-bordered table-hover" id="active_department_table" cellspacing="0" width="100%">
                                <?php
                                $query = "SELECT * 
                                          FROM `tbl_department`
                                          WHERE `dept_status` = 'activated'";
                                $result = $conn->query($query);
                                ?>
                                <thead>
                                    <tr>
                                        <th width="1%">#</th>
                                        <th width="50%">Department</th>
                                        <th width="30%">Short Name</th>
                                        <th width="19%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    while ($row = $result->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?php echo $i ?></td>
                                            <td><?php echo ucwords($row['department']) ?></td>
                                            <td><?php echo strtoupper($row['dept_acronym']) ?></td>
                                            <td class="text-center">
                                                <button class="btn btn-primary btn-outline-primary btn-xs m-r-5" data-toggle="modal" data-target="#editdepartmentModal<?php echo $row['department_id']; ?>"><i class="fa fa-edit"></i></button>
                                                <button class="btn btn-danger btn-outline-danger btn-xs m-r-5" data-toggle="modal" data-target="#deletedepartmentModal<?php echo $row['department_id']; ?>"><i class="fa fa-archive"></i></button>
                                            </td>
                                        </tr>
                                    <?php
                                        include 'modal/modal_update.php';
                                        include 'modal/modal_delete.php';
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade show active" id="tab-7-2">
                        <div id="inactive_departments">
                            <table class="table table-striped table-bordered table-hover" id="inactive_department_table" cellspacing="0" width="100%">
                                <?php
                                $query = "SELECT * 
                                          FROM `tbl_department`
                                          WHERE `dept_status` = 'deactivated'";
                                $result = $conn->query($query);
                                ?>
                                <thead>
                                    <tr>
                                        <th width="1%">#</th>
                                        <th width="50%">Department</th>
                                        <th width="30%">Short Name</th>
                                        <th width="19%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    while ($row = $result->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?php echo $i ?></td>
                                            <td><?php echo ucwords($row['department']) ?></td>
                                            <td><?php echo strtoupper($row['dept_acronym']) ?></td>
                                            <td class="text-center">
                                                <small>
                                                    <button class="btn btn-primary btn-outline-primary btn-xs m-r-5" data-toggle="modal" data-target="#departmentModalActivate<?php echo $row['department_id']; ?>"><i class="fa fa-toggle-on"></i></button>
                                                </small>
                                            </td>
                                        </tr>
                                    <?php
                                        include 'modal/modal_update.php';
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>
<?php include('include/footer.php'); ?>
<script type="text/javascript">
    $(document).ready(function() {

        $('#active_department_table').DataTable({});
        $('#inactive_department_table').DataTable({});

        $('#inactive_departments').hide();

        $('#btnActive').click(function() {
            $('#active_departments').show();
            $('#inactive_departments').hide()
        });

        $('#btnInactive').click(function() {
            $('#inactive_departments').show();
            $('#active_departments').hide();
        });

        setTimeout(function() {
            document.getElementById("alert").style.display = "none";
        }, 2000);
    });

    
</script>
<?php include('modal/modal_add.php'); ?>