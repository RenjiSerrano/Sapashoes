<?php
if(isset($_GET['testcheckbox'])){
    
    foreach($_GET['checkbox_option'] as $option){
        foreach($_GET['checkbox_quantity'] as $qty){
            $sql_insert_checkbox = "INSERT INTO multi_order (`step_id`,`ingredient_id`,`user_id`,`order_qty`)
                                       values ('5','$option','3',$qty)";
        }
        
        mysqli_query($conn,$sql_insert_checkbox);
    }
    
    
}    
?>

<form action="" method="get">
     <div class="col-lg-6 col-sm-12">
                  <h4 class="display-6">Step 5. Multiple Entry</h4>
                  <div class="container-fluid">
                      <div class="row">
                              <div class="col-6"> 
                                 <div class="input-group">
                                  <input id="opt1" name="checkbox_option[]" value="1" type="checkbox" class="btn-check"> 
                                  <label for="opt1" class="btn btn-outline-primary mb-1">Checkbox 1</label> 
                                  <input type="text" class="form-control" name="checkbox_quantity[]">
                                 </div>
                              </div>
                              <div class="col-6"> 
                                 <div class="input-group">
                                  <input id="opt2" name="checkbox_option[]" value="2" type="checkbox" class="btn-check"> 
                                  <label for="opt2" class="btn btn-outline-primary mb-1">Checkbox 2</label> 
                                  <input type="text" class="form-control" name="checkbox_quantity[]">
                                 </div>
                              </div>
                              <div class="col-6"> 
                                 <div class="input-group">
                                  <input id="opt3" name="checkbox_option[]" value="3" type="checkbox" class="btn-check"> 
                                  <label for="opt3" class="btn btn-outline-primary mb-1">Checkbox 3</label> 
                                  <input type="text" class="form-control" name="checkbox_quantity[]">
                                 </div>
                              </div>
                      </div>
                      <div class="row">
                              
                      </div>
                  </div>
    </div>
    <div class="col-lg-6 col-sm-12">
        <input type="submit" name="testcheckbox" class="btn btn-success">
    </div>
</form>