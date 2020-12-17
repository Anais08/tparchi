<!doctype html> 
<html>
	<head> 
		<meta charset="utf-8">
	</head> 
	<body>
		<form method="POST">
			<input type="text" name="nom" placeholder="Nom"><br>
			<textarea name="commentaire" placeholder="Commentaire"></textarea><br>
			<input type="submit" value="Envoyer" name="envoyer">
		</form>
		<?php
			$lien=mysqli_connect("localhost","root","","tp");

			//Ajout d'un commentaire
			if(isset($_POST['envoyer']))
			{
				$nom=trim(htmlentities(mysqli_real_escape_string($lien,$_POST['nom'])));
				$commentaire=trim(htmlentities(mysqli_real_escape_string($lien,$_POST['commentaire'])));
				$req="INSERT INTO commentaires VALUES (NULL,'$nom','$commentaire')";
				$res=mysqli_query($lien,$req);
				if(!$res)
				{
					echo "Erreur SQL:$req<br>".mysqli_error($lien);
				}
			}
			
			//Quelle page je suis et quels commentaires prendre 
			if(!isset($_GET['page']))
			{
				$page=1;
			}
			else
			{
				$page=$_GET['page'];
			}
			$commparpage=5;
			$premiercomm=$commparpage*($page-1);//numero du premier commentaire sur une page a partir du numéro de la page 
			$req="SELECT * FROM commentaires ORDER BY id LIMIT $premiercomm,$commparpage";/* LIMIT dit ou je commence et combien j'en prends*/
			$res=mysqli_query($lien,$req);
			if(!$res)
			{
				echo "Erreur SQL:$req<br>".mysqli_error($lien);
			}
			else
			{
				while($tableau=mysqli_fetch_array($res))
				{
					echo "<h2>".$tableau['Nom']."</h2>";
					echo "<p>".$tableau['Commentaire']."</p>";
				}
			}
			
			//Affichage des numéros de page 
			$req="SELECT * FROM commentaires";
			$res=mysqli_query($lien,$req);
			if(!$res)
			{
				echo "Erreur SQL:$req<br>".mysqli_error($lien);
			}
			else
			{
				$nbcomm=mysqli_num_rows($res); // Retourne le nombre de lignes dans un résultat. 
				$nbpages=ceil($nbcomm/$commparpage); /*Ceil arrondit a l'entier supérieur*/
				echo "<br> Pages : ";

				//Affiche Début et précédent que quand on est pas à la première page 
				if ($page !=1)
				{
				echo "<a href='commentaires.php?page=1'> Début </a>";
				echo "<a href='commentaires.php?page=".($page-1)."'> Précédente </a>";
				$afficherPage = $page-2;
				}
				else
				{
					$afficherPage = $page;
				}




				

				if($page==1)
				{
					
					for($i=($page);$i<=($nbpages+5);$i++)
					{
						echo "<a href='commentaires.php?page=$i'> $i </a>";
					}
				}
				else if ($page==2)
				{
					for($i=($page-1);$i<=($nbpages+3);$i++)
					
					{
						echo "<a href='commentaires.php?page=$i'> $i </a>";

					}
				}

				else if($page==$nbpages-1)
				{
					for($i=($page-3);$i<=($nbpage+1);$i++)
					{
						echo "<a href='commentaires.php?page=$i'> $i </a>";
					}
				
				}
				else if ($page=$nbpages)
				{
					for($i=($page);$i<=($page+1);$i++)
					{
						echo "<a href='commentaires.php?page=$i'> $i </a>";
					}

				}










				else
				{
					for($i=$afficherPage;$i<=($page+2);$i++)
					{
					echo "<a href='commentaires.php?page=$i'> $i </a>";
					}
				}
				
			//Afficher Suivant et fin que quand on est pas à la dernière page
				if($page != $nbpages)
				echo "<a href='commentaires.php?page=".($page+1)."'> Suivante </a>";
				echo "<a href='commentaires.php?page=$nbpages'> Fin </a>";
			}
			mysqli_close($lien);
		?>	
	</body>
</html>