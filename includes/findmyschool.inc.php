<?php
	require_once("includes/util.inc.php");

	/**
	*	Fonction d'affichage des résultats en fonction des critères sélectionnés
	*	Arguments:
	*	$n: Colonne selon laquelle trier (par défaut 17 = Académie)
	*	$page: page à afficher
	*/
	function find_my_school($n = 17, $page = 0) {
		@session_start();							// Démarrage d'une session pour utiliser $_SESSION['parsed'] et $_SESSION['liste']

		if (isset($_GET['page']))					// Si une page est spécifiée dans l'URL ($_GET), alors on affichera celle-ci
			$page = $_GET['page'];


		if (isset($_POST['liste'])) {				// Si on a spécifié un critère de tri dans le menu déroulant, alors on reset la page
			$_SESSION['liste'] = $_POST['liste'];
			$page = 0;
			$reset = true;
		}
		else
			$reset = false;							// Sinon, on initialise $reset à false

		if ($page == 49.3) {						// Easter egg
			echo "<img src=\"images/manu.jpg\" style=\"display: block; margin: auto;\" alt=\"manu\" />";
			return;
		}

		$toprint = array();
		foreach ($_SESSION['parsed'] as $key => $row)		// Inversion des lignes et des colonnes pour trier avec array_multisort()
						for ($i = 0; $i < 26; $i++)
							$tab[$i][$key] = $row[$i];

		array_multisort($tab[$n], SORT_ASC, $_SESSION['parsed']);	// On trie avec array_multisort() en fonction de la colonne envoyée en paramètre

		for ($i = 1; $i < 3659; $i++)	// On parcourt tout le tableau parsé et on met en page chaque ligne
			if ((isset($_SESSION['liste']) && ($_SESSION['liste'] == $_SESSION['parsed'][$i][$n] || $_SESSION['liste'] == "tout")) && (isset($_GET['page']) || isset($_POST['liste'])))
				$toprint[] = get_tabled_parsed($_SESSION['parsed'][$i]);

		print_pages($toprint, $reset);				// On affiche une première fois les pages, avant les résultats

		for ($i = 0; $i < 10; $i++)					// On affiche tous les résultats de la page actuelle
			if (isset($toprint[$i + $page * 10]))
				echo $toprint[$i + $page * 10];

		print_pages($toprint, $reset);				// On affiche une seconde fois les pages, après les résultats
	}

// A REFAIRE \\
	function find_my_school_advance() {
		@session_start();
		if (!isset($_POST['academie']))
			return;
		foreach ($_SESSION['parsed'] as $key => $row)
						for ($i = 0; $i < 26; $i++)
							$tab[$i][$key] = $row[$i];

		array_multisort($tab[17], SORT_ASC, $_SESSION['parsed']);

		for ($i = 1; $i < 3659; $i++) {
			if ((($_POST['academie'] == "tout") || ($_POST['academie'] == $_SESSION['parsed'][$i][17])) && (($_POST['region'] == "tout") || ($_POST['region'] == $_SESSION['parsed'][$i][18])) && (($_POST['ville'] == "tout") || ($_POST['ville'] == $_SESSION['parsed'][$i][11])) && (($_POST['type'] == "tout") || ($_POST['type'] == $_SESSION['parsed'][$i][2])))
				echo get_tabled_parsed($_SESSION['parsed'][$i]);
		}
	}
?>