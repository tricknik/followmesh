<?php
if(!class_exists('WP_List_Table')){
		require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class FollowMesh_Followings_Table extends WP_List_Table {
		
		/** ************************************************************************
		 * @var array 
		 **************************************************************************/
		public $example_data = array(
			array(
				'ID'     => 1,
				'user'   => 'bob',
				'domain' => 'bob.example.com',
				'name'   => 'Bob'
			),
			array(
				'ID'     => 2,
				'user'   => 'bob',
				'domain' => 'bob.example.com',
				'name'   => 'Bob'
			),
			array(
				'ID'     => 3,
				'user'   => 'bob',
				'domain' => 'bob.example.com',
				'name'   => 'Bob'
			)
		);
		
		function __construct(){
				global $status, $page;
				
				parent::__construct( array(
					'singular'	=> 'Following',			//singular name of the listed records
					'plural'		=> 'Followings',		//plural name of the listed records
					'ajax'			=> false				//does this table support ajax?
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
		function column_name($item){
			$actions = array(
				'edit'     => sprintf('<a href="?page=%s&action=%s&movie=%s">Edit</a>',$_REQUEST['page'],'edit',$item['ID']),
				'unfollow' => sprintf('<a href="?page=%s&action=%s&movie=%s">Unfollow</a>',$_REQUEST['page'],'unfollow',$item['ID']),
			);
			return sprintf('%1$s <span style="color:silver">(id:%2$s)</span>%3$s',
				/*$1%s*/ $item['name'],
				/*$2%s*/ $item['ID'],
				/*$3%s*/ $this->row_actions($actions)
			);
		}
		
		/** ************************************************************************
		 * @see WP_List_Table::::single_row_columns()
		 * @param array $item A singular item (one full row's worth of data)
		 * @return string Text to be placed inside the column <td> (movie title only)
		 **************************************************************************/
		function column_cb($item){
			return sprintf(
				'<input type="checkbox" name="%1$s[]" value="%2$s" />',
				/*$1%s*/ $this->_args['singular'],
				/*$2%s*/ $item['ID']
			);
		}
		
		/** ************************************************************************
		 * @see WP_List_Table::::single_row_columns()
		 * @return array An associative array containing column information: 'slugs'=>'Visible Titles'
		 **************************************************************************/
		function get_columns(){
			$columns = array(
				'cb'     => '<input type="checkbox" />',
				'name'   => 'Name',
				'domain' => 'Domain',
				'user'   => 'User'
			);
			return $columns;
		}
		
		/** ************************************************************************
		 * @return array An associative array containing all the columns that should be sortable: 'slugs'=>array('data_values',bool)
		 **************************************************************************/
		function get_sortable_columns() {
			$sortable_columns = array(
				'name'   => array('name',false),
				'user'   => array('user',false),
				'domain' => array('domain',false)
			);
			return $sortable_columns;
		}
		
		/** ************************************************************************
		 * @return array An associative array containing all the bulk actions: 'slugs'=>'Visible Titles'
		 **************************************************************************/
		function get_bulk_actions() {
			$actions = array(
				'unfollow'		=> 'Unfollow'
			);
			return $actions;
		}
		
		/** ************************************************************************
		 * @see $this->prepare_items()
		 **************************************************************************/
		function process_bulk_action() {
			//Detect when a bulk action is being triggered...
			if( 'unfollow'===$this->current_action() ) {
				wp_die('Items deleted (or they would be if we had items to delete)!');
			}
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
			$this->process_bulk_action();
			$data = $this->example_data;

			function usort_reorder($a,$b){
				$orderby = (!empty($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : 'name';
				$order = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : 'asc';
				$result = strcmp($a[$orderby], $b[$orderby]);
				return ($order==='asc') ? $result : -$result;
			}
			usort($data, 'usort_reorder');
			
			$current_page = $this->get_pagenum();
			$total_items = count($data);
			$data = array_slice($data,(($current_page-1)*$per_page),$per_page);
			$this->items = $data;
			$this->set_pagination_args( array(
				'total_items' => $total_items,
				'per_page'		=> $per_page,
				'total_pages' => ceil($total_items/$per_page)
			) );
		}
		
}
