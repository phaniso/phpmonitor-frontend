<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">
    <title>Auth</title>

    <link href="<?php echo base_url(); ?>media/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>media/css/login.css" rel="stylesheet">
  </head>

  <body>
    <div class="container">
		<?php 
        if (isset($error)) {
            echo '<p id="login-alert" class="alert alert-danger">'.$error.'</p>';
        } 
        ?>
		<?php echo form_open('', array('class' => 'form-login')); ?>
        <h2 class="form-login-heading">Please Log in</h2>
        <label for="inputLogin" class="sr-only">Login</label>
        <input type="login" name="username" id="username" class="form-control" placeholder="Login" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Login in</button>
        <?php echo form_close(); ?>
    </div>
  </body>
</html>
