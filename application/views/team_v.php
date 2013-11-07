<div>
    <?php if ( $coach === TRUE ) : ?>
        
    <h2> EPIC UNITED </h2> 
    <br><!-- $teamname -->
    
    <ul id="team_tabs" class="nav nav-tabs">
        <li><a href="#schedule" data-toggle="tab"><span class="glyphicon glyphicon-calendar"></span>Schedule</a></li>
        <li><a href="#stats" data-toggle="tab"><span class="glyphicon glyphicon-stats"></span>Statistics</a></li>
        <li><a href="#edit" data-toggle="tab"><span class="glyphicon glyphicon-edit"></span>Edit</a></li>
        <li><a href="#about" data-toggle="tab"><span class="glyphicon glyphicon-info-sign"></span>About</a></li>
    </ul>
    <!-- Tab panes -->
    <div id="team_content" class="tab-content">
        <div class="tab-pane fade in active" id="schedule">
            <p>Content</p>
        </div>
        
        <div class="tab-pane fade" id="stats">
            <p>More content</p>
        </div>
        
        <div class="tab-pane fade" id="edit">
            <p>Even more content</p>
        </div>
        
        <div class="tab-pane fade" id="about">
            <p>Dude, enough with the content already</p>
            <br>
            <p> Oh great, more content </p>
            <br>
        </div>
    </div>
    
    <!-- Must be moved into Functions.js -->
    <script>
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
    </script>
    
    <?php else : ?>
        
    <!-- Player stuff -->
    
    <?php endif; ?>
</div>

