<?php
error_log("Server test accessed at " . date('Y-m-d H:i:s'));
echo json_encode(['status' => 'ok', 'time' => date('Y-m-d H:i:s')]);
