<div class="piechartcontainer"></div>




<script>
$(document).ready(function() {
    generatepiechart("Sales Person Quantity Chart",".piechartcontainer",<?php echo $values;?>)
});
</script>