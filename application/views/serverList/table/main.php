<div class="container">
    <h1>Server List</h1>
    <a class="glyphicon glyphicon-align-justify" href="<?php echo base_url('view/panel');?>">
    </a>
    <div id="no-more-tables">
        <table id="server-list" class="col-md-12 table-striped table-condensed cf">
            <thead class="cf">
                <tr>
                <th style="text-align: center;">
                    <span class="label label-info">Name</span>
                </th>
                <?php foreach($services as $label): ?>
                <th><span class="label label-info"><?php echo $label['name']?></span></th>
                <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
            <?php echo $content; ?>
        </tbody>        
        </table>
    </div>
    <p class="text-right">
        <small>Last update was <?php echo $updateTime; ?></small>
    </p>

</div><!-- /.container -->