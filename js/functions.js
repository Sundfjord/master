/*!
 * rockEnroll v1.0
 * (c) 2014 Yngve Sundfjord
 */

globals = {};

$(document).ready(function(){

    var filter_id = $('#filter_id').val();
    var user_id = $('#user').val();
    var base_url = 'http://localhost/rockEnroll';

    /*************************************
    **************************************
    * CALENDAR
    **************************************
    *************************************/

    $('#calendar').fullCalendar({
        firstDay:'1',
        defaultView: 'basicWeek',
        height: 200,
        eventColor: "#336799",
        timeFormat: 'H(:mm)',
        allDayDefault: false,
        header:
        {
            left: 'prev,next',
            center: '',
            right:  'month,basicWeek,basicDay'
        },
        columnFormat: 'ddd d/M',
        events: function(start, end, callback)
        {
            $.getJSON(base_url+'/index.php/team/json', function(data)
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
                    function(result)
                    {
                        if($('#event-info').css("display") === 'block')
                        {
                            $("#event-info").css("display", "none");
                            $("#coach-only").empty();
                            $("#date").empty();
                            $("#location").empty();
                            $("#time").empty();
                            $("#description").empty();
                            $("#attendance_tables").empty();
                            $("#invisible").empty();
                            $(".hidden_id").empty();
                            $("#notallowed").remove();
                            $("#choice").show();
                            $('.attendance .panel-body').removeAttr("style");
                        }

                        $('#attendance_tables').append(result);
                        $('.hidden_id').prepend("<input id='episode-id' class='noshow' type='hidden' name='ep-id' value='" + calEvent.id + "' readonly>");
                        $('#coach-only').prepend("\
                            <div class='editbuttons row'><div class='col-sm-6'><button id='delete_episode_button'class='btn btn-danger btn-block' type='button'><span class='glyphicon glyphicon-trash'></span>Delete this event</button></div>\n\
                            <div class='col-sm-6'><button id='edit_episode_button' class='btn btn-default btn-block' type='button'><span class='glyphicon glyphicon-edit'></span>Edit event details</button></div></div>\n\
                            ");
                        var varDate = $.fullCalendar.formatDate(calEvent.start, 'yyyy-MM-dd');
                        var outputDate = $.fullCalendar.formatDate(calEvent.start, 'dd.MM.yyyy');
                        var comparison = varDate + " " + startTime;
                        var haveToPass = moment(comparison);
                        var bar = moment().subtract("hours", 24);

                        $('#date').append(outputDate);
                        $('#location').append(calEvent.location);
                        $('#time').append(startTime + " - " + endTime);
                        if (calEvent.description !== '')
                        {
                            $('#description').append(calEvent.description);
                        }
                        else {
                            $('#description').append('No description');
                        }

                        $('#attend_yes, #attend_no').iCheck('uncheck');

                        $('#invisible').append("\
                            <input id='title' class='noshow' type='hidden' name='title' value='" + calEvent.title + "' readonly>\n\
                            <input id='date' class='noshow' type='hidden' name='date' value='" + stDate + "' readonly>\n\
                            <input id='start-time' class='noshow' type='hidden' name='start-time' value='" + startTime + "' readonly>\n\
                            <input id='end-time' class='noshow' type='hidden' name='end-time' value='" + endTime + "' readonly>\n\
                            <input id='episode-id' class='noshow' type='hidden' name='episode-id' value='" + calEvent.id + "' readonly>\n\
                        ");
                        $('#event-info').fadeIn(500);

                        if (bar > haveToPass)
                        {
                            $('#delete_episode_button').attr('disabled', 'disabled');
                            $('#edit_episode_button').attr('disabled', 'disabled');
                            $("#choice").hide();
                            $('.attendance .panel-body').append("<div id='notallowed' class='bg-danger'><center><p><span class='glyphicon glyphicon-exclamation-sign'></span>Registration for this event has expired.</p></center></div>");
                            $('.attendance .panel-body').css("border", "1px solid #ecb1b4");
                        }
                        else
                        {
                            $('#delete_episode_button').attr('disabled', false);
                            $('#edit-episode-button').attr('disabled', false);
                        }
                    }
            });
        }
    });

    /*************************************
    **************************************
    * SNIPPETS
    **************************************
    *************************************/

    $('#event_table').on(' change','input[name="check_all"]',function() {
            $('.allboxes').prop('checked', $(this).prop('checked'));
    });

    $('#squad_table').on(' change','input[name="check_all_squad"]',function() {
            $('.allboxes_squad').prop('checked', $(this).prop('checked'));
    });

    $('#staff_table').on(' change','input[name="check_all_staff"]',function() {
            $('.allboxes_staff').prop("checked" , this.checked);
    });

    $("input[name='search']").each(function() {
                $(this).attr("placeholder", "Search...");
                });

    $('.allboxes_staff').each(function (){
        if(user_id === $(this).val())
            {
                $(this).prop("disabled", true);
            }
    });

    $('.nrOfCoaches').each(function () {
        var coachcount = $(this).val();
        if (coachcount === '1')
        {
            var button = ($(this).closest(".list-group-item").find(".disabledcheck"));

            $(function() {
                jQuery.fn.extend({
                    disable: function(state) {
                        return this.each(function() {
                            var $this = $(this);
                            $this.toggleClass('disabled', state);
                        });
                    }
                });

                $(button).disable(true);

                $('body').on('click', 'a.disabled', function(event) {
                    event.preventDefault();
                });
            });
        }
    });

    $('input[name="frequency"]').change(function()
    {
         if($(this).val() === "single")
         {
            $("#end_date").attr("disabled","disabled");
            $("#end_date").attr("placeholder","");
            $("#end-date .input-group-addon").css("cursor", "not-allowed");
            $("#end-date .input-group-addon i").css("cursor", "not-allowed");
            $('#error5').removeClass('has-error');
            $('#error5inline p').text('');
         }
         else
         {
            $("#end_date").removeAttr("disabled");
            $("#end_date").attr("placeholder", "End date");
         }
    });

    /*************************************
    **************************************
    * CHECKBOX AND RADIO BUTTONS
    **************************************
    *************************************/

    $('#green').iCheck({
        radioClass: 'iradio_square-green',
        increaseArea: '30%',
        inheritID: true
    });

    $('#red').iCheck({
        radioClass: 'iradio_square-red',
        increaseArea: '30%',
        inheritID: true
    });

    $("#green, #label_yes").click(function(){
        $('#attend_yes').iCheck('check');
    });

    $("#red, #label_no").click(function(){
        $('#attend_no').iCheck('check');
    });

    /*************************************
    **************************************
    * DATE AND TIME PICKERS
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
        $('#errorinline_createteam p').text('');
        $('#error2_createteam').removeClass('has-error');
        $('#error2inline_createteam p').text('');
    });

    $('#join_team').click(function() {
        $('#join_team_modal').modal();
    });

    $('#join_team_modal').on('hidden.bs.modal', function () {
        $('#join_team_table').removeClass('has-error');
        $('#errorinline_join p').text('');
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
    * TABS
    **************************************
    *************************************/

    $('.nav-tabs a').click(function() {
            preventDefault();
            $('.nav-tabs a').tab('show');
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
    $(this).find("input[name='eventname']").focus();
    });

    $("#edit_episode_modal").on('shown', function() {
    $(this).find("input[name='edited_episodeName']").focus();
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
                    $("#statistics_table > tbody").append('<tr><td>' + data.username + '</td><td>' + data.email + '</td><td class="number">' + data.count + '</td></tr>');
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
                            $("#statistics_table > tbody").append('<tr><td>' + data.username + '</td><td>' + data.email + '</td><td class="number">' + data.count + '</td></tr>').fadeIn(500);
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

    $(document).ajaxStart(function(){
        $("#loading").show();
    });

    $("#attend_yes, #attend_no").on('ifChecked', function()
    {
        var attendance_choice   = $("[name='attendance_choice']:checked").val(); //
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
                            $("#attendance_tables").hide();
                            $("#attendance_tables").append(result);
                            $("#attendance_tables").fadeIn(500);
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

    $(addplayer).click(function()
    {
        var players = new Array();
        $("input[name='players[]']:checked").each(function() {
            players.push($(this).val());
            });

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

    var coachboxes = $("input[id='coachtest']"),
    addcoach = $("#addcoachsubmit");

    coachboxes.click(function() {
        addcoach.attr("disabled", !coachboxes.is(":checked"));
    });

    $(addcoach).click(function()
    {
        var coaches = new Array();
        $("input[name='coaches[]']:checked").each(function() {
            coaches.push($(this).val());
            });

        $.ajax({
            type: "POST",
            dataType: "json",
            url: base_url+"/index.php/team/add_coach/"+filter_id,
            data:
            {
                coaches:coaches
            },
            success:
                function(data)
            {
                if(data.count > 0)
                {
                    window.location = "?addcoachsuccess";
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

    var staffcheckboxes = $("input[id='staffchecktest']"),
    removecoach = $("#removecoachsubmit");

    staffcheckboxes.click(function() {
        removecoach.attr("disabled", !staffcheckboxes.is(":checked"));
    });

    $('#removecoachsubmit').click(function()
    {
        var staff = new Array();
        $("input[name='staff[]']:checked").each(function() {
                staff.push($(this).val());
                });

        $.ajax({
            type: "POST",
            dataType: "json",
            url: base_url+"/index.php/team/remove_coach/"+filter_id,
            data:
            {
                staff:staff
            },
            success:
                function(data)
            {
                if(data.count > 0)
                {
                    window.location = "?removecoachsuccess";
                    return true;
                }
            }
        });
    });

    $('#input_form input').keydown(function(e) {
        if (e.keyCode === 13)
        {
            $('#createteamsubmit').click();
            return false;
        }
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
                        $('#errorinline_createteam p').text(data.createteamnameError);
                    }
                    else
                    {
                        $('#error_createteam').removeClass('has-error');
                        $('#errorinline_createteam p').text('');
                    }

                    if (data.createsportError)
                    {
                        $('#error2_createteam').addClass('has-error');
                        $('#error2inline_createteam p').text(data.createsportError);
                    }
                    else
                    {
                        $('#error2_createteam').removeClass('has-error');
                        $('#error2inline_createteam p').text('');
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

        var request = $.ajax({
            type: "POST",
            dataType: "json",
            url: base_url+"/index.php/team/join_team",
            data: { teams:teams }
            });
            request.done(function(data) {
                if (data.joinError)
                {
                    $('#join_team_modal').modal('hide');
                    window.location = base_url+"/?jointeampartlysuccess";
                    return true;
                }
            });

            request.done(function(data) {
                if(data.count > 0)
                {
                    $('#join_team_modal').modal('hide');
                    window.location = base_url+"/?jointeamsuccess";
                    return true;
                }
            });
    });

    $('#leaveteamsubmit').click(function()
    {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: base_url+"/index.php/team/leave_team/",
            data: {team_id:filter_id},
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

    $('.leaveteam').click(function() {
        var teamid = $(this).closest(".list-group-item").find(".team_id").val();
        $(".modal-body #teamid").val(teamid);
        $('#profile_leave_team_modal').modal();
    });

    $('#profileleaveteamsubmit').click(function()
    {
        var team_id = $("#teamid").val();

        $.ajax({
            type: "POST",
            dataType: "json",
            url: base_url+"/index.php/profile/profile_leave_team",
            data: {team_id:team_id},
            success:
                function(data)
            {
                if(data.count > 0)
                {
                    $('#profile_leave_team_modal').modal('hide');
                    window.location = base_url+"/?profileleaveteamsuccess";
                    return true;
                }
            }
        });
    });

    $('#edit_team_info input').keydown(function(e) {
        if (e.keyCode === 13)
        {
            $('#teaminfosubmit').click();
            return false;
        }
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
                        $('#errorinline_teaminfo p').text(data.teamnameError);
                    }
                    else
                    {
                        $('#error_teaminfo').removeClass('has-error');
                        $('#errorinline_teaminfo p').text('');
                    }

                    if (data.sportError)
                    {
                        $('#error2_teaminfo').addClass('has-error');
                        $('#error2inline_teaminfo p').text(data.sportError);
                    }
                    else
                    {
                        $('#error2_teaminfo').removeClass('has-error');
                        $('#error2inline_teaminfo p').text('');
                    }
            }
        });
    });

    $('#delete_team input').keydown(function(e) {
        if (e.keyCode === 13)
        {
            $('#deleteteamsubmit').click();
            return false;
        }
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
                        $('#errorinline_deleteteam p').text(data.matchError);
                    }

                    else if (data.deleteError)
                    {
                        $('#error_deleteteam').addClass('has-error');
                        $('#errorinline_deleteteam p').text(data.deleteError);
                    }
                    else
                    {
                        $('#error_deleteteam').removeClass('has-error');
                        $('#errorinline_deleteteam p').text('');
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
            data:
            {
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
                    $('#errorinline_editEp p').text(data.episodeNameError);
                }
                else
                {
                    $('#error_editEp').removeClass('has-error');
                    $('#errorinline_editEp p').text('');
                }

                if (data.episodeDescError)
                {
                    $('#error2_editEp').addClass('has-error');
                    $('#error2inline_editEp p').text(data.episodeDescError);
                }
                else
                {
                    $('#error2_editEp').removeClass('has-error');
                    $('#error2inline_editEp p').text('');
                }

                if (data.episodeDateError)
                {
                    $('#error3_editEp').addClass('has-error');
                    $('#error3inline_editEp p').text(data.episodeDateError);
                }
                else
                {
                    $('#error3_editEp').removeClass('has-error');
                    $('#error3inline_editEp p').text('');
                }

                if (data.episodeStartTimeError)
                {
                    $('#error4_editEp').addClass('has-error');
                    $('#error4inline_editEp p').text(data.episodeStartTimeError);
                }
                else
                {
                    $('#error4_editEp').removeClass('has-error');
                    $('#error4inline_editEp p').text('');
                }
                if (data.episodeEndTimeError)
                {
                    $('#error5_editEp').addClass('has-error');
                    $('#error5inline_editEp p').text(data.episodeEndTimeError);
                }
                else
                {
                    $('#error5_editEp').removeClass('has-error');
                    $('#error5inline_editEp p').text('');
                }
                if (data.episodeLocationError)
                {
                    $('#error6_editEp').addClass('has-error');
                    $('#error6inline_editEp p').text(data.episodeLocationError);
                }
                else
                {
                    $('#error6_editEp').removeClass('has-error');
                    $('#error6inline_editEp p').text('');
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

    $('#add_event_form input').keydown(function(e) {
        if (e.keyCode === 13)
        {
            $('#addeventsubmit').click();
            return false;
        }
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
        var referrer_id     = $("#referrer_id").val();
        if($("#add_to_statistics").is(":checked")) {
            var add_to_stats = 1;
        } else {
            var add_to_stats = 0;
        }

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
                eventlocation: eventlocation,
                add_to_stats: add_to_stats,
                referrer_id: referrer_id
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
                        $('#errorinline p').text(data.nameerror);
                    }
                    else
                    {
                        $('#error').removeClass('has-error');
                        $('#errorinline p').text('');
                    }

                    if (data.descerror)
                    {
                        $('#error2').addClass('has-error');
                        $('#error2inline p').text(data.descerror);
                    }
                    else
                    {
                        $('#error2').removeClass('has-error');
                        $('#error2inline p').text('');
                    }

                    if (data.freqerror)
                    {
                        $('#error3').addClass('has-error');
                        $('#error3inline p').text(data.freqerror);
                    }
                    else
                    {
                        $('#error3').removeClass('has-error');
                        $('#error3inline p').text('');
                    }

                    if (data.stdateerror)
                    {
                        $('#error4').addClass('has-error');
                        $('#error4inline p').text(data.stdateerror);
                    }
                    else
                    {
                        $('#error4').removeClass('has-error');
                        $('#error4inline p').text('');
                    }
                    if (data.enddateerror)
                    {
                        $('#error5').addClass('has-error');
                        $('#error5inline p').text(data.enddateerror);
                    }
                    else
                    {
                        $('#error5').removeClass('has-error');
                        $('#error5inline p').text('');
                    }
                    if (data.sttimeerror)
                    {
                        $('#error6').addClass('has-error');
                        $('#error6inline p').text(data.sttimeerror);
                    }
                    else
                    {
                        $('#error6').removeClass('has-error');
                        $('#error6inline p').text('');
                    }
                    if (data.endtimeerror)
                    {
                        $('#error7').addClass('has-error');
                        $('#error7inline p').text(data.endtimeerror);
                    }
                    else
                    {
                        $('#error7').removeClass('has-error');
                        $('#error7inline p').text('');
                    }
                    if (data.locerror)
                    {
                        $('#error8').addClass('has-error');
                        $('#error8inline p').text(data.locerror);
                    }
                    else
                    {
                        $('#error8').removeClass('has-error');
                        $('#error8inline p').text('');
                    }
            }
        });
    });

    $("#import-data").change(function(){
        var id = $(this).find(":selected").attr("id");
        console.log(id);
        if(id === '0') {
            $("#event_name").val('');
            $("#event_desc").val('');
            $("#start_date").val('');
            $("#end_date").val('');
            $("#start_time").val('');
            $("#end_time").val('');
            $("#location").val('');
            $("#referrer_id").val('');
            return false;
        }
        $.ajax({
            url: base_url+"/index.php/team/get_event/"+id,
            type: "POST",
            dataType: "json",
            success:
                function(data)
                {
                    data = data[0];
                    $("#event_name").val(data.name);
                    if(data.name != '' || data.name != 'NULL') {
                        $("#event_desc").val(data.description);
                    }
                    $("#start_time").val(data.start_time);
                    $("#end_time").val(data.end_time);
                    $("#eventlocation").val(data.location);
                    $("#referrer_id").val(data.id);
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
        if($(this).closest(".panel-body").find("#edited_add_to_statistics").is(":checked")) {
            var edited_add_to_statistics = 1;
        } else {
            var edited_add_to_statistics = 0;
        }

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
                edited_location: edited_location,
                edited_add_to_statistics: edited_add_to_statistics
            },
            success:
                    function(data)
            {
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
                        $(button).closest(".panel-body").find('#errorinline_edit p').text(data.edit_nameerror);
                    }
                    else
                    {
                        $(button).closest(".panel-body").find('#error_edit').removeClass('has-error');
                        $(button).closest(".panel-body").find('#errorinline_edit p').text('');
                    }

                    if (data.edit_descerror)
                    {
                        $(button).closest(".panel-body").find('#error2_edit').addClass('has-error');
                        $(button).closest(".panel-body").find('#error2inline_edit p').text(data.edit_descerror);
                    }
                    else
                    {
                        $(button).closest(".panel-body").find('#error2_edit').removeClass('has-error');
                        $(button).closest(".panel-body").find('#error2inline_edit p').text('');
                    }

                    if (data.edit_stTimeError)
                    {
                        $(button).closest(".panel-body").find('#error3_edit').addClass('has-error');
                        $(button).closest(".panel-body").find('#error3inline_edit p').text(data.edit_stTimeError);
                    }
                    else
                    {
                        $(button).closest(".panel-body").find('#error3_edit').removeClass('has-error');
                        $(button).closest(".panel-body").find('#error3inline_edit p').text('');
                    }

                    if (data.edit_endTimeError)
                    {
                        $(button).closest(".panel-body").find('#error4_edit').addClass('has-error');
                        $(button).closest(".panel-body").find('#error4inline_edit p').text(data.edit_endTimeError);
                    }
                    else
                    {
                        $(button).closest(".panel-body").find('#error4_edit').removeClass('has-error');
                        $(button).closest(".panel-body").find('#error4inline_edit p').text('');
                    }

                    if (data.edit_locerror)
                    {
                        $(button).closest(".panel-body").find('#error5_edit').addClass('has-error');
                        $(button).closest(".panel-body").find('#error5inline_edit p').text(data.edit_locerror);
                    }
                    else
                    {
                        $(button).closest(".panel-body").find('#error5_edit').removeClass('has-error');
                        $(button).closest(".panel-body").find('#error5inline_edit p').text('');
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

    $('#update_profile input').keydown(function(e) {
        if (e.keyCode === 13)
        {
            $('#profileinfosubmit').click();
            return false;
        }
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
                        $('#errorinline_updateprofile p').text(data.editUsernameError);
                    }
                    else
                    {
                        $('#error_updateprofile').removeClass('has-error');
                        $('#errorinline_updateprofile p').text('');
                    }

                    if (data.editEmailError)
                    {
                        $('#error2_updateprofile').addClass('has-error');
                        $('#error2inline_updateprofile p').text(data.editEmailError);
                    }
                    else
                    {
                        $('#error2_updateprofile').removeClass('has-error');
                        $('#error2inline_updateprofile p').text('');
                    }
            }
        });
    });

    /*************************************
    **************************************
    * TABLES
    **************************************
    *************************************/

    $('#squad_table').dataTable({
        iDisplayLength: 25,
        bInfo: false,
        bPaginate: false,
        "sDom": 'l<"squad">frtip',
        aaSorting: [[ 1, "desc" ]],
        bSortClasses: false,
        "oLanguage": { "sSearch": "<span class='glyphicon glyphicon-search'></span>" },

        "aoColumnDefs" : [ {
            'bSortable' : false,
            'aTargets' : [ 0 ]
        } ]
    });

    $('#staff_table').dataTable({
        iDisplayLength: 25,
        bInfo: false,
        bPaginate: false,
        "sDom": 'l<"staff">frtip',
        aaSorting: [[ 1, "desc" ]],
        bSortClasses: false,
        "oLanguage": { "sSearch": "<span class='glyphicon glyphicon-search'></span>" },

        "aoColumnDefs" : [ {
            'bSortable' : false,
            'aTargets' : [ 0 ]
        } ]
    });

    $('#player_squad_table').dataTable({
        bSortClasses: false,
        bInfo: false,
        bPaginate: false,
        "oLanguage": { "sSearch": "<span class='glyphicon glyphicon-search'></span>" }
    });

    $('#player_staff_table').dataTable({
        bSortClasses: false,
        bInfo: false,
        bPaginate: false,
        "oLanguage": { "sSearch": "<span class='glyphicon glyphicon-search'></span>" }
    });

    $('#player_table').dataTable({
        bSortClasses: false,
        //bInfo: false,
        "oLanguage": { "sSearch": "<span class='glyphicon glyphicon-search white'></span>" },
        "aoColumnDefs" : [ {
            'bSortable' : false,
            'aTargets' : [ 0 ]
        } ]
    });

    $('#coach_table').dataTable({
        bSortClasses: false,
        "oLanguage": { "sSearch": "<span class='glyphicon glyphicon-search white'></span>" },
        "aoColumnDefs" : [{
            'bSortable' : false,
            'aTargets' : [ 0 ]
        }]
    });

    /*$('#statistics_table').dataTable({
        bSortClasses: false,
        bInfo: false,
        bPaginate: false,
        bFilter: false,
        "oLanguage":
        {
            "sSearch": "<span class='glyphicon glyphicon-search'></span>",
            "sEmptyTable": '',
            "sInfoEmpty": '',
            "sZeroRecords": ''
        }
    });*/

    $('#event_table').dataTable({
        bSortClasses: false,
        bInfo: false,
        bPaginate: false,
        "aoColumnDefs" : [ {
            'bSortable' : false,
            'aTargets' : [ 0 ]
        } ],
        bSort: false,
        bFilter: false
    });

    $('#join_team_table').dataTable({
        bSortClasses: false,
        "oLanguage": { "sSearch": "<span class='glyphicon glyphicon-search' ></span>" },
        "aoColumnDefs" : [ {
            'bSortable' : false,
            'aTargets' : [ 0 ]
        } ]
    });

    /*************************************
    **************************************
    * SUCCESS MESSAGES
    **************************************
    *************************************/

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

    else if (hash === 'addcoachsuccess')
    {
        $("#success").append('<p><span class="glyphicon glyphicon-ok"></span>Coaches were added to staff. </p>');
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

    else if (hash === 'removecoachsuccess')
    {
        $("#success").append('<p><span class="glyphicon glyphicon-ok"></span>Coaches were removed from staff. </p>');
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
    else if (hash === 'jointeampartlysuccess')
    {
        $("#home_success").addClass('warning');
        $("#home_success").append('<p><span class="glyphicon glyphicon-warning-sign"></span>One or more of the teams selected was not joined because the team limit was exceeded. </p>');
        $("#home_success").show().delay(5000).fadeOut(1000);
        window.history.replaceState("gammel", "ny", window.location.pathname);
    }
    else if (hash === 'leaveteamsuccess')
    {
        $("#home_success").append('<p><span class="glyphicon glyphicon-ok"></span>You left team. </p>');
        $("#home_success").show().delay(3000).fadeOut(1000);
        window.history.replaceState("gammel", "ny", window.location.pathname);
    }
    else if (hash === 'profileleaveteamsuccess')
    {
        $("#profile_success").append('<p><span class="glyphicon glyphicon-ok"></span>You left team.</p>');
        $("#profile_success").show().delay(3000).fadeOut(1000);
        window.history.replaceState("gammel", "ny", window.location.pathname);

    }
    else if (hash === 'updateprofilesuccess')
    {
        $("#profile_success").append('<p><span class="glyphicon glyphicon-ok"></span>Profile was updated. </p>');
        $("#profile_success").show().delay(3000).fadeOut(1000);
        window.history.replaceState("gammel", "ny", window.location.pathname);
    }

    $(document).ajaxComplete(function(){
        setTimeout(function() {
            $("#loading").hide();
        }, 1500);
        
    });
});