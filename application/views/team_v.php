<div>
    <?php if ( $coach === TRUE ) : ?>
        <!-- HTML to display for coaches here -->
        <h3>Coach area</h3>
        <p> Welcome, <?php echo $username; ?> </p>
        <form action="team/create_team">
            
            <input><!-- Form content, fields etc here -->
            
        </form>
    
    
    <?php else : ?>
        <!-- HTML to display for players here -->
        <h3>Player area</h3>
        <p> Welcome, <?php echo $username; ?> </p>
        <!-- Here goes a search in the 'team' database table -->
        
    <?php endif; ?>
</div>