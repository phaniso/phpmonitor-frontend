<div class="container">
    <h1>Notification</h1>
    <div id="form" class="col-lg-6">
	<?php
    echo validation_errors();
    echo form_open();
    ?>
    <div class="col-lg-6">
    <div class="form-group">
        <label for="name">Name</label>
		<input type="text" class="form-control" name="name" placeholder="Name" value="<?php echo isset($name) ? $name : set_value('name', ''); ?>"> 
        </div>
    </div>
    <div class="col-lg-12">
        <div class="form-group">
        <label for="message">Message</label>
		<textarea class="form-control" name="message" rows="4" placeholder="Message text"><?php echo isset($message) ? $message : set_value('message', ''); ?></textarea>
        </div>
    </div>
    <!-- <div class="row"> -->
    <div class="col-lg-6">
		<button class="btn btn-default" type="submit"><?php echo $submitName; ?></button>
    </div>
    <!-- </div> -->
	<?php echo form_close(); ?>
    </div>
</div>
