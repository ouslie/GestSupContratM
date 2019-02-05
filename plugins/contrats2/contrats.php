<?php 

$token_export = uniqid();
$db->exec("INSERT INTO ttoken (token) VALUES ('$token_export')");
?>
<script src="plugins/contrats2/contratsusers.js"></script>
<script src="plugins/contrats2/editablegrid-2.1.0-49.js"></script>
<script src="plugins/contrats2/jquery-3.3.1.min.js"></script>


<a href=index.php?page=plugins/contrats2/contrats&type=1> <button class="btn btn-sm btn-success">
  Ticket de support
  </button>
</a>

<a href=index.php?page=plugins/contrats2/contrats&type=3> <button class="btn btn-sm btn-success">
  Ticket de support prépayé
  </button>
</a>
<a href=index.php?page=plugins/contrats2/contrats&type=2> <button class="btn btn-sm btn-success">
  Contrats maintenance 
  </button>
</a>


<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
  <div class="card">
    <div class="card-body">
      <div class="table-responsive">


        <!-- Grid contents -->
        <div id="tablecontent"></div>

        <!-- Paginator control -->
        <div id="paginator"></div>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  var user_id = "<?php echo $_SESSION['user_id']?>";
  var datagrid;

  window.onload = function () {
    datagrid = new DatabaseGrid();
    // key typed in the filter field
    $("#filter").keyup(function () {
      datagrid.editableGrid.filter($(this).val());
      // To filter on some columns, you can set an array of column index
      datagrid.editableGrid.filter($(this).val(), [0, 3, 5]);
    });
    $("#addbutton").click(function () {
      datagrid.addRow();
    });

  }

</script>