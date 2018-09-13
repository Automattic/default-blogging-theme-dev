<?php

require_once '../../sites/ip3.local/wp-load.php';

echo ip3_human_time_diff( strtotime( '11 months ago' ) ) . "\n";