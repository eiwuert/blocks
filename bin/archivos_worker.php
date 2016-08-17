
<?php
    require('vendor/autoload.php');
    use App\Http\Controllers\Worker;
    
    $worker = new Worker();
    
    $worker->listen();
