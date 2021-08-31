<?php
// $repo_dir = '/home/admin/domains/git.datahost.lt/public_html/datahostmain';
// $web_root_dir = '/home/admin/domains/git.datahost.lt/public_html/live';
// $git_bin_path = '/usr/bin/git';


// copy($web_root_dir."/.env",$web_root_dir."/public/deploy/.env");

// echo shell_exec('cd ' . $repo_dir . ' && ' . $git_bin_path  . ' fetch 2>&1');
// echo shell_exec('cd ' . $repo_dir . ' && ' . $git_bin_path  . ' pull 2>&1');
// exec('cd ' . $repo_dir . ' && GIT_WORK_TREE=' . $web_root_dir . ' ' . $git_bin_path  . ' checkout -f');

// exec("chmod -R 755 $web_root_dir");

// $commit_hash = shell_exec('cd ' . $repo_dir . ' && ' . $git_bin_path  . ' rev-parse --short HEAD');
// echo $commit_hash;
// file_put_contents('deploy.log', date('m/d/Y h:i:s a') . " Deployed branch: " .  $branch . " Commit: " . $commit_hash . "\n", FILE_APPEND);

// copy($web_root_dir."/public/deploy/.env",$web_root_dir."/.env");

$myfile = fopen("need_update.txt", "w") or die("Unable to open file!");
$txt = "True";
fwrite($myfile, $txt);
fclose($myfile);

echo "OK";

?>
