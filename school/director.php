<?php define('TITLE', 'Director'); ?>

<?php require_once('../connection.php') ;?>
<?php require_once('../admin/includes/functions.php') ;?>
<?php require_once('../inc/header.php') ;?> 


<div class="container">
        <h1 class="p-4">Director word</h1>
        <?php
            if($school['director'] == null){
        ?>
        
            <div class="p-3">
                <p class="d-block ">
                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ipsam mollitia blanditiis id non ad quam libero commodi repellendus, neque quasi nobis aut laudantium facere accusamus molestiae, voluptate ex, unde modi.
                </p>
                <p class="d-block">
                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ipsam mollitia blanditiis id non ad quam libero commodi repellendus, neque quasi nobis aut laudantium facere accusamus molestiae, voluptate ex, unde modi.
                </p>
                <p class="d-block">
                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ipsam mollitia blanditiis id non ad quam libero commodi repellendus, neque quasi nobis aut laudantium facere accusamus molestiae, voluptate ex, unde modi.
                </p>
                <p class="d-block ">
                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ipsam mollitia blanditiis id non ad quam libero commodi repellendus, neque quasi nobis aut laudantium facere accusamus molestiae, voluptate ex, unde modi.
                </p>
                <p class="d-block">
                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ipsam mollitia blanditiis id non ad quam libero commodi repellendus, neque quasi nobis aut laudantium facere accusamus molestiae, voluptate ex, unde modi.
                </p>
                <p class="d-block">
                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ipsam mollitia blanditiis id non ad quam libero commodi repellendus, neque quasi nobis aut laudantium facere accusamus molestiae, voluptate ex, unde modi.
                </p>
            </div>
        <?php }else{ ?>
            <div class="p-4">
                <?php echo $school['director'] ?>
            </div>


        <?php }  ?>


    </div>




<?php require_once('../inc/footer.php') ;?>