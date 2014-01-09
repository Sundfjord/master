globals = {};

$(document).ready(function(){
    
    

    var counter = 1;
    var limit = 7;
    function addInput(divName){
         if (counter === limit)  {
              alert("You have reached the limit of adding " + counter + " inputs");
         }
         else {
              var newdiv = document.createElement('div');
              newdiv.innerHTML = "Entry " + (counter + 1) + " <br><input type='text' name='myInputs[]'>";
              document.getElementById(divName).appendChild(newdiv);
              counter++;
         }
    }
    
    if(document.getElementById("single").checked){
        $(".form-control").prop("disabled");
    };
    
    /*************************************
    **************************************
    * CALENDAR
    **************************************
    *************************************/
    
    var filter_id = $('#filter_id').val();
    
    $('#calendar').fullCalendar({
        
        firstDay:'1',
        defaultView: 'basicWeek',
        height: 400,
        weekends: false,
        timeFormat: 'H(:mm)',
        allDayDefault: false,
        header: 
        {
            left: '',
            center: '',
            right: 'prev,next, month,basicWeek'
        },
        columnFormat: 'ddd d/M',
        events: function(start,end, callback) 
        {
            $.getJSON('http://localhost/master/index.php/team/json', function(data)
            {
                var eventsToShow = [];
                for(var i=0; i<data.length; i++)
                {
                    if(data[i].team === filter_id)
                    {
                        eventsToShow.push(data[i]);
                    }
                }
                callback(eventsToShow);
            });
        },        
       //eventRender determines what should be shown in the calendar
      /*  eventRender: function(event, element, view) {
            if (view.name === "agendaDay") 
                {
                element.find(".fc-event-content")
                    content: event.description;
                }
        } */
        
        eventClick: function(calEvent) 
        {
            /*var json = JSON.stringify(calEvent);
            $.ajax({        
                type: "POST",
                url: "http://localhost/master/index.php/team/get_episode_data",
                data: 
                { 
                    eventData: json 
                }
                });
            console.log(json); */
            
            var stDate = $.fullCalendar.formatDate(calEvent.start, 'dd-MM-yyyy');
            globals['textDate'] = $.fullCalendar.formatDate(calEvent.start, 'dddd the dS MMMM yyyy');
            globals['textTitle'] = calEvent.title;
            globals['textId'] = calEvent.id;
            
            if( $('#event-info').is(':visible') ) 
            {
                $('#event-info').empty();
            } 
            $('#event-info').append("<form id='edit_episode'action=''><button id='delete_episode_button'class='btn btn-danger btn-xs' type='button'><span class='glyphicon glyphicon-trash'></span></button><button id='edit_episode_button' class='btn btn-default btn-xs' type='button'><span class='glyphicon glyphicon-edit'></span></button><label for='title'>Title:</label><input id='title' class='readonly' type='text' name='title' value='" + calEvent.title + "' readonly><label for='date'>Date:</label><input id='date' class='readonly' type='text' name='date' value='" + stDate + "' readonly><label for='location'>Location:</label><input id='location' class='readonly' type='text' name='location' value='" + calEvent.location + "' readonly><label for='start-time'>Start time:</label><input id='start-time' class='readonly' type='text' name='start-time' value='" + calEvent.start_time + "' readonly><label for='end_time'>End time:</label><input id='end-time' class='readonly' type='text' name='end-time' value='" + calEvent.end_time + "' readonly><label for='description'>Description:</label><input id='description' class='readonly' type='text' name='description' value='" + calEvent.description + "' readonly><input id='episode-id' class='readonly' type='hidden' name='episode-id' value='" + calEvent.id + "' readonly></form>");
            $('#event-info').show();
        }
        
    });
    
    /*************************************
    **************************************
    * BLABLA
    **************************************
    *************************************/
    
    
    
    $('#event-info').on("click", "#edit_episode_button", function() {
        var title = $('#title').val();
        var date = $('#date').val();
        var location = $('#location').val();
        var startTime = $('#start-time').val();
        var endTime = $('#end-time').val();
        var description = $('#description').val();
        var episodeId = $('#episode-id').val();

        console.log(episodeId);

        var base_url = '<?php echo base_url(); ?>';

        $.ajax({  
            type: 'POST',  
            url: base_url+'index.php/team/edit_episode',  
            data: 
            { 
                episodeId: 'episodeId', 
                eventId: 'eventId' 
            },
            success: function()
            {                   
                $('#edit_episode_modal').modal();
                    $("#edited_episodeName").val(title);
                    $("#edited_episodeDate").val(date);
                    $("#edited_episodeDesc").val(description);
                    $("#edited_episodeStartTime").val(startTime);
                    $("#edited_episodeEndTime").val(endTime);
                    $("#edited_episodeLocation").val(location);
                    $("#edited_episodeId").val(episodeId);
            }
        });
      });
      
      $('#event-info').on("click", "#delete_episode_button", function () {
          
          $('#delete_episode_modal .modal-body').append("<p>Are you sure you want to delete the event " + globals.textTitle + " on " + globals.textDate + " ?</p>");
            $("#delete_episodeId").val(globals.textId);
            $('#delete_episode_modal').modal('show');         
      });
      
      $('#delete_episode_modal').on('hidden.bs.modal', function (e) {
        $('#delete_episode_modal .modal-body').empty();
        });  
    
    /*************************************
    **************************************
    * DATES AND TIMES
    **************************************
    *************************************/
    
    $('#start-date').datepicker({
        format: "dd-mm-yyyy",
        weekStart: 1,
        startDate: "today",
        autoclose: true
    }); 
    
    $('#end-date').datepicker({
        format: "dd-mm-yyyy",
        weekStart: 1,
        startDate: "+1d",
        endDate: "+1y",
        showMeridian: false,
        autoclose: true
    });
    
    $('#start-time').datetimepicker({
        format: "hh:ii",
        weekStart: 1,
        startDate: "today",
        autoclose: true,
        minuteStep: 15,
        startView: 1,
        todayHighlight: true
        
    });
    
    $('#end-time').datetimepicker({
        format: "hh:ii",
        weekStart: 1,
        endDate: "+1y",
        autoclose: true,
        minuteStep: 15,
        startView: 1
    });
    
    $('#edit-start-time').datetimepicker({
        format: "hh:ii",
        weekStart: 1,
        startDate: "today",
        autoclose: true,
        minuteStep: 15,
        startView: 1,
        todayHighlight: true
        
    });
    
    $('#edit-end-time').datetimepicker({
        format: "hh:ii",
        weekStart: 1,
        endDate: "+1y",
        autoclose: true,
        minuteStep: 15,
        startView: 1
    });
    
    /*************************************
    **************************************
    * MODALS
    **************************************
    *************************************/
    
    $('#add_event').click(function() {
        $('#add_event_modal').modal();
    });
    
    $('#edit_event').click(function() {
        $('#edit_event_modal').modal();
    });
    
    $('#delete_event').click(function() {
        $('#delete_event_modal').modal();
    });
    
    /*************************************
    **************************************
    * POPOVERS
    **************************************
    *************************************/
    
    $('#gay').popover({
        placement: top,
        title: "Just a heads-up",
        content: "This date can be no more than 1 year from the start date."
        
    });
    
    /*************************************
    **************************************
    * TABS
    **************************************
    *************************************/
    
    $('.nav a').click(function() {
            preventDefault();
            $(this).tab('show');
            $('#calendar').fullCalendar('render');
        });
        
        // on load of the page: switch to the currently selected tab
        var hash = window.location.hash;
        $('.nav a[href="' + hash + '"]').tab('show');
        
        // store the currently selected tab in the hash value
        $("ul.nav-tabs > li > a").on("shown.bs.tab", function (e) {
            var id = $(e.target).attr("href").substr(1);
            window.location.hash = id;
        });
    
    $("#add_event_modal").on('shown', function() {
    $(this).find("[autofocus]:first").focus();
    });
    
    /*************************************
    **************************************
    * SEARCH PLAYER
    **************************************
    *************************************/
    

    $("#search_player").keyup(function(e)
    {
    	// Sletter innhold i feltet dersom man trykker esc
		if (e.keyCode === 27) 
		{ 
			$(this).val(""); 
		}
		 
        //Henter teksten frå inputfeltet, og resetter counten til 0.
        var filter = $(this).val(), count = 0;
        var soking = false;
        //Looper gjennom ordlisten
        $(".username").each(function()
        {
            // Dersom listen ikke inneholder inputen, så fades det ut.
            if ($(this).text().search(new RegExp(filter, "i")) < 0)
            {
                $(this).parent().parent().hide();              
			} 
            
            //Viser inputen dersom listen inneholder denne, og øker counten med 1.
           	else
           	{
                $(this).parent().parent().show();
                count++;
            }
            
            if ($(this).text() === $("#search_player").val())
            {
            	soking = true;
            }  
        });
        
        // Fjerner blå knapp om ordet finnes
        if (soking)
        {
        	$('#legg_til_ord').removeClass('btn-primary');
        	$('#legg_til_ord').children().removeClass('icon-white');
        	$('#legg_til_ord').attr('disabled', 'disabled');
        }
        
        
        // Hindrer blå knapp om søket er tomt
        else if ($("#search_player").val() === 0)
        {
        	$('#legg_til_ord').removeAttr('disabled');
        	$('#legg_til_ord').removeClass('btn-primary');
        	$('#legg_til_ord').children().removeClass('icon-white');
        }
        
        // Setter blå knapp
        else
        {
        	$('#legg_til_ord').removeAttr('disabled');
        	$('#legg_til_ord').addClass('btn-primary');
        	$('#legg_til_ord').children().addClass('icon-white');
        }
        $('#stripetabell').trigger("update");
        $('#stripetabell').trigger("appendCache");
    });

    /* $('#search_player').live('keypress', function(e){
  		// Trykker enter
  		if(e.keyCode === 13)
  		{
  			// Om legg til-knappen er blå, legg til verdi i modal
	    	if ($('#legg_til_ord').hasClass('btn-primary'))
	    	{
		  		event.preventDefault();
		  		$('#legg_til_ord_modal').modal();
		  		$('#ord').val($("#search_player").val());
		  		//$('#ord').removeAttr('autofocus');
		  		
		  		$('#grad').attr('autofocus','autofocus');
		  	}
		  	
		  	// Om knappen er grå, ikke gjør noe
		  	else
		  	{
		  		event.preventDefault();
		  	}
	  	}
	}); */

	// Legger til tekst i modal dersom knappen er blå, og man trykker på den
	$('#legg_til_ord').click(function(){
		if ($('#legg_til_ord').hasClass('btn-primary'))
	    {
	    	$('#ord').val($("#sok").val());
	    	$('#grad').focus();
	    }
	});

    /*************************************
    **************************************
    * SEARCH TEAM
    **************************************
    *************************************/

        $("#search_team").keyup(function(e)
    {
    	// Sletter innhold i feltet dersom man trykker esc
		if (e.keyCode === 27) 
		{ 
			$(this).val(""); 
		}
		 
        //Henter teksten frå inputfeltet, og resetter counten til 0.
        var filter = $(this).val(), count = 0;
        var soking = false;
        //Looper gjennom ordlisten
        $(".teamname").each(function()
        {
            // Dersom listen ikke inneholder inputen, så fades det ut.
            if ($(this).text().search(new RegExp(filter, "i")) < 0)
            {
                $(this).parent().parent().hide();              
			} 
            
            //Viser inputen dersom listen inneholder denne, og øker counten med 1.
           	else
           	{
                $(this).parent().parent().show();
                count++;
            }
            
            if ($(this).text() === $("#search_team").val())
            {
            	soking = true;
            }  
        });
        
        // Fjerner blå knapp om ordet finnes
        if (soking)
        {
        	$('#legg_til_ord').removeClass('btn-primary');
        	$('#legg_til_ord').children().removeClass('icon-white');
        	$('#legg_til_ord').attr('disabled', 'disabled');
        }
        
        
        // Hindrer blå knapp om søket er tomt
        else if ($("#search_team").val() === 0)
        {
        	$('#legg_til_ord').removeAttr('disabled');
        	$('#legg_til_ord').removeClass('btn-primary');
        	$('#legg_til_ord').children().removeClass('icon-white');
        }
        
        // Setter blå knapp
        else
        {
        	$('#legg_til_ord').removeAttr('disabled');
        	$('#legg_til_ord').addClass('btn-primary');
        	$('#legg_til_ord').children().addClass('icon-white');
        }
        $('#stripetabell').trigger("update");
        $('#stripetabell').trigger("appendCache");
    });

    /* $('#search_team').live('keypress', function(e){
  		// Trykker enter
  		if(e.keyCode === 13)
  		{
  			// Om legg til-knappen er blå, legg til verdi i modal
	    	if ($('#legg_til_ord').hasClass('btn-primary'))
	    	{
		  		event.preventDefault();
		  		$('#legg_til_ord_modal').modal();
		  		$('#ord').val($("#search_team").val());
		  		//$('#ord').removeAttr('autofocus');
		  		
		  		$('#grad').attr('autofocus','autofocus');
		  	}
		  	
		  	// Om knappen er grå, ikke gjør noe
		  	else
		  	{
		  		event.preventDefault();
		  	}
	  	}
	}); */

	// Legger til tekst i modal dersom knappen er blå, og man trykker på den
	$('#legg_til_ord').click(function(){
		if ($('#legg_til_ord').hasClass('btn-primary'))
	    {
	    	$('#ord').val($("#sok").val());
	    	$('#grad').focus();
	    }
	});
        
        $(document).ready(function(){
 		  var str=location.href.toLowerCase();
        $('.navigation li a').each(function() {
                if (str.indexOf(this.href.toLowerCase()) > -1) {
						$("li.highlight").removeClass("highlight");
                        $(this).parent().addClass("highlight"); 
                   }
              	 							}); 
		$('li.highlight').parents().each(function(){
												  
					if ($(this).is('li')){
						$(this).addClass("highlight"); 
						}							  
												  });
       });
    
        $('#team_table').dataTable();           
        });