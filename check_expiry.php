<?php
session_start();
include('include/node-check.php');

if (isset($_POST['address'])) {
	$address = $_POST['address'];
	if ($whitelist == '1') {

		$url = $scheme.'://'.$server_ip.':'.$api_port.'/api/Staking/getStakingNotExpired?WalletName='.$WalletName.$api_ver;
		$result = $wallet->CallAPI ($url,"GET");

		if(is_array($result)){
			foreach($result as $a => $b){
				$i=0;
				foreach($b as $c => $d){ // /[^a-z|\s+]+/i /[^0-9]/
					$add = trim((json_encode($result['addresses'][$i]['address'])),'"') ;
					$exp = strtr(trim(json_encode($result['addresses'][$i]['expiry']),'"'),"T"," ") ;
					$exp = substr($exp, 0, strlen($exp)-4);
					if ( $add == $address ) {
						$expires = $exp;
					}
					$i++;
				}
			}
		} else {echo "Not an array";}
	}
}
?>
<?php include('include/header.php'); ?>
<?php include('include/menu.php'); ?>
<!-- Main -->
	<article id="main">
		<header>
			<img src="images/coin_logo-<?php print $ticker; ?>.png" alt="" width="200"/>
		</header>
			<section class="wrapper style5">
				<div class="inner">
				<section>
					<h3>Check My Expiry Date</h3>
				</div>
				<?php if ( (isset($_POST['address'])) && isset($expires) ){?>
				<div class="table-wrapper">
					<table>
							<thead>
								<tr>
									<th>Address</th>
									<th>Expiry</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo $address;?></td>
									<td><?php echo $expires;?></td>
								</tr>
							</tbody>
							<tfoot>
							</tfoot>
						</table>
				<?php } ?> <br />
				<form method="post" action="">
						<div class="col-24">
							<input type="text" name="address" id="address" value="" placeholder="address" />
						</div>
						<br />
						<div class="col-12">
								<ul class="actions">
									<li><input type="submit" value="Search" class="primary" /></li>
									<li><input type="reset" value="Reset" /></li>
								</ul>
						</div>
				</form>
				</section>	
			</section>
	</article>
<?php include('include/footer.php'); ?>