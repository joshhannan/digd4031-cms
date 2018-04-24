<?php
/**
* Class to handle articles
*/
class Article
{

	// Properties

	/**
	* @var int The article ID from the database
	*/
	public $id = null;

	/**
	* @var int When the article was published
	*/
	public $publicationDate = null;

	/**
	* @var string Full title of the article
	*/
	public $title = null;

	/**
	* @var string A short summary of the article
	*/
	public $summary = null;

	/**
	* @var string The HTML content of the article
	*/
	public $content = null;


	/**
	* Sets the object's properties using the values in the supplied array
	*
	* @param assoc The property values
	*/

	public function __construct( $data = array() ) {
		if ( isset( $data['id'] ) ) $this->id = (int) $data['id'];
		if ( isset( $data['publicationDate'] ) ) $this->publicationDate = (int) $data['publicationDate'];
		if ( isset( $data['title'] ) ) $this->title = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['title'] );
		if ( isset( $data['summary'] ) ) $this->summary = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['summary'] );
		if ( isset( $data['content'] ) ) $this->content = $data['content'];
	}


	/**
	* Sets the object's properties using the edit form post values in the supplied array
	*
	* @param assoc The form post values
	*/

	public function storeFormValues ( $params ) {
		// Store all the parameters
		$this->__construct( $params );

		// Parse and store the publication date
		if ( isset($params['publicationDate']) ) {
			$publicationDate = explode ( '-', $params['publicationDate'] );

			if ( count($publicationDate) == 3 ) {
				list ( $y, $m, $d ) = $publicationDate;
				$this->publicationDate = mktime ( 0, 0, 0, $m, $d, $y );
			}
		}
	}


	/**
	* Returns an Article object matching the given article ID
	*
	* @param int The article ID
	* @return Article|false The article object, or false if the record was not found or there was a problem
	*/

	public static function getById( $id ) {
		$conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
		$sql = "SELECT *, UNIX_TIMESTAMP(publicationDate) AS publicationDate FROM articles WHERE id = :id";
		$st = $conn->prepare( $sql );
		$st->bindValue( ":id", $id, PDO::PARAM_INT );
		$st->execute();
		$row = $st->fetch();
		$conn = null;
		if ( $row ) return new Article( $row );
	}


	/**
	* Returns all (or a range of) Article objects in the DB
	*
	* @param int Optional The number of rows to return (default=all)
	* @param string Optional column by which to order the articles (default="publicationDate DESC")
	* @return Array|false A two-element array : results => array, a list of Article objects; totalRows => Total number of articles
	*/

	public static function getList( $numRows=1000000, $order="publicationDate DESC" ) {
		$conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
		$sql = "SELECT SQL_CALC_FOUND_ROWS *, UNIX_TIMESTAMP(publicationDate) AS publicationDate FROM articles
			ORDER BY " . $order . " LIMIT :numRows";

		$st = $conn->prepare( $sql );
		$st->bindValue( ":numRows", $numRows, PDO::PARAM_INT );
		$st->execute();
		$list = array();

		while ( $row = $st->fetch() ) {
			$article = new Article( $row );
			$list[] = $article;
		}

		// Now get the total number of articles that matched the criteria
		$sql = "SELECT FOUND_ROWS() AS totalRows";
		$totalRows = $conn->query( $sql )->fetch();
		$conn = null;
		return $list;
	}


	/**
	* Inserts the current Article object into the database, and sets its ID property.
	*/

	public function insert() {

		// Does the Article object already have an ID?
		if ( !is_null( $this->id ) ) trigger_error ( "Article::insert(): Attempt to insert an Article object that already has its ID property set (to $this->id).", E_USER_ERROR );

		// Insert the Article
		$conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
		$sql = "INSERT INTO articles ( publicationDate, title, summary, content ) VALUES ( FROM_UNIXTIME(:publicationDate), :title, :summary, :content )";
		$st = $conn->prepare ( $sql );
		$st->bindValue( ":publicationDate", $this->publicationDate, PDO::PARAM_INT );
		$st->bindValue( ":title", $this->title, PDO::PARAM_STR );
		$st->bindValue( ":summary", $this->summary, PDO::PARAM_STR );
		$st->bindValue( ":content", $this->content, PDO::PARAM_STR );
		$st->execute();
		$this->id = $conn->lastInsertId();
		$conn = null;
	}


	/**
	* Updates the current Article object in the database.
	*/

	public function update() {

		// Does the Article object have an ID?
		if ( is_null( $this->id ) ) trigger_error ( "Article::update(): Attempt to update an Article object that does not have its ID property set.", E_USER_ERROR );

		// Update the Article
		$conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
		$sql = "UPDATE articles SET publicationDate=FROM_UNIXTIME(:publicationDate), title=:title, summary=:summary, content=:content WHERE id = :id";
		$st = $conn->prepare ( $sql );
		$st->bindValue( ":publicationDate", $this->publicationDate, PDO::PARAM_INT );
		$st->bindValue( ":title", $this->title, PDO::PARAM_STR );
		$st->bindValue( ":summary", $this->summary, PDO::PARAM_STR );
		$st->bindValue( ":content", $this->content, PDO::PARAM_STR );
		$st->bindValue( ":id", $this->id, PDO::PARAM_INT );
		$st->execute();
		$conn = null;
	}


	/**
	* Deletes the current Article object from the database.
	*/

	public function delete() {

		// Does the Article object have an ID?
		if ( is_null( $this->id ) ) trigger_error ( "Article::delete(): Attempt to delete an Article object that does not have its ID property set.", E_USER_ERROR );

		// Delete the Article
		$conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
		$st = $conn->prepare ( "DELETE FROM articles WHERE id = :id LIMIT 1" );
		$st->bindValue( ":id", $this->id, PDO::PARAM_INT );
		$st->execute();
		$conn = null;
	}
	 
	function editArticle() {
	 
		$results = array();
		$results['pageTitle'] = "Edit Article";
		$results['formAction'] = "editArticle";
	 
		if ( isset( $_POST['saveChanges'] ) ) {
	 
			// User has posted the article edit form: save the article changes			
			if( isset( $_GET['articleId'] ) ) :
				$article->storeFormValues( $_POST );
				$article->update();
			else :
				$article = new Article;
				$article->storeFormValues( $_POST );
				$article->insert();
			endif;
			
			header( "Location: admin.php?status=changesSaved" );
	 
		} elseif ( isset( $_POST['cancel'] ) ) {
	 
			// User has cancelled their edits: return to the article list
			header( "Location: admin.php" );
		} else {
	 
			// User has not posted the article edit form yet: display the form
			if( isset( $_GET['articleId'] ) ) :
				$results['article'] = Article::getById( (int)$_GET['articleId'] );
			endif;
		}
	 	
	 	return $results;
	}
	 
	 
	function deleteArticle() {
	 
		if ( !$article = Article::getById( (int)$_GET['articleId'] ) ) {
			header( "Location: admin.php?error=articleNotFound" );
			return;
		}
	 
		$article->delete();
		header( "Location: admin.php?status=articleDeleted" );
	}
	 
	 
	function listArticles() {
		$results = array();
		$data = Article::getList();
		$results['articles'] = $data['results'];
		$results['totalRows'] = $data['totalRows'];
		$results['pageTitle'] = "All Articles";
	 
		if ( isset( $_GET['error'] ) ) {
			if ( $_GET['error'] == "articleNotFound" ) $results['errorMessage'] = "Error: Article not found.";
		}
	 
		if ( isset( $_GET['status'] ) ) {
			if ( $_GET['status'] == "changesSaved" ) $results['statusMessage'] = "Your changes have been saved.";
			if ( $_GET['status'] == "articleDeleted" ) $results['statusMessage'] = "Article deleted.";
		}
	 
		require( TEMPLATE_PATH . "/admin/list.php" );
	}

}

?>