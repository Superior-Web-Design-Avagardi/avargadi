<?php
/**
 * Content wrappers
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$template = get_option( 'template' );

function showText() {
	if(is_shop()) {
	echo '
		<article class="text-content">
		<h1>About us</h1>
		<br>
		<h3>Our vision</h3>
		<p>
		Lighting is about more than just light and darkness.

		Since the first electric lamp was demonstrated in 1835 by James Bowman 

		Lindsay, the luminaire has performed an inanimate, functional role.

		Over time technology and design have evolved, but the lamp has not.

		We believe that this should change.
		</p>

		<h3>Our method</h3>
		<p>
		Avargadi luminaires are created using additive 3D printing technology, allowing our 

		designers to redefine the possibilities of a lamp, limited only by their imaginations.

		The 3D printed luminaire is paired with an advanced “smart” light bulb, allowing 

		users to customise an array of tone, contrast and colour.
		An Avargadi luminaire can transform any living space, adapting to the desired mood 

		and atmosphere of the room.
		</p>
		<br>
		<p class="center"> 
		Welcome to the next evolution of lighting.
		</p>
		</article>
		';
	}
}

switch( $template ) {
	case 'twentyeleven' :
		echo '<div id="primary">'.showText().'<div id="content" role="main">';
		break;
	case 'twentytwelve' :
		echo '<div id="primary" class="site-content">'.showText().'<div id="content" role="main">';
		break;
	case 'twentythirteen' :
		echo '<div id="primary" class="site-content">'.showText().'<div id="content" role="main" class="entry-content twentythirteen">';
		break;
	case 'twentyfourteen' :
		echo '<div id="primary" class="content-area">'.showText().'<div id="content" role="main" class="site-content twentyfourteen"><div class="tfwc">';
		break;
	default :
		echo '<div id="container">'.showText().'<div id="content" role="main">';
		break;
}