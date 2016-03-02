<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="">
		<title>PHPMonitor
        <?php if (isset($title)) {
            echo '- '.$title; 
        } ?>
        </title>
        <link href="<?php echo base_url(); ?>media/bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>media/css/main-template.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>media/css/no-more-tables.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    	<script src="<?php echo base_url(); ?>media/bootstrap/js/bootstrap.min.js"></script> 
		<?php
        if (isset($js) && is_array($js)) {
            foreach ($js as $jsName) {
                echo '<script type="text/javascript" src="'.base_url().'media/js/'.$jsName.'"></script>'.PHP_EOL;
            }
        }
        ?>
		<script>var <?php echo $this->security->get_csrf_token_name() ?> = '<?php echo $this->security->get_csrf_hash(); ?>';</script>
    </head>

    <body>

        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo base_url()?>">PHPMonitor</a>
                </div>
                <div id="navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li>
							<?php echo anchor('', 'Home'); ?>
                        </li>
                        <li>
							<?php echo anchor('admin', 'Admin'); ?>
                        </li>
                        <li>
							<?php
                            if ($this->session->userdata('loggedIn')) {
                                echo anchor('auth/logout', 'Logout');
                            }
                            ?>
                        </li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>
