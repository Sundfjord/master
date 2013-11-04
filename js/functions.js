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

    $('#search_player').live('keypress', function(e){
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
	});

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

    $('#search_team').live('keypress', function(e){
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
	});

	// Legger til tekst i modal dersom knappen er blå, og man trykker på den
	$('#legg_til_ord').click(function(){
		if ($('#legg_til_ord').hasClass('btn-primary'))
	    {
	    	$('#ord').val($("#sok").val());
	    	$('#grad').focus();
	    }
	});
});