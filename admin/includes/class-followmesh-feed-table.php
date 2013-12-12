<?php
if(!class_exists('WP_List_Table'))
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );

class FollowMesh_Feed_Table extends WP_List_Table {
	
	/** ************************************************************************
	 * @var array
	 **************************************************************************/
	public $example_data = array(
		array(
			'ID'				=> 1,
			'timestamp' => '26481368173',
			'name'			=> 'Bob',
			'user'			=> 'bob',
			'domain'		=> 'bob.example.com',
			'url'				=> 'http://bob.example.com/permalink',
			'update'		=> 'Hello World!'
		),
		array(
			'ID'				=> 2,
			'timestamp' => '36481368173',
			'name'			=> 'Bob',
			'user'			=> 'bob',
			'domain'		=> 'bob.example.com',
			'url'				=> 'http://bob.example.com/permalink',
			'update'		=> 'Hello World!'
		),
		array(
			'ID'				=> 3,
			'timestamp' => '46481368173',
			'name'			=> 'Bob',
			'user'			=> 'bob',
			'domain'		=> 'bob.example.com',
			'url'				=> 'http://bob.example.com/permalink',
			'update'		=> 'Hello World!'
		)
	);
		
	function __construct() {
		global $status, $page;
		parent::__construct( array(
			'singular' => 'Update',
			'plural'   => 'Feed',
			'ajax'     => false
		) );
	}
	
	/** ************************************************************************
	 * @param array $item A singular item (one full row's worth of data)
	 * @param array $column_name The name/slug of the column to be processed
	 * @return string Text or HTML to be placed inside the column <td>
	 **************************************************************************/
	function column_default( $item, $column_name ) {
		if ( array_key_exists( $column_name, $item ) ) {
			return $item[$column_name];
		} else {
			return print_r($item,true);
		}
	}
	
	/** ************************************************************************
	 * @see WP_List_Table::::single_row_columns()
	 * @param array $item A singular item (one full row's worth of data)
	 * @return string Text to be placed inside the column <td> (movie title only)
	 **************************************************************************/
	function column_timestamp($item){
		$actions = array(
			'visit'		 => sprintf('<a href="?page=%s&action=%id=%s">Visit</a>',$_REQUEST['page'],'visit',$item['ID'])
		);
		return sprintf('%1$s %2$s',
			/*$1%s*/ $item['timestamp'],
			/*$2%s*/ $this->row_actions($actions)
		);
	}
	
	/** ************************************************************************
	 * @see WP_List_Table::::single_row_columns()
	 * @return array An associative array containing column information: 'slugs'=>'Visible Titles'
	 **************************************************************************/
	function get_columns(){
		$columns = array(
			'timestamp'			 => 'Timestamp',
			'name'			=> 'Name',
			'update'		=> 'Update'
		);
		return $columns;
	}
		
	/** ************************************************************************
	 * @return array An associative array containing all the columns that should be sortable: 'slugs'=>array('data_values',bool)
	 **************************************************************************/
	function get_sortable_columns() {
		$sortable_columns = array(
			'name'			=> array('name',false),
			'timestamp' => array('timestamp',false)
		);
		return $sortable_columns;
	}
		
		
	/** ************************************************************************
	 * @uses $this->_column_headers
	 * @uses $this->items
	 * @uses $this->get_columns()
	 * @uses $this->get_sortable_columns()
	 * @uses $this->get_pagenum()
	 * @uses $this->set_pagination_args()
	 **************************************************************************/
	function prepare_items() {
		$per_page = 25;
		$columns = $this->get_columns();
		$hidden = array();
		$sortable = $this->get_sortable_columns();
		$this->_column_headers = array($columns, $hidden, $sortable);
		$data = $this->example_data;
		
		function usort_reorder($a,$b){
			$orderby = (!empty($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : 'timestamp';
			$order = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : 'desc';
			$result = strcmp($a[$orderby], $b[$orderby]);
			return ($order==='asc') ? $result : -$result;
		}
		usort($data, 'usort_reorder');
		
		$current_page = $this->get_pagenum();
		$total_items = count( $data );
		$data = array_slice( $data, ( ( $current_page-1 ) * $per_page ), $per_page );
		$this->items = $data;
		$this->set_pagination_args( array(
			'total_items' => $total_items,
			'per_page'    => $per_page,
			'total_pages' => ceil($total_items/$per_page)
		) );
	}
		
}

