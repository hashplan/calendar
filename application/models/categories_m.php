<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categories_m extends MY_Model {

	public function get_top_level_categories() {
		// i'm using conventional query, as CI always escape LIKE arguments
		$query = '
			SELECT c.* FROM categories c WHERE path LIKE "____." ORDER BY path
		';
		return $this->db->query($query)->result();
	}

	public function get_child_categories($category_id) {
		$query = '
			SELECT c.*
			FROM categories c
			WHERE c.path LIKE CONCAT(
				(SELECT c2.path FROM categories c2 WHERE c2.id = '. $this->db->escape($category_id) .'), "%"
			)
			ORDER BY c.path
		';

		return $this->db->query($query)->result();
	}
}