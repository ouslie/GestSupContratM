<?php
include_once 'EditableGrid.php';
include_once '../../connect.php';
$type = $_GET['type'];
$user_id = $_GET['user_id'];

$db->exec("set names utf8");

function fetch_pairs($db, $query)
{
    if (!($res = $db->query($query))) {
        return false;
    }

    $rows = array();
    while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
        $first = true;
        $key = $value = null;
        foreach ($row as $val) {
            if ($first) {$key = $val;
                $first = false;} else { $value = $val;
                break;}
        }
        $rows[$key] = $value;
    }
    return $rows;
}

$grid = new EditableGrid();
$grid->addColumn('status', 'Status', 'string',[0 => "Inactif", 1 => "Actif"], false);
$grid->addColumn('type', 'Type', 'integer', fetch_pairs($db, 'SELECT id, nom  FROM tcontratstype'), false);
$grid->addColumn('user', 'Client', 'integer', fetch_pairs($db, 'SELECT id, login  FROM tusers'), false, NULL, true, true);
$grid->addColumn('periode', 'Période', 'string', ["Mensuel" => "Mensuel","Annuel" => "Annuel"], false);
$grid->addColumn('service', 'Service', 'date', null, false);
$grid->addColumn('date_souscription', 'Date de souscription', 'date', null, false);

if ($type == 3 ){
    $grid->addColumn('temps_souscrit', 'Temps souscrit', 'string',null, false);
    $grid->addColumn('timeused', 'Temps consommé', 'string',null, false);
    $grid->addColumn('tempsrestant', 'Temps restant', 'string',null, false);
    $grid->addColumn('tarifcontrat', 'Tarif', 'string',null, false);
}

if ($type == 1 ){
    $grid->addColumn('date_fin', 'Date de fin', 'date',null, false);
    $grid->addColumn('timeused', 'Temps consommé', 'string',null, false);
    $grid->addColumn('tarif', 'Tarif horaire', 'string',null, false);
}
if ($type == 2 ){
    $grid->addColumn('date_fin', 'Date de fin', 'date',null, false);
    $grid->addColumn('tarifcontrat', 'Tarif contrat', 'string',null, false);
}



$grid->addColumn('facturelink', 'Facture', 'html',null, false,'facturelink');

$mydb_tablename = (isset($_GET['db_tablename'])) ? stripslashes($_GET['db_tablename']) : 'tcontrats';

error_log(print_r($_GET, true));

            

switch($type)
{
    case 1:
    $query = "SELECT sum(tincidents.time) AS timeused,
    tcontrats.temps_souscrit  AS temps_souscrit,
    tcontrats.temps_souscrit - sum(tincidents.time) AS tempsrestant,
    tincidents.contrats, 
    tcontrats.id, 
    tcontrats.status,
    tcontrats.service,
    date_format(tcontrats.date_souscription, '%d/%m/%Y') AS date_souscription,
    date_format(tcontrats.date_fin, '%d/%m/%Y') AS date_fin,
    tcontrats.tarif, 
    tcontrats.periode, 
    tcontrats.prepaye, 
    tcontrats.tarifcontrat, 
    tcontrats.facturelink,
    tcontrats.type,
    tcontrats.user
    FROM tincidents
    INNER JOIN tcontrats ON (tincidents.contrats=tcontrats.id)
    WHERE tcontrats.type = 1 AND tcontrats.user = $user_id
    GROUP BY tcontrats.id";

    break;

    case 2:
    $query = "SELECT 
    tcontrats.id, 
    tcontrats.status,
    tcontrats.service,
    date_format(tcontrats.date_souscription, '%d/%m/%Y') AS date_souscription,
    date_format(tcontrats.date_fin, '%d/%m/%Y') AS date_fin,
    tcontrats.periode, 
    tcontrats.tarifcontrat, 
    tcontrats.facturelink,
    tcontrats.type, 
    tcontrats.user
    FROM tcontrats
    WHERE tcontrats.type = 2  AND tcontrats.user = $user_id
    GROUP BY tcontrats.id";

    break;

    case 3:
    $query = "SELECT sum(tincidents.time) AS timeused,
    tcontrats.temps_souscrit AS temps_souscrit,
    tcontrats.temps_souscrit - sum(tincidents.time)  AS tempsrestant,
    tincidents.contrats, 
    tcontrats.id, 
    tcontrats.status,
    tcontrats.service,
    date_format(tcontrats.date_souscription, '%d/%m/%Y') AS date_souscription,
    date_format(tcontrats.date_fin, '%d/%m/%Y') AS date_fin,
    tcontrats.tarif, 
    tcontrats.periode, 
    tcontrats.prepaye, 
    tcontrats.tarifcontrat, 
    tcontrats.facturelink,
    tcontrats.type, 
    tcontrats.user
    FROM tincidents
    INNER JOIN tcontrats ON (tincidents.contrats=tcontrats.id)
    WHERE tcontrats.type = 3  AND tcontrats.user = $user_id
    GROUP BY tcontrats.id";

    break;

}
if (isset($_GET['sort']) && $_GET['sort'] != "") 
{
    $query .= " ORDER BY " . $_GET['sort'] . ($_GET['asc'] == "0" ? " DESC " : "");
} else {
    $query .= " ORDER BY status DESC,date_fin";

}

//error_log($query);
$result = $db->query($query);

// close PDO
$pdo = null;

// envoie data
$grid->renderJSON($result, false, false, !isset($_GET['data_only']));
