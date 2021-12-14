<?php
class Presenter_Bookmaster_Detail extends Presenter
{
	/**
	 * Prepare the view data, keeping this in here helps clean up
	 * the controller.
	 *
	 * @return void
	 */
	public function view()
	{
		$this->title = $this->request()->param('title', 'chi tiết');
	}
}
