<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>status</title>
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
<meta http-equiv="refresh" content="60" />
</head>
<body>
<?php
//create table s(host text, info text, date text, cpus int,primary key (host)) ;
$f_contents = file("quotes.html");
$quote = $f_contents[rand(0, count($f_contents) - 1)];
$h = new SQLite3("status.dat");
$h->busyTimeout(40);
if ($_POST && (!strpos($_SERVER['REMOTE_ADDR'],'192.168.1') || !strpos($_SERVER['REMOTE_ADDR'],'212.87.3.12') )){ // not very secure - update status only from these ip's
    $info = $_POST['ping'];
    $cpus = $_POST['cpus'];
    $date = $_POST['date'];
    $host = $_POST['hostname'];
	sleep(rand(1,14));
    $stmt0 = $h->query("DELETE FROM s WHERE host='".$host."'");
    
    $stmt1 = $h->prepare("INSERT INTO s(host,info,date,cpus) VALUES (:host,:info,:date,:cpus)");
    $stmt1->bindValue(":host",$host,SQLITE3_TEXT);
    $stmt1->bindValue(":info",$info,SQLITE3_TEXT);
    $stmt1->bindValue(":date",$date,SQLITE3_TEXT);
    $stmt1->bindValue(":cpus",$cpus,SQLITE3_INTEGER);
    $r = $stmt1->execute();
}
else {
?>
<div class="container">
<div class="row">
<div class="col-md-2"></div>
<div class="col-md-8">
<div class="table-responsive">
<table class="table table-striped table-hover">
<thead>
<tr>    <th>host</th><th>cpus</th><th>load</th><th>uptime</th></tr>
</thead>
<tbody>

<?php
function status($cpus, $load) {
$v = round(100*$load/(1.0*$cpus),0);
if ($v>90) { // success, info, warning, danger
	return '<span class="label label-danger">'.$v.' %</span>';
}
else if ($v>60) {
	return '<span class="label label-warning">'.$v.' %</span>';
}
else if ($v>20) {
	return '<span class="label label-info">'.$v.' %</span>';
}
else {
	return '<span class="label label-success">'.$v.' %</span>';
}
}
    $r = $h->query("SELECT * FROM s ORDER BY host ASC");
    while ($row = $r->fetchArray()) {
	$load = explode(" ",$row['info']);
	$load = array_slice($load,-3,1);
	$load = explode(",",$load[0]); // amatorszczyzna gwizdze
	$load = $load[0];
	$cpus = $row['cpus'];

	print "<tr><td><strong><div rel='tooltip' data-toggle='tooltip' data-placement='right' title='".$row['date']."'>".$row['host']."</div></strong></td>".
	"<td>".$row['cpus']."</td>".	 	
	"<td>".status($cpus,$load)."</td>".
	"<td><small>".$row['info']."</small></td>".	 	
"</tr>\n";
    }

}

$h->close();
unset($h);
?>
</tbody>
</table>
</div>
<div class="well">
<span class="fa-stack fa-lg pull-left">
  <i class="fa fa-square fa-stack-2x pull-left"></i>
<i class="fa fa-quote-left fa-stack-1x pull-left fa-square fa-inverse"></i>
</span>

<?php print $quote; ?>
<a href="http://amiquote.tumblr.com/" target=_blank><small>[src]</small></a>
</div>
</div>
<div class="col-md-2"></div>
</div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
$("[rel=tooltip]").tooltip();
    });
</script>
</body></html>
