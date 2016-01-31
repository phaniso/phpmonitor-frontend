<div class="container">
    <h1>Server List</h1>
    <div class="table">
        <table id="server-list" class="table table-condensed table-hover">
            <thead>
                <tr>
                <th style="text-align: center;"><span class="label label-info">Name</span></th>
                <?php foreach($services as $label): ?>
                <th><span class="label label-info"><?php echo $label['sub']?></span></th>
                <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
            <?php echo $tableContent; ?>
        </tbody>        
        </table>
    </div>
    <p class="text-right">
        <small>Last update was <?php echo $updateTime; ?></small>
    </p>

</div><!-- /.container -->