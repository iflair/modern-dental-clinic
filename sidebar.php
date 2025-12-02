<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

// Check if sidebar should be displayed
if (!is_active_sidebar('sidebar-1')) {
	return;
}
?>

<aside id="secondary" class="mlt-sidebar" role="complementary">
	<?php
	// Display the primary sidebar
	dynamic_sidebar('sidebar-1');
	?>
</aside>
