<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://localhost:80/cdig/assets/css/bootstrap.css">
    <link rel="stylesheet" href="http://localhost:80/cdig/assets/css/custom.css">
    <title>Email Verification Form</title>
  </head>
  <body class="login">
    <section>
      <div class="container row">
        <div class="card border border-primary">
          <h5 class="card-header bg-primary text-white border border-primary">Email Verification Form</h5>
          <div class="card-body">
            <?php echo form_open("ForgetPasswordApi/getFrgtPassword",["method"=>"POST"]) ?>
              <div class="form-group">
                <label>Email Id</label>
                <input type="email" class="form-control" name="email_id" value ="<?php echo set_value('email_id'); ?>" placeholder="Enter email id">
                <span class="text-danger"><?php echo form_error('email_id'); ?></span>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            <?php echo form_close() ?>
          </div>
        </div>
      </div>
    </section>
  </body>
</html>
