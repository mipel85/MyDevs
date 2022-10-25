<?php
/**
 * @copyright   &copy; 2005-2022 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Julien BRISWALTER <j1.seth@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2021 03 15
 * @since       PHPBoost 4.0 - 2014 08 24
 * @contributor Sebastien LARTIGUE <babsolune@phpboost.com>
*/

class ReviewCacheInTable implements CacheData
{
	private $files_in_content = array();
	private $files_in_upload = array();
	private $files_in_gallery = array();

	public function synchronize()
	{
		$this->files_in_content = array();
		$this->files_in_upload = array();
		$this->files_in_gallery = array();

		if (ModulesManager::is_module_installed('review') && ModulesManager::is_module_activated('review')) 
		{
			$result_files_in_content = PersistenceContext::get_querier()->select('SELECT review.*
			FROM ' . ReviewSetup::$files_incontenttable . ' review
			ORDER BY id ASC');

			$i = 1;
			foreach ($result_files_in_content as $row)
			{
				$this->files_in_content[$i] = array(
					'id' 				 => $row['id'],
					'file_path' 		 => $row['file_path'],
					'file_link' 		 => $row['file_link'],
					'file_size' 		 => $row['file_size'],
					'upload_by' 		 => $row['upload_by'],
					'upload_date' 		 => $row['upload_date'],
					'module_source' 	 => $row['module_source'],
					'id_module_category' => $row['id_module_category'],
					'category_name' 	 => $row['category_name'],
					'item_id' 			 => $row['item_id'],
					'item_title' 		 => $row['item_title'],
					'id_in_module' 		 => $row['id_in_module'],
				);
				$i++;
			}
			$result_files_in_content->dispose();
		}
		
		$result_files_in_upload = PersistenceContext::get_querier()->select('SELECT upload.*, member.display_name
		FROM ' . DB_TABLE_UPLOAD . ' upload
		LEFT JOIN ' . DB_TABLE_MEMBER . ' member ON upload.user_id = member.user_id
		ORDER By upload.id');

		$i = 1;
		foreach($result_files_in_upload as $row)
		{
			$this->files_in_upload[$i] = array(
				'id' => $row['id'],
				'path' => $row['path'],
				'display_name' => $row['display_name'],
				'size' => $row['size'],
				'timestamp' => $row['timestamp'],
			);
			$i++;
		}
		$result_files_in_upload->dispose();

		if (ModulesManager::is_module_installed('gallery') && ModulesManager::is_module_activated('gallery')) 
		{
			$result_files_in_gallery = PersistenceContext::get_querier()->select('SELECT gallery.*, member.display_name
			FROM ' . GallerySetup::$gallery_table . ' gallery
			LEFT JOIN ' . DB_TABLE_MEMBER . ' member ON gallery.user_id = member.user_id
			ORDER By gallery.id');

			$i = 1;
			foreach($result_files_in_gallery as $row)
			{
				$this->files_in_gallery[$i] = array(
					'id' => $row['id'],
					'name' => $row['name'],
					'path' => $row['path'],
					'display_name' => $row['display_name'],
					'timestamp' => $row['timestamp'],
				);
				$i++;
			}
			$result_files_in_gallery->dispose();
		}
	}

	public function get_files_in_content_list()
	{
		return $this->files_in_content;
	}

	public function file_in_content_exists($id)
	{
		return array_key_exists($id, $this->files_in_content);
	}

	public function get_files_in_content($id)
	{
		if ($this->file_in_content_exists($id)) {
			return $this->files_in_content[$id];
		}
		return null;
	}

	public function get_files_in_content_number()
	{
		return count($this->files_in_content);
	}

	public function get_files_in_upload_list()
	{
		return $this->files_in_upload;
	}

	public function file_in_upload_exists($id)
	{
		return array_key_exists($id, $this->files_in_upload);
	}

	public function get_files_in_upload($id)
	{
		if ($this->file_in_upload_exists($id)) {
			return $this->files_in_upload[$id];
		}
		return null;
	}

	public function get_files_in_upload_number()
	{
		return count($this->files_in_upload);
	}

	public function get_files_in_gallery_list()
	{
		return $this->files_in_gallery;
	}

	public function file_in_gallery_exists($id)
	{
		return array_key_exists($id, $this->files_in_gallery);
	}

	public function get_files_in_gallery($id)
	{
		if ($this->file_in_gallery_exists($id)) {
			return $this->files_in_gallery[$id];
		}
		return null;
	}

	public function get_files_in_gallery_number()
	{
		return count($this->files_in_gallery);
	}

	/**
	 * Loads and returns the items cached data.
	 * @return ReviewCacheInTable The cached data
	 */
	public static function load()
	{
		return CacheManager::load(__CLASS__, 'review', 'files-in-table');
	}

	/**
	 * Invalidates the current items cached data.
	 */
	public static function invalidate()
	{
		CacheManager::invalidate('review', 'files-in-table');
	}
}
?>
