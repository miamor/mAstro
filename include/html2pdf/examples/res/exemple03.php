<page backtop="10mm" backbottom="10mm" backleft="20mm" backright="20mm">
	<page_header>
		<div class="center"><? echo $name ?> natal report by mAstro</div>
	</page_header>
	<page_footer>
		<div class="center italic">Page [[page_cu]]/[[page_nb]]</div>
	</page_footer>

	<span style="font-size: 20px; font-weight: bold">Démonstration des retour à la ligne automatique, ainsi que des sauts de page automatique</span><br>

	<table style="width: 80%;border: solid 1px #5544DD; border-collapse: collapse" align="center">
		<thead>
			<tr>
				<th style="width: 30%; text-align: left; border: solid 1px #337722; background: #CCFFCC">Header 1</th>
				<th style="width: 30%; text-align: left; border: solid 1px #337722; background: #CCFFCC">Header 2</th>
			</tr>
		</thead>
		<tbody>
<?php
	for ($k=0; $k<13; $k++) {
?>
			<tr>
				<td style="width: 30%; text-align: left; border: solid 1px #55DD44">
					test de texte assez long pour engendrer des retours à la ligne automatique...
					a b c d e f g h i j k l m n o p q r s t u v w x y z
					a b c d e f g h i j k l m n o p q r s t u v w x y z
				</td>
				<td style="width: 70%; text-align: left; border: solid 1px #55DD44">
					test de texte assez long pour engendrer des retours à la ligne automatique...
					a b c d e f g h i j k l m n o p q r s t u v w x y z
					a b c d e f g h i j k l m n o p q r s t u v w x y z

				</td>
			</tr>
<?php
	}
?>
		</tbody>
		<tfoot>
			<tr>
				<th style="width: 30%; text-align: left; border: solid 1px #337722; background: #CCFFCC">Footer 1</th>
				<th style="width: 30%; text-align: left; border: solid 1px #337722; background: #CCFFCC">Footer 2</th>
			</tr>
		</tfoot>
	</table>
	<br>
	Ca marche !!!<br>
	refaisons un test : <br>
	<table style="width: 80%;border: solid 1px #5544DD">
<?php
	for ($k=0; $k<12; $k++) {
?>
		<tr>
			<td style="width: 30%; text-align: left; border: solid 1px #55DD44">
				test de texte assez long pour engendrer des retours à la ligne automatique...
				a b c d e f g h i j k l m n o p q r s t u v w x y z
				a b c d e f g h i j k l m n o p q r s t u v w x y z
			</td>
			<td style="width: 70%; text-align: left; border: solid 1px #55DD44">
				test de texte assez long pour engendrer des retours à la ligne automatique...
				a b c d e f g h i j k l m n o p q r s t u v w x y z
				a b c d e f g h i j k l m n o p q r s t u v w x y z

			</td>
		</tr>
<?php
	}
?>
	</table>
	<br>
	Ca marche toujours !<br>
	De plus, vous pouvez faire des sauts de page manuellement en utilisant les balises &lt;page&gt; &lt;/page&gt;, comme ici par exemple :
</page>
<page pageset="old">
	Nouvelle page !!!!
</page>
