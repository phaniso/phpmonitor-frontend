<div class="container">
	<?php echo isset($header) ? '<h1>'.$header.'</h1>' : ''; ?>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin'); ?>">Servers</a></li>
        <li><a href="<?php echo base_url('admin/profile'); ?>">Profile</a></li>
        <li><a href="<?php echo base_url('admin/notification'); ?>">Notifications</a></li>
        <li><a href="<?php echo base_url('admin/trigger'); ?>">Triggers</a></li>
    </ol>
	<?php echo isset($content) ? $content : ''; ?>
</div>
