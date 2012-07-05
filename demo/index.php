<!DOCTYPE html>
<html>
<head>
	<title>Minecraft Server Status</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<style>
		tr td, tr th { text-align: center !important; }
		tr td.motd, tr th.motd { text-align: left !important; }
	</style>
	<!-- HTML5 shim -->
    <!--[if lt IE 9]>
    	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>


<body style="width: 700px; margin: 30px auto;">


<div>
	<table class="table table-bordered table-striped">
		<thead>
			<tr> <th>Status</th> <th class='motd'>Server</th> <th>Players</th> </tr>
		</thead>
		<tbody>

			<?php
				include "../MCServerStatus.php";
				$servers = array(
					"s.nerd.nu",
					"p.nerd.nu",
					"hardcore.hcsmp.com",
					"theverge.game.nfoservers.com:25565"
				);
				foreach ($servers as $server) {
					if (strpos($server, ':') !== false) {
						$parts = explode(':', $server);
						$port = $parts[1];
					}
					else {
						$port = '25565';
					}
					$s = new MCServerStatus($server, $port);
					$status = ($s->online) ? '<span class="badge badge-success"><i class="icon-ok icon-white"></i></span>' : '<span class="badge badge-important"><i class="icon-remove icon-white"></i></span>';
					$players = ($s->online_players) ? $s->online_players : 0 ;
					$max_players = ($s->max_players) ? $s->max_players : 0 ;
					echo "<tr>";
					echo "<td>".$status."</td>";
					echo "<td class='motd'>".$s->motd." <code>".$server."</code></td>";
					echo "<td>".$players."/".$max_players."</td>";
					echo "</tr>";
				}
			?>

		</tbody>
	</table>
</div>

<p>This page is using PHP to check if Minecraft servers are online and query their listing information. <a href="http://www.webmaster-source.com/?p=4730">Read more here.</a></p>


</body>
</html>