<div id="response" class="alert alert-danger" style="display : none;"></div>

<h2><?php echo $itemName; ?>s</h2>
<div class="col-md-6 col-xs-12">
    <?php
    foreach ($items as $item) {
    ?>
        <div id="<?php echo strtolower($itemName); ?>_<?php echo $item['id']; ?>" class="row">
        <div class="col-md-6 col-xs-4"><?php echo $item['name']; ?></div>
            <div class="col-md-1 col-xs-1">
                <a class="btn btn-info btn-sm" href="<?php echo $itemPath; ?>/edit/<?php echo $item['id']; ?>">Edit</a>
            </div>
            <div class="col-md-1 col-xs-1">
                <a id="delete" name="<?php echo $item['id']; ?>" class="btn btn-danger btn-sm" href="#">Delete</a>
            </div>
        </div>
    <?php                                                                                                         } ?>
    <div class="row">
            <div class="col-md-12 col-xs-12">
                <a class="btn btn-default btn-sm" href="<?php echo $itemPath; ?>/add">Add <?php echo $itemPath; ?></a>
            </div>
    </div>
</div>
