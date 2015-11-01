<?php
class BooksController extends AppController {

	var $name = 'Books';
	var $helpers = array('Html', 'Form');

	function beforeFilter() # REQUIRE they put in a school name., but if logged in, messes up, so just restrict by url
	{
		$this->Auth->allow('*');
		parent::beforeFilter();
		#error_log("CHILD BEFORE");
		# Let them put in the school name....
		# CHECK FOR SCHOOL NAME
		# IF NO SCHOOL NAME SET, GO TO INPUT PAGE (unless ON input page!)

		# Now check to see if school_id check somehow... if not, send to selector page.
		#$school_id = $this->get_school_id(); # checks account too
		#error_log("SCHOOL_ID FOR FILTER=$school_id");

		#if ($school_id == "" && $this->action != 'index')
		#{
		#	$this->setAction("index");
		#} 

	}

	function index() {
		#$this->Book->recursive = 0;
		#$this->set('books', $this->paginate());
		#$this->redirect("/pages");
		# Show school selector page.

		#error_log("AT INDEX");

		if (!empty($this->data) && $this->data["School"]["school_id"] != "")
		{
			#error_log("SCHOOLID=".$this->data["School"]["school_id"]);
			$this->Session->write("school_id", $this->data["School"]["school_id"]);
			$this->redirect(array('controller'=>"books", 'action'=>"home"));
		} # If chosen, send home, otherwise, show splash page again.

		$this->set("schools", $this->School->findAll());
		$this->layout = "splash";
	}

	function home()
	{
		$school_id = $this->get_school_id(); # checks account too
		error_log("SCHOOL_ID FOR FILTER=$school_id");
	}

	function all() {
		$this->Book->recursive = 0;
		$this->set('books', $this->paginate());
	}

	function search($keywords = null)
	{
		if (!$keywords)
		{
			$this->setAction("buy");
		} else {
			$this->Book->recursive = 0;
			$this->set('books', $this->paginate('Book',"title LIKE '%$keywords%' OR author LIKE '%$keywords%'"));
		}
	}

	function topsellers()
	{
		# Confine pricing by current school...
		# XXX TODO
		$school_id = $this->get_school_id(); # checks account too
		$this->Book->set_school($school_id);
		return $this->Book->get_topsellers();
	}

	function topsellers_xml($school_id = null)
	{
		error_log("LOADED");
		header('Content-Type: text/xml');
		if ($school_id == '') { echo "<topteninfo error='No school_id specified'/>"; exit(0); }
		$this->Book->set_school($school_id);
		$topsellers = $this->Book->get_topsellers(10);
		echo "<topteninfo>\n";
		foreach ($topsellers as $topseller)
		{
			$book_id = $topseller['books']['book_id'];
			echo "\t<bookinfo>\n";
			echo "\t\t<coverlocation>/books/cover/full/$book_id</coverlocation>\n";
			echo "\t\t<author>".$topseller['books']['author']."</author>\n";
			echo "\t\t<title>".$topseller['books']['title']."</title>\n";
			echo "\t\t<bookLink>$_SERVER[HTTP_HOST]/books/view/$book_id</bookLink>\n";
			echo "\t</bookinfo>\n";
		}
		echo "</topteninfo>\n";
		exit(0);
	}



	function amazon($isbn)
	{
		$xml = $this->Book->get_amazon_xml($isbn);
		if (!$xml) { echo "Invalid ISBN"; exit(0); }
		#$xml = preg_replace("/></", ">\n<", $xml);
		#header('Content-Type: text/plain');
		header('Content-Type: text/xml');
		echo $xml;
		#error_log(print_r($this->Book->parse_amazon_xml($xml), true));

		exit(0);
	}

	function amazon_info($isbn)
	{
		header('Content-Type: text/plain');
		$info = $this->Book->get_amazon_bookinfo($isbn);
		print_r($info);
		exit(0);
	}

	function amazon_update($isbn)
	{
		$this->Book->retrieve_info_byisbn($isbn); # Update no matter what...
		$book = $this->Book->ensure_and_find_byisbn($isbn);
		$this->set("book", $book);
		$this->action = "view";
	}

	function view_byisbn($isbn = null)
	{
		# XXX TODO add in error page saying not available.

		#error_log(print_r($this->params['form'], true));
		if (!empty($this->params['form'])) { $isbn = $this->params['form']["isbn"]; }
		#error_log("CALLED VIEW_BYISBN, ISBN=$isbn\n");

		if (!$isbn)
		{
			$this->Session->setFlash(__('Invalid book or not available. Please try again.', true));
			$this->redirect(array('controller'=>"books", 'action'=>"buy"));
		}

		$isbn13 = $this->Book->get_isbn13($isbn);

		#$this->Book->school_id = $this->get_school_id(); # So only see for current school...
		#$where_school = $this->Book->where_school("active_listing");
		#error_log("WHERE_SCHOOL=$where_school");
		#$book = $this->Book->find("isbn13 = '$isbn13' $where_school");
		$this->Book->set_school($this->get_school_id());
		$book = $this->Book->find("isbn13 = '$isbn13'");
		if (!$book)
		{
			$this->Session->setFlash(__('Invalid book or not available. Please try another.', true));
			#$this->redirect("/pages");
			$this->redirect(array('controller'=>"books", 'action'=>"buy"));
		}
		$this->set('book', $book);
		$this->action = "view"; # Show view page....
	}

	function view($id = null, $compare = '') {
		if (!$id) {
			$this->Session->setFlash(__('Invalid book or not available. Please try another.', true));
			$frompage = $this->data["frompage"];
			if ($frompage != "")
			{
				$this->redirect($frompage); # Go back to search form, if given.
			} else {
				$this->redirect(array('controller'=>"pages", 'action'=>"index"));
			}
		}
		#$this->Book->school_id = $this->get_school_id(); # So only see for current school...
		#$where_school = $this->Book->where_school("active_listing");
		#error_log("WHERE_SCHOOL=$where_school");
		#$book = $this->Book->find("book_id = '$id' $where_school");

		$this->Book->set_school($this->get_school_id());
		$book = $this->Book->find("book_id = '$id'");
		$this->set('book', $book);
		$amazon_compare_info = array();

		if ($compare == 'compare')
		{
			$amazon_compare_info = $this->Book->get_amazon_compare_info($book['Book']['isbn13']);
		}
		$this->set("compare_mode", $compare);
		$this->set('amazon_compare_info', $amazon_compare_info);
	}

	function buy($isbn = null) # Whether keyword (in title) OR isbn...
	{

		# Submits to view_byisbn
		#error_log("FORM=".print_r($this->params['form'], true));
		if (!$isbn && isset($this->params['form']['isbn'])) { $isbn = $this->params['form']['isbn']; }

		if ($isbn && $this->Book->is_isbn($isbn)) { $this->setAction("view_byisbn", $isbn); }
		else if ($isbn) { $this->setAction("search", $isbn); } # Keyword.... may be multiple items.
		# Otherwise show form...
	}

	function sell($isbn = null)
	{
		# XXX may want to change logic so retrieves and saves info locally so page ALWAYS shows book
		# even if book doesn't exist yet....

		# Whether available or not, let them sell it!
		# If available, pull up existing book info.
		if (!$isbn && !empty($this->params['form']))
		{
			$isbn = $this->params['form']["isbn"];
			#$this->redirect("/books/sell/$isbn"); # Redirect so friendly url for logging in.
			#$this->redirect(array('controller'=>"active_listings", 'action'=>"add", $isbn));
		}

		#error_log(print_r($this->params['form'],true));

		#error_log("ISBN=$isbn, RETURN?");

		if (!$isbn) { return; } # Display form.

		$isbn13 = $this->Book->get_isbn13($isbn);
		$isbn10 = $this->Book->get_isbn10($isbn);

		#error_log("10=$isbn10");

		# Retrieve book from third-party source if not available
		# Search.
		if (!$isbn10 || $isbn10 == 0)
		{
			$this->Session->setFlash(__('Please enter a proper ISBN only. Please try again.', true));
			return;
		} 
		# Should not only refuse to search for, but search should exit gracefully... (since invalid entry)

		$book = $this->Book->ensure_and_find_byisbn($isbn13);
		if (!$book) # Not Found
		{
			$this->Session->setFlash(__('Invalid book or not available. Please try again.', true));
		} else { # FOUND!
			# display page to buy, then append form to add 
			#$this->set("book", $book);
			#$this->set("isbn", $isbn13);
			#$this->action = "sell_submit";
			$this->redirect("/active_listings/add/$isbn13");
		}
	}

	function sell_submit()
	{
		if (empty($this->data))
		{
			$this->Session->setFlash(__('Invalid operation.', true));
			#$this->redirect("/books/sell");
			$isbn = $this->get("isbn");
			$this->redirect(array('controller'=>"active_listings", 'action'=>"add", $isbn));
		} else {
			# Process adding book listing....
		}
	}

	function add() {
		if (!empty($this->data)) {
			$this->Book->create();
			if ($this->Book->save($this->data)) {
				$this->Session->setFlash(__('The Book has been saved', true));
				$this->redirect(array('action'=>'home'));
			} else {
				$this->Session->setFlash(__('The Book could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Book', true));
			$this->redirect(array('action'=>'home'));
		}
		if (!empty($this->data)) {
			if ($this->Book->save($this->data)) {
				$this->Session->setFlash(__('The Book has been saved', true));
				$this->redirect(array('action'=>'home'));
			} else {
				$this->Session->setFlash(__('The Book could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Book->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Book', true));
			$this->redirect(array('action'=>'home'));
		}
		if ($this->Book->del($id)) {
			$this->Session->setFlash(__('Book deleted', true));
			$this->redirect(array('action'=>'home'));
		}
	}


	function admin_index() {
		$this->Book->recursive = 0;
		$this->set('books', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Book.', true));
			$this->redirect(array('action'=>'home'));
		}
		$this->set('book', $this->Book->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Book->create();
			if ($this->Book->save($this->data)) {
				$this->Session->setFlash(__('The Book has been saved', true));
				$this->redirect(array('action'=>'home'));
			} else {
				$this->Session->setFlash(__('The Book could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Book', true));
			$this->redirect(array('action'=>'home'));
		}
		if (!empty($this->data)) {
			if ($this->Book->save($this->data)) {
				$this->Session->setFlash(__('The Book has been saved', true));
				$this->redirect(array('action'=>'home'));
			} else {
				$this->Session->setFlash(__('The Book could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Book->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Book', true));
			$this->redirect(array('action'=>'home'));
		}
		if ($this->Book->del($id)) {
			$this->Session->setFlash(__('Book deleted', true));
			$this->redirect(array('action'=>'home'));
		}
	}

	function get_coverpath($abs = false)
	{
		$img = "webroot/img";
		$coverfolder = "$img/bookcovers";
		if ($abs) { return APP . $coverfolder; }
		else { return $coverfolder; }
	}

	function cover($size, $isbn)
	{
		# WILL LOOK FOR BOTH ISBN13 and ISBN10 files....
		$isbn10 = $this->Book->get_isbn10($isbn);
		$isbn13 = $this->Book->get_isbn13($isbn);

		$ext = "jpg";
		$file = "";

		$coverfolder = $this->get_coverpath();
		$abscoverfolder = $this->get_coverpath(true);

		$this->view = 'Media';
		
		# Will show 
		if ($size == 'full')
		{
			$file = "$coverfolder/../books-sm.$ext"; #default
			#error_log("$abscoverfolder/$isbn.$ext");
			if (file_exists("$abscoverfolder/$isbn13.$ext"))
			{
				$file = "$coverfolder/$isbn13.$ext";
			}
			else if (file_exists("$abscoverfolder/$isbn10.$ext"))
			{
				$file = "$coverfolder/$isbn10.$ext";
			}

		} else { # if ($size == 'thumb') # default to thumb.
			$file = "$coverfolder/../books-icon.$ext"; #default
			if (file_exists("$abscoverfolder/thumbs/$isbn13.$ext"))
			{
				$file = "$coverfolder/thumbs/$isbn13.$ext";
			}
			else if (file_exists("$abscoverfolder/thumbs/$isbn10.$ext"))
			{
				$file = "$coverfolder/thumbs/$isbn10.$ext";
			}
		}

		$params = array(
			'id' => basename($file),
			'name' => '',
			'download' => false,
			'extension' => $ext,
			'path' => dirname($file) . DS
		);

		$this->set($params);
	}

}
?>
