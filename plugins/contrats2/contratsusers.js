function $_GET(param) {
	var vars = {};
	window.location.href.replace( location.hash, '' ).replace( 
		/[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
		function( m, key, value ) { // callback
			vars[key] = value !== undefined ? value : '';
		}
	);

	if ( param ) {
		return vars[param] ? vars[param] : null;	
	}
	return vars;
}


function display(n) {
    var num = n;
    var hours = (num / 60);
    var rhours = Math.floor(hours);
    var minutes = (hours - rhours) * 60;
    var rminutes = Math.round(minutes);
    return rhours + " heure(s) et " + rminutes + " minute(s)";
    }

var typecontrat = $_GET('type');

/**
 *  highlightRow and highlight are used to show a visual feedback. If the row has been successfully modified, it will be highlighted in green. Otherwise, in red
 */
function highlightRow(rowId, bgColor, after) {
    var rowSelector = $("#" + rowId);
    rowSelector.css("background-color", bgColor);
    rowSelector.fadeTo("normal", 0.5, function () {
        rowSelector.fadeTo("fast", 1, function () {
            rowSelector.css("background-color", '');
        });
    });
}

function highlight(div_id, style) {
    highlightRow(div_id, style == "error" ? "#e5afaf" : style == "warning" ? "#ffcc00" : "#8dc70a");
}



function message(type, message) {
    if (type == "error") {
        type = "danger"
    } else {
        type = "success"
    }
    $('#message').html("<div class=\"alert alert-" + type + "\" role=\"alert\">" + message + "</div>").slideDown('normal').delay(1800).slideToggle('slow');
}

DatabaseGrid.prototype.initializeGrid = function (grid) {

    var self = this;

    grid.setCellRenderer("timeused", new CellRenderer({
        render: function (cell, id) {
           
            cell.innerHTML += display(id);
          
        }
    }));

    grid.setCellRenderer("temps_souscrit", new CellRenderer({
        render: function (cell, id) {
           
            cell.innerHTML += display(id);
          
        }
    }));

    grid.setCellRenderer("tempsrestant", new CellRenderer({
        render: function (cell, id) {
           
        if (id < 0){
            cell.innerHTML += "Dépassé";
            }
        else {
            cell.innerHTML += display(id);
            }  
        }
    }));

    grid.setCellRenderer("tarif", new CellRenderer({
        render: function (cell, id) {
            cell.innerHTML += id + "€"; 
        }
    }));

    grid.setCellRenderer("tarifcontrat", new CellRenderer({
        render: function (cell, id) {
            cell.innerHTML += id + "€"; 
        }
    }));
    // render for the action column
    grid.setCellRenderer("action", new CellRenderer({
        render: function (cell, id) {
            cell.innerHTML += "<i onclick=\"datagrid.deleteRow(" + id + ");\" class='fa fa-trash red' ></i>";
        }
    }));

    grid.setCellRenderer("facturelink", new CellRenderer({
        render: function (cell, id) {
            if (id==null){
            cell.innerHTML += "Non disponible";
            } else {
                cell.innerHTML +=   "<a href="+id+"> Ma facture<i class='icon-file></i></a>";
            }
        }
    }));
    grid.setCellRenderer("edit", new CellRenderer({
        render: function (cell, id) {
            cell.innerHTML += "<a style='margin:0px 10px 0px 10px' href=index.php?module=items&action=list&id_fact="+id+" class='fas fa-edit'></i></a>";
            cell.innerHTML += "<a style='margin:0px 10px 0px 10px' href=facture.php?id_fact="+id+" <i class='far fa-file-pdf' ></i></a>";
            cell.innerHTML += "<i style='margin:0px 10px 0px 10px' onclick=\"datagrid.deleteRow(" + id + ");\" class='icon-trash red' ></i>";
            cell.innerHTML += "<a style='margin:0px 10px 0px 10px'  href=index.php?module=factures&action=generate&id_fact="+id+ "  class='fas fa-cog red' ></i></a>";

        }
    }));

    grid.renderGrid("tablecontent", "table table-hover table-striped table-bordered first");

};

function updatePaginator(grid, divId) {
    divId = divId || "paginator";
    var paginator = $("#" + divId).empty();
    var nbPages = grid.getPageCount();

    // get interval
    var interval = grid.getSlidingPageInterval(20);
    if (interval == null) return;

    // get pages in interval (with links except for the current page)
    var pages = grid.getPagesInInterval(interval, function (pageIndex, isCurrent) {
        if (isCurrent) return "<span id='currentpageindex'>" + (pageIndex + 1) + "</span>";
        return $("<a>").css("cursor", "pointer").html(pageIndex + 1).click(function (event) {
            grid.setPageIndex(parseInt($(this).html()) - 1);
        });
    });

    // "first" link
    var link = $("<a class='nobg'>").html("<i class='fa fa-fast-backward'></i>");
    if (!grid.canGoBack()) link.css({
        opacity: 0.4,
        filter: "alpha(opacity=40)"
    });
    else link.css("cursor", "pointer").click(function (event) {
        grid.firstPage();
    });
    paginator.append(link);

    // "prev" link
    link = $("<a class='nobg'>").html("<i class='fa fa-backward'></i>");
    if (!grid.canGoBack()) link.css({
        opacity: 0.4,
        filter: "alpha(opacity=40)"
    });
    else link.css("cursor", "pointer").click(function (event) {
        grid.prevPage();
    });
    paginator.append(link);

    // pages
    for (p = 0; p < pages.length; p++) paginator.append(pages[p]).append(" ");

    // "next" link
    link = $("<a class='nobg'>").html("<i class='fa fa-forward'>");
    if (!grid.canGoForward()) link.css({
        opacity: 0.4,
        filter: "alpha(opacity=40)"
    });
    else link.css("cursor", "pointer").click(function (event) {
        grid.nextPage();
    });
    paginator.append(link);

    // "last" link
    link = $("<a class='nobg'>").html("<i class='fa fa-fast-forward'>");
    if (!grid.canGoForward()) link.css({
        opacity: 0.4,
        filter: "alpha(opacity=40)"
    });
    else link.css("cursor", "pointer").click(function (event) {
        grid.lastPage();
    });
    paginator.append(link);
};


function showAddForm() {
    if ($("#addform").is(':visible'))
        $("#addform").hide();
    else
        $("#addform").show();
}

/**
   updateCellValue calls the PHP script that will update the database. 
 */
function updateCellValue(editableGrid, rowIndex, columnIndex, oldValue, newValue, row, onResponse)
{      
	$.ajax({
		url: 'index.php?page=plugins/contrats2/update',
		type: 'POST',
		dataType: "html",
	   		data: {
			tablename : editableGrid.name,
			id: editableGrid.getRowId(rowIndex), 
			newvalue: editableGrid.getColumnType(columnIndex) == "boolean" ? (newValue ? 1 : 0) : newValue, 
			colname: editableGrid.getColumnName(columnIndex),
			coltype: editableGrid.getColumnType(columnIndex)			
		},
		success: function (response) 
		{ 
			// reset old value if failed then highlight row
			var success = onResponse ? onResponse(response) : (response == "ok" || !isNaN(parseInt(response))); // by default, a sucessfull reponse can be "ok" or a database id 
			if (!success) editableGrid.setValueAt(rowIndex, columnIndex, oldValue);
		    highlight(row.id, success ? "ok" : "error"); 
		},
		error: function(XMLHttpRequest, textStatus, exception) { alert("Ajax failure\n" + errortext); },
		async: true
	});
   
}
   


function DatabaseGrid() 
{ 
	this.editableGrid = new EditableGrid("contrats", {
      enableSort: true,


      /* Comment this line if you set serverSide to true */
	    // define the number of row visible by page
      /*pageSize: 50,*/

      /* This property enables the serverSide part */
      serverSide: true,

      // Once the table is displayed, we update the paginator state
        tableRendered:  function() {  updatePaginator(this); },
   	    tableLoaded: function() { datagrid.initializeGrid(this); },
		modelChanged: function(rowIndex, columnIndex, oldValue, newValue, row) {
   	    	updateCellValue(this, rowIndex, columnIndex, oldValue, newValue, row);
       	}
 	});
        this.fetchGrid(); 


  
    $("#filter").val(this.editableGrid.currentFilter != null ? this.editableGrid.currentFilter : "");
	if ( this.editableGrid.currentFilter != null && this.editableGrid.currentFilter.length > 0)
	  $("#filter").addClass('filterdefined');
    else
	  $("#filter").removeClass('filterdefined');
	
}

DatabaseGrid.prototype.fetchGrid = function()  {
	// call a PHP script to get the data
	this.editableGrid.loadJSON("plugins/contrats2/loaddatausers.php?db_tablename=tcontrats&type="+typecontrat+"&user_id="+user_id);
};



DatabaseGrid.prototype.deleteRow = function(id) 
{

  var self = this;

  if ( confirm('Voulez vous bien suprimer la transaction ' + id )  ) {

        $.ajax({
		url: 'index.php?page=plugins/contrats2/delete',
		type: 'POST',
		dataType: "html",
		data: {
			tablenamed : self.editableGrid.name,
			id: id 
		},
		success: function (response) 
		{ 		
          if (response == "ok" ) {
              message("success","Transaction supprimé");
              self.fetchGrid();
		  }
		},
		error: function(XMLHttpRequest, textStatus, exception) { alert("Ajax failure\n" + errortext); },
		async: true
	});

        
  }
			
}; 


DatabaseGrid.prototype.addRow = function(id) 
{

  var self = this;

        $.ajax({
		url: 'index.php?module=transaction&action=add',
		type: 'POST',
		dataType: "html",
		data: {
			tablename : self.editableGrid.name,
			third:  $("#third").val(),
			comment:  $("#comment").val(),
			id_category:  $("#id_category").val(),
			id_bank:  $("#id_bank").val(),
			id_type:  $("#id_type").val(),
			amount:  $("#amount").val(),
			date:  $("#date").val(),
			id_contrat:  $("#id_contrat").val()



		},
		success: function (response) 
		{ 
			if (response == "ok" ) {
                message("success","Transaction ajouté");
                self.fetchGrid();
           	}
            else 
            message("error","Error occured");		
        },
		error: function(XMLHttpRequest, textStatus, exception) { alert("Ajax failure\n" + errortext); },
		async: true
	});

        
			
}; 



