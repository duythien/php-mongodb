<?php namespace Blog\DB;

class DB {

	/**
	* Return db
	* @var object
	*/
	private $db;
	/**
	* Results limit.
	* @var integer
	*/
    public $limit = 5;

	
	public function __construct($config){

		$this->connect($config);	
	}

	private function connect($config){
		try{
			if ( !class_exists('Mongo')){
	            echo ("The MongoDB PECL extension has not been installed or enabled");
	            return false;
	        }
			$connection=  new \MongoClient($config['connection_string'],array('username'=>$config['username'],'password'=>$config['password']));
	    	return $this->db = $connection->selectDB($config['dbname']);
		}catch(Exception $e) {
			return false;
		}
	}
	/**
	 * get one article by id
	 * @return array
	 */
	public function getById($id,$collection){
		// Convert strings of right length to MongoID
		if (strlen($id) == 24){
			$id = new \MongoId($id);
		}
		$table = $this->db->selectCollection($collection);
		$cursor  = $table->find(array('_id' => $id));
		$article = $cursor->getNext();

		if (!$article ){
			return false ;
		}
		return $article;
	}
	/**
	 * get all data in collection and paginator
	 *
	 * @return multi array 
	 */
	public function get($page,$collection){

		$currentPage = $page;
		$articlesPerPage = $this->limit;

		//number of article to skip from beginning
		$skip = ($currentPage - 1) * $articlesPerPage; 

		$table = $this->db->selectCollection($collection);

		$cursor = $table->find();
		//total number of articles in database
		$totalArticles = $cursor->count(); 
		//total number of pages to display
		$totalPages = (int) ceil($totalArticles / $articlesPerPage); 

		$cursor->sort(array('saved_at' => -1))->skip($skip)->limit($articlesPerPage);
		//$cursor = iterator_to_array($cursor);
		$data=array($currentPage,$totalPages,$cursor);

		return $data;
	}
	/**
	 * Create article
	 * @return boolean
	 */
	public function create($collection,$article){

		$table 	 = $this->db->selectCollection($collection);
		return $result = $table->insert($article);
	}
	/**
	 * delete article via id
	 * @return boolean
	 */
	public function delete($id,$collection){
		// Convert strings of right length to MongoID
		if (strlen($id) == 24){
			$id = new \MongoId($id);
		}
		$table 	 = $this->db->selectCollection($collection);
		$result = $table->remove(array('_id'=>$id));
		if (!$id){
			return false;
		}
		return $result;

	}
	/**
	 * Update article
	 * @return boolean
	 */
	public function update($id,$collection,$article){
		// Convert strings of right length to MongoID
		if (strlen($id) == 24){
			$id = new \MongoId($id);
		}
		$table 	 = $this->db->selectCollection($collection);
		$result  = $table->update(
				array('_id' => new \MongoId($id)), 
				array('$set' => $article)
		);
		if (!$id){
			return false;
		}
		return $result;

	}
	/**
	 * create and update comment
	 * @return boolean
	 */
	public function commentId($id,$collection,$comment){
		
		$postCollection = $this->db->selectCollection($collection);
		$post = $postCollection->findOne(array('_id' => new \MongoId($id)));

		if (isset($post['comments'])) {
			$comments = $post['comments'];
		}else{
			$comments = array();
		}	                
		array_push($comments, $comment);

		return $postCollection->update(
						array('_id' => new \MongoId($id)), 
						array('$set' => array('comments' => $comments))
		);
	}

}
