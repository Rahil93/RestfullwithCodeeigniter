<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://localhost:80/cdig/assets/css/bootstrap.css">
    <link rel="stylesheet" href="http://localhost:80/cdig/assets/css/custom.css">
    <title>Forget Password form</title>
  </head>
  <body class="login">
    <section>
      <div class="container row">
        <div class="card border border-primary">
          <h5 class="card-header bg-primary text-white border border-primary">Reset Password</h5>
          <div class="card-body">
            <?php echo form_open("ForgetPasswordApi/resetPassword/",["method"=>"POST"]) ?>
              <div class="form-group">
                <label>New Password</label>
                <input type="password" class="form-control" name="password" placeholder="Enter Password">
                <span class="text-danger"><?php echo form_error('password'); ?></span>
              </div>
              <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" class="form-control" name="confirm_password" placeholder="Enter Password">
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
