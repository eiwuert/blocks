
<?php
    require('vendor/autoload.php');
    use Worker;
    
    $worker = new Worker();
    
    $worker->listen();
