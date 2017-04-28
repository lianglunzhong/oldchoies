<?php

return array(
    'enabled' => TRUE, 
    'rate' => array(
        'starter' => 0.10, 
        'standard' => 0.12, 
        'vip' => 0.14, 
    ), 
    'pending_duration' => 5184000, /* 60 days */
    'status' => array(
        'ready' => 'Ready for Payment', 
        'pending' => 'Pending', 
    ), 
);
