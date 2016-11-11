<?php

$yaml = '/var/www/localhost/htdocs/mount/swagger.yaml';

if (file_exists($yaml) && $_SERVER['REQUEST_METHOD'] === 'GET') {
    header('text/vnd.yaml');
    print file_get_contents($yaml);
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $incoming = fopen("php://input", "r");
    $fp = fopen($yaml, "w");
    while ($data = fread($incoming, 1024)) {
        fwrite($fp, $data);
    }
    fclose($fp);
    fclose($incoming);

    header('application/json');
    print json_encode(array("message" => "OK"), 128);
} else {
    print "API definitions Yaml file probably not mounted";
}
exit(0);

