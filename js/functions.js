globals = {};

$(document).ready(function(){
    
    /*************************************
    **************************************
    * CALENDAR
    **************************************
    *************************************/
    
    var filter_id = $('#filter_id').val();
    var base_url = 'http://localhost/master';
    
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
        eventRender: function(event, element, view) {
            if (view.name === "agendaWeek") 
                {
                element.find(".fc-event-content");
                    content: event.description;
                }
        },
        
        eventClick: function(calEvent) 
        {
            var stDate = $.fullCalendar.formatDate(calEvent.start, 'dd-MM-yyyy');
            var stime = calEvent.start_time;
            var startTime = stime.slice(0, -3);
            var etime = calEvent.end_time;
            var endTime = etime.slice(0, -3);
            
            globals['textDate'] = $.fullCalendar.formatDate(calEvent.start, 'dddd dS MMMM yyyy');
            globals['textTitle'] = calEvent.title;
            globals['textId'] = calEvent.id;
            
            $.ajax({
                type: "POST",
                url: base_url+"/index.php/team/get_attendance", 
                data: { epId : calEvent.id },
                dataType: "text",  
                cache: false,
                success: 
                    function(result){
                        $('#attendance_tables').append(result);
                    }
                });
                          
            if( $('#event-info').is(':visible') ) 
            {
                //$('#event-info').empty();
            } 
            $('.hidden_id').prepend("<input id='episode-id' class='noshow' type='hidden' name='ep-id' value='" + calEvent.id + "' readonly>");
            $('#coach-only').prepend("\
                            <button id='delete_episode_button'class='btn btn-danger btn-xs' type='button'><span class='glyphicon glyphicon-trash'></span></button>\n\
                            <button id='edit_episode_button' class='btn btn-default btn-xs' type='button'><span class='glyphicon glyphicon-edit'></span></button>\n\
                            ");
            $('#event-details').prepend("\
                    <div id='boxes-inline'>\n\
                    <div class='loc panel panel-default'>\n\
                        <div class='panel-heading'><span class='glyphicon glyphicon-map-marker'></span>Location</div>\n\
                        <div class='panel-body'>\n\
                            <p id='location' type='text' name='location'>" + calEvent.location + "</p>\n\
                        </div>\n\
                    </div>\n\
                    \n\
                    <div class='time panel panel-default'>\n\
                        <div class='panel-heading'><span class='glyphicon glyphicon-time'></span>Time</div>\n\
                        <div class='panel-body'>\n\
                            <p id='time' type='text' name='time'>" + startTime + " - " + endTime + "</p>\n\
                        </div>\n\
                    </div>\n\
                    </div>\n\
                    <div class='desc panel panel-default'>\n\
                        <div class='panel-heading'><span class='glyphicon glyphicon-info-sign'></span>Description</div>\n\
                        <div class='panel-body'>\n\
                            <p id='description' type='text' name='description'>" + calEvent.description + "</p>\n\
                        </div>\n\
                    </div>\n\
                    <input id='title' class='noshow' type='hidden' name='title' value='" + calEvent.title + "' readonly>\n\
                    <input id='date' class='noshow' type='hidden' name='date' value='" + stDate + "' readonly>\n\
                    <input id='start-time' class='noshow' type='hidden' name='start-time' value='" + startTime + "' readonly>\n\
                    <input id='end-time' class='noshow' type='hidden' name='end-time' value='" + endTime + "' readonly>\n\
                    <input id='episode-id' class='noshow' type='hidden' name='episode-id' value='" + calEvent.id + "' readonly>\n\
                    </div>\n\
                    ");    
            $('#event-info').show();
        }
        
    });
    
    /*************************************
    **************************************
    * BLABLA
    **************************************
    *************************************/
    
    
    
    $('#event-info').on("click", "#edit_episode_button", function() {
        
        var description = $("#event-details").find("#description").text();
        var location = $("#event-details").find("#location").text();
        var title = $('#title').val();
        var date = $('#date').val();
        var startTime = $('#start-time').val();
        var endTime = $('#end-time').val();
        var episodeId = $('#episode-id').val();

        console.log(episodeId);

        var base_url = 'http://localhost/master'; //try to make this dynamic 

        $.ajax({  
            type: "POST",  
            url: base_url+"/index.php/team/edit_episode",  
            data: { episodeId: episodeId },
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
    * FORMS
    **************************************
    *************************************/
    
    $('#start-date').datepicker({
        format: "dd-mm-yyyy",
        weekStart: 1,
        startDate: "today",
        todayHighlight: true,
        autoclose: true
    }); 
    
    $('#end-date').datepicker({
        format: "dd-mm-yyyy",
        weekStart: 1,
        startDate: "+1d",
        endDate: "+1y",
        autoclose: true
    });
    
    $('#edit-episode-date').datepicker({
        format: "dd-mm-yyyy",
        weekStart: 1,
        startDate: "+1d",
        endDate: "+1y",
        todayHighlight: true,
        autoclose: true
    });
    
    $('#start-time').datetimepicker({
        formatViewType:"time",
        format: "hh:ii",
        weekStart: 1,
        startDate: "today",
        autoclose: true,
        minuteStep: 15,
        startView: 1,
        todayHighlight: true,
        viewSelect: "day"
        
    });
    
    $('#end-time').datetimepicker({
        formatViewType:"time",
        format: "hh:ii",
        weekStart: 1,
        endDate: "+1y",
        autoclose: true,
        minuteStep: 15,
        startView: 1,
        todayHighlight: true,
        viewSelect: "day"
    });
    
    $('#edit-start-time').datetimepicker({
        formatViewType:"time",
        format: "hh:ii",
        weekStart: 1,
        startDate: "today",
        autoclose: true,
        minuteStep: 15,
        startView: 1,
        todayHighlight: true,
        viewSelect: "day"
        
    });
    
    $('#edit-end-time').datetimepicker({
        formatViewType:"time",
        format: "hh:ii",
        weekStart: 1,
        endDate: "+1y",
        autoclose: true,
        minuteStep: 15,
        startView: 1,
        todayHighlight: true,
        viewSelect: "day"
    });
    
    $('#edit-episode-start-time').datetimepicker({
        formatViewType:"time",
        format: "hh:ii",
        weekStart: 1,
        startDate: "today",
        autoclose: true,
        minuteStep: 15,
        startView: 1,
        todayHighlight: true,
        viewSelect: "day"
    });
    
    $('#edit-episode-end-time').datetimepicker({
        formatViewType:"time",
        format: "hh:ii",
        weekStart: 1,
        endDate: "+1y",
        autoclose: true,
        minuteStep: 15,
        startView: 1,
        todayHighlight: true,
        viewSelect: "day"
    });
    
    if(document.getElementById("single").checked){
        $(".form-control end").prop("disabled");
    };
    
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
    
    /*$(document).ready(function(){
    alert(window.location.pathname);
    $("#menu ul li a").each(function(){
        if($(this).attr("href") === window.location.pathname)
            $(this).addClass("active");
        });
    });
    
    $(function(){

    var url = window.location.pathname, 
        urlRegExp = new RegExp(url.replace(/\/$/,'') + "$"); // create regexp to match current url pathname and remove trailing slash if present as it could collide with the link in navigation in case trailing slash wasn't present there
        // now grab every link from the navigation
        $('#menu a').each(function(){
            // and test its normalized href against the url pathname regexp
            if(urlRegExp.test(this.href.replace(/\/$/,''))){
                $(this).addClass('active');
            }
        });

    });*/

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
    * STATISTICS TABLE
    **************************************
    *************************************/
    
    var startmoment = moment().subtract('days', 29);
    var startend = moment();
    
    var initialstart = startmoment.format('YYYY-MM-DD');
    var initialend = startend.format('YYYY-MM-DD');
    
    $.ajax({
        type: "POST",
        url: base_url+"/index.php/team/get_statistics", 
        data: 
            { 
                team_id : filter_id,
                startrange : initialstart,
                endrange : initialend
            },
        dataType: "json",  
        cache: false,
        success: 
            function(data) 
            {
                $.each(data, function(index, data) 
                {
                    $("#statistics_table > tbody").append('<tr><td>' + data.username + '</td><td>' + data.count + '</td></tr>');
                    //remember to empty this if updated
                });            
            }
    });
                
    var cb = function(start, end) 
    {
        $('#daterange .text').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        var startrange = start.format('YYYY-MM-DD');
        var endrange = end.format('YYYY-MM-DD');
                    
        $.ajax({
            type: "POST",
            url: base_url+"/index.php/team/get_statistics", 
            data: 
                { 
                    team_id : filter_id,
                    startrange: startrange,
                    endrange: endrange
                },
            dataType: "json",  
            cache: false,
            success: 
                function(data) 
                {
                    if (data === null) 
                    {
                        $("#statistics_table > tbody").empty();
                    }
                    else
                    {
                        $("#statistics_table > tbody").empty();
                        $.each(data, function(index, data) 
                        {
                            $("#statistics_table > tbody").append('<tr><td>' + data.username + '</td><td>' + data.count + '</td></tr>');
                        });
                    }
                }
        });
    };

    var optionSet1 = 
    {
        startDate: moment().subtract('days', 29),
        endDate: moment(),
        minDate: moment().subtract('year', 1),
        maxDate: moment(),
        showDropdowns: true,
        showWeekNumbers: true,
        ranges: 
        {
           'Last 7 Days': [moment().subtract('days', 6), moment()],
           'Last 30 Days': [moment().subtract('days', 29), moment()],
           'Last Year': [moment().subtract('year', 1), moment()]
        },
        opens: 'left',
        buttonClasses: ['btn btn-default'],
        applyClass: 'btn-small btn-primary',
        cancelClass: 'btn-small',
        format: 'DD/MM/YYYY',
        separator: ' to ',
        locale: 
        {
            applyLabel: 'Submit',
            cancelLabel: 'Clear',
            fromLabel: 'From',
            toLabel: 'To',
            customRangeLabel: 'Custom Range',
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            firstDay: 1
        }
    };

    $('#daterange').daterangepicker(optionSet1, cb);
                  
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