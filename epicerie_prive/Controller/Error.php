<?php

abstract class Controller_Error extends Controller_Template
{

    public static function documentNotFound($title)
    {
	header('HTTP/1.1 404 Not Found');
	header('Content-Type: text/html; charset=utf-8');
	include 'View/header.tpl';
	include 'View/error/404.tpl';
	require 'View/rightcol.tpl';
	include 'View/footer.tpl';
    }

    public static function connectionNeeded($title)
    {
	header('Content-Type: text/html; charset=utf-8');
	include 'View/header.tpl';
	include 'View/error/denied.tpl';
	require 'View/rightcol.tpl';
	include 'View/footer.tpl';
    }
    
    public static function connectionFailed($title, $json = false)
    {
	header('Content-Type: text/html; charset=utf-8');
	!$json ? include 'View/header.tpl' : null ;
	include 'View/error/failed.tpl';
	!$json ? require 'View/rightcol.tpl' : null ;
	!$json ? include 'View/footer.tpl' : null ;
    }
    
    public static function emptySearch($title)
    {
	header('Content-Type: text/html; charset=utf-8');
	include 'View/header.tpl';
	include 'View/error/search.tpl';
	require 'View/rightcol.tpl';
	include 'View/footer.tpl';
    }

    public static function overStock($title)
    {
	header('Content-Type: text/html; charset=utf-8');
	include 'View/header.tpl';
	include 'View/error/stock.tpl';
	require 'View/rightcol.tpl';
	include 'View/footer.tpl';
    }
    
    public static function alreadyInList($title)
    {
	header('Content-Type: text/html; charset=utf-8');
	include 'View/header.tpl';
	include 'View/error/liste.tpl';
	require 'View/rightcol.tpl';
	include 'View/footer.tpl';
    }

}

