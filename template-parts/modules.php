<?php
/**
 * Modules template.
 *
 * @package Milos
 * @subpackage Chriss
 */

?>
<div class="wrapper-content-modules">
<?php
foreach ( get_modules() as $module ) :
	get_template_part( slug: 'template-parts/modules/' . $module['acf_fc_layout'], args: $module );
endforeach;
?>
</div>
