<?php 

$token_export = uniqid();
$db->exec("INSERT INTO ttoken (token) VALUES ('$token_export')");
?>
<script src="plugins/contrats2/contratsusers.js"></script>
<script src="plugins/contrats2/editablegrid-2.1.0-49.js"></script>
<div class="page-header position-relative">
  <h1>
    <i class="icon-bar-chart"></i> Contrats
    <div class="pull-right">
    </div>
  </h1>
</div>
<div class="col-sm-12">
  <div class="tabbable">
    <ul class="nav nav-tabs" id="myTab">
      <li <?php if ($_GET['type']=='2' ) echo 'class="active"' ; echo '' ; ?>>
        <a href="index.php?page=plugins/contrats2/contrats&type=2">
          <i class="green icon-ticket bigger-110"></i>
          Contrats de maintenance
        </a>
      </li>

      <li <?php if ($_GET['type']=='1' ) echo 'class="active"' ; echo '' ; ?>>
        <a href="index.php?page=plugins/contrats2/contrats&type=1">
          <i class="blue icon-desktop bigger-110"></i>
          Ticket de support
        </a>
      </li>
      <li <?php if ($_GET['type']=='3' ) echo 'class="active"' ; echo '' ; ?>>
        <a href="index.php?page=plugins/contrats2/contrats&type=3">
          <i class="blue icon-desktop bigger-110"></i>
          Ticket de support prépayé
        </a>
      </li>
    </ul>
    <div class="tab-content">
    
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