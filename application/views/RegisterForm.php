<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://localhost:80/cdig/assets/css/bootstrap.css">
    <link rel="stylesheet" href="http://localhost:80/cdig/assets/css/custom.css">
    <title>Registration form</title>
  </head>
  <body>
    <section>
      <div class="container row">
        <div class="card border border-primary">
          <h5 class="card-header bg-primary text-white border border-primary">Sign Up</h5>
          <div class="card-body">
            <?php echo form_open("RegisterApi/getregisterdata",["method"=>"POST"]) ?>
              <div class="form-group">
                <label>First Name</label>
                <input type="text" class="form-control" name="firstname"  value ="<?php echo set_value('firstname'); ?>" placeholder="Enter First Name"/>
                <span class="text-danger"><?php echo form_error('firstname'); ?></span>
              </div>
              <div class="form-group">
                <label>Last Name</label>
                <input type="text" class="form-control" name="lastname" value ="<?php echo set_value('lastname'); ?>" placeholder="Enter Last Name">
                <span class="text-danger"><?php echo form_error('lastname'); ?></span>
              </div>
              <div class="form-group">
                <label>Email Address</label>
                <input type="email" class="form-control" name="email_id" value ="<?php echo set_value('email_id'); ?>" placeholder="Enter email id">
                <span class="text-danger"><?php echo form_error('email_id'); ?></span>
              </div>
              <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" name="password" placeholder="Password">
                <span class="text-danger"><?php echo form_error('password'); ?></span>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Confirm Password</label>
                <input type="password" class="form-control" name="confirm_password" placeholder="Password">
                <span class="text-danger"><?php echo form_error('confirm_password'); ?></span>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            <?php echo form_close() ?>
          </div>
        </div>
      </div>
    </section>
  </body>
</html>
