<?php
/**
* Class to handle pages
*/
Class Page {

	// Properties

	/**
	* @var int The page ID from the database
	*/
	public $id = null;

	/**
	* @var int When the page was published
	*/
	public $publicationDate = null;

	/**
	* @var string Full title of the page
	*/
	public $title = null;

	/**
	* @var string A short summary of the page
	*/
	public $summary = null;

	/**
	* @var string The HTML content of the page
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
		if ( isset( $data['slug'] ) ) $this->slug = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['slug'] );
		if ( isset( $data['template'] ) ) $this->template = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['template'] );
		if ( isset( $data['summary'] ) ) $this->summary = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['summary'] );
		if ( isset( $data['content'] ) ) $this->content = $data['content'];
	}

	function get_file( $file = '' ) {
		$url = SITE_URL;
		if( !empty( $file ) ) :
			$url .= $file;
		endif;

		return $url;
	}

	function get_url( $slug = '' ) {

		$url = SITE_URL;
		if( !empty( $slug ) ) :
			$url .= $slug;
		endif;

		return $url;
	}

	function get_page() {
		$obj = array();
		$obj['slug'] = trim($_SERVER['REQUEST_URI'], '/');

		if( $obj['slug']  === '' ) {
			$obj['slug'] = 'home';
		} else if( $obj['slug'] === 'login' ) {
			$obj['slug'] = 'login';
			$obj['data']['template'] = 'login';
		}

		$conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );

		$slug = $obj['slug'];
		$sql = "SELECT * FROM pages WHERE slug='$slug'";

		$st = $conn->prepare( $sql );
		$st->bindValue( ":slug", $slug, PDO::PARAM_STR );
		$st->execute();
		$row = $st->fetch();
		$conn = null;
		if( $row ) {
			$obj['data'] = $row;
			$obj['route'] = $row['slug'];
			$obj['pageTitle'] = $row['title'];
		} else if( $obj['data']['template'] == 'login' ) {
			$obj['route'] = 'login';
			$obj['pageTitle'] = 'Login';
		} else {
			$obj['data'] = null;
		}

		return $obj;
	}

	function get_page_object( $page ) {
		$obj = array();
		$obj['slug'] = trim($_SERVER['REQUEST_URI'], '/');
		if( !empty( $page ) ) :
			$obj['route'] = $page;
			$obj['pageTitle'] = ucwords( $page );
		else:
			$obj['route'] = 'default';
			$obj['pageTitle'] = 'Default';
		endif;
		
		$template = $this->get_page_template( $obj );
		$obj['template'] = $template;

		return $obj;
	}

	function get_page_template( $tpl_name = 'home' ) {

		if( !empty( $tpl_name ) ) :
			if( $tpl_name == 'login' && file_exists( ADMIN_PATH . "/login.php" ) ) :
				$template = ADMIN_PATH . '/login.php';
			else :
				if( file_exists( FRONTEND_PATH . "/" . $tpl_name . ".php" ) ) :
					$template = FRONTEND_PATH . "/" . $tpl_name . ".php";
				else :
					$template = FRONTEND_PATH . "/index.php";
				endif;
			endif;
		else :
			$template = FRONTEND_PATH . "/home.php";
		endif;

		return $template;

	}

	function get_header() {
		require FRONTEND_PATH . '/includes/header.php';
	}

	function get_footer() {
		require FRONTEND_PATH . '/includes/footer.php';
	}

	/**
	* Returns an Page object matching the given article ID
	*
	* @param int The page ID
	* @return Page|false The page object, or false if the record was not found or there was a problem
	*/

	public static function getById( $id ) {
		$conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
		$sql = "SELECT * FROM pages WHERE id = '$id'";
		$st = $conn->prepare( $sql );
		$st->bindValue( ":id", $id, PDO::PARAM_INT );
		$st->execute();
		$row = $st->fetch();
		$conn = null;
		if ( $row ) return new Page( $row );
	}

	/**
	* Returns all (or a range of) Page objects in the DB
	*
	* @param int Optional The number of rows to return (default=all)
	* @param string Optional column by which to order the pages (default="publicationDate DESC")
	* @return Array|false A two-element array : results => array, a list of Page objects; totalRows => Total number of pages
	*/

	public static function getList( $numRows=1000000, $order="publicationDate DESC" ) {
		$conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
		$sql = "SELECT SQL_CALC_FOUND_ROWS *, UNIX_TIMESTAMP(publicationDate) AS publicationDate FROM pages
			ORDER BY " . $order . " LIMIT :numRows";

		$st = $conn->prepare( $sql );
		$st->bindValue( ":numRows", $numRows, PDO::PARAM_INT );
		$st->execute();
		$list = array();

		while ( $row = $st->fetch() ) {
			$page = new Page( $row );
			$list[] = $page;
		}

		// Now get the total number of pages that matched the criteria
		$sql = "SELECT FOUND_ROWS() AS totalRows";
		$totalRows = $conn->query( $sql )->fetch();
		$conn = null;
		return $list;
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
	* Inserts the current Page object into the database, and sets its ID property.
	*/

	public function insert() {

		// Does the Page object already have an ID?
		if ( !is_null( $this->id ) ) trigger_error ( "Page::insert(): Attempt to insert an Page object that already has its ID property set (to $this->id).", E_USER_ERROR );

		// Insert the Page
		$conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
		$sql = "INSERT INTO pages ( publicationDate, title, slug, template, summary, content ) VALUES ( FROM_UNIXTIME(:publicationDate), :title, :slug, :template, :summary, :content )";
		$st = $conn->prepare ( $sql );
		$st->bindValue( ":publicationDate", $this->publicationDate, PDO::PARAM_INT );
		$st->bindValue( ":title", $this->title, PDO::PARAM_STR );
		$st->bindValue( ":slug", $this->slug, PDO::PARAM_STR );
		$st->bindValue( ":template", $this->template, PDO::PARAM_STR );
		$st->bindValue( ":summary", $this->summary, PDO::PARAM_STR );
		$st->bindValue( ":content", $this->content, PDO::PARAM_STR );
		$st->execute();
		$this->id = $conn->lastInsertId();
		$conn = null;
	}


	/**
	* Updates the current Page object in the database.
	*/

	public function update() {

		// Does the Page object have an ID?
		if ( is_null( $this->id ) ) trigger_error ( "Page::update(): Attempt to update an Page object that does not have its ID property set.", E_USER_ERROR );

		// Update the Page
		$conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
		$sql = "UPDATE pages SET publicationDate=FROM_UNIXTIME(:publicationDate), title=:title, slug=:slug, template=:template, summary=:summary, content=:content WHERE id = :id";
		$st = $conn->prepare ( $sql );
		$st->bindValue( ":publicationDate", $this->publicationDate, PDO::PARAM_INT );
		$st->bindValue( ":title", $this->title, PDO::PARAM_STR );
		$st->bindValue( ":slug", $this->slug, PDO::PARAM_STR );
		$st->bindValue( ":template", $this->template, PDO::PARAM_STR );
		$st->bindValue( ":summary", $this->summary, PDO::PARAM_STR );
		$st->bindValue( ":content", $this->content, PDO::PARAM_STR );
		$st->bindValue( ":id", $this->id, PDO::PARAM_INT );
		$st->execute();
		$conn = null;

	}


	/**
	* Deletes the current Page object from the database.
	*/

	public function delete() {

		// Does the Page object have an ID?
		if ( is_null( $this->id ) ) trigger_error ( "Page::delete(): Attempt to delete an Page object that does not have its ID property set.", E_USER_ERROR );

		// Delete the Page
		$conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
		$st = $conn->prepare ( "DELETE FROM pages WHERE id = :id LIMIT 1" );
		$st->bindValue( ":id", $this->id, PDO::PARAM_INT );
		$st->execute();
		$conn = null;
	}

	function newPage() {
	 
		$results = array();
		$results['pageTitle'] = "New Page";
		$results['formAction'] = "newPage";
	 
		if ( isset( $_POST['saveChanges'] ) ) {
	 
			// User has posted the page edit form: save the new page
			$page = new Page;
			$page->storeFormValues( $_POST );
			$page->insert();
			header( "Location: admin.php?status=changesSaved" );
	 
		} elseif ( isset( $_POST['cancel'] ) ) {
	 
			// User has cancelled their edits: return to the page list
			header( "Location: admin.php" );
		} else {
	 
			// User has not posted the page edit form yet: display the form
			$results['page'] = new Page;
			require( TEMPLATE_PATH . "/admin/pages/edit.php" );
		}
	 
	}
	 
	 
	function editPage() {
	 
		$results = array();
		$results['pageTitle'] = "Edit Page";
		$results['formAction'] = "editPage";
	 
		if ( isset( $_POST['saveChanges'] ) ) {
	 
			// User has posted the page edit form: save the page changes
			if( isset( $_GET['pageId'] ) ) :
				$page->storeFormValues( $_POST );
				$page->update();
			else :
				$page = new Page;
				$page->storeFormValues( $_POST );
				$page->insert();
			endif;
			
			header( "Location: admin.php?status=changesSaved" );
	 
		} elseif ( isset( $_POST['cancel'] ) ) {
	 
			// User has cancelled their edits: return to the page list
			header( "Location: admin.php" );
		} else {
	 
			// User has not posted the article edit form yet: display the form
			if( isset( $_GET['pageId'] ) ) :
				$results['page'] = Article::getById( (int)$_GET['pageId'] );
			endif;
		}
	 
	}
	 
	 
	function deletePage() {
	 
		if ( !$page = Page::getById( (int)$_GET['pageId'] ) ) {
			header( "Location: admin.php?error=pageNotFound" );
			return;
		}
	 
		$page->delete();
		header( "Location: admin.php?status=pageDeleted" );
	}

}