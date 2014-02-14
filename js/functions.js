globals = {};

$(document).ready(function(){    
    
    var filter_id = $('#filter_id').val();
    var base_url = 'http://localhost/master';
    
    /*************************************
    **************************************
    * CALENDAR
    **************************************
    *************************************/
    
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
            
            globals['textDate'] = $.fullCalendar.formatDate(calEvent.start, 'dddd, MMMM dS, yyyy');
            globals['textTitle'] = calEvent.title;
            globals['textId'] = calEvent.id;
            
            $.ajax({
                type: "POST",
                url: base_url+"/index.php/team/get_attendance", 
                data: { episode_id : calEvent.id },
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
            
            $('#location').append(calEvent.location);
            $('#time').append(startTime + " - " + endTime);
            $('#description').append(calEvent.description);
            $('#event-details').append("\
                <input id='title' class='noshow' type='hidden' name='title' value='" + calEvent.title + "' readonly>\n\
                <input id='date' class='noshow' type='hidden' name='date' value='" + stDate + "' readonly>\n\
                <input id='start-time' class='noshow' type='hidden' name='start-time' value='" + startTime + "' readonly>\n\
                <input id='end-time' class='noshow' type='hidden' name='end-time' value='" + endTime + "' readonly>\n\
                <input id='episode-id' class='noshow' type='hidden' name='episode-id' value='" + calEvent.id + "' readonly>\n\
            ");    
            $('#event-info').show();
            
            
            
        }
        
    });
    
    /*************************************
    **************************************
    * BLABLA
    **************************************
    *************************************/
     
    $('input[name="frequency"]').change(function()
    {
         if($(this).val() === "single")
         {
            $("#end_date").attr("disabled","disabled");
            $("#end_date").attr("placeholder","");
            $("#end-date .input-group-addon").css("cursor", "not-allowed");
            $("#end-date .input-group-addon i").css("cursor", "not-allowed");
         }
         else
         {
            $("#end_date").removeAttr("disabled");
         }   
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
        startView: 1,
        todayHighlight: true,
        viewSelect: "day",
        pickerPosition: "bottom-left"
        
    });
    
    $('#end-time').datetimepicker({
        formatViewType:"time",
        format: "hh:ii",
        weekStart: 1,
        endDate: "+1y",
        autoclose: true,
        startView: 1,
        todayHighlight: true,
        viewSelect: "day",
        pickerPosition: "bottom-left"
    });
    
    $('.edit-start-time').each(function(){
        $(this).datetimepicker({
            formatViewType:"time",
            format: "hh:ii",
            weekStart: 1,
            startDate: "today",
            autoclose: true,
            startView: 1,
            todayHighlight: true,
            viewSelect: "day",
            pickerPosition: "bottom-left"
        });
    });
    
    $('.edit-end-time').each(function(){
        $(this).datetimepicker({
            formatViewType:"time",
            format: "hh:ii",
            weekStart: 1,
            endDate: "+1y",
            autoclose: true,
            startView: 1,
            todayHighlight: true,
            viewSelect: "day",
            pickerPosition: "bottom-left"
        });
    });
    
    $('#edit-episode-start-time').datetimepicker({
        formatViewType:"time",
        format: "hh:ii",
        weekStart: 1,
        startDate: "today",
        autoclose: true,
        startView: 1,
        todayHighlight: true,
        viewSelect: "day",
        pickerPosition: "bottom-left"
    });
    
    $('#edit-episode-end-time').datetimepicker({
        formatViewType:"time",
        format: "hh:ii",
        weekStart: 1,
        endDate: "+1y",
        autoclose: true,
        startView: 1,
        todayHighlight: true,
        viewSelect: "day",
        pickerPosition: "bottom-left"
    });
    
    /*************************************
    **************************************
    * MODALS
    **************************************
    *************************************/
    
    $('#create_team').click(function() {
        $('#create_team_modal').modal('show');
    });
    
    $('#home_create_team').click(function() {
        $('#create_team_modal').modal();
    });
    
    $('#create_team_modal').on('hidden.bs.modal', function () {
        $('#error_createteam').removeClass('has-error');
        $('#errorinline_createteam').text('');
        $('#error2_createteam').removeClass('has-error');
        $('#error2inline_createteam').text('');
    })
    
    $('#join_team').click(function() {
        $('#join_team_modal').modal();
    });
    
    $('#home_join_team').click(function() {
        $('#join_team_modal').modal();
    });
    
    $('#leave_team').click(function() {
        $('#leave_team_modal').modal();
    });
        
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
           'Last 7 Days': [moment().subtract('days', 7), moment()],
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
    * AJAX FUNCTIONS
    **************************************
    *************************************/
   
    $('#attend_yes, #attend_no').click(function()
    {
        var attendance_choice   = $("[name='attendance_choice']:checked").val();
        var episode_id          = $("#episode-id").val();
        
        $.ajax({  
            type: "POST",
            dataType: "json",
            url: base_url+"/index.php/team/set_attendance",  
            data: { 
                attendance_choice:attendance_choice,
                episode_id:episode_id
                },
            success:                   
                function(data)
            {       
                    if(data.count > 0)
                    {   
                        $("#attendance_tables").empty();
                        $.ajax({
                            type: "POST",
                            dataType: "html",
                            data: { episode_id:episode_id },
                            url: base_url+"/index.php/team/get_attendance",
                            success: function(result)
                            {
                              $("#attendance_tables").append(result);
                            }
                        });
                    }
            }
        });
    });
    
    var checkboxes = $("input[id='checktest']"),
    addplayer = $("#addplayersubmit");

    checkboxes.click(function() {
        addplayer.attr("disabled", !checkboxes.is(":checked"));
    });
    
    $('#addplayersubmit').click(function()
    {
        var players = new Array();
        $("input[name='players[]']:checked").each(function() {
                players.push($(this).val());
                });
        console.log(players);
        
        $.ajax({
            type: "POST",
            dataType: "json",
            url: base_url+"/index.php/team/add_player/"+filter_id,
            data: 
            { 
                players:players 
            },
            success:
                function(data)
            {
                
                if(data.count > 0)
                {   
                    window.location = "?addplayersuccess";
                    return true;
                }
            }
        });
    });
    
    var squadcheckboxes = $("input[id='squadchecktest']"),
    removeplayer = $("#removeplayersubmit");

    squadcheckboxes.click(function() {
        removeplayer.attr("disabled", !squadcheckboxes.is(":checked"));
    });
    
    $('#removeplayersubmit').click(function()
    {
        var squad = new Array();
        $("input[name='squad[]']:checked").each(function() {
                squad.push($(this).val());
                });
        console.log(squad);
        
        $.ajax({
            type: "POST",
            dataType: "json",
            url: base_url+"/index.php/team/remove_player/"+filter_id,
            data: 
            { 
                squad:squad 
            },
            success:
                function(data)
            {
                
                if(data.count > 0)
                {   
                    window.location = "?removeplayersuccess";
                    return true;
                }
            }
        });
    });
    
    $('#createteamsubmit').click(function()
    {
        var create_teamname    = $("#create_teamname").val();
        var create_sport       = $("#create_sport").val();
        
        $.ajax({  
            type: "POST",
            dataType: "json",
            url: base_url+"/index.php/team/create_team",  
            data: { 
                create_teamname:create_teamname,
                create_sport:create_sport
                },
            success:                   
                function(data)
            {       
                    if(data.count > 0)
                    {   
                        $('#create_team_modal').modal('hide');
                        window.location = base_url+"/?createteamsuccess";
                    return true;
                    }
                    
                    if (data.createteamnameError)
                    {
                        $('#error_createteam').addClass('has-error');
                        $('#errorinline_createteam').text(data.createteamnameError);
                    }
                    else
                    {
                        $('#error_createteam').removeClass('has-error');
                        $('#errorinline_createteam').text('');
                    }

                    if (data.createsportError)
                    {
                        $('#error2_createteam').addClass('has-error');
                        $('#error2inline_createteam').text(data.createsportError);
                    }
                    else
                    {   
                        $('#error2_createteam').removeClass('has-error');
                        $('#error2inline_createteam').text('');
                    }
            }
        });
    });
    
    var joincheckboxes = $("input[id='teamids']"),
    jointeam = $("#jointeamsubmit");

    joincheckboxes.click(function() {
        jointeam.attr("disabled", !joincheckboxes.is(":checked"));
    });    
    
    $('#jointeamsubmit').click(function()
    {
        var teams = new Array();
        $("input[name='team[]']:checked").each(function() {
                teams.push($(this).val());
                });
        console.log(teams);
        
        $.ajax({
            type: "POST",
            dataType: "json",
            url: base_url+"/index.php/team/join_team",
            data: { teams:teams },
            success:
                function(data)
            {
                
                if(data.count > 0)
                {   
                    console.log(data.count);
                    $('#join_team_modal').modal('hide');
                    window.location = base_url+"/?jointeamsuccess";
                    return true;
                }
            }
        });
    });
    
    $('#leaveteamsubmit').click(function()
    {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: base_url+"/index.php/team/leave_team/"+filter_id,
            success:
                function(data)
            {
                
                if(data.count > 0)
                {   
                    $('#leave_team_modal').modal('hide');
                    window.location = base_url+"/?leaveteamsuccess";
                    return true;
                }
            }
        });
    });
    
    $('#teaminfosubmit').click(function()
    {
        var teamname    = $("#teamname").val();
        var sport       = $("#sport").val();
        
        $.ajax({  
            type: "POST",
            dataType: "json",
            url: base_url+"/index.php/team/update_team/"+filter_id,  
            data: { 
                teamname:teamname,
                sport:sport
                },
            success:                   
                function(data)
            {       
                    if(data.count > 0)
                    {   
                        window.location = "?updateteaminfosuccess";
                        return true;
                    }
                    
                    if (data.teamnameError)
                    {
                        $('#error_teaminfo').addClass('has-error');
                        $('#errorinline_teaminfo').text(data.teamnameError);
                    }
                    else
                    {
                        $('#error_teaminfo').removeClass('has-error');
                        $('#errorinline_teaminfo').text('');
                    }

                    if (data.sportError)
                    {
                        $('#error2_teaminfo').addClass('has-error');
                        $('#error2inline_teaminfo').text(data.sportError);
                    }
                    else
                    {
                        $('#error2_teaminfo').removeClass('has-error');
                        $('#error2inline_teaminfo').text('');
                    }
            }
        });
    });
    
    $('#deleteteamsubmit').click(function()
    {
        var deletion  = $("#delete").val();
        var match   = $("#match").val();
        
        $.ajax({  
            type: "POST",
            dataType: "json",
            url: base_url+"/index.php/team/delete_team/"+filter_id,  
            data: { 
                deletion:deletion,
                match:match
                },
            success:                   
                function(data)
            {     
                if (data.count > 0)
                {
                    window.location = base_url+"/?deleteteamsuccess";
                    return true;
                }
                
                 if (data.matchError)
                    {
                        $('#error_deleteteam').addClass('has-error');
                        $('#errorinline_deleteteam').text(data.matchError);
                    }
                    
                    else if (data.deleteError)
                    {
                        $('#error_deleteteam').addClass('has-error');
                        $('#errorinline_deleteteam').text(data.deleteError);
                    }
                    else
                    {
                        $('#error_deleteteam').removeClass('has-error');
                        $('#errorinline_deleteteam').text('');
                    }

                   
            }
        });
    });
    
    
    $('#event-info').on("click", "#edit_episode_button", function() {
        
        var description = $("#event-details").find("#description").text();
        var location = $("#event-details").find("#location").text();
        var title = $('#title').val();
        var date = $('#date').val();
        var startTime = $('#start-time').val();
        var endTime = $('#end-time').val();
        var episodeId = $('#episode-id').val();
        
        $('#edit_episode_modal').modal();
        $("#edited_episodeName").val(title);
        $("#edited_episodeDate").val(date);
        $("#edited_episodeDesc").val(description);
        $("#edited_episodeStartTime").val(startTime);
        $("#edited_episodeEndTime").val(endTime);
        $("#edited_episodeLocation").val(location);
        $("#edited_episodeId").val(episodeId);
    });
    
    //Write a function that submits edit_episode with the input data
    $('#editepisodesubmit').click(function()
    {   
        var edited_episodeName = $("#edited_episodeName").val();
        var edited_episodeDate = $("#edited_episodeDate").val();
        var edited_episodeDesc = $("#edited_episodeDesc").val();
        var edited_episodeStartTime = $("#edited_episodeStartTime").val();
        var edited_episodeEndTime = $("#edited_episodeEndTime").val();
        var edited_episodeLocation = $("#edited_episodeLocation").val();
        var episodeId = $("#edited_episodeId").val();
    
        $.ajax({  
            type: "POST",
            dataType: "json",
            url: base_url+"/index.php/team/edit_episode/"+episodeId,  
            data: { 
                edited_episodeName:edited_episodeName,
                edited_episodeDesc:edited_episodeDesc,
                edited_episodeDate:edited_episodeDate,
                edited_episodeStartTime:edited_episodeStartTime,
                edited_episodeEndTime:edited_episodeEndTime,
                edited_episodeLocation:edited_episodeLocation
                
                 },
            success:                   
                function(data)
            {       
                    if(data.count > 0)
                    {   
                        $('#edit_episode_modal').modal('hide');
                        window.location = "?editepisodesuccess";
                        return true;
                    }
                    
                    if (data.episodeNameError)
                    {
                        $('#error_editEp').addClass('has-error');
                        $('#errorinline_editEp').text(data.episodeNameError);
                    }
                    else
                    {
                        $('#error_editEp').removeClass('has-error');
                        $('#errorinline_editEp').text('');
                    }

                    if (data.episodeDescError)
                    {
                        $('#error2_editEp').addClass('has-error');
                        $('#error2inline_editEp').text(data.episodeDescError);
                    }
                    else
                    {
                        $('#error2_editEp').removeClass('has-error');
                        $('#error2inline_editEp').text('');
                    }
                    
                    if (data.episodeDateError)
                    {
                        $('#error3_editEp').addClass('has-error');
                        $('#error3inline_editEp').text(data.episodeDateError);
                    }
                    else
                    {
                        $('#error3_editEp').removeClass('has-error');
                        $('#error3inline_editEp').text('');
                    }
                    
                    if (data.episodeStartTimeError)
                    {
                        $('#error4_editEp').addClass('has-error');
                        $('#error4inline_editEp').text(data.episodeStartTimeError);
                    }
                    else
                    {
                        $('#error4_editEp').removeClass('has-error');
                        $('#error4inline_editEp').text('');
                    }
                    if (data.episodeEndTimeError)
                    {
                        $('#error5_editEp').addClass('has-error');
                        $('#error5inline_editEp').text(data.episodeEndTimeError);
                    }
                    else
                    {
                        $('#error5_editEp').removeClass('has-error');
                        $('#error5inline_editEp').text('');
                    }
                    if (data.episodeLocationError)
                    {
                        $('#error6_editEp').addClass('has-error');
                        $('#error6inline_editEp').text(data.episodeLocationError);
                    }
                    else
                    {
                        $('#error6_editEp').removeClass('has-error');
                        $('#error6inline_editEp').text('');
                    }
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
    
    $('#addeventsubmit').click(function()
    {
        var eventname       = $("#event_name").val();
        var eventdesc       = $("#event_desc").val();
        var frequency       = $("[name='frequency']:checked").val();
        var start_date      = $("#start_date").val();
        var end_date        = $("#end_date").val();
        var start_time      = $("#start_time").val();
        var end_time        = $("#end_time").val();
        var eventlocation   = $("#eventlocation").val();
        
        $.ajax({
            type: "POST",
            dataType: "json",
            url: base_url+"/index.php/team/add_event/"+filter_id,
            data: 
            {
                eventname: eventname,
                eventdesc: eventdesc,
                frequency: frequency,
                start_date: start_date,
                end_date: end_date,
                start_time: start_time,
                end_time: end_time,
                eventlocation: eventlocation 
            },
            success:
                    function(data)
            {       
                    if(data.count > 0)
                    {   
                        $('#add_event_modal').modal('hide');
                        window.location = "?addeventsuccess";
                        return true;
                    }
                    
                    if (data.nameerror)
                    {
                        $('#error').addClass('has-error');
                        $('#errorinline').text(data.nameerror);
                    }
                    else
                    {
                        $('#error').removeClass('has-error');
                        $('#errorinline').text('');
                    }

                    if (data.descerror)
                    {
                        $('#error2').addClass('has-error');
                        $('#error2inline').text(data.descerror);
                    }
                    else
                    {
                        $('#error2').removeClass('has-error');
                        $('#error2inline').text('');
                    }
                    
                    if (data.stdateerror)
                    {
                        $('#error4').addClass('has-error');
                        $('#error4inline').text(data.stdateerror);
                    }
                    else
                    {
                        $('#error4').removeClass('has-error');
                        $('#error4inline').text('');
                    }
                    if (data.enddateerror)
                    {
                        $('#error5').addClass('has-error');
                        $('#error5inline').text(data.enddateerror);
                    }
                    else
                    {
                        $('#error5').removeClass('has-error');
                        $('#error5inline').text('');
                    }
                    if (data.sttimeerror)
                    {
                        $('#error6').addClass('has-error');
                        $('#error6inline').text(data.sttimeerror);
                    }
                    else
                    {
                        $('#error6').removeClass('has-error');
                        $('#error6inline').text('');
                    }
                    if (data.endtimeerror)
                    {
                        $('#error7').addClass('has-error');
                        $('#error7inline').text(data.endtimeerror);
                    }
                    else
                    {
                        $('#error7').removeClass('has-error');
                        $('#error7inline').text('');
                    }
                    if (data.locerror)
                    {
                        $('#error8').addClass('has-error');
                        $('#error8inline').text(data.locerror);
                    }
                    else
                    {
                        $('#error8').removeClass('has-error');
                        $('#error8inline').text('');
                    }
            }
            
        });
    });
    
    $(".editeventsubmit").click(function()
    {
        var button            = $(this).closest(".panel-body").find(".editeventsubmit");   
        var edited_eventname  = $(this).closest(".panel-body").find("#edited_eventname").val();
        var edited_eventdesc  = $(this).closest(".panel-body").find("#edited_eventdesc").val();
        var edited_start_time = $(this).closest(".panel-body").find("#edited_start_time").val();
        var edited_end_time   = $(this).closest(".panel-body").find("#edited_end_time").val();
        var edited_location   = $(this).closest(".panel-body").find("#edited_location").val();
        var event_id          = $(this).closest(".panel-body").find(".event_id").val();
        
        $.ajax({
            type: "POST",
            dataType: "json",
            url: base_url+"/index.php/team/edit_event/"+event_id,
            data: 
            {
                edited_eventname: edited_eventname,
                edited_eventdesc: edited_eventdesc,
                edited_start_time: edited_start_time,
                edited_end_time: edited_end_time,
                edited_location: edited_location 
            },
            success:
                    function(data)
            {       
                    console.log(data.count);
                    if(data.count > 0)
                    {   
                        $(button).closest(".panel-body").find(".form-group").removeClass("has-error");
                        $(button).closest(".panel-body").find(".help-inline").text("");
                        $(button).closest(".panel-default").css("border-color", "green");
                        button.removeClass("btn btn-info");
                        button.addClass("btn btn-success");
                        button.text("");
                        button.append('<p class="nomargin"><span class="glyphicon glyphicon-ok"></span>Saved!</p>');
                        
                        setTimeout(function () 
                        {
                            $(button).closest(".panel-default").css("border-color", "#ddd");
                            button.removeClass("btn btn-success");
                            button.text("");
                            button.addClass("btn btn-info");
                            button.text("Save changes");
                        }, 2500);
                    }
                    
                    if (data.edit_nameerror)
                    {
                        $(button).closest(".panel-body").find('#error_edit').addClass('has-error');
                        $(button).closest(".panel-body").find('#errorinline_edit').text(data.edit_nameerror);
                    }
                    else
                    {
                        $(button).closest(".panel-body").find('#error_edit').removeClass('has-error');
                        $(button).closest(".panel-body").find('#errorinline_edit').text('');
                    }

                    if (data.edit_descerror)
                    {
                        $(button).closest(".panel-body").find('#error2_edit').addClass('has-error');
                        $(button).closest(".panel-body").find('#error2inline_edit').text(data.edit_descerror);
                    }
                    else
                    {
                        $(button).closest(".panel-body").find('#error2_edit').removeClass('has-error');
                        $(button).closest(".panel-body").find('#error2inline_edit').text('');
                    }
                    
                    if (data.edit_stTimeError)
                    {
                        $(button).closest(".panel-body").find('#error3_edit').addClass('has-error');
                        $(button).closest(".panel-body").find('#error3inline_edit').text(data.edit_stTimeError);
                    }
                    else
                    {
                        $(button).closest(".panel-body").find('#error3_edit').removeClass('has-error');
                        $(button).closest(".panel-body").find('#error3inline_edit').text('');
                    }
                    
                    if (data.edit_endTimeError)
                    {
                        $(button).closest(".panel-body").find('#error4_edit').addClass('has-error');
                        $(button).closest(".panel-body").find('#error4inline_edit').text(data.edit_endTimeError);
                    }
                    else
                    {
                        $(button).closest(".panel-body").find('#error4_edit').removeClass('has-error');
                        $(button).closest(".panel-body").find('#error4inline_edit').text('');
                    }
                    
                    if (data.edit_locerror)
                    {
                        $(button).closest(".panel-body").find('#error5_edit').addClass('has-error');
                        $(button).closest(".panel-body").find('#error5inline_edit').text(data.edit_locerror);
                    }
                    else
                    {
                        $(button).closest(".panel-body").find('#error5_edit').removeClass('has-error');
                        $(button).closest(".panel-body").find('#error5inline_edit').text('');
                    }
            }
            });
    });
    
    var eventcheckboxes = $("input[id='ids']"),
    deleteevent = $("#deleteeventsubmit");

    eventcheckboxes.click(function() {
        deleteevent.attr("disabled", !eventcheckboxes.is(":checked"));
    });    
    
    $('#deleteeventsubmit').click(function()
    {
        var events = new Array();
        $("input[name='events[]']:checked").each(function() {
                events.push($(this).val());
                });
        console.log(events);
        
        $.ajax({
            type: "POST",
            dataType: "json",
            url: base_url+"/index.php/team/delete_event",
            data: { events:events },
            success:
                function(data)
            {
                
                if(data.count > 0)
                {   
                    console.log(data.count);
                    $('#delete_event_modal').modal('hide');
                    window.location = "?deleteeventsuccess";
                    return true;
                }
            }
        });
    });
    
    $('#deleteepisodesubmit').click(function()
    {
        var id = globals.textId;
        console.log(id);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: base_url+"/index.php/team/delete_episode",
            data: { delete_episodeId:id },
            success:
                function(data)
            {
                if(data.count > 0)
                {   
                    $('#delete_episode_modal').modal('hide');
                    window.location = "?deleteepisodesuccess";
                    return true;
                }
            }
        });
    });
    
    $('#profileinfosubmit').click(function()
    {
        var edit_username   = $("#edit_name").val();
        var edit_email      = $("#edit_email").val();
        
        $.ajax({  
            type: "POST",
            dataType: "json",
            url: base_url+"/index.php/profile/update_profile",  
            data: { 
                edit_username:edit_username,
                edit_email:edit_email
                },
            success:                   
                function(data)
            {       
                    if(data.count > 0)
                    {   
                        window.location = "?updateprofilesuccess";
                        return true;
                    }
                    
                    if (data.editUsernameError)
                    {
                        $('#error_updateprofile').addClass('has-error');
                        $('#errorinline_updateprofile').text(data.editUsernameError);
                    }
                    else
                    {
                        $('#error_updateprofile').removeClass('has-error');
                        $('#errorinline_updateprofile').text('');
                    }

                    if (data.editEmailError)
                    {
                        $('#error2_updateprofile').addClass('has-error');
                        $('#error2inline_updateprofile').text(data.editEmailError);
                    }
                    else
                    {
                        $('#error2_updateprofile').removeClass('has-error');
                        $('#error2inline_updateprofile').text('');
                    }
            }
        });
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
       
    
        $('#team_table').dataTable();           
       
        
        
    
        /**
	 *
	 * Gir brukeren beskjed om at ulike operasjoner var vellykket
	 * 
	 */
        var hash = window.location.search.substring(1);
        if ( hash === "addeventsuccess")
        {
            $("#success").append('<p><span class="glyphicon glyphicon-ok"></span>Events were added to calendar. </p>');
            $("#success").show().delay(3000).fadeOut(1000);
            window.history.replaceState("gammel", "ny", window.location.pathname);
        }
        else if (hash === 'deleteeventsuccess')
        {
            $("#success").append('<p><span class="glyphicon glyphicon-ok"></span>Events were deleted. </p>');
            $("#success").show().delay(3000).fadeOut(1000);
            window.history.replaceState("gammel", "ny", window.location.pathname);
        }
        else if (hash === 'deleteepisodesuccess')
        {
            $("#success").append('<p><span class="glyphicon glyphicon-ok"></span>Event was deleted. </p>');
            $("#success").show().delay(3000).fadeOut(1000);
            window.history.replaceState("gammel", "ny", window.location.pathname);
        }
        else if (hash === 'editepisodesuccess')
        {
            $("#success").append('<p><span class="glyphicon glyphicon-ok"></span>Event changes were saved. </p>');
            $("#success").show().delay(3000).fadeOut(1000);
            window.history.replaceState("gammel", "ny", window.location.pathname);
        } 
       else if (hash === 'addplayersuccess')
        {
            $("#success").append('<p><span class="glyphicon glyphicon-ok"></span>Players were added to squad. </p>');
            $("#success").show().delay(3000).fadeOut(1000);
            window.history.replaceState("gammel", "ny", window.location.pathname);
            var hash = '#manage_squad';
            $('.nav a[href="' + hash + '"]').tab('show');
        }
        else if (hash === 'removeplayersuccess')
        {
            $("#success").append('<p><span class="glyphicon glyphicon-ok"></span>Players were removed from squad. </p>');
            $("#success").show().delay(3000).fadeOut(1000);
            window.history.replaceState("gammel", "ny", window.location.pathname);
            var hash = '#manage_squad';
            $('.nav a[href="' + hash + '"]').tab('show');
        }
        else if (hash === 'updateteaminfosuccess')
        {
            $("#success").append('<p><span class="glyphicon glyphicon-ok"></span>Team information was updated. </p>');
            $("#success").show().delay(3000).fadeOut(1000);
            window.history.replaceState("gammel", "ny", window.location.pathname);
            var hash = '#edit';
            $('.nav a[href="' + hash + '"]').tab('show');
        }

        else if (hash === 'deleteteamsuccess')
        {
            $("#home_success").append('<p><span class="glyphicon glyphicon-ok"></span>Team was deleted. </p>');
            $("#home_success").show().delay(3000).fadeOut(1000);
            window.history.replaceState("gammel", "ny", window.location.pathname);
        }

        else if (hash === 'createteamsuccess')
        {
            $("#home_success").append('<p><span class="glyphicon glyphicon-ok"></span>Team was created. </p>');
            $("#home_success").show().delay(3000).fadeOut(1000);
            window.history.replaceState("gammel", "ny", window.location.pathname);
        }

        else if (hash === 'jointeamsuccess')
        {
            $("#home_success").append('<p><span class="glyphicon glyphicon-ok"></span>Team was joined. </p>');
            $("#home_success").show().delay(3000).fadeOut(1000);
            window.history.replaceState("gammel", "ny", window.location.pathname);
        }
        else if (hash === 'leaveteamsuccess')
        {
            $("#home_success").append('<p><span class="glyphicon glyphicon-ok"></span>You left team. </p>');
            $("#home_success").show().delay(3000).fadeOut(1000);
            window.history.replaceState("gammel", "ny", window.location.pathname);
        }
        else if (hash === 'updateprofilesuccess')
        {
            $("#profile_success").append('<p><span class="glyphicon glyphicon-ok"></span>Profile was updated. </p>');
            $("#profile_success").show().delay(3000).fadeOut(1000);
            window.history.replaceState("gammel", "ny", window.location.pathname);
        }
       
    
    });