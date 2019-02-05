<?php 
if ($rright['admin_contrat'] != 0) {

  if (isset($_POST['formSubmitcloture'])) {
    $var = $_POST['bookId'];
    if(!isset( $_POST['mail'])){
      $_POST['mail']=0;
    }
include "cloture.php";
require_once('webservice.php');
cloturecontrat($var,$_POST['mail']);
}

?>

<script src="plugins/contrats2/demo.js"></script>
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
        <a href="index.php?page=plugins/contrats2/contratsadmin&type=2">
          <i class="green icon-ticket bigger-110"></i>
          Contrats de maintenance
        </a>
      </li>

      <li <?php if ($_GET['type']=='1' ) echo 'class="active"' ; echo '' ; ?>>
        <a href="index.php?page=plugins/contrats2/contratsadmin&type=1">
          <i class="blue icon-desktop bigger-110"></i>
          Ticket de support
        </a>
      </li>
      <li <?php if ($_GET['type']=='3' ) echo 'class="active"' ; echo '' ; ?>>
        <a href="index.php?page=plugins/contrats2/contratsadmin&type=3">
          <i class="blue icon-desktop bigger-110"></i>
          Ticket de support prépayé
        </a>
      </li>
    </ul>
    <div class="tab-content">
      <div id="toolbar" class="card-header">
        <!-- Button trigger modal -->
        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
          + Ajouter un contrat
        </a>
      </div>
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
<div class="row">
  <!-- ============================================================== -->
  <!-- modal  -->
  <!-- ============================================================== -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ajout d'un contrat</h5>
          <a href="#" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </a>
        </div>
        <div id="addform">
          <div class="modal-body">
            <div class="form-group row">
              <label class="col-3 col-lg-2 col-form-label text-right">Demandeur</label>
              <div class="col-9 col-lg-10">
                <select id="user" name="user" class="form-control">
                  <option value="">--User--</option>
                  <?php
                        $query = "SELECT id, login FROM tusers";
                        $query = $db->query($query);

                        $user = $query->fetchAll();
                        foreach ($user as $row) : ?>
                  <option value="<?= $row['id']; ?>">
                    <?= $row['login']; ?>
                  </option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-3 col-lg-2 col-form-label text-right">Type</label>
              <div class="col-9 col-lg-10">
                <select id="type" name="type" class="form-control">
                  <option value="">--Type--</option>
                  <?php
                        $query = "SELECT * FROM tcontratstype";
                        $query = $db->query($query);

                        $user = $query->fetchAll();
                        foreach ($user as $row) : ?>
                  <option value="<?= $row['id']; ?>">
                    <?= $row['nom']; ?>
                  </option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-3 col-lg-2 col-form-label text-right">Service</label>
              <div class="col-9 col-lg-10">
                <select id="service" name="service" class="form-control">
                  <option value="Webmastering"> Webmastering </option>
                  <option value="Infogérance"> Infogérance </option>
                  <option value="Infogérance + Webmastering"> Infogérance + Webmastering </option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-3 col-lg-2 col-form-label text-right">Période</label>
              <div class="col-9 col-lg-10">
                <select id="periode" name="periode">
                  <option value="Mensuel">Mensuel</option>
                  <option value="Annuel">Annuel</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-3 col-lg-2 col-form-label text-right">Date de debut</label>
              <div class="col-9 col-lg-10">
                <input type="date" class="form-control" id="date_debut" name="date_debut">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-3 col-lg-2 col-form-label text-right">Date de fin</label>
              <div class="col-9 col-lg-10">
                <input type="date" class="form-control" id="date_fin" name="date_fin">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-3 col-lg-2 col-form-label text-right">Temps soucrit</label>
              <div class="col-9 col-lg-10">
                <input type="text" class="form-control" id="temps_souscrit" name="temps_souscrit">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-3 col-lg-2 col-form-label text-right">Montant Heure</label>
              <div class="col-9 col-lg-10">
                <input type="text" class="form-control" id="montantheure" name="montantheure">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-3 col-lg-2 col-form-label text-right">Tarif contrat</label>
              <div class="col-9 col-lg-10">
                <input type="text" class="form-control" id="tarifcontrat" name="tarifcontrat">
              </div>
            </div>
            <div class="form-group row ">
              <label class="col-3 col-lg-2 col-form-label text-right">Prepaye</label>
              <div class="col-9 col-lg-10">
                <input type="checkbox" class="form-control" id="prepaye" name="prepaye">
              </div>
            </div>
            <div class="modal-footer">
              <a href="#" class="btn btn-secondary" data-dismiss="modal">Annuler</a>
              <a href="#" id="addbutton" data-dismiss="modal" class="btn btn-primary">Valider</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="modal" id="my_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Cloture contrats</h4>
      </div>
      <div class="modal-body">
        <form id="myFormcloture" method="POST" action="index.php?page=plugins/contrats2/contratsadmin&type=2">
        <div class="form-group row">
              <label class="col-3 col-lg-2 col-form-label text-right">Contrat numéro </label>
              <div class="col-9 col-lg-10">
                <input type="text" class="form-control"  name="bookId">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-3 col-lg-2 col-form-label text-right">Mail ? </label>
              <div class="col-9 col-lg-10">
                <input type="checkbox" class="form-control"  name="mail">
              </div>
            </div>
          
      </div>
      <div class="modal-footer">
<button type="submit" name="formSubmitcloture" value="Clore" class="btn btn-sm btn-danger">
              <i class="icon-remove icon-on-right bigger-110"></i>
              &nbsp;Clore
            </button>             </form>
 </div>
    </div>
  </div>
</div>
<script type="text/javascript">
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
    $('#my_modal').on('show.bs.modal', function (e) {
      var bookId = $(e.relatedTarget).data('book-id');
      $(e.currentTarget).find('input[name="bookId"]').val(bookId);

    });
  }
</script>
<?php } else { echo "pas de droit";}?>