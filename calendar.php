<?php
################################################################################
# @Name : calendar.php
# @Description : display calendar
# @Call : /menu.php
# @Parameters : 
# @Author : Flox
# @Create : 19/02/2018
# @Update : 21/12/2018
# @Version : 3.1.37
################################################################################

//init var
if(!isset($_POST['technician'])) $_POST['technician']= $_SESSION['user_id'];

//select technician selection
if($_POST['technician']!='%')
{
   //select name of technician
   $querytech= $db->query("SELECT * FROM tusers WHERE id = $_POST[technician]"); 
   $resulttech=$querytech->fetch();
   $displaytech=T_('pour').'  '.$resulttech['firstname'].' '.$resulttech['lastname'];
}
else
{
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

<script type="text/javascript">
	if('ontouchstart' in document.documentElement) document.write("<script src='./template/assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
</script>

<!-- page specific plugin scripts -->
<script src="./template/assets/js/jquery-ui.custom.min.js"></script>
<script src="./template/assets/js/jquery.ui.touch-punch.min.js"></script>

<script src='./components/fullcalendar/lib/moment.min.js'></script>
<script src='./components/fullcalendar/fullcalendar.js'></script>
<?php
	//load locales
	if($ruser['language']=='fr_FR') {echo "<script src='./components/fullcalendar/locale/fr.js'></script>";}
	if($ruser['language']=='de_DE') {echo "<script src='./components/fullcalendar/locale/de.js'></script>";}
	if($ruser['language']=='es_ES') {echo "<script src='./components/fullcalendar/locale/es.js'></script>";}
	if($ruser['language']=='it_IT') {echo "<script src='./components/fullcalendar/locale/it.js'></script>";}

?>
<!-- <script src="./template/assets/js/fullcalendar.min.js"></script>  -->
<script src="./template/assets/js/bootbox.min.js"></script>

<!-- ace scripts -->
<script src="./template/assets/js/ace-elements.min.js"></script>
<script src="./template/assets/js/ace.min.js"></script>

<script type="text/javascript">
setTimeout("jQuery('#calendar').fullCalendar( 'render' );",100);
</script>

<!-- calendar script -->
<script type="text/javascript">
	jQuery(function($) {
		/* initialize the external events
			-----------------------------------------------------------------*/
			$('#external-events div.external-event').each(function() {

				// create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
				// it doesn't need to have a start or end
				var eventObject = {
					title: $.trim($(this).text()) // use the element's text as the event title
				};

				// store the Event Object in the DOM element so we can get to it later
				$(this).data('eventObject', eventObject);

				// make the event draggable using jQuery UI
				$(this).draggable({
					zIndex: 999,
					revert: true,      // will cause the event to go back to its
					revertDuration: 0  //  original position after the drag
				});
				
			});

			/* initialize the calendar
			-----------------------------------------------------------------*/
			var date = new Date();
			var d = date.getDate();
			var m = date.getMonth();
			var y = date.getFullYear();
			
			var calendar = $('#calendar').fullCalendar({
				height: 'auto',
				defaultView: 'agendaWeek',
				allDaySlot: false,
				weekNumbers: 'true',
				displayEventEnd : 'true',
				aspectRatio: 1.35,
				header: {
					left: 'prev,next today',
					center: 'title',
					right: 'month,agendaWeek,agendaDay'
				},
				events:
				<?php
					//list events
					$json = array();
					$db_technician=strip_tags($_POST['technician']);
					$qry=$db->prepare("SELECT `id`, `title`, `date_start` AS start, `date_end` AS end, `allday` as allDay, `classname` AS className, `incident` FROM `tevents` WHERE `technician` LIKE :technician AND (type=1 OR disable=0) ORDER BY id");
					$qry->execute(array('technician' => $db_technician));
					$calendar=json_encode($qry->fetchAll(PDO::FETCH_ASSOC)); 
					//$calendar=str_replace('"false"', 'false',$calendar);
					//$calendar=str_replace('"true"', 'true',$calendar);
					echo $calendar;
				?>
				,
				minTime: '07:00:00',
				maxTime: '21:00:00',
				editable: true,
				droppable: false, // this allows things to be dropped onto the calendar !!!
				drop: function(date, allDay) { // this function is called when something is dropped
				
					// retrieve the dropped element's stored Event Object
					var originalEventObject = $(this).data('eventObject');
					var $extraEventClass = $(this).attr('data-class');
					
					// we need to copy it, so that multiple events don't have a reference to the same object
					var copiedEventObject = $.extend({}, originalEventObject);
					
					// assign it the date that was reported
					copiedEventObject.start = date;
					copiedEventObject.allDay = allDay;
					if($extraEventClass) copiedEventObject['className'] = [$extraEventClass];
					
					// render the event on the calendar
					// the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
					$('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
					
					// is the "remove after drop" checkbox checked?
					if ($('#drop-remove').is(':checked')) {
						// if so, remove the element from the "Draggable Events" list
						$(this).remove();
					}
					
				}
				,
				selectable: true,
				selectHelper: true,
				select: function(start, end, allDay) {
					bootbox.prompt("<?php echo T_("Nouvel événement :"); ?>", function(title) {
						if (title !== null) {
							start=moment(start).format('YYYY/MM/DD HH:mm:ss');
							end=moment(end).format('YYYY/MM/DD HH:mm:ss');
							$.ajax({
								url: './core/calendar.php',
								data: 'action=add_event&title='+ title+'&start='+ start +'&end='+ end +'&allday='+allDay+'&technician='+ <?php echo $_SESSION['user_id']; ?>,
								type: "POST",
								success: function(json) {
									//alert('AddEvent'+allDay);
								}
							});
							calendar.fullCalendar('renderEvent',
								{
									title: title,
									start: start,
									end: end,
									allDay: allDay
								},
								true // make the event "stick"
							);
						}
					});
					calendar.fullCalendar('unselect');
				}
				,
				eventDrop: function(event, delta) {
					start=moment(event.start).format('YYYY/MM/DD HH:mm:ss');
					end=moment(event.end).format('YYYY/MM/DD HH:mm:ss');
					$.ajax({
						url: './core/calendar.php',
						data: 'action=move_event&title='+ event.title+'&start='+ start +'&end='+ end +'&id='+ event.id +'&technician='+ <?php echo $_SESSION['user_id']; ?> ,
						type: "POST",
						success: function(json) {
							//alert("event drop");
						}
					});
				}
				,
				eventResize: function(event) {
					start=moment(event.start).format('YYYY/MM/DD HH:mm:ss');
					end=moment(event.end).format('YYYY/MM/DD HH:mm:ss');
				
					$.ajax({
						url: './core/calendar.php',
						data: 'action=resize_event&title='+ event.title+'&start='+ start +'&end='+ end +'&id='+ event.id +'&technician='+ <?php echo $_SESSION['user_id']; ?> ,
						type: "POST",
						success: function(json) {
							//alert("event resize");
						}
					});
				}
				,
				eventClick: function(calEvent, jsEvent, view) {

					//display a modal
					var modal = 
					'<div class="modal fade">\
					  <div class="modal-dialog">\
					   <div class="modal-content">\
						 <div class="modal-body">\
						   <button type="button" class="close" data-dismiss="modal" style="margin-top:-10px;">&times;</button>\
						   <form class="no-margin">\
							  <label><?php echo T_('Changer le nom :'); ?> &nbsp;</label>\
							  <input size="25" class="middle" autocomplete="off" type="text" value="' + calEvent.title + '" />\
							 &nbsp;&nbsp;<button type="submit" class="btn btn-sm btn-success"><i class="icon-save"></i> <?php echo T_("Sauvegarder"); ?></button>\
						   </form>\
						 </div>\
						 <div class="modal-footer">';
							if(calEvent.incident && calEvent.incident!=0) {var modal = modal+'<button type="button" class="btn btn-sm btn-info" data-action="openlink"><i class="icon-ticket"></i> <?php echo T_("Ouvrir le ticket"); ?></button>'}
							var modal = modal + '<button type="button" class="btn btn-sm btn-danger" data-action="delete"><i class="icon-trash"></i> <?php echo T_("Supprimer"); ?></button>\
							<button type="button" class="btn btn-sm" data-dismiss="modal"><i class="icon-remove"></i> <?php echo T_("Annuler"); ?></button>\
						 </div>\
					  </div>\
					 </div>\
					</div>';
				
					var modal = $(modal).appendTo('body');
					modal.find('form').on('submit', function(ev){
						
						ev.preventDefault();
						calEvent.title = $(this).find("input[type=text]").val();
						calendar.fullCalendar('updateEvent', calEvent);
						modal.modal("hide");
						$.ajax({
							url: './core/calendar.php',
							data: 'action=update_title&title='+ calEvent.title +'&id='+ calEvent.id ,
							type: "POST",
							success: function(json) {
								//alert("Évenement mis à jour"+calEvent);
							}
						});
					});
					modal.find('button[data-action=delete]').on('click', function() {
						var decision = confirm("Voulez vous supprimer cet évenement?" ); 
						if (decision) {
							$.ajax({
								type: "POST",
								url: './core/calendar.php',
								data: 'action=delete_event&id='+ calEvent.id ,
								type: "POST",
								success: function(json) {
									//alert("Évenement supprimer"+calEvent.id);
								}
							});
							calendar.fullCalendar('removeEvents' , function(ev){
								return (ev._id == calEvent._id);
							})
							modal.modal("hide");
						} 
					});
					
					modal.modal('show').on('hidden', function(){
						modal.remove();
					});
					
					modal.find('button[data-action=openlink]').on('click', function() {
					window.open("./index.php?page=ticket&id="+ calEvent.incident, "_blank")
					});

					//console.log(calEvent.id);
					//console.log(jsEvent);
					//console.log(view);

					//change the border color just for fun
					//$(this).css('border-color', 'red');

				}
				
			});


		})
</script>


<?php
if($rparameters['debug'])
{
	echo '<u><b>DEBUG MODE:</b></u><br />';
	$json = array();
	$query = "SELECT id, title, date_start AS start, date_end AS end, allday as allDay  FROM `tevents` ORDER BY id ";  
	$row = $db->query($query) or die(print_r($db->errorInfo()));
	echo json_encode($row->fetchAll(PDO::FETCH_ASSOC)); 
}
?>
