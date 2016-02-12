    <div id="response" class="alert alert-danger" style="display : none;"></div>

    <div class="table">
     <table class="table table-condensed table-striped">
        <thead>
          <tr>
            <th>Name</th>
            <th>Api url</th>
            <th>Ping Hostname</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($servers_config as $server) : ?>
    		<tr id="server_<?php echo $server['id']; ?>">
            <td>
                <a href="<?php echo base_url("server/{$server['id']}"); ?>"><?php echo $server['name']; ?></a>
            </td>
            <td>
                <?php echo $server['url_path']; ?>
            </td>
            <td>
                <?php echo $server['ping_hostname']; ?>
            </td>
            <td>
              <a id="delete" class="btn btn-danger btn-sm" name="<?php echo $server['id'] ?>" ahref="">
                <i class="icon-trash icon-white"></i>
                Delete
              </a>
            </td>
          </tr>
            <?php endforeach; ?>
          <tr>
            <td>
              <input type="text" class="form-control" id="name" placeholder="Name">
            </td>
            <td>
              <input type="text" class="form-control" id="url_path" placeholder="Api url path">
            </td>
            <td>
              <input class="form-control" type="text" id="ping_hostname" placeholder="Ping Hostname">
            </td>
            <td>
              <a id="add" class="btn btn-success">Add</a>
            </td>    
          </tr>
        </tbody>
          </table>
         </div>
