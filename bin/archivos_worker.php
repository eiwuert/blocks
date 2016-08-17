
<?php
    require('vendor/autoload.php');
    use App\Worker;
    
    $worker = new Worker();
    
    $worker->listen();
