<?php
/**
 * This file is processed then sent via AJAX when adding/editing a tooltip
 *
 * @file Template file for TinyMCE "Insert a tooltip" editor
 *
 * @author Gerkin
 * @copyright 2016 GerkinDevelopment
 * @license https://www.gnu.org/licenses/gpl-3.0.html GPLv3
 * @package ithoughts-tooltip-glossary
 *
 * @version 3.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	status_header( 403 );
	wp_die( 'Forbidden' );// Exit if accessed directly.
}

?>

<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="display: none;">
	<defs>
		<g id="icon-pin">
			<path
				  d="M 0.25621998,25.646497 C 0.35412138,25.51563 8.5166343,14.857495 8.5374693,14.833322 c 0.01094,-0.0127 0.590149,0.546824 1.2871218,1.243379 l 1.2672239,1.266464 -0.113872,0.108034 c -0.06263,0.05942 -2.4218887,1.87452 -5.2427987,4.033559 -2.8209111,2.159038 -5.22033552,3.995592 -5.33205472,4.081231 -0.1117192,0.08564 -0.1778105,0.121867 -0.1468696,0.08051 z M 10.813205,15.081346 5.1765477,9.4410226 5.5066273,9.1363586 c 1.352333,-1.248209 3.394005,-2.021634 5.3421487,-2.02371 0.458009,-5.08e-4 1.41897,0.119826 1.818038,0.227623 0.153614,0.04149 0.294168,0.07572 0.312341,0.07605 0.01817,3.55e-4 1.092202,-1.489664 2.386729,-3.3111007 1.294528,-1.8214368 2.428561,-3.38662092 2.520075,-3.47818672 0.28165,-0.2818105 0.555582,-0.3909508 0.943521,-0.3759184 0.182951,0.00709 0.162107,-0.013074 3.864784,3.73859352 3.254781,3.2978453 3.086677,3.0918563 2.93667,3.5984923 -0.05076,0.17145 -0.146799,0.319619 -0.312683,0.482424 -0.13168,0.129236 -1.72794,1.247526 -3.547245,2.4850904 l -3.307827,2.250116 0.07053,0.238176 c 0.261983,0.884659 0.33256,2.448506 0.155133,3.437409 -0.207111,1.154346 -0.770968,2.461073 -1.459695,3.382811 -0.341163,0.456586 -0.692454,0.857442 -0.751422,0.857442 -0.01533,0 -2.564362,-2.538145 -5.664523,-5.640321 z m 1.183444,-3.15174 c 0.635549,-0.607589 1.394229,-1.208949 1.823733,-1.445565 0.189467,-0.104378 0.350419,-0.193746 0.357671,-0.198595 0.0073,-0.0049 -0.209838,-0.23123 -0.482424,-0.5030684 l -0.495609,-0.494252 -0.458787,0.02717 c -0.763005,0.04518 -1.725568,0.417431 -2.613089,1.0105574 -0.2096949,0.140138 -0.3897971,0.261798 -0.4002271,0.270355 -0.02985,0.02449 1.6821321,1.797302 1.7356301,1.797302 0.02632,0 0.266216,-0.208755 0.533102,-0.4639 z m 6.401659,-4.9697184 c 1.204232,-1.103227 2.189716,-2.019561 2.189964,-2.036297 0.0011,-0.07401 -1.735932,-1.6808181 -1.772946,-1.6400264 -0.02268,0.024997 -0.866374,1.1015034 -1.874874,2.3922374 l -1.833635,2.346789 0.493873,0.483774 c 0.27163,0.266075 0.519575,0.478287 0.550989,0.471582 0.03141,-0.0067 1.042397,-0.914832 2.246629,-2.018059 z" />
		</g>
	</defs>
</svg>