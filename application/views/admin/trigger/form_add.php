<div class="container">
    <h1>Trigger</h1>
    <div id="form" class="col-sm-4 col-md-3">
	<?php
    echo validation_errors();
    echo form_open();
    ?>
    <div class="form-group">
        <label for="name">Name</label>
		<input type="text" class="form-control" name="name" placeholder="Name" value="<?php echo set_value('name', ''); ?>">
    </div>
    <div class="form-group">
        <label for="type">Type</label>
		<?php
            echo form_dropdown(
                'type',
                $typeOptions,
                set_value('type', ''),
                'class="form-control selectpicker"'
            );
        ?>
    </div>
    <div class="form-group">
        <label for="name">Type Name</label>
		<input type="text" class="form-control" name="serviceName" placeholder="Type Name" value="<?php echo set_value('serviceName', ''); ?>">
    </div>
    <div class="form-group">
        <label for="notification_id">Notification Id</label>
		<?php
            echo form_dropdown(
                'notification_id',
                $notificationOptions,
                set_value('notification_id', ''),
                'class="form-control selectpicker"'
            );
        ?>
    </div>
    <div class="form-group">
        <label for="value">Value</label>
		<input type="text" class="form-control" id="value" name="value" placeholder="Trigger Value" value="<?php echo set_value('value', ''); ?>">
    </div>
    <div class="form-group">
        <label for="operator">Operator</label>
		<?php
            echo form_dropdown(
                'operator',
                $operatorOptions,
                set_value('operator', ''),
                'class="form-control selectpicker"'
            );
        ?>
    </div>
	<div><button type="submit" class="btn btn-info btn-sm"><?php echo $submitName; ?></button></div>
	<?php echo form_close(); ?>
    </div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.3/css/bootstrap-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.3/js/bootstrap-select.min.js"></script>
