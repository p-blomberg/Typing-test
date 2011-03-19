<?php
$text=htmlspecialchars($_POST['text']);
$rows=explode("\n",$text);
foreach($rows as $key => $value) {
	$rows[$key]=trim($value);
}

echo '<?xml version="1.0" encoding="utf-8"?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'; ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Typing test</title>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<script type="text/javascript">
			var mistakes=0;
			var time=0;
			var win=0;

			function check() {
				b=document.getElementsByTagName("body");
				b=b[0];

				var c=document.getElementById("c");
				var t=document.getElementById("t");

				// Win?
				if(t.value == c.value) {
					b.style.backgroundColor = "lime";
					win=1;
					alert("Gtz!");
				} else {
					// Good so far?
					if(t.value == c.value.substring(0,t.value.length)) {
						b.style.backgroundColor = "yellow";
					} else {
						if(b.style.backgroundColor != "orange") {
							b.style.backgroundColor = "orange";
							mistakes++;
						}
					}

					// Update display text
					var row=new Array();
					<?php
					foreach($rows as $key => $value) {
						echo "row[$key]=\"$value\";\n";
					}
					?>
					ir=t.value.split("\n");
					dt='';
					for(var i=0;i<row.length;i++) {
						if(ir[i]!=row[i]) {
							break;
						}
					}
					if(row.length>i+2) {
						dt=row[i]+"<br />"+row[i+1]+"<br />"+row[i+2];
					} else if(row.length>i+1) {
						dt=row[i]+"<br />"+row[i+1];
					} else {
						dt=row[i];
					}
					var dte=document.getElementById('displaytext');
					dte.innerHTML=dt;
				}

				return true;
			}

			function update_stats() {
				var stats=document.getElementById("stats");
				var c=document.getElementById("c");
				var t=document.getElementById("t");

				if(t.value.length==0)
					time=0;
				var min = Math.floor(time/60);
				var sec = time - (min*60);

				var words = t.value.split(" ");
				var w = words.length;
				words = c.value.split(" ");
				var target = words.length;
				var wpm = Math.floor((w/time)*60);
				var cpm = Math.floor((t.value.length/time)*60);

				stats.value="Time: "+min+":"+sec+"\nMistakes: "+mistakes+"\nWords: "+w+" of "+target+"\n\nWords per minute: "+wpm+"\nCharacters per minute: "+cpm;

				to=setTimeout("update_stats()", 1000);
				if(win==0) {
					time=time+1;
				}
			}

		</script>
		<style type="text/css">
			p, textarea {
				font-family: Verdana, Arial, Sans-serif;
				font-size: 14pt;
			}
		</style>
	</head>
	<body>
		<h1>Here you go.</h1>
		<h2>Timing starts when you type the first character.</h2>
		<p id="displaytext"><?php echo $text; ?></p>
		<p style="display: none;"><textarea name="c" id="c"><?php echo $text;?></textarea></p>
		<p><textarea name="t" id="t" rows="3" cols="80" onkeyup="check();" ></textarea></p>
		<p><textarea name="stats" id="stats" rows="7" cols="80"></textarea></p>

		<script type="text/javascript">
			update_stats();
		</script>
	</body>
</html>

