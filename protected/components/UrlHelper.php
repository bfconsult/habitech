<?php
class UrlHelper {
	public static function getPrefixLink($link) {
		$url = Yii::app()->params['server'].'/'.$link;
		$beautiful_url = str_replace('//', '/', $url);
		return Yii::app()->params['protocol'].$beautiful_url;
	}

	public static function getPath($file) {
		return Yii::getPathOfAlias('webroot').'/uploads/images/'.$file;
                //return '/req/uploads/images/'.$file;
	}
}