 <?php    

function createComment(string $post, string $author, string $comment)
{
	$database = dbConnect();
	$statement = $database->prepare(
    	'INSERT INTO comments(post_id, author, comment, comment_date) VALUES(?, ?, ?, NOW())'
	);
	$affectedLines = $statement->execute([$post, $author, $comment]);

	return ($affectedLines > 0);
}


 function getPosts(){
      $bdd=dbConnect();

      // On récupère les 5 derniers billets
      $req = $bdd->query('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date FROM posts ORDER BY creation_date DESC LIMIT 0, 5');

		$posts = [];
		while (($row = $req->fetch())) {
			$post = [
				'id' => $row['id'],
				'title' => $row['title'],
				'french_creation_date' => $row['creation_date'],
				'content' => $row['content'],
			];

			$posts[] = $post;
		}
		return $posts;
 }	

function getPost($id) {
	$database = dbConnect();
	$statement = $database->prepare(
    	"SELECT id, title, content, DATE_FORMAT(creation_date, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date 
		FROM posts 
		WHERE id = ?"
	);
	$statement->execute([$id]);

	$row = $statement->fetch();
	$post = [
		'identifier' => $row['id'],
    		'title' => $row['title'],
    		'french_creation_date' => $row['french_creation_date'],
    		'content' => $row['content'],
	];
	return $post;
}

// Nouvelle fonction qui nous permet d'éviter de répéter du code
// Connexion à la base de données

function dbConnect()
{
    try {
        $database = new PDO('mysql:host=localhost;dbname=mvc1;charset=utf8', 'root', '');

        return $database;
    } catch(Exception $e) {
        die('Erreur : '.$e->getMessage());
    }
}	

function getComments($identifier)
{
 
 	$database = dbConnect();
    $statement = $database->prepare(
        "SELECT comments.id,comment, DATE_FORMAT(comment_date, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date,user.prenom FROM comments,user WHERE post_id = 1 AND user.id = comments.author AND author = 1  ORDER BY comment_date DESC"
    );
    $statement->execute([$identifier]);
 
    $comments = [];
    while (($row = $statement->fetch())) {
        $comment = [
            'author' => $row['prenom'],
            'french_creation_date' => $row['french_creation_date'],
            'comment' => $row['comment'],
        ];
        $comments[] = $comment;
    }

    return $comments;
}

function Test_connexion(string $login, string $password)
{
    $database = dbConnect();
	$statement = $database->prepare("SELECT * FROM `user` where login = ? and mdp = ? ");
	$affectedLines = $statement->execute([$login, $password]);
    $user = [];
    while (($row = $statement->fetch())) {
        $user = [
             'id' => $row['id'],
             'login' => $row['login'],
            'nom' => $row['nom'],
            'prenom' => $row['prenom'],
            'email' => $row['email'],
        ];
}
    return $user;

}

		?>
