<?php
// WEB TIMING

if ($_POST)
{
	$keys = [
		'URL',
		'Effective URL',
		'Server IP',
		'Redirects count',
		'Connection count',
		'HTTP response code',
		'Download size',
		'Time Namelookup',
		'Time Connect',
		'Time AppConnect',
		'Time PreTransfer',
		'Time Redirect',
		'Time StartTransfer',
		'Time total',
	];
	
	$comments = [
		'',
		'',
		'',
		'',
		'',
		'',
		'',
		'The time, in seconds,  it  took  from  the  start until the name resolving was completed.',
		'The time, in seconds,  it  took  from  the  start until  the  TCP  connect  to  the remote host (or proxy) was completed.',
		'The time, in seconds,  it  took  from  the  start until  the  SSL/SSH/etc  connect/handshake to the remote host was completed. (Added in 7.19.0)',
		'The  time,  in  seconds,  it  took from the start until the file transfer was just about to  begin. This includes all pre-transfer commands and negotiations that are specific to the particular protocol(s) involved.',
		'The time, in seconds, it took for all redirection steps include name lookup,  connect,  pretransfer and  transfer  before  the  final transaction was started. time_redirect shows the complete  execution  time  for  multiple redirections. (Added in 7.12.3)',
		'The time, in seconds,  it  took  from  the  start until  the first byte was just about to be transferred. This includes time_pretransfer  and  also the  time the  server  needed  to  calculate the result.',
		'The total time, in seconds, that the full  operation lasted. The time will be displayed with millisecond resolution.',
	];

	$req = 'curl '.escapeshellarg($_POST['url']).' -o /dev/null -s -L -w '.escapeshellarg("
$_POST[url]
%{url_effective}
%{remote_ip}
%{num_redirects}
%{num_connects}
%{http_code}
%{size_download} bytes
%{time_namelookup}s
%{time_connect}s
%{time_appconnect}s
%{time_pretransfer}s
%{time_redirect}s
%{time_starttransfer}s
%{time_total}s
");
	$s = shell_exec($req);
	$s = trim($s);
	$x = array_combine($keys, explode("\n", $s));
	$comments = array_combine($keys, $comments);
	$s = '';
	foreach ($x as $k=>$v)
	{
		$s .= '<tr><td class="first">'.$k.':</td><td class="second" '.($comments[$k]?'':'colspan=2').'>'.htmlspecialchars($v).'</td>'.($comments[$k]?'<td>'.$comments[$k].'</td>':'').'</tr>';
	}
}
	else
{
	// $_POST = [
		// 'url' => 'http://...',
	// ];
}
?>
<!DOCTYPE html>
<html>
<head>
<title>CURL Time / Замерить время запроса страницы / Web Timing</title>
<style>
	.first {font-weight:bold}
	.second {min-width:100px;}
	textarea {width:95%;height:100px;}
	input[type=text] {width:95%;}
</style>
</head>
<body>
<form method=post action="">
	<input onclick="this.select()" type=text size=60 name=url placeholder="example.com" value="<?=htmlspecialchars($_POST['url'])?>">
	<p><input type=submit value="Выполнить"></p>
</form>
<table>
	<?=nl2br($s)?>
</table>
<p>Выполненная команда:</p>
<textarea onclick="this.select()" readonly=yes><?=htmlspecialchars($req)?></textarea>
</body>
</html>
