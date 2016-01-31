<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <link rel="icon" href="">

        <title>Installation</title>

		<link href="<?php echo base_url(); ?>media/css/layout.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>media/css/install.css" rel="stylesheet">
    </head>

    <body>
        <div class="container">
			<?php
            if (isset($errors)) {
                foreach ($errors as $error) {
                    echo "<div class=\"alert alert-danger\">{$error}</div>";
                }
            }
            echo validation_errors();
            
            echo form_open('', 
                [
                    'id' => 'form',
                    'class' => 'form-install'
                ]
            );
            ?>
                <h2 class="form-login-heading">Installation</h2>
                <h3>Database:</h3>
                <fieldset>
                    <div class="form-group">
                        <label class="sr-only" for="name">Host</label>
						<input type="text" class="form-control" name="db_host" id="db_host" value="<?php echo set_value('db_host', ''); ?>" placeholder="Host"/>
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="name">Username</label>
						<input type="text" class="form-control" name="db_user" id="db_user" value="<?php echo  set_value('db_user', ''); ?>" placeholder="Username"/>
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="key">Password</label>
						<input type="password" class="form-control" name="db_password" id="db_password" value="<?php echo  set_value('db_password', ''); ?>" placeholder="Password" />
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="key">Database Name</label>
						<input type="text" class="form-control" name="db_name" id="db_name" value="<?php echo  set_value('db_name', ''); ?>" placeholder="Database Name"/>
                    </div>

                    <h3>Admin:</h3>
                    <div class="form-group">
                        <label class="sr-only" for="key">Username</label>
						<input type="text" class="form-control" name="username" id="username" value="<?php echo  set_value('username', ''); ?>" placeholder="Username" />
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="key">Password</label>
						<input type="password" class="form-control" name="password" id="password" value="<?php echo  set_value('password', ''); ?>" placeholder="Password"/>
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="key">Password Confirmation</label>
                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" value="<?php echo  set_value('password_confirmation', ''); ?>" placeholder="Password Confirmation"/>
                    </div>
                </fieldset>
                <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Install</button>
            </form>
        </div>
    </body>
</html>
