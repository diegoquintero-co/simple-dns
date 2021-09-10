<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="Diego Quintero">
    <link rel="icon" href="/favicon.ico">

    <title>Simple DNS Lookup</title>

    <!-- Bootstrap core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>


 
<div class="container">
      <div class="header clearfix">
        <nav>
          <ul class="nav nav-pills pull-right">
            <li role="presentation" class="active"><a href="/dnscheck">Home</a></li>
          </ul>
        </nav>
        <h3 class="text-muted">Simple DNS Lookup</h3>
      </div>

	<div class="jumbotron">
		<form action="" method="post">
			<div class="form-group">
				<input class="form-control input-lg text-center" name ="domain" type="text" placeholder="<?php if(isset($_POST['submit'])) { echo($_POST['domain']); }else{echo("www.domain.com");} ?>" requirerd>
	        	<button type="submit" name="submit" class="btn btn-primary btn-lg">Lookup DNS</button>
			</div>
		</form>
	</div>

	<div class="row marketing">

		<?php

			if(isset($_POST['submit']))
					{
						$domain_regex = '/[a-z\d][a-z\-\d\.]+[a-z\d]/i';
						$domain = $_POST['domain'];
						$dns_a = dns_get_record($domain, DNS_A);
						$dns_ns = dns_get_record($domain, DNS_NS);
						$dns_mx = dns_get_record($domain, DNS_MX);
						$dns_txt = dns_get_record($domain, DNS_TXT);

		?>

		<table class="table table-striped table-bordered table-responsive">
			<thead class="bg-primary">
					<td class="text-center">Record</td>
					<td class="text-center">Class</td>
					<td class="text-center">TTL</td>
					<td>Details for <?php echo($_POST['domain']); ?></td>
			</thead>
			<tr>
				<td class="vert-align text-center"><h4><span class="label label-primary"><?php echo($dns_a[0]['type']); ?></span></h4></td>
				<td class="vert-align text-center"><?php echo($dns_a[0]['class']); ?></td>
				<td class="vert-align text-center"><?php echo($dns_a[0]['ttl']); ?></td>
				<td>
					<?php 
					foreach($dns_a as $value)
						{
							?>	<h4>
									<?php
										echo($value['ip']);
									?>
								</h4>
							<?php } ?>
				</td>
			</tr>

			<tr>
				<td class="vert-align text-center"><h4><span class="label label-success"><?php echo($dns_ns[0]['type']); ?></span></h4></td>
				<td class="vert-align text-center"><?php echo($dns_ns[0]['class']); ?></td>
				<td class="vert-align text-center"><?php echo($dns_ns[0]['ttl']); ?></td>
				<td>
					<?php 
					foreach($dns_ns as $value)
						{
							?><h4>
								<?php  echo($value['target']); ?>
								(<?php echo(gethostbyname($value['target'])) ?>)
							</h4>
							<?php } ?>
				</td>
			</tr>
			<tr>
				<td class="vert-align text-center"><h4><span class="label label-danger"><?php echo($dns_mx[0]['type']); ?></span></h4></td>
				<td class="vert-align text-center"><?php echo($dns_mx[0]['class']); ?></td>
				<td class="vert-align text-center"><?php echo($dns_mx[0]['ttl']); ?></td>
				<td>
					<?php 
					foreach($dns_mx as $value)
						{
							?><h4>
								[<?php  echo($value['pri']); ?>] 
								<?php  echo($value['target']); ?>
								(<?php echo(gethostbyname($value['target'])) ?>)
							</h4>
							<?php } ?>
				</td>
			</tr>
			
			<tr>
				<td class="vert-align text-center"><h4><span class="label label-default"><?php echo($dns_txt[0]['type']); ?></span></h4></td>
				<td class="vert-align text-center"><?php echo($dns_txt[0]['class']); ?></td>
				<td class="vert-align text-center"><?php echo($dns_txt[0]['ttl']); ?></td>
				<td>
						<h4><?php echo($dns_txt[0]['txt']); ?></h4>
				</td>
			</tr>
			<tr>
				<td colspan="4" class="vert-align text-center">
					<?php $uniqid = uniqid(); file_put_contents('export/dns_export_'.$domain.'_'.$uniqid.'.txt', var_export($dns_all, TRUE)); $link = $domain.'_'.$uniqid ?>
					<a href="export/dns_export_<?php echo($link); ?>.txt" class="btn btn-info" role="button" target="_blank" download>Download records (.txt)</a>
				</td>
			</tr>
		</table>

	</div>

<?php
					}
?>

      <footer class="footer">
        <p>&copy; Uscreen - Simple DNS Lookup</p>
      </footer>

    </div> <!-- /container -->
  </body>
</html>
