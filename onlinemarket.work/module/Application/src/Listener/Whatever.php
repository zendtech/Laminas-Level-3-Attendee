<?php
namespace Application\Listener;

class Whatever
{
	public function doThis($e)
	{
		error_log(__METHOD__);
	}
}
