<?php

function get_feed($url) {

	require_once 'SimplePie/simplepie_1.3.1.compiled.php';

	$feed = new SimplePie();
	$feed->set_feed_url($url);
	$feed->init();
	$feed->handle_content_type();

	return $feed;
}


function ecrire_fichier($f, $content) {
	return
	($fp = fopen($f, 'w'))
	&& fwrite($fp, $content)
	&& fclose($fp);
}

function rss2files($feeds=array(), $desc = array()) {

	$feed = get_feed($feeds);

	// descriptif du site
	if (!isset($desc['title']))
		$desc['title'] = $feed->get_title();
	if (!isset($desc['url']))
		$desc['url'] = $feed->get_permalink();
	if (!isset($desc['date']))
		$desc['date'] = date('Y-m-d H:i:s');
	if (!isset($desc['description']))
		$desc['description'] = $feed->get_description();

	$dir = 'sites/'. trim(preg_replace(',[^\w],', '-', preg_replace(',^https?://,', '', $desc['url'])), '-') .'/';

	// creer l'index
	if (!is_dir($dir)) mkdir($dir, 0777, true);
	$index = $dir.'index.json';
	ecrire_fichier($index, json_encode($desc, JSON_PRETTY_PRINT));
	touch($index, strtotime($desc['date']));

	// creer les pages
	foreach ($feed->get_items() as $item) {
		$link = $item->get_permalink();
		$subdir = $item->get_date('Y/Y-m/');
		if (!is_dir("$dir$subdir")) mkdir("$dir$subdir", 0777, true);

		$uniq = substr(md5($item->get_permalink()),0,9);
		// TODO: supprimer un Žventuel autre fichier ayant le mme permalink mais pas la meme date
		// $idem = glob("$dir*/*/*-$uniq.json") etc

		$article = array();
		$article['title'] = $item->get_title();
		$article['date'] = $item->get_date('Y-m-d H:i:s');
		$article['description'] = $item->get_description();
		$article['content'] = $item->get_content();
		$article['tags'] = $item->get_item_tags();

		$date = $item->get_date('YmdHis');
		$f = "$dir$subdir$date-$uniq.json";
		$c = json_encode($article, JSON_PRETTY_PRINT);
		if (@file_get_contents($f) !== $c) {
			ecrire_fichier($f, $c);
			$res['added'] ++;
			touch ($f, strtotime($article['date']));
		} else {
			$res['checked'] ++;
		}
	}

	return $res;
}

$res = rss2files(array('http://quefaitlapolice.samizdat.net/?feed=rss2'),
	array(
		'title' => 'Que fait la police ?',
		'url' => 'http://quefaitlapolice.samizdat.net/',
	)
);


if (!$res) echo "erreur ...\n";

if ($res['added']) echo $res['added']." articles added\n";
if ($res['checked']) echo $res['checked']." articles checked\n";
