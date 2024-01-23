<?php include('./include/db_connect.php'); ?>

<!-- Modal Add Member-->
<div class="modal fade" id="modalAddMember" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="POST" action="./functions/insert.php?action=insert_department" id="dept_form" enctype="multipart/form-data">
                <div class="modal-header bg-success">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus-square"></i> Add Member</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row justify-content-center">
                            <a href="add_member.php" class="btn btn-success btn-lg btn-rounded"> New Member</a>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row justify-content-center">
                            <a href="add_existing_member.php" class="btn btn-success btn-lg btn-rounded"> Existing Member</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end  Modal Add Member-->

<!-- Modal Department-->
<div class="modal fade" id="departmentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="./functions/insert.php?action=insert_department" id="dept_form" enctype="multipart/form-data">
                <div class="modal-header bg-success">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus-square"></i> New Department</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Department</label>
                        <input type="text" name="department" class="form-control" id="department" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label for="">Department Acronym</label>
                        <input type="text" name="dept_acronym" class="form-control" id="dept_acronym" autocomplete="off" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-success" name="" id="" value="Add">
                </div>
            </form>
        </div>
    </div>
</div>
<!--end  Modal Department-->

<!-- Modal Add Share-->
<div class="modal fade" id="modalAddShare" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="functions/insert.php?action=add_member_share" id="form_add_share" enctype="multipart/form-data">
                <div class="modal-header bg-success">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus-square"></i> Add Member's Share</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Member's Name</label>
                            </div>
                            <div class="col-sm-12">
                                <?php
                                    $sql1 = "SELECT * FROM `tbl_members_info` WHERE `employment_status` =  'Active'";
                                    $rql1Result = mysqli_query($conn, $sql1);
                                ?>
                                <select class="form-control select2_demo_1" style="width: 100%;" name="member_id" id="member_id" required>
                                    <option selected disabled value="">Select Member's Name</option>
                                    <?php
                                    while ($sql1Row = $rql1Result->fetch_assoc()) {
                                    ?>
                                        <option value="<?php echo $sql1Row['member_id'] ?>"><?php echo strtoupper($sql1Row['lastname']) . ', ' . strtoupper($sql1Row['firstname']) ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Remittance</label>
                            </div>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" step="any" name="remittance" id="remittance" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Retention</label>
                            </div>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" step="any" name="retention" id="retention" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>OR</label>
                            </div>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" step="any" name="or" id="or" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Withdrawal</label>
                            </div>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" step="any" name="withdrawal" id="withdrawal" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Dividend</label>
                            </div>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" step="any" name="dividend" id="dividend" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-success" name="btn_add_share" id="btn_add_share" value="Add">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end Modal Add Share-->

<!-- Modal upload file-->
<div class="modal fade" id="modalUploadExcel" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="functions/insert.php?action=upload_excel_file" enctype="multipart/form-data">
                <div class="modal-header bg-success">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus-square"></i> Upload Excel File</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Choose Excel File</label>
                        <input type="file" name="excel_shares" class="form-control" id="excel_shares" required>
                    </div>
                    <div class="form-group">
                        <label for="">Date</label>
                        <input type="date" name="date" class="form-control" id="date" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-success" value="Import">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end upload file-->

<!-- Modal upload payment-->
<div class="modal fade" id="modalUploadPayment" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="functions/insert.php?action=upload_excel_payment" enctype="multipart/form-data">
                <div class="modal-header bg-success">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus-square"></i> Upload Excel File</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Choose Excel File</label>
                        <input type="file" name="excel_payments" class="form-control" id="excel_payments" required>
                    </div>
                    <div class="form-group">
                        <label for="">Date</label>
                        <input type="date" name="date" class="form-control" id="date" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-success" value="Import">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end upload payment-->

<!-- Modal Individual Share-->
<div class="modal fade" id="modaIndividualShare" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-user"></i> View Member's Share</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="shares3.php" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Member's Name</label>
                        <?php 
                            $memberSet = $conn->query("SELECT *
                                                        FROM tbl_members_info
                                                        WHERE `employment_status` = 'Active'"); 
                        ?>
                        <select name="member_id" id="member_id" class="form-control select2_demo_1 member_id" style="width: 100%;" required>
                            <option selected disabled value="">Select</option>
                            <?php
                                while ($rows = $memberSet->fetch_assoc()) {
                                    $firstname = strtoupper($rows['firstname']);
                                    $lastname = strtoupper($rows['lastname']);
                                    $member_id = $rows['member_id']; 
                            ?>
                            <option value="<?php echo $member_id?>"><?php echo $lastname.", ".$firstname?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-success" value="Go">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end Individual Share-->

<!-- Modal Position-->
<div class="modal fade" id="positionModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="./functions/insert.php?action=insert_position" id="position_form" enctype="multipart/form-data">
                <div class="modal-header bg-success">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus-square"></i> New Position</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Position</label>
                        <input type="text" name="position" class="form-control" id="position" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label for="">Department</label>
                        <select name="department_id" id="department_id" class="form-control select2_demo_1" style="width: 100%;" required>
                            <option selected disabled value="">Select</option>
                            <?php
                                $query = "SELECT * 
                                FROM `tbl_department`";
                                $result = $conn->query($query);
                                while($row = $result->fetch_assoc()){
                            ?>
                            <option value="<?php echo $row['department_id']?>"><?php echo ucwords($row['department'])?></option>
                            <?php 
                                } 
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Monthly Salary</label>
                        <input type="number" name="monthly_salary" class="form-control" id="monthly_salary" autocomplete="off" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-success" name="" id="" value="Add">
                </div>
            </form>
        </div>
    </div>
</div>
<!--end  Modal Position-->

<!-- add add Modal Loan Type-->
<div class="modal fade" id="loanTypeModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="./functions/insert.php?action=insert_loan_type" id="loan_type_form" enctype="multipart/form-data">
                <div class="modal-header bg-success">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus-square"></i> New Loan Type</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Loan Name</label>
                        <input type="text" name="loan_type" class="form-control" id="loan_type" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label for="">Loan Interest</label>
                        <input type="number" step="any" name="loan_interest" class="form-control" id="loan_interest" autocomplete="off" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="">Service Fee</label>
                        <input type="number" step="any" name="service_fee" class="form-control" id="service_fee" autocomplete="off" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="">Share Capital</label>
                        <input type="number" step="any" name="share_capital" class="form-control" id="share_capital" autocomplete="off" value="" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-success" name="" id="" value="Add">
                </div>
            </form>
        </div>
    </div>
</div>
<!--end add Modal Loan Type-->

<!-- Modal Add Payment-->
<div class="modal fade" id="paymentModal" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="./functions/insert.php?action=direct_payment" enctype="multipart/form-data">
                <div class="modal-header bg-success">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus-square"></i> Add New Payment</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Member's Name & Application Number</label>
                        <?php 
                            $memberSet = $conn->query("SELECT *, tbl_members_info.lastname, tbl_members_info.firstname
                                                       FROM tbl_loan_list
                                                       LEFT JOIN `tbl_members_info` 
                                                       ON tbl_loan_list.member_id = tbl_members_info.member_id
                                                       WHERE `status` = 'approved'"); 
                        ?>
                        <select name="loan_id" id="loan_id" class="form-control select2_demo_1" style="width: 100%;" required>
                            <option selected disabled hidden value="">Select</option>
                            <?php
                                while ($rows = $memberSet->fetch_assoc()) {
                                    $firstname = strtoupper($rows['firstname']);
                                    $lastname = strtoupper($rows['lastname']);
                                    $application_num = $rows['application_number']; 
                                    $loan_id = $rows['loan_id']; 
                            ?>
                            <option value="<?php echo $loan_id?>"><?php echo $lastname.", ".$firstname." - ".$application_num?></option>
                            <?php
                                }
                            ?>
                            </select>
                    </div>
                    <div class="form-group">
                        <label>Payment Amount</label>
                        <input type="number" step=".01" name="payment_amount" class="form-control" id="payment_amount" autocomplete="off" required>
                    </div>
                    <div class="row justify-content-center my-4">
                        <button class="btn btn-primary" id="showIntRate">Change Intereset Rate</button>
                    </div>
                    <div id="interest_rate_input" class="form-group">
                        <label>Interest Rate</label>
                        <input type="number" step="any" name="interest_rate" class="form-control" id="interest_rate" placeholder="Interest should be in decimal form e.g. (0.0275)" autocomplete="off">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end Modal Add Payment-->

<!-- Modal Member Loan Request-->
<div class="modal fade" id="modalMemberLoanRequest" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="./functions/insert.php?action=member_request_loan" enctype="multipart/form-data">
                <div class="modal-header bg-success">
                    <h5 class="modal-title" id="exampleModalLabel">Member's Loan Request Form</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 form-group">
                            <input type="hidden" id="date_today" name="date_today" value="<?php echo date('Y-m-d')?>">
                            <label>Member's Name</label>
                            <?php $memberSet = $conn->query("SELECT * FROM tbl_members_info WHERE employment_status = 'Active' AND member_id != $loggedinmember_id"); ?>
                            <select name="member_id" id="member_id" class="form-control select2_demo_1 member_id" style="width: 100%;" required>
                                <option selected disabled value="">Select</option>
                                <?php
                                    while ($rows = $memberSet->fetch_assoc()) {
                                        $firstname = strtoupper($rows['firstname']);
                                        $lastname = strtoupper($rows['lastname']);
                                        $member_id = $rows['member_id']; 
                                ?>
                                <option value="<?php echo $member_id?>"><?php echo $lastname.", ".$firstname?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label>Loan Type</label>
                            <?php $loantypeSet = $conn->query("SELECT * FROM tbl_loan_type WHERE loan_type_status = 'activated'"); ?>
                            <select name="loan_type_id" id="loan_type_id" class="loan_type_id form-control select2_demo_1" style="width: 100%;" required>
                                <option selected disabled value="">Select</option>
                                <?php
                                $loan_interest = 0;
                                while ($rows = $loantypeSet->fetch_assoc()) {
                                    $loan_type = $rows['loan_type'];
                                    $loan_type_id = $rows['loan_type_id'];
                                    $loan_interest = $rows['loan_interest'];
                                    $service_fee = $rows['service_fee'];
                                    $share_capital = $rows['share_capital'];
                                ?>
                                <option value="<?php echo $loan_type_id?>,<?php echo $loan_interest?>,<?php echo $service_fee ?>,<?php echo $share_capital ?>"><?php echo $loan_type?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="">Loan Amount</label>
                            <input type="number" style="text-align: right;" name="loan_amount" class="form-control" id="loan_amount" autocomplete="off" required>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label>Payment Term</label>
                            <select name="payment_term" id="payment_term" class="form-control select2_demo_1" style="width: 100%;" required>
                                <option selected value="">Select</option>
                                <?php
                                    $i = 1;
                                    while ($i <= 36) {
                                        echo "<option value='$i'>$i Months</option>";
                                        $i++;
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="">Co-maker</label>
                            <select name="comaker_id" id="comaker_id" class="form-control select2_demo_1" style="width: 100%;" required>
                                <option selected disabled value="">Select</option>
                            </select>
                        </div>
                    </div>
                    <div class="row justify-content-center my-4">
                        <button class="btn btn-primary" id="btnCalculate">Calculate</button>
                    </div>
                    <div id="table">
                        <div class="row justify-content-center">
                            <div class="col-4">
                                <p class="text-center"><strong>Total Interest</strong></p>
                            </div>
                            <div class="col-4">
                                <p class="text-center"><strong>Total Payable Amount</strong></p>
                            </div>
                            <div class="col-4">
                                <p class="text-center"><strong>Monthly Payable Amount</strong></p>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-4">
                                <p class="text-center" id="table_total_interest">0.00</p>
                            </div>
                            <div class="col-4">
                                <p class="text-center" id="table_total_payable_amount">0.00</p>
                            </div>
                            <div class="col-4">
                                <p class="text-center" id="table_monthly_payable_amount">0.00</p>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-6">
                                <p class="text-center"><strong>Service Fee</strong></p>
                            </div>
                            <div class="col-6">
                                <p class="text-center"><strong>Share Capital</strong></p>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-6">
                                <p class="text-center" id="table_service_fee">0.00</p>
                            </div>
                            <div class="col-6">
                                <p class="text-center" id="table_share_capital">0.00</p>
                            </div>
                        </div>
                        <input type="hidden" name="total_service_fee" id="total_service_fee">                               
                        <input type="hidden" name="total_share_capital" id="total_share_capital">
                        <input type="hidden" name="total_interest" id="total_interest">
                        <input type="hidden" name="total_payable_amount" id="total_payable_amount">
                        <input type="hidden" name="monthly_payable_amount" id="monthly_payable_amount">
                        <input type="hidden" name="payment_count" id="payment_count">
                    </div>              
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-success" id="btnSubmit" value="Confirm">
                </div>
            </form>
        </div>
    </div>
</div>
<!--end Modal Member Loan Request-->





