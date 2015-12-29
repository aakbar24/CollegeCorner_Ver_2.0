<li class="span3">
	<div class="dashboard-item thumbnail"  rel="tooltip" data-placement="bottom" title="<?php echo $data['description'];?>">
		<div>
			<div class="text-center">
				<h3>
					<?php echo $data['label'];?>
				</h3>

			</div>
			<div class="text-center dashboard-link" >
				<a href="<?php echo Yii::app()->createAbsoluteUrl($data['url']);?>" >
				<span class="dashboard-icon icon-<?php echo $data['icon']?>"></span>
				</a>
			</div>
			
		</div>
	</div>
</li>
