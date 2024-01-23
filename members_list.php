<?php include('include/db_connect.php'); ?>
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
if ($user_type != 'system administrator' && $user_type != 'secretary') {
    header("Location: index.php");
}

?>
<?php $page = 'members_list'; include('include/header_sidebar.php'); ?>

<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <?php
    if (isset($_SESSION['message'])) {
        echo '<div id="alert" class="alert alert-' . $_SESSION["msg_type"] . '">' . $_SESSION["message"] . '</div>';
        unset($_SESSION['message']);
    }
    ?>
    <div class="page-heading">
        <h1 class="page-title">Members List</h1>
    </div>
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head" style="overflow-x: hidden;">
                <div class="ibox-title"></div>
                <span class="pr-3">
                    <button id="export" class="btn btn-success"><i class="fa fa-download"></i> Export Excel</button>
                    <button class="btn btn-success" data-toggle="modal" data-target="#modalAddMember"><i class="fa fa-plus"></i> Add Member</button>
                </span>
            </div>
            <div class="ibox-body" style="overflow-x: scroll;">
                <?php
                    if ($user_type == "system administrator") {
                ?>
                    <ul class="nav nav-tabs tabs-line">
                        <li class="nav-item">
                            <a class="nav-link active" href="#tab-7-1" data-toggle="tab" id="btnActive"><i class="fa fa-caret-right"></i> Active Members</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#tab-7-2" data-toggle="tab" id="btnInactive"><i class="fa fa-caret-right"></i> Inactive Members</a>
                        </li>
                    </ul>
                <?php
                    }
                ?>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-7-1">
                        <div id="active_members">
                            <table class="table table-striped table-bordered table-hover" id="active_member_table" cellspacing="0" width="100%">
                                <?php
                                $query = "SELECT tbl_members_info.member_id, tbl_members_info.member_number, tbl_members_info.lastname, tbl_members_info.firstname,tbl_members_info.address,tbl_members_info.phone_num,tbl_members_info.member_id, tbl_department.department, tbl_user_accounts.user_type 
                                    FROM tbl_members_info 
                                    LEFT JOIN tbl_department 
                                    ON tbl_members_info.department_id = tbl_department.department_id 
                                    LEFT JOIN tbl_user_accounts 
                                    ON tbl_members_info.member_id = tbl_user_accounts.member_id 
                                    WHERE employment_status = 'Active'";
                                $result = $conn->query($query);
                                ?>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Phone</th>
                                        <th>Department</th>
                                        <th>User Type</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $result->fetch_assoc()) { ?>
                                        <tr>
                                            <td><small><?php echo $row['member_number'] ?></small></td>
                                            <td><small><?php echo strtoupper($row['lastname']), ", ", strtoupper($row['firstname']) ?></small></td>
                                            <td><small><?php echo strtoupper($row['address']) ?></small></td>
                                            <td><small><?php echo $row['phone_num'] ?></small></td>
                                            <td><small><?php echo strtoupper($row['department']) ?></small></td>
                                            <td><small><?php echo strtoupper($row['user_type']) ?></small></td>
                                            <td class="text-center">
                                                <small>
                                                    <?php
                                                    $updateid = (($row['member_id']) * 91824826 / 2);
                                                    $salt = "cV0puOlxgX09Klm";
                                                    $hashed = md5($salt . $updateid);
                                                    $link = "update_member.php?updateid=" . $updateid . "&hashed=" . $hashed;
                                                    ?>
                                                    <a class="btn btn-primary btn-outline-primary btn-xs m-r-5" href="<?php echo $link?>"><i class="fa fa-edit"></i></a>
                                                    <button class="btn btn-danger btn-outline-danger btn-xs m-r-5" data-toggle="modal" data-target="#memberModalDelete<?php echo $row['member_id']; ?>"><i class="fa fa-archive"></i></button>
                                                </small>
                                            </td>
                                        </tr>
                                        <?php include('modal/modal_delete.php'); ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade show active" id="tab-7-2">
                        <div id="inactive_members">
                            <table class="table table-striped table-bordered table-hover" id="inactive_member_table" cellspacing="0" width="100%">
                                <?php
                                $query = "SELECT * , tbl_department.department, tbl_user_accounts.user_type 
                                    FROM tbl_members_info 
                                    LEFT JOIN tbl_department 
                                    ON tbl_members_info.department_id = tbl_department.department_id 
                                    LEFT JOIN tbl_user_accounts 
                                    ON tbl_members_info.member_id = tbl_user_accounts.member_id 
                                    WHERE employment_status != 'Active'";
                                $result = $conn->query($query);
                                ?>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Department</th>
                                        <th>User Type</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $result->fetch_assoc()) { ?>
                                        <tr>
                                            <td><small><?php echo $row['member_number'] ?></small></td>
                                            <td><small><?php echo strtoupper($row['lastname']), ", ", strtoupper($row['firstname']) ?></small></td>
                                            <td><small><?php echo strtoupper($row['address']) ?></small></td>
                                            <td><small><?php echo strtoupper($row['department']) ?></small></td>
                                            <td><small><?php echo strtoupper($row['user_type']) ?></small></td>
                                            <td><small><?php echo strtoupper($row['employment_status']) ?></small></td>
                                            <td class="text-center">
                                                <small>
                                                    <button class="btn btn-primary btn-outline-primary btn-xs m-r-5" data-toggle="modal" data-target="#memberModalActivate<?php echo $row['member_id']; ?>"><i class="fa fa-toggle-on"></i></button>
                                                </small>
                                            </td>
                                        </tr>
                                        <?php include('modal/modal_update.php'); ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="hiddenTable">
        <table id="activeMembers">
            <?php
            $query = "SELECT *, tbl_department.department, tbl_position.position, tbl_user_accounts.user_type 
                FROM tbl_members_info 
                LEFT JOIN tbl_department 
                ON tbl_members_info.department_id = tbl_department.department_id 
                LEFT JOIN tbl_position 
                ON tbl_members_info.position_id = tbl_position.position_id 
                LEFT JOIN tbl_user_accounts 
                ON tbl_members_info.member_id = tbl_user_accounts.member_id 
                WHERE employment_status = 'Active'";
            $result = $conn->query($query);
            ?>
            <thead>
                <tr>
                    <th>Member Number</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Civil Status</th>
                    <th>Birthdate</th>
                    <th>Address</th>
                    <th>Birth Place</th>
                    <th>Phone</th>
                    <th>Department</th>
                    <th>Position</th>
                    <th>Salary</th>
                    <th>Other Income Source</th>
                    <th>Annual Income</th>
                    <th>Religion</th>
                    <th>TIN</th>
                    <th>Spouse Name</th>
                    <th>Occupation</th>
                    <th>Beneficiary</th>
                    <th>Relation</th>
                    <th>Dependents Number</th>
                    <th>Membership Date</th>
                    <th>User Type</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><small><?php echo $row['member_number'] ?></small></td>
                    <td><small><?php echo strtoupper($row['lastname']), ", ", strtoupper($row['firstname']) ?></small></td>
                    <td><small><?php echo strtoupper($row['gender']) ?></small></td>
                    <td><small><?php echo strtoupper($row['civil_status']) ?></small></td>
                    <td><small><?php echo strtoupper($row['birth_date']) ?></small></td>
                    <td><small><?php echo strtoupper($row['address']) ?></small></td>
                    <td><small><?php echo strtoupper($row['birth_place']) ?></small></td>
                    <td><small><?php echo $row['phone_num'] ?></small></td>
                    <td><small><?php echo strtoupper($row['department']) ?></small></td>
                    <td><small><?php echo strtoupper($row['position']) ?></small></td>
                    <td><small><?php echo strtoupper($row['salary']) ?></small></td>
                    <td><small><?php echo strtoupper($row['other_income_source']) ?></small></td>
                    <td><small><?php echo strtoupper($row['annual_income']) ?></small></td>
                    <td><small><?php echo strtoupper($row['religion']) ?></small></td>
                    <td><small><?php echo strtoupper($row['tin']) ?></small></td>
                    <td><small><?php echo strtoupper($row['spouse_name']) ?></small></td>
                    <td><small><?php echo strtoupper($row['occupation']) ?></small></td>
                    <td><small><?php echo strtoupper($row['beneficiary']) ?></small></td>
                    <td><small><?php echo strtoupper($row['relation']) ?></small></td>
                    <td><small><?php echo strtoupper($row['dependents_num']) ?></small></td>
                    <td><small><?php echo strtoupper($row['membership_date']) ?></small></td>
                    <td><small><?php echo strtoupper($row['user_type']) ?></small></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <!-- END PAGE CONTENT-->
</div>

<?php include('include/footer.php'); ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#active_member_table').DataTable({
            order:[[0,"desc"]]
        });
        $('#inactive_member_table').DataTable({
            order:[[0,"desc"]]
        });

        $('#inactive_members').hide();

        $('#hiddenTable').hide();

        $('#export').click(function() {
            $("#activeMembers").table2excel({
                // exclude CSS class
                exclude:".noExl",
                name:"Members",
                filename:"COOP MEMBERS",//do not include extension
                fileext:".xlsx" // file extension
            });
        });

        $('#btnActive').click(function() {
            $('#active_members').show();
            $('#inactive_members').hide()
        });

        $('#btnInactive').click(function() {
            $('#inactive_members').show();
            $('#active_members').hide();
        });

        setTimeout(function() {
            document.getElementById("alert").style.display = "none";
        }, 2000);

    });
</script>
<?php include('modal/modal_add.php'); ?>