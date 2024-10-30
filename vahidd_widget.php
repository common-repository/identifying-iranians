<?php
	function iran_register_widget_area() 
	{
		register_sidebar( array(
				'name' => 'موقعیت ابزارک ایرانیان',
				'id' => 'iranian-widget-area',
				'description' => 'ابتدا تمام ابزارک هایی که میخواهید برایشان استثنا قائل شوید را به اینجا بکشید، سپس ابزارک ایرانیان که بین ابزارک های وردپرس است را به یکی از دیگر موقعیت های ابزارک بکشید.',
				'before_widget' => '<div id="%1$s" class="iranian-widget widget-container %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>',
							) );
	}
	
	class IranianWidget extends WP_Widget {
		function IranianWidget() 
		{
			$widget_ops = array('classname' => 'iran_widget', 'description' => __( 'ابزارکي که قابليت نمايش فقط به ايرانيان را دارد.', 'Iranian-Widget') );
			$this->WP_Widget('IranianWidget', __('ابزارک ايرانيان', 'Iranian-Widget'), $widget_ops);
		}
		function widget( $args, $instance ) 
		{
			extract( $args );
			global $country_name,$country_code;	
			echo $before_widget;
			if ( $instance['iran_or_not'] == 1 &&  $country_code == 'IR' ) 
			{
				if (function_exists('dynamic_sidebar') && dynamic_sidebar('iranian-widget-area')) : else : ?>
				<p>شما هنوز ابزارکي براي "موقعيت ابزارک ايرانيان" تعيين نکرده ايد.</p>
				<?php endif; ?>
			<?php 
			} 
			elseif ( $instance['iran_or_not'] == 0 &&  $country_code != 'IR' ) 
			{
				if (function_exists('dynamic_sidebar') && dynamic_sidebar('iranian-widget-area')) : else : ?>
				<p>شما هنوز ابزارکي براي "موقعيت ابزارک ايرانيان" تعيين نکرده ايد.</p>
				<?php endif; ?>
			<?php }
				echo $after_widget;
			}
		function update( $new_instance, $old_instance ) 
		{
			$instance = $old_instance;
			$instance['iran_or_not'] = $new_instance['iran_or_not'];
			return $instance;
		}
		function form( $instance ) 
		{
			$instance = wp_parse_args( (array) $instance, array('iran_or_not' => 0,));?>  
			<p>
			<input id="<?php echo $this->get_field_id('iran_or_not'); ?>" name="<?php echo $this->get_field_name('iran_or_not'); ?>" 
				type="checkbox" <?php if ($instance['iran_or_not']) { ?> checked="checked" <?php } ?> value="1" />
			<label for="<?php echo $this->get_field_id('iran_or_not'); ?>">در این صورتی که تیک این گزینه را بگذارید این ابزارک فقط به ایرانیان نشان داده میشود.</label>
			</p>
		<?php
		}}
	function iran_widget_init() 
	{
		register_widget('IranianWidget');
	}
	add_action( 'widgets_init', 'iran_register_widget_area' );
	add_action('widgets_init', 'iran_widget_init');