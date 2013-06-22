<?php

// Autoloader. Use SPL in a real project.
foreach(array('Server', 'Stats', 'StatsException') as $file) {
	include sprintf('../MCServerStatus/Minecraft/%s.php', $file);
}

$servers = array(
	"s.nerd.nu",
	"p.nerd.nu",
	"hardcore.hcsmp.com",
	"theverge.game.nfoservers.com:25565",
);

?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>Minecraft Server Status</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	<style>tr td,tr th {text-align:center !important}tr td.motd,tr th.motd{text-align:left !important;}</style>
	<style>.status{width:50px;}</style>
	<!-- HTML5 shim -->
    <!--[if lt IE 9]>
    	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>
	<div class="container">
		<div class="row" style="margin:15px 0;">
			<h1>MCServerStatus</h1>
			<p>This is a basic implementation of reading Minecraft server meta and online/offline status.</p>
		</div>
		<div class="row">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th class="status">Status</th>
						<th class="motd">Server</th>
						<th>Players</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($servers as $server): ?>
					<?php $stats = \Minecraft\Stats::retrieve(new \Minecraft\Server($server)); ?>
					<tr>
						<td>
							<?php if($stats->is_online): ?>
							<span class="badge badge-success"><i class="icon-ok icon-white"></i></span>
							<?php else: ?>
							<span class="badge badge-important"><i class="icon-remove icon-white"></i></span>
							<?php endif; ?>
						</td>
						<td class="motd"><?php echo $stats->motd; ?> <code><?php echo $server; ?></code></td>
						<td><?php printf('%u/%u', $stats->online_players, $stats->max_players); ?></td>
					</tr>
					<?php unset($stats); ?>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<div class="row">
			<p>This page is using PHP to check if Minecraft servers are online and query their listing information. <a href="http://www.webmaster-source.com/?p=4730">Read more about redwallhp's original PHP 5.2 implementation here.</a></p>
			<iframe src="http://ghbtns.com/github-btn.html?user=redwallhp&repo=MCServerStatus&type=watch&count=true" allowtransparency="true" frameborder="0" scrolling="0" width="110" height="20"></iframe>
			<iframe src="http://ghbtns.com/github-btn.html?user=redwallhp&repo=MCServerStatus&type=fork&count=true"allowtransparency="true" frameborder="0" scrolling="0" width="95" height="20"></iframe>
		</div>
	</div>
</body>
</html>