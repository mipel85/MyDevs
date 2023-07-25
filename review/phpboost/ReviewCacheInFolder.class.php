<?php
/**
 * @copyright   &copy; 2005-2022 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Julien BRISWALTER <j1.seth@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2021 03 15
 * @since       PHPBoost 4.0 - 2014 08 24
 * @contributor Sebastien LARTIGUE <babsolune@phpboost.com>
*/

class ReviewCacheInFolder implements CacheData
{
	private $files_in_upload = array();
	private $datas_in_upload = array();
	private $files_in_gallery = array();
	private $datas_in_gallery = array();

	public function synchronize()
	{
		$upload_folder = new Folder(PATH_TO_ROOT . '/upload');
		$this->files_in_upload = array();
		if ($upload_folder->exists()) {
			$files = $upload_folder->get_files();
			foreach ($files as $file) {
				if (!strpos($file->get_name(), '.') != 1) 
					$this->files_in_upload[] = $file->get_name();
			}
		}

		$ingalleryfolder = new Folder(PATH_TO_ROOT . '/gallery/pics');
		$this->files_in_gallery = array();
		if ($ingalleryfolder->exists()) {
			$files = $ingalleryfolder->get_files();
			foreach ($files as $file) {
				if (!strpos($file->get_name(), '.') != 1) 
					$this->files_in_gallery[] = $file->get_name();
			}
		}
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
	 * @return ReviewCacheInFolder The cached data
	 */
	public static function load()
	{
		return CacheManager::load(__CLASS__, 'review', 'files-in-folder');
	}

	/**
	 * Invalidates the current items cached data.
	 */
	public static function invalidate()
	{
		CacheManager::invalidate('review', 'files-in-folder');
	}
}
?>
