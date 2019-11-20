<?php
################################################################################
# @Name : calendar.php
# @Description : display calendar
# @Call : /menu.php
# @Parameters : 
# @Author : Flox
# @Create : 19/02/2018
# @Update : 12/06/2019
# @Version : 3.1.42
################################################################################

//init var
if(!isset($_POST['technician'])) $_POST['technician']= $_SESSION['user_id'];

//select technician selection
if($_POST['technician']!='%')
{
	//select name of technician
	$qry=$db->prepare("SELECT `firstname`,`lastname` FROM `tusers` WHERE id=:id");
	$qry->execute(array('id' => $_POST['technician']));
	$row=$qry->fetch();
	$qry->closeCursor();
	$displaytech=T_('pour').'  '.$row['firstname'].' '.$row['lastname'];
} else {
   $_POST['technician']='%';
   $displaytech=T_('de tous les techniciens');
}
?>

<div class="page-header">
	<h1>
		<i class="icon-calendar"></i> 
		<?php echo T_('Calendrier'); ?>
		<small>
			<i class="icon-double-angle-right"></i>
			&nbsp;<?php echo $displaytech; ?>
		</small>
	</h1>
</div>
<div class="row">
	<div class="col-xs-12">
		<div class="row">
			<div class="col-sm-9">
				<form method="post" action="" name="technician">
					<?php echo T_('Technicien'); ?>:
					<select name="technician" onchange="submit()">
						<?php
						$qry=$db->prepare("SELECT `id`,`firstname`,`lastname` FROM `tusers` WHERE (`profile`=0 OR `profile`=4) AND `disable`=0");
						$qry->execute();
						while($row=$qry->fetch()) {
							if ($row['id'] == $_POST['technician']) 
							{ 
								echo '<option value="'.$row['id'].'" selected>'.$row['firstname'].' '.$row['lastname'].'</option>'; 
							} else {
								echo '<option value="'.$row['id'].'" >'.$row['firstname'].' '.$row['lastname'].'</option>'; 
							}
						}
						$qry->closeCursor();
						if ($_POST['technician']=='%') {echo '<option value="%" selected >'.T_('Tous').'</option>'; } else {echo '<option value="%">'.T_('Tous').'</option>'; }
						?>
					</select> 
				</form>
				<div class="space"></div>
			</div>
			<br />
			<br />
			<div class="space"></div>
			<div id="calendar"></div>
		</div>
	</div>
</div>

<!-- Fullcalendar 4 scripts -->
<script src='./components/fullcalendar/packages/core/main.js'></script>
<script src='./components/fullcalendar/packages/daygrid/main.js'></script>
<script src='./components/fullcalendar/packages/timegrid/main.js'></script>
<script src='./components/fullcalendar/packages/interaction/main.js'></script>
<script src='./components/fullcalendar/packages/core/locales-all.min.js'></script>

<script src='./components/moment/min/moment.min.js'></script>
<script src="./template/assets/js/bootbox.min.js"></script>

<!-- calendar script -->
<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {
	<?php
	if($ruser['language']=='fr_FR') {echo "locale:'fr',";}
	if($ruser['language']=='de_DE') {echo "locale:'de',";}
	if($ruser['language']=='es_ES') {echo "locale:'es',";}
	?>
    plugins: [ 'interaction', 'dayGrid', 'timeGrid' ],
    timeZone: 'UTC',
    defaultView: 'timeGridWeek',
    header: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,timeGridDay,list'
    },
    editable: true,
	droppable: false,
	selectable: true,
    firstDay: 1,
	weekNumbers: 'true',
	displayEventEnd : 'true',
	aspectRatio: 1.35,
	minTime: '07:00:00',
	maxTime: '21:00:00',
	height: 'auto',
	timeZone: 'local',
	events:
	<?php
		//list events
		$json = array();
		$db_technician=strip_tags($_POST['technician']);
		$qry=$db->prepare("SELECT `id`, `title`, `date_start` AS start, `date_end` AS end, `allday` as allDay, `classname` AS className, `incident` AS textColor FROM `tevents` WHERE `technician` LIKE :technician AND (type=1 OR disable=0) ORDER BY id");
		$qry->execute(array('technician' => $db_technician));
		$calendar=json_encode($qry->fetchAll(PDO::FETCH_ASSOC)); 
		$calendar=str_replace('"false"', 'false',$calendar);
		$calendar=str_replace('"true"', 'true',$calendar);
		echo $calendar;
	?>
	,
	eventResize: function(info) {
		start=moment(info.event.start).format('YYYY/MM/DD HH:mm:ss');
		end=moment(info.event.end).format('YYYY/MM/DD HH:mm:ss');
		$.ajax({
			url: './core/calendar.php',
			data: 'action=resize_event&title='+info.event.title+'&start='+start+'&end='+end+'&id='+info.event.id +'&technician='+ <?php echo $_SESSION['user_id']; ?> ,
			type: "POST",
			success: function(json) {
				//alert("json resize");
			}
		});
	}
	,
	eventDrop: function(info, delta) {
		start=moment(info.event.start).format('YYYY/MM/DD HH:mm:ss');
		end=moment(info.event.end).format('YYYY/MM/DD HH:mm:ss');
		allDay=info.event.allDay;
		$.ajax({
			url: './core/calendar.php',
			data: 'action=move_event&title='+info.event.title+'&start='+start+'&end='+end+'&allday='+allDay+'&id='+info.event.id+'&technician='+ <?php echo $_SESSION['user_id']; ?> ,
			type: "POST",
			success: function(json) {
				//alert("event move : id="+info.event.id+" start"+start+"start="+end+"allday="+allDay);
			}
		});
	}
	,
	select: function(info) {
		start=info.startStr;
		end=info.endStr;
		allDay=info.allDay;
		bootbox.prompt("<?php echo T_("Nouvel événement :"); ?>", function(title) {
			if (title !== null) {
				start=moment(start).format('YYYY/MM/DD HH:mm:ss');
				end=moment(end).format('YYYY/MM/DD HH:mm:ss');
				$.ajax({
					url: './core/calendar.php',
					data: 'action=add_event&title='+title+'&start='+start+'&end='+end+'&allday='+allDay+'&technician='+ <?php echo $_SESSION['user_id']; ?>,
					type: "POST",
					success: function(result) {
						var data = JSON.parse(result);
						//alert("event create");
						//render event
						calendar.addEvent({
							id: data.event_id,
							title: title,
							start: info.startStr,
							end: info.endStr,
							allDay: info.allDay
						});
					}
				});
				
			}
		});
	}
	,
	eventClick: function(info,calEvent) {
		//get ticket id 
		ticket=info.event.textColor
		
		//display a modal
		var modal = 
		'<div class="modal fade">\
		  <div class="modal-dialog">\
		   <div class="modal-content">\
			 <div class="modal-body">\
			   <button type="button" class="close" data-dismiss="modal" style="margin-top:-10px;">&times;</button>\
			   <form class="no-margin">\
				  <label><?php echo T_('Changer le nom :'); ?> &nbsp;</label>\
				  <input size="25" class="middle" autocomplete="off" type="text" value="' + info.event.title + '" />\
				 &nbsp;&nbsp;<button type="submit" class="btn btn-sm btn-success"><i class="icon-save"></i> <?php echo T_("Sauvegarder"); ?></button>\
			   </form>\
			 </div>\
			 <div class="modal-footer">';
				if(ticket!=0) {var modal = modal+'<button type="button" class="btn btn-sm btn-info" data-action="openlink"><i class="icon-ticket"></i> <?php echo T_("Ouvrir le ticket"); ?></button>'}
				var modal = modal + '<button type="button" class="btn btn-sm btn-danger" data-action="delete"><i class="icon-trash"></i> <?php echo T_("Supprimer"); ?></button>\
				<button type="button" class="btn btn-sm" data-dismiss="modal"><i class="icon-remove"></i> <?php echo T_("Annuler"); ?></button>\
			 </div>\
		  </div>\
		 </div>\
		</div>';
	
		var modal = $(modal).appendTo('body');
		modal.find('form').on('submit', function(ev){
			ev.preventDefault();
			newtitle = $(this).find("input[type=text]").val();
			//calendar.updateEvent', info.event);
			modal.modal("hide");
			$.ajax({
				url: './core/calendar.php',
				data: 'action=update_title&title='+newtitle+'&id='+ info.event.id ,
				type: "POST",
				success: function(json) {
					//alert("Évenement mis à jour"+info.event.id);
					info.event.setProp('title', newtitle);
				}
			});
		});

		modal.find('button[data-action=delete]').on('click', function() {
			var decision = confirm("Voulez vous supprimer cet évenement?" ); 
			if (decision) {
				$.ajax({
					type: "POST",
					url: './core/calendar.php',
					data: 'action=delete_event&id='+info.event.id ,
					type: "POST",
					success: function(json) {
						//alert("Évenement supprimer"+calEvent.id);
						info.event.remove();
					}
				});
				modal.modal("hide");
			} 
		});
		
		modal.modal('show').on('hidden', function(){
			modal.remove();
		});
		
		modal.find('button[data-action=openlink]').on('click', function() {
		window.open("./index.php?page=ticket&id="+ticket)
		});
	}
  });
  calendar.render();
});
</script>

<?php if($rparameters['debug']) {echo $calendar;}?>