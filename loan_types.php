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
        <h1 class="page-title">Loan Types</h1>
    </div>
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title"></div>
                <span class="pr-3">
                    <button type="button" id="btn_add_loan_type" name="btn_add_loan_type" class="btn btn-success" data-toggle="modal" data-target="#loanTypeModal">
                        <i class="fa fa-plus"></i> Add Loan Type
                    </button>
                </span>
            </div>
            <div class="ibox-body" style="overflow-x: scroll;">
                <ul class="nav nav-tabs tabs-line">
                    <li class="nav-item">
                        <a class="nav-link active" href="#tab-7-1" data-toggle="tab" id="btnActive"><i class="fa fa-caret-right"></i> Active Loan Type</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tab-7-2" data-toggle="tab" id="btnInactive"><i class="fa fa-caret-right"></i> Inactive Loan Type</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-7-1">
                        <div id="active_loan_types">
                            <table class="table table-striped table-bordered table-hover" id="active_loan_type_table" cellspacing="0" width="100%">
                                <?php
                                $query = "SELECT * 
                              FROM `tbl_loan_type`
                              WHERE `loan_type_status` = 'activated'";
                                $result = $conn->query($query);
                                ?>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Loan Name</th>
                                        <th>Interest Rate</th>
                                        <th>Service Fee</th>
                                        <th>Share Capital</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    while ($row = $result->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?php echo $i ?></td>
                                            <td><?php echo ucwords($row['loan_type']) ?></td>
                                            <td><?php echo $row['loan_interest'] ?></td>
                                            <td><?php echo $row['service_fee'] ?></td>
                                            <td><?php echo $row['share_capital'] ?></td>
                                            <td class="text-center">
                                                <button class="btn btn-primary btn-outline-primary btn-xs m-r-5" data-toggle="modal" data-target="#editloanTypeModal<?php echo $row['loan_type_id']; ?>"><i class="fa fa-edit"></i></button>
                                                <button class="btn btn-danger btn-outline-danger btn-xs m-r-5" data-toggle="modal" data-target="#deleteloanTypeModal<?php echo $row['loan_type_id']; ?>"><i class="fa fa-archive"></i></button>
                                            </td>
                                        </tr>
                                        <?php include 'modal/modal_update.php'; ?>
                                        <?php include 'modal/modal_delete.php'; ?>
                                    <?php
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade show active" id="tab-7-2">
                        <div id="inactive_loan_types">
                            <table class="table table-striped table-bordered table-hover" id="inactive_loan_type_table" cellspacing="0" width="100%">
                                <?php
                                $query = "SELECT * 
                              FROM `tbl_loan_type`
                              WHERE `loan_type_status` = 'deactivated'";
                                $result = $conn->query($query);
                                ?>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Loan Name</th>
                                        <th>Interest Rate</th>
                                        <th>Service Fee</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    while ($row = $result->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?php echo $i ?></td>
                                            <td><?php echo ucwords($row['loan_type']) ?></td>
                                            <td><?php echo $row['loan_interest'] ?></td>
                                            <td><?php echo $row['service_fee'] ?></td>
                                            <td class="text-center">
                                                <small>
                                                    <button class="btn btn-primary btn-outline-primary btn-xs m-r-5" data-toggle="modal" data-target="#loantypeModalActivate<?php echo $row['loan_type_id']; ?>"><i class="fa fa-toggle-on"></i></button>
                                                </small>
                                            </td>
                                        </tr>
                                        <?php include 'modal/modal_update.php'; ?>
                                    <?php
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
        $('#active_loan_type_table').DataTable({});
        $('#inactive_loan_type_table').DataTable({});

        $('#inactive_loan_types').hide();

        $('#btnActive').click(function() {
            $('#active_loan_types').show();
            $('#inactive_loan_types').hide()
        });

        $('#btnInactive').click(function() {
            $('#inactive_loan_types').show();
            $('#active_loan_types').hide();
        });

        setTimeout(function() {
            document.getElementById("alert").style.display = "none";
        }, 2000);
    });
</script>
<?php include 'modal/modal_add.php'; ?>