<?php
include_once 'EditableGrid.php';
include_once '../../connect.php';
$type = $_GET['type'];

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
$grid->addColumn('id', 'REF', 'integer', null, false);
$grid->addColumn('status', 'Status', 'string',[0 => "Inactif", 1 => "Actif"], false);
$grid->addColumn('user', 'Client', 'integer', fetch_pairs($db, 'SELECT id, login  FROM tusers'), true);
$grid->addColumn('type', 'Type', 'integer', fetch_pairs($db, 'SELECT id, nom  FROM tcontratstype'), true);
$grid->addColumn('periode', 'periode', 'string', ["Mensuel" => "Mensuel","Annuel" => "Annuel"], true);
$grid->addColumn('service', 'service', 'string', ["Webmastering" => "Webmastering","Infogérance" => "Infogérance","Infogérance + Webmastering" => "Infogérance + Webmastering"], true);
$grid->addColumn('date_souscription', 'Date de souscription', 'date', null, true);
$grid->addColumn('date_fin', 'Date de fin', 'date',null, true);

if ($type == 3 ){
    $grid->addColumn('nom', 'Nom', 'string',null, true);
    $grid->addColumn('temps_souscrit', 'Temps souscrit', 'string',null, true);
    $grid->addColumn('timeused', 'Temps consommé', 'string',null, false);
    $grid->addColumn('tempsrestant', 'Temps restant', 'string',null, false);
    $grid->addColumn('tarifcontrat', 'Tarif', 'string',null, true);
}

if ($type == 1 ){
    $grid->addColumn('nom', 'Nom', 'string',null, true);
    $grid->addColumn('timeused', 'Temps consommé', 'string',null, false);
    $grid->addColumn('tarif', 'Tarif horaire', 'string',null, true);
}
if ($type == 2 ){
    $grid->addColumn('tarifcontrat', 'Tarif contrat', 'string',null, true);
}



$grid->addColumn('facturelink', 'Facture', 'html',null, false,'facturelink');
$grid->addColumn('edit', 'Action', 'html', null, false, 'id');

$mydb_tablename = (isset($_GET['db_tablename'])) ? stripslashes($_GET['db_tablename']) : 'tcontrats';

error_log(print_r($_GET, true));

            

switch($type)
{
    case 1:
    $query = "SELECT sum(tincidents.time) AS timeused,
    tcontrats.temps_souscrit AS temps_souscrit,
    tcontrats.temps_souscrit - sum(tincidents.time)  AS tempsrestant,
    tincidents.contrats, 
    tcontrats.user,
    tcontrats.id, 
    tcontrats.status,
    tcontrats.nom,
    tcontrats.service,
    date_format(tcontrats.date_souscription, '%d/%m/%Y') AS date_souscription,
    date_format(tcontrats.date_fin, '%d/%m/%Y') AS date_fin,
    tcontrats.tarif, 
    tcontrats.periode, 
    tcontrats.prepaye, 
    tcontrats.tarifcontrat, 
    tcontrats.facturelink,
    tcontrats.type
    
    FROM tincidents
    INNER JOIN tcontrats ON (tincidents.contrats=tcontrats.id)
    WHERE tcontrats.type = 1
    GROUP BY tcontrats.id
    ORDER BY tcontrats.status DESC";

    break;

    case 2:
    $query = "SELECT 
    tcontrats.user,
    tcontrats.id, 
    tcontrats.status,
    tcontrats.nom,
    tcontrats.service,
    date_format(tcontrats.date_souscription, '%d/%m/%Y') AS date_souscription,
    date_format(tcontrats.date_fin, '%d/%m/%Y') AS date_fin,
    tcontrats.periode, 
    tcontrats.tarifcontrat, 
    tcontrats.facturelink,
    tcontrats.type
    FROM tcontrats
    WHERE tcontrats.type = 2
    GROUP BY tcontrats.id
    ORDER BY tcontrats.status DESC";

    break;

    case 3:
    $query = "SELECT sum(tincidents.time) AS timeused,
    tcontrats.temps_souscrit AS temps_souscrit,
    tcontrats.temps_souscrit - sum(tincidents.time)  AS tempsrestant,
    tincidents.contrats, 
    tcontrats.user,
    tcontrats.id, 
    tcontrats.status,
    tcontrats.nom,
    tcontrats.service,
    date_format(tcontrats.date_souscription, '%d/%m/%Y') AS date_souscription,
    date_format(tcontrats.date_fin, '%d/%m/%Y') AS date_fin,
    tcontrats.tarif, 
    tcontrats.periode, 
    tcontrats.prepaye, 
    tcontrats.tarifcontrat, 
    tcontrats.facturelink,
    tcontrats.type
    FROM tincidents
    INNER JOIN tcontrats ON (tincidents.contrats=tcontrats.id)
    WHERE tcontrats.type = 3
    GROUP BY tcontrats.id
    ORDER BY tcontrats.status DESC";

    break;

}
//$query = "SELECT * FROM $mydb_tablename";
//$queryCount = "SELECT count(id) as nb FROM $mydb_tablename";

//error_log($query);
$result = $db->query($query);

// close PDO
$pdo = null;

// envoie data
$grid->renderJSON($result, false, false, !isset($_GET['data_only']));
