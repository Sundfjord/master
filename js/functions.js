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
    
    /*************************************
    **************************************
    * CALENDAR
    **************************************
    *************************************/
    
    $('#calendar').fullCalendar({
        firstDay:'1',
        defaultView: 'basicWeek',
        height: 500,
        editable: true,
        header: 
        {
            left: '',
            center: '',
            right: 'prev,next, basicWeek,basicDay'
        },
        columnFormat: 'ddd d/M',
        allDayDefault: false,
        events: 'http://localhost/master/index.php/team/json'
                
        });
    
    /*************************************
    **************************************
    * BLABLA
    **************************************
    *************************************/
   
    if(document.getElementById("single").checked){
        $(".disabled form-control").prop("disabled");
    };
    
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
    
    $('#team_tabs a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
        });

        // store the currently selected tab in the hash value
        $("ul.nav-tabs > li > a").on("shown.bs.tab", function (e) {
            var id = $(e.target).attr("href").substr(1);
            window.location.hash = id;
        });

        // on load of the page: switch to the currently selected tab
        var hash = window.location.hash;
        $('#team_tabs a[href="' + hash + '"]').tab('show');
    
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
           
           
        $('#team_tabs a').click(function (e) {
            e.preventDefault()
            $(this).tab('show')
        });

        // store the currently selected tab in the hash value
        $("ul.nav-tabs > li > a").on("shown.bs.tab", function (e) {
            var id = $(e.target).attr("href").substr(1);
            window.location.hash = id;
        });

        // on load of the page: switch to the currently selected tab
        var hash = window.location.hash;
        $('#team_tabs a[href="' + hash + '"]').tab('show');
    
        $('#team_table').dataTable();           
        });