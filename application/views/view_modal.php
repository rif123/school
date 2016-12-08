<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<div id="setting-user-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form role="form" id="form-staff" enctype="multipart/form-data">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Register new staff</h4>
                </div>
                <div class="modal-body" style="padding:10px 30px 10px 30px;">
                    <div class="form-group hide">                                            
                        <label>Staff Id</label>
                        <input type="text" name="staff_id" class="form-control" placeholder="Enter ..."/>
                    </div>  
                    <div class="form-group">
                        <label>NIP</label>
                        <input type="text" name="nip" class="form-control" placeholder="Enter ..."/>
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter ..."/>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <div class="input-group">                                                
                            <input type="password" name="password" id="password" class="form-control" readonly="true">
                            <span class="input-group-addon">
                                <input type="checkbox" id="show-password"> Show Password
                            </span>
                        </div>
                    </div>                    
                    <div class="form-group">
                        <label>Photo</label>
                        <input name="photo" type="file" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label>Born Date</label>
                        <input name="born_date" type="text" class="form-control" readonly="true">
                    </div><!-- /.form group -->
                    <div class="form-group">
                        <label>Gender</label>
                        <select name="gender_id" class="form-control"></select>
                    </div>  
                    <div class="form-group">
                        <label>Language</label>
                        <select name="language_id" class="form-control"></select>
                    </div>  
                    <div class="form-group">
                        <label>Permission</label>
                        <select name="permission_id" class="form-control"></select>
                    </div>  
                    <div class="form-group">
                        <label>Address</label>
                        <textarea name="address" class="form-control" rows="3" style="" placeholder="Enter ..."></textarea>
                    </div>                                        
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>


<div id="profile-student-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form role="form" id="form-student" enctype="multipart/form-data">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Student profile</h4>
                </div>
                <div class="modal-body" style="padding:10px 30px 10px 30px;">
                    <div class="form-group hide">
                        <label>Student Id</label>
                        <input name="student_id" type="text" class="form-control" placeholder="Enter ..."/>
                    </div>
                    <div class="form-group">
                        <label>NIS</label>
                        <input name="nis" type="text" class="form-control" placeholder="Enter ..."/>
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input name="name" type="text" class="form-control" placeholder="Enter ..."/>
                    </div>
                    <div class="form-group">
                        <label>Gender</label>
                        <select name="gender_id" class="form-control"></select>
                    </div>  
                    <div class="form-group">
                        <label>Education</label>
                        <select name="education_id" class="form-control"></select>
                    </div>  
                    <div class="form-group">
                        <label>Period</label>
                        <select name="period_id" class="form-control"></select>
                    </div> 
                    <div class="form-group">
                        <label>Class</label>
                        <select name="class_id" class="form-control"></select>
                    </div>
                    <div class="form-group">
                        <label>Born Date</label>
                        <input name="born_date" type="text" class="form-control" readonly="true">
                    </div><!-- /.form group -->                    
                    <div class="form-group">
                        <label>Address</label>
                        <textarea name="address" class="form-control" rows="3" style="" placeholder="Enter ..."></textarea>
                    </div>
                    <div class="form-group">
                        <label>Photo</label>
                        <input name="photo" type="file" class="form-control"/>
                    </div>                    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>


<div id="payment-student-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form role="form" id="form-payment" enctype="multipart/form-data">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Payment Update</h4>
                </div>
                <div class="modal-body" style="padding:10px 30px 10px 30px;">
                    <div class="form-group hide">
                        <label>Payment Id</label>
                        <input name="payment_id" type="text" class="form-control" placeholder="Enter ..." readonly="true"/>
                    </div>
                    <div class="form-group hide">
                        <label>Payment Type Id</label>
                        <input name="payment_type_id" type="text" class="form-control" placeholder="Enter ..." readonly="true"/>
                    </div>
                    <div class="form-group">
                        <label>Payment Detail</label>
                        <input name="detail" type="text" class="form-control" placeholder="Enter ..." readonly="true"/>
                    </div>
                    <div class="form-group hide">
                        <label>Student Id</label>
                        <input name="student_id" type="text" class="form-control" placeholder="Enter ..." readonly="true"/>
                    </div>
                    <div class="form-group">
                        <label>Student Detail</label>
                        <input name="student_detail" type="text" class="form-control" placeholder="Enter ..." readonly="true"/>
                    </div>
                    <div class="form-group">
                        <label>Invoice</label>
                        <input name="invoice" type="text" class="form-control" placeholder="Enter ..." readonly="true"/>
                    </div>                                        
                    <div class="form-group">
                        <label>Paid</label>
                        <input name="total_payment" type="text" class="form-control" placeholder="Enter ..." readonly="true"/>
                    </div>                                        
                    <div class="form-group">
                        <label>Total Payment</label>
                        <input name="total" type="number" class="form-control" value="0" placeholder="Enter ..."/>
                    </div>  
                    <div class="form-group">
                        <label>Payment Date</label>
                        <input name="payment_date" type="text" class="form-control" placeholder="Enter ..." />
                    </div>                     
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>



<div id="payment-revision-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form role="form" id="form-payment-revision" enctype="multipart/form-data">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Payment Revision</h4>
                </div>
                <div class="modal-body" style="padding:10px 30px 10px 30px;">
                    <div class="form-group hide">
                        <label>Payment Id</label>
                        <input name="payment_id" type="text" class="form-control" placeholder="Enter ..." readonly="true"/>
                    </div>
                    <div class="form-group hide">
                        <label>Payment Type Id</label>
                        <input name="payment_type_id" type="text" class="form-control" placeholder="Enter ..." readonly="true"/>
                    </div>
                    <div class="form-group hide">
                        <label>Student Id</label>
                        <input name="student_id" type="text" class="form-control" placeholder="Enter ..." readonly="true"/>
                    </div>
                    <div class="form-group">
                        <label>Payment Date</label>
                        <input name="payment_date" type="text" class="form-control" placeholder="Enter ..." readonly="true"/>
                    </div>                                        
                    <div class="form-group">
                        <label>Total Payment</label>
                        <input name="total" type="number" class="form-control" value="0" placeholder="Enter ..."/>
                    </div>                                        
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="primary-payment-student-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form role="form" id="form-primary-payment" enctype="multipart/form-data">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Payment Update</h4>
                </div>
                <div class="modal-body" style="padding:10px 30px 10px 30px;">
                    <div class="form-group hide">
                        <label>Payment Id</label>
                        <input name="payment_id" type="text" class="form-control" placeholder="Enter ..." readonly="true"/>
                    </div>
                    <div class="form-group hide">
                        <label>Payment Type Id</label>
                        <input name="payment_type_id" type="text" class="form-control" placeholder="Enter ..." readonly="true"/>
                    </div>
                    <div class="form-group">
                        <label>Payment Detail</label>
                        <input name="detail" type="text" class="form-control" placeholder="Enter ..." readonly="true"/>
                    </div>
                    <div class="form-group hide">
                        <label>Student Id</label>
                        <input name="student_id" type="text" class="form-control" placeholder="Enter ..." readonly="true"/>
                    </div>
                    <div class="form-group">
                        <label>Student Detail</label>
                        <input name="student_detail" type="text" class="form-control" placeholder="Enter ..." readonly="true"/>
                    </div>
                    <div class="form-group">
                        <label>Invoice</label>
                        <input name="invoice" type="text" class="form-control" placeholder="Enter ..." readonly="true"/>
                    </div>                                        
                    <div class="form-group">
                        <label>Paid</label>
                        <input name="total_payment" type="text" class="form-control" placeholder="Enter ..." readonly="true"/>
                    </div>                                        
                    <div class="form-group">
                        <label>Total Payment</label>
                        <input name="total" type="number" class="form-control" value="0" placeholder="Enter ..."/>
                    </div>  

                                
                    
                   <div class="form-group">
                        <label>Payment Date</label>
                        <input name="payment_date" type="text" class="form-control" placeholder="Enter ..." />
                    </div> 
                    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="other-report-filter" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form role="form" id="form-other-filter" enctype="multipart/form-data">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Other Filter</h4>
                </div>
                <div class="modal-body" style="padding:10px 30px 10px 30px;">                    
                    <div class="form-group">
                        <label>Start Date</label>
                        
                        <div class="input-group">                            
                            <input name="start_date" type="text" class="form-control" placeholder="Enter ..." readonly="true"/>
                            <div class="input-group-btn">
                                <button type="button" id="reset_start_date" class="btn btn-default" style="padding:9px;"><i class="fa fa-repeat"></i></button>
                            </div><!-- /btn-group -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Finish Date</label>
                        <div class="input-group">                            
                            <input name="finish_date" type="text" class="form-control" placeholder="Enter ..." readonly="true"/>
                            <div class="input-group-btn">
                                <button type="button" id="reset_finish_date" class="btn btn-default" style="padding:9px;"><i class="fa fa-repeat"></i></button>
                            </div><!-- /btn-group -->
                        </div>
                    </div>                                      
                    <div class="form-group">
                        <label>Education</label>
                        <select name="education" class="form-control"></select>
                    </div>
                    <div class="form-group">
                        <label>Class</label>
                        <select name="class" class="form-control"></select>
                    </div>
                    <div class="form-group">
                        <label>Payment Type</label>
                        <select name="payment_type" class="form-control"></select>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="">-</option>
                            <option value="Lunas">Lunas</option>
                            <option value="Proses">Proses</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>


<div id="primary-report-filter" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form role="form" id="form-primary-filter" enctype="multipart/form-data">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Primary Filter</h4>
                </div>
                <div class="modal-body" style="padding:10px 30px 10px 30px;">                    
                    <div class="form-group">
                        <label>Start Date</label>                        
                        <div class="input-group">                            
                            <input name="start_date" type="text" class="form-control" placeholder="Enter ..." readonly="true"/>
                            <div class="input-group-btn">
                                <button type="button" id="reset_start_date" class="btn btn-default" style="padding:9px;"><i class="fa fa-repeat"></i></button>
                            </div><!-- /btn-group -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Finish Date</label>
                        <div class="input-group">                            
                            <input name="finish_date" type="text" class="form-control" placeholder="Enter ..." readonly="true"/>
                            <div class="input-group-btn">
                                <button type="button" id="reset_finish_date" class="btn btn-default" style="padding:9px;"><i class="fa fa-repeat"></i></button>
                            </div><!-- /btn-group -->
                        </div>
                    </div>                                      
                    <div class="form-group">
                        <label>Education</label>
                        <select name="education" class="form-control"></select>
                    </div>
                    <div class="form-group">
                        <label>Class</label>
                        <select name="class" class="form-control"></select>
                    </div>                    
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="">-</option>
                            <option value="Lunas">Lunas</option>
                            <option value="Proses">Proses</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
