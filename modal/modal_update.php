<!-- Modal Department-->
<div class="modal fade" id="editdepartmentModal<?php echo $row['department_id']; ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="./functions/update.php?action=edit_department" id="dept_form" enctype="multipart/form-data">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-edit"></i> New Department</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="department_id" id="department_id" value="<?php echo $row['department_id']; ?>">
                        <label for="">Department</label>
                        <input type="text" name="department" class="form-control" id="department" autocomplete="off" required value="<?php echo ucwords($row['department']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="">Department Acronym</label>
                        <input type="text" name="dept_acronym" class="form-control" id="dept_acronym" autocomplete="off" required value="<?php echo strtoupper($row['dept_acronym']) ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-info" name="" id="" value="Save">
                </div>
            </form>
        </div>
    </div>
</div>
<!--end  Modal Department-->

<!-- Modal Position-->
<div class="modal fade" id="editpositionModal<?php echo $row['position_id'] ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="./functions/update.php?action=edit_position" id="position_form" enctype="multipart/form-data">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-edit"></i> New Position</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Position</label>
                        <input type="hidden" name="position_id" id="position_id" value="<?php echo $row['position_id'] ?>">
                        <input type="text" name="position" class="form-control" id="position" autocomplete="off" required value="<?php echo ucwords($row['position']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="">Department</label>
                        <select name="department_id" id="department_id" class="form-control select2_demo_1" style="width: 100%;" required>
                            <option selected value="<?php echo $row['department_id'] ?>"><?php echo ucwords($row['department']) ?></option>
                            <?php
                            $query2 = "SELECT * 
                                FROM `tbl_department`";
                            $result2 = $conn->query($query2);
                            while ($row2 = $result2->fetch_assoc()) {
                            ?>
                                <option value="<?php echo $row2['department_id'] ?>"><?php echo ucwords($row2['department']) ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Monthly Salary</label>
                        <input type="number" name="monthly_salary" class="form-control" id="monthly_salary" autocomplete="off" required value="<?php echo $row['monthly_salary'] ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-info" name="" id="" value="Save">
                </div>
            </form>
        </div>
    </div>
</div>
<!--end  Modal Position-->

<!-- edit Modal Loan Type-->
<div class="modal fade" id="editloanTypeModal<?php echo $row['loan_type_id'] ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="./functions/update.php?action=edit_loan_type" id="loan_type_form" enctype="multipart/form-data">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-edit"></i> Edit Loan Type</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="number" name="loan_type_id" class="form-control" id="loan_type_id" value="<?php echo $row['loan_type_id'] ?>" hidden>
                        <label for="">Loan Name</label>
                        <input type="text" name="loan_type" class="form-control" id="loan_type" autocomplete="off" value="<?php echo ucwords($row['loan_type']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="">Loan Interest</label>
                        <input type="number" step="any" name="loan_interest" class="form-control" id="loan_interest" autocomplete="off" value="<?php echo $row['loan_interest'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="">Service Fee</label>
                        <input type="number" step="any" name="service_fee" class="form-control" id="service_fee" autocomplete="off" value="<?php echo $row['service_fee'] ?>" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-info" name="add_loan_type" id="add_loan_type" value="Save">
                </div>
            </form>
        </div>
    </div>
</div>
<!--end edit Modal Loan Type-->

<!-- edit Modal Share-->
<div class="modal fade" id="editshareModal<?php echo $sqlRow['shares_id']; ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="./functions/update.php?action=edit_share" enctype="multipart/form-data">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-edit"></i> Edit Record</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="share_id" value="<?php echo $sqlRow['shares_id']?>">
                    <input type="hidden" name="date" value="<?php echo $sqlRow['date']?>">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Member's Name</label>
                            </div>
                            <div class="col-sm-12">
                                <?php
                                    $mem_id = $sqlRow['member_id'];
                                    $sql1 = "SELECT * FROM `tbl_members_info` WHERE `employment_status` =  'Active' AND `member_id` != '$mem_id'";
                                    $rql1Result = mysqli_query($conn, $sql1);
                                ?>
                                <select class="form-control select2_demo_1" style="width: 100%;" name="member_id" id="member_id" required>
                                    <option selected value="<?php echo $sqlRow['member_id']?>"><?php echo strtoupper($sqlRow['lastname']) . ", " . strtoupper($sqlRow['firstname']) ?></option>
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
                                <input type="number" class="form-control" step="any" name="remittance" id="remittance" value="<?php echo $sqlRow['remittance']?>" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Retention</label>
                            </div>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" step="any" name="retention" id="retention" value="<?php echo $sqlRow['retention']?>" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>OR</label>
                            </div>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" step="any" name="or" id="or" value="<?php echo $sqlRow['floatOR']?>" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Withdrawal</label>
                            </div>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" step="any" name="withdrawal" id="withdrawal" value="<?php echo $sqlRow['withdrawal']?>" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-info" value="Save">
                </div>
            </form>
        </div>
    </div>
</div>
<!--end edit Modal Share-->

<!-- modal Edit Loan -->
<div class="modal fade" id="modalEditLoan<?php echo $loan_id ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-edit"></i> Edit Loan</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col form-group">
                        <label for="">Loan Amount</label>
                        <input type="number" name="loan_amount" class="form-control" id="loan_amount" autocomplete="off" value="<?php echo ucwords($loanlistRow['loan_amount']); ?>" required>
                        <input type="hidden" name="loan_int" class="form-control" id="loan_int" autocomplete="off" value="<?php echo ucwords($loanlistRow['loan_interest']); ?>">
                        <input type="hidden" name="paymentCount" class="form-control" id="paymentCount" autocomplete="off" value="<?php echo ucwords($loanlistRow['payment_count']); ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col form-group">
                        <label for="">Payment Term</label>
                        <select name="payment_term" id="payment_term" class="form-control" required>
                            <?php
                            $payment_term = $loanlistRow['payment_term'];
                            $explodedValue = explode(' ', $payment_term);
                            $num = $explodedValue[0];
                            ?>
                            <option selected hidden value="<?php echo $num ?>"><?php echo ucwords($loanlistRow['payment_term']); ?></option>
                            <?php
                            $counter = 1;
                            while ($counter <= 36) {
                                echo "<option value='$counter'>$counter Months</option>";
                                $counter++;
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row justify-content-center my-4">
                    <button class="btn btn-info" id="btnCalculate">Calculate</button>
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
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btnclsEditLoan" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-info btnEditLoan" name="btnEditLoan" id="btnEditLoan">Save</Button>
            </div>
        </div>
    </div>
</div>
<!--end modal Edit Loan -->

<!-- Modal Cancel Loan-->
<div class="modal fade" id="modalCancelLoan<?php echo $loan_id ?>" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="functions/update.php?action=cancel_loan" enctype="multipart/form-data">
                <div class="modal-header bg-secondary">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-close"></i> Cancel Loan</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12 mt-4">
                                <input type="hidden" name="loan_id" value="<?php echo $loanlistRow['loan_id'];?>">
                                <input type="hidden" name="renewed" value="<?php echo $loanlistRow['renewed'];?>">
                                <?php
                                    $class = "";
                                    if ($loanlistRow['renewed'] != '') {
                                        $class = "renewal";
                                    } else {
                                        $class = "application";
                                    }
                                ?>
                                <h4>Do you want to cancel your loan <?php echo $class?>?</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-secondary" value="Confirm">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end Modal Cancel Loan-->

<!-- Modal Change Comaker-->
<div class="modal fade" id="modalChangeComaker<?php echo $loan_id ?>" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="functions/update.php?action=change_comaker" enctype="multipart/form-data">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-edit"></i> Change Comaker</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Member's Name</label>
                            </div>
                            <div class="col-sm-12">
                                <input type="hidden" name="loan_id" value="<?php echo $loanlistRow['loan_id'];?>">
                                <input type="hidden" name="encrypted_loan_id" value="<?php echo $encrypted_loan_id;?>">
                                <input type="hidden" name="hashed" value="<?php echo $hashed;?>">
                                <?php
                                    $member_id = $loanlistRow['member_id'];
                                    $comaker_id = $loanlistRow['comaker_id'];
                                    $sql1 = "SELECT *, tbl_comaker.comaker_id
                                             FROM `tbl_members_info`
                                             LEFT JOIN `tbl_comaker`
                                             ON tbl_members_info.member_id = tbl_comaker.member_id
                                             WHERE `employment_status` =  'Active'
                                             AND tbl_comaker.comaker_id != '$comaker_id'
                                             AND tbl_comaker.member_id != '$member_id'";
                                    $rql1Result = mysqli_query($conn, $sql1);
                                ?>
                                <select class="form-control select2_demo_1" style="width: 100%;" name="comaker_id" id="comaker_id" required>
                                    <option selected disabled value="">Select Member's Name</option>
                                    <?php
                                        while ($sql1Row = mysqli_fetch_assoc($rql1Result)) {
                                    ?>
                                        <option value="<?php echo $sql1Row['comaker_id'] ?>"><?php echo strtoupper($sql1Row['lastname']) . ', ' . strtoupper($sql1Row['firstname']) ?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-info" value="Save">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end Modal Change Comaker-->

<!-- Modal Change Check Number-->
<div class="modal fade" id="modalChangeChecknum<?php echo $loan_id ?>" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="functions/update.php?action=update_check_number" enctype="multipart/form-data">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-edit"></i> Edit Check Number</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Check Number</label>
                            </div>
                            <div class="col-sm-12">
                                <input type="hidden" name="loan_id" value="<?php echo $loanlistRow['loan_id'];?>">
                                <input type="hidden" name="encrypted_loan_id" value="<?php echo $encrypted_loan_id;?>">
                                <input type="hidden" name="hashed" value="<?php echo $hashed;?>">
                                <input type="text" class="form-control" name="check_number" id="check_number" value="<?php echo $loanlistRow['check_number'];?>" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-info" value="Confirm">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end Modal Change Check Number-->

<!-- Modal Activate Member-->
<div class="modal fade" id="memberModalActivate<?php echo $row['member_id'];?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="functions/update.php?action=activate_member" enctype="multipart/form-data">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title-delete" id="exampleModalLabel"><i class="fa fa-edit"></i> Activate Member</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="member_id" id="member_id" value="<?php echo $row['member_id'];?>">
                        <h5>Do you want to activate this member again?</h5>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-primary" value="Activate">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end Modal Activate Member-->

<!-- Modal Activate Department-->
<div class="modal fade" id="departmentModalActivate<?php echo $row['department_id'];?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="functions/update.php?action=activate_department" enctype="multipart/form-data">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title-delete" id="exampleModalLabel"><i class="fa fa-edit"></i> Activate Department</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="department_id" id="department_id" value="<?php echo $row['department_id'];?>">
                        <h5>Do you want to activate this department again?</h5>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-primary" value="Activate">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end Modal Activate Department-->

<!-- Modal Activate Position-->
<div class="modal fade" id="positionModalActivate<?php echo $row['position_id'];?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="functions/update.php?action=activate_position" enctype="multipart/form-data">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title-delete" id="exampleModalLabel"><i class="fa fa-edit"></i> Activate Position</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="position_id" id="position_id" value="<?php echo $row['position_id'];?>">
                        <h5>Do you want to activate this position again?</h5>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-primary" value="Activate">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end Modal Activate Position-->

<!-- Modal Activate Loan Type-->
<div class="modal fade" id="loantypeModalActivate<?php echo $row['loan_type_id'];?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="functions/update.php?action=activate_loan_type" enctype="multipart/form-data">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title-delete" id="exampleModalLabel"><i class="fa fa-edit"></i> Activate Loan Type</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="loan_type_id" id="loan_type_id" value="<?php echo $row['loan_type_id'];?>">
                        <h5>Do you want to activate this loan type again?</h5>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-primary" value="Activate">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end Modal Activate Loan Type-->

