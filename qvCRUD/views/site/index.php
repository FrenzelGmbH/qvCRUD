<?php
/**
 * @var yii\base\View $this
 */
$this->title = 'qvCRUD 2.0';
?>
<div class="site-index">

	<h2 class="page-title">
		Dashboard
		<small>Statistics and more</small>
	</h2>

	<div class="widget">

		<p class="lead">You have successfully created your Yii-powered application.</p>

		<p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
	</div>

	<div class="body-content">

		<div class="row">
			<div class="col-lg-4">
				<h2>News</h2>
				
				<div class="widget">				
				<?php
					echo app\modules\posts\widgets\PortletPosts::widget(array(
	        		'limit'=>3,
	    		));
				?>
				</div>
			</div>
			<div class="col-lg-4">
				<h2>Heading</h2>

				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
					dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
					ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
					fugiat nulla pariatur.</p>

				<p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
			</div>
			<div class="col-lg-4">
				<h2>Heading</h2>

				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
					dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
					ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
					fugiat nulla pariatur.</p>

				<p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
			</div>
		</div>

	</div>
</div>
