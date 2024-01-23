<!-- Modal Delete Department-->

<div class="modal fade" id="deletedepartmentModal<?php echo $row['department_id'];?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="./functions/delete.php?action=delete_department" id="dept_formDelete" enctype="multipart/form-data">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title-delete" id="exampleModalLabel"><i class="fa fa-archive"></i> Archive Department</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h5>Do you want to archive this department?</h5>
                    <input type="hidden" name="department_id" id="department_id" value="<?php echo $row['department_id'];?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-danger" value="Archive">
                </div>
            </form>
        </div>
    </div>
</div>

<!-- end Modal Delete Department-->

<!-- Modal Delete Position-->

<div class="modal fade" id="deletepositionModal<?php echo $row['position_id']?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="./functions/delete.php?action=delete_position" id="position_formDelete" enctype="multipart/form-data">
                <div class="modal-header  bg-danger">
                    <h5 class="modal-title-delete" id="exampleModalLabel"><i class="fa fa-archive"></i> Archive Position</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h5>Do you want to archive this position?</h5>
                    <input type="hidden" name="position_id" id="position_id" value="<?php echo $row['position_id']?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-danger" name="" id="" value="Archive">
                </div>
            </form>
        </div>
    </div>
</div>

<!-- end Modal Delete Position-->

<!-- Modal Delete Loan Type-->

<div class="modal fade" id="deleteloanTypeModal<?php echo $row['loan_type_id']?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="./functions/delete.php?action=delete_loan_type" id="loan_type_formDelete" enctype="multipart/form-data">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title-delete" id="exampleModalLabel"><i class="fa fa-archive"></i> Archive Loan Type</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="loan_type_id" name="loan_type_id" value="<?php echo $row['loan_type_id']?>">
                    <h5>Do you want to archive this loan type?</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-danger" name="delete_loan_type" id="delete_loan_type" value="Archive">
                </div>
            </form>
        </div>
    </div>
</div>

<!-- end Modal Delete Loan Type-->

<!-- Modal Delete Member-->
<div class="modal fade" id="memberModalDelete<?php echo $row['member_id'];?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="functions/delete.php?action=edit_employment_status" id="member_formDelete" enctype="multipart/form-data">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title-delete" id="exampleModalLabel"><i class="fa fa-archive"></i> Archive Member</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="member_id" id="member_id" value="<?php echo $row['member_id'];?>">
                        <label>Remove Member From Table:</label><br>
                        <select class="form-control" name="employment_status" id="employment_status" required>
                            <option selected value="">Select an option</option>
                            <option value="Retired">Retired</option>
                            <option value="Resigned">Resigned</option>
                            <option value="Terminated">Terminated</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-danger" value="Archive">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end Modal Delete Loan Type-->