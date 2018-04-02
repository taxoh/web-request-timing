<?php
// WEB TIMING

if ($_POST)
{
	$s = shell_exec('curl '.escapeshellarg($_POST['url']).' -o /dev/null -s -L -w '.escapeshellarg(
		'URL: '.$_POST['url']."\n".
		'EFFECTIVE URL: %{url_effective}'."\n".
		'SERVER IP: %{remote_ip}'."\n".
		'REDIRECT COUNT: %{num_redirects}'."\n".
		'CONNECT COUNT: %{num_connects}'."\n".
		'RESPONSE CODE: %{http_code}'."\n".
		'SIZE: %{size_download} bytes'."\n".
		'TIME: %{time_total}s'."\n"
	));
}
	else
{
	// $_POST = [
		// 'url' => 'http://scripts/mycms-wp',
	// ];
}
?>
<p>Показывает полное время выполнения GET-запроса на указанный URL</p>
<form method=post action="">
	<input onclick="this.select()" type=text size=60 name=url placeholder="example.com" value="<?=htmlspecialchars($_POST['url'])?>">
	<input type=submit value="Тест">
</form>
<?=nl2br($s)?>