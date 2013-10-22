<div>
    <?php if ( $coach === TRUE ) : ?>
        <!-- HTML to display for coaches here -->
        <h3>Coach area</h3>
        <p> Welcome, <?php echo $username; ?> </p>
    
    
    <?php else : ?>
        <!-- HTML to display for players here -->
        <h3>Player area</h3>
        <p> Welcome, <?php echo $username; ?> </p>
    <?php endif; ?>
</div>