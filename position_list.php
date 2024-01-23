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
        <h1 class="page-title">Position List</h1>
    </div>
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title"></div>
                <span class="pr-3">
                    <button type="button" id="btn_add_position" name="btn_add_position" class="btn btn-success" data-toggle="modal" data-target="#positionModal">
                        <i class="fa fa-plus"></i> Add Position
                    </button>
                </span>
            </div>
            <div class="ibox-body" style="overflow-x: scroll;">
                <ul class="nav nav-tabs tabs-line">
                    <li class="nav-item">
                        <a class="nav-link active" href="#tab-7-1" data-toggle="tab" id="btnActive"><i class="fa fa-caret-right"></i> Active Position</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tab-7-2" data-toggle="tab" id="btnInactive"><i class="fa fa-caret-right"></i> Inactive Position</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-7-1">
                        <div id="active_positions">
                            <table class="table table-striped table-bordered table-hover" id="active_position_table" cellspacing="0" width="100%">
                                <?php
                                $query = "SELECT *, tbl_department.department_id
                                          FROM `tbl_position`
                                          LEFT JOIN `tbl_department`
                                          ON tbl_position.department_id = tbl_department.department_id
                                          WHERE `position_status` = 'activated'
                                          ORDER BY position_id ASC";
                                $result = $conn->query($query);
                                ?>
                                <thead>
                                    <tr>
                                        <th width="1%">#</th>
                                        <th width="20%">Position</th>
                                        <th width="50%">Department</th>
                                        <th width="20%">Monthly Salary</th>
                                        <th width="9%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    while ($row = $result->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?php echo $i ?></td>
                                            <td><?php echo ucwords($row['position']) ?></td>
                                            <td><?php echo ucwords($row['department']) ?></td>
                                            <td><?php echo $row['monthly_salary'] ?></td>
                                            <td class="text-center">
                                                <button class="btn btn-primary btn-outline-primary btn-xs m-r-5" data-toggle="modal" data-target="#editpositionModal<?php echo $row['position_id'] ?>"><i class="fa fa-edit"></i></button>
                                                <button class="btn btn-danger btn-outline-danger btn-xs m-r-5" data-toggle="modal" data-target="#deletepositionModal<?php echo $row['position_id'] ?>"><i class="fa fa-archive"></i></button>
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
                        <div id="inactive_positions">
                            <table class="table table-striped table-bordered table-hover" id="inactive_position_table" cellspacing="0" width="100%">
                                <?php
                                $query = "SELECT *, tbl_department.department_id
                                          FROM `tbl_position`
                                          LEFT JOIN `tbl_department`
                                          ON tbl_position.department_id = tbl_department.department_id
                                          WHERE `position_status` = 'deactivated'
                                          ORDER BY position_id ASC";
                                $result = $conn->query($query);
                                ?>
                                <thead>
                                    <tr>
                                        <th width="1%">#</th>
                                        <th width="20%">Position</th>
                                        <th width="50%">Department</th>
                                        <th width="20%">Monthly Salary</th>
                                        <th width="9%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    while ($row = $result->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?php echo $i ?></td>
                                            <td><?php echo ucwords($row['position']) ?></td>
                                            <td><?php echo ucwords($row['department']) ?></td>
                                            <td><?php echo $row['monthly_salary'] ?></td>
                                            <td class="text-center">
                                                <small>
                                                    <button class="btn btn-primary btn-outline-primary btn-xs m-r-5" data-toggle="modal" data-target="#positionModalActivate<?php echo $row['position_id']; ?>"><i class="fa fa-toggle-on"></i></button>
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
        $('#active_position_table').DataTable({});
        $('#inactive_position_table').DataTable({});

        $('#inactive_positions').hide();

        $('#btnActive').click(function() {
            $('#active_positions').show();
            $('#inactive_positions').hide()
        });

        $('#btnInactive').click(function() {
            $('#inactive_positions').show();
            $('#active_positions').hide();
        });

        setTimeout(function() {
            document.getElementById("alert").style.display = "none";
        }, 2000);
    });
</script>
<?php include 'modal/modal_add.php'; ?>