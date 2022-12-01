<?php
$oTab1 = $oTab2 = $oButton = "";
if (trim($o_mode) === "I") {
	$oTab1 = "active";
	$oButton = $o_extra['o_save'];
} else {
	$oTab2 = "active";
	$oButton = $o_extra['o_update'] . " " . $o_extra['o_delete'];
}
$oButton .= " " . $o_extra['o_cancel'];
?>
<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">
		<li class="<?php print $oTab1; ?>"><a data-toggle="tab" href="#tab_1">Example Time Line 1</a></li>
		<li class=""><a data-toggle="tab" href="#tab_2">Example Time Line 1</a></li>
		<li class=""><a data-toggle="tab" href="#tab_3">Example HighCharts Line</a></li>
		<li class=""><a data-toggle="tab" href="#tab_4">Example HighCharts Gauge</a></li>
		<li class=""><a data-toggle="tab" href="#tab_5">Example Session</a></li>
		<li class=""><a data-toggle="tab" href="#tab_6">Example HighCharts Gauge 1</a></li>
		<li class=""><a data-toggle="tab" href="#tab_7">Google Maps</a></li>
		<li class=""><a data-toggle="tab" href="#tab_11">Time Line 2</a></li>
		<li class=""><a data-toggle="tab" href="#tab_12">Time Line 3</a></li>
		<li class=""><a data-toggle="tab" href="#tab_13">Basic PLUpload</a></li>
		<li class=""><a data-toggle="tab" href="#tab_14">Embed PDF</a></li>
		<li class=""><a data-toggle="tab" href="#tab_15">Table Group</a></li>
		<li class=""><a data-toggle="tab" href="#tab_16">JQuery Blur Overlay</a></li>
	</ul>
	<div class="tab-content">
		<div id="tab_16" class="tab-pane">
			<button id="cmdBlur" mode="0" type="button" class="btn btn-primary">Test</button>
		</div>
		<div id="tab_15" class="tab-pane">
			<table id="myTable1" border="1" cellpadding="3" cellspacing="0">
				<tr>
					<th>Category</th>
					<th>Product</th>
					<th>Size</th>
					<th>Price</th>
					<th>Shipping</th>
				</tr>
				<tr>
					<td>Category-1</td>
					<td>Product-1</td>
					<td>Big</td>
					<td>102</td>
					<td>Free</td>
				</tr>
				<tr>
					<td>Category-1</td>
					<td>Product-7</td>
					<td>Big</td>
					<td>102</td>
					<td>Free</td>
				</tr>
				<tr>
					<td>Category-1</td>
					<td>Product-2</td>
					<td>Big</td>
					<td>130</td>
					<td>Free</td>
				</tr>
				<tr>
					<td>Category-2</td>
					<td>Product-3</td>
					<td>Big</td>
					<td>130</td>
					<td>Free</td>
				</tr>
				<tr>
					<td>Category-1</td>
					<td>Product-1</td>
					<td>Big</td>
					<td>132</td>
					<td>Free</td>
				</tr>
				<tr>
					<td>Category-2</td>
					<td>Product-4</td>
					<td>Big</td>
					<td>150</td>
					<td>10</td>
				</tr>
				<tr>
					<td>Category-1</td>
					<td>Product-2</td>
					<td>Small</td>
					<td>100</td>
					<td>Free</td>
				</tr>
				<tr>
					<td>Category-2</td>
					<td>Product-3</td>
					<td>Big</td>
					<td>100</td>
					<td>Free</td>
				</tr>
				<tr>
					<td>Category-2</td>
					<td>Product-3</td>
					<td>Small</td>
					<td>100</td>
					<td>10</td>
				</tr>
				<tr>
					<td>Category-3</td>
					<td>Product-5</td>
					<td>Big</td>
					<td>150</td>
					<td>10</td>
				</tr>
				<tr>
					<td>Category-3</td>
					<td>Product-5</td>
					<td>Big</td>
					<td>120</td>
					<td>Free</td>
				</tr>
				<tr>
					<td>Category-4</td>
					<td>Product-6</td>
					<td>Big</td>
					<td>120</td>
					<td>10</td>
				</tr>
				<tr>
					<td>Category-3</td>
					<td>Product-5</td>
					<td>Small</td>
					<td>120</td>
					<td>10</td>
				</tr>
				<tr>
					<td>Category-4</td>
					<td>Product-6</td>
					<td>Small</td>
					<td>120</td>
					<td>10</td>
				</tr>
			</table>
			<br />
			<table id="myTable" border="1" cellpadding="3" cellspacing="0">
				<tr>
					<th>Category</th>
					<th>Product</th>
					<th>Size</th>
					<th>Price</th>
					<th>Shipping</th>
				</tr>
				<tr>
					<td>Category-1</td>
					<td>Product-1</td>
					<td>Big</td>
					<td>102</td>
					<td>Free</td>
				</tr>
				<tr>
					<td>Category-1</td>
					<td>Product-7</td>
					<td>Big</td>
					<td>102</td>
					<td>Free</td>
				</tr>
				<tr>
					<td>Category-1</td>
					<td>Product-2</td>
					<td>Big</td>
					<td>130</td>
					<td>Free</td>
				</tr>
				<tr>
					<td>Category-2</td>
					<td>Product-3</td>
					<td>Big</td>
					<td>130</td>
					<td>Free</td>
				</tr>
				<tr>
					<td>Category-1</td>
					<td>Product-1</td>
					<td>Big</td>
					<td>132</td>
					<td>Free</td>
				</tr>
				<tr>
					<td>Category-2</td>
					<td>Product-4</td>
					<td>Big</td>
					<td>150</td>
					<td>10</td>
				</tr>
				<tr>
					<td>Category-1</td>
					<td>Product-2</td>
					<td>Small</td>
					<td>100</td>
					<td>Free</td>
				</tr>
				<tr>
					<td>Category-2</td>
					<td>Product-3</td>
					<td>Big</td>
					<td>100</td>
					<td>Free</td>
				</tr>
				<tr>
					<td>Category-2</td>
					<td>Product-3</td>
					<td>Small</td>
					<td>100</td>
					<td>10</td>
				</tr>
				<tr>
					<td>Category-3</td>
					<td>Product-5</td>
					<td>Big</td>
					<td>150</td>
					<td>10</td>
				</tr>
				<tr>
					<td>Category-3</td>
					<td>Product-5</td>
					<td>Big</td>
					<td>120</td>
					<td>Free</td>
				</tr>
				<tr>
					<td>Category-4</td>
					<td>Product-6</td>
					<td>Big</td>
					<td>120</td>
					<td>10</td>
				</tr>
				<tr>
					<td>Category-3</td>
					<td>Product-5</td>
					<td>Small</td>
					<td>120</td>
					<td>10</td>
				</tr>
				<tr>
					<td>Category-4</td>
					<td>Product-6</td>
					<td>Small</td>
					<td>120</td>
					<td>10</td>
				</tr>
			</table>
		</div>
		<div id="tab_14" class="tab-pane">
			<embed src="<?php print site_url(); ?>Output.pdf" width="600" height="500" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html">
		</div>
		<div id="tab_13" class="tab-pane">
			This show example how to use PLUpload Lib Engine
			<br />
			<br />
			<img class="img-responsive img-rounded hidden" style="max-width: 200px; margin-bottom: 20px;" src="" />
			<a class="cursor-pointer btn btn-primary" title="Click here to Change Profile Picture" id="aUploadImage">Upload File</a>
			<span id="spanProgress"></span>
		</div>
		<div id="tab_12" class="tab-pane">
			<header class="example-header">
				<h1 class="text-center">Simple Responsive Timeline</h1>
				<p>Handcrafted by <a href="http://overflowdg.com" target="_blank">Overflow</a></p>
			</header>
			<div class="container-fluid">
				<div class="row example-basic">
					<div class="col-md-12 example-title">
						<h2>Basic Timeline</h2>
						<p>Extra small devices (phones, less than 768px)</p>
					</div>
					<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2">
						<ul class="timelines">
							<li class="timelines-item">
								<div class="timelines-info">
									<span>March 12, 2016</span>
								</div>
								<div class="timelines-marker"></div>
								<div class="timelines-content">
									<h3 class="timelines-title">Event Title</h3>
									<p>Nullam vel sem. Nullam vel sem. Integer ante arcu, accumsan a, consectetuer eget, posuere ut, mauris. Donec orci lectus, aliquam ut, faucibus non, euismod id, nulla. Donec vitae sapien ut libero venenatis faucibus. ullam dictum felis
										eu pede mollis pretium. Pellentesque ut neque.</p>
								</div>
							</li>
							<li class="timelines-item">
								<div class="timelines-info">
									<span>March 23, 2016</span>
								</div>
								<div class="timelines-marker"></div>
								<div class="timelines-content">
									<h3 class="timelines-title">Event Title</h3>
									<p>Nullam vel sem. Nullam vel sem. Integer ante arcu, accumsan a, consectetuer eget, posuere ut, mauris. Donec orci lectus, aliquam ut, faucibus non, euismod id, nulla. Donec vitae sapien ut libero venenatis faucibus. ullam dictum felis
										eu pede mollis pretium. Pellentesque ut neque. </p>
								</div>
							</li>
							<li class="timelines-item period">
								<div class="timelines-info"></div>
								<div class="timelines-marker"></div>
								<div class="timelines-content">
									<h2 class="timelines-title">April 2016</h2>
								</div>
							</li>
							<li class="timelines-item">
								<div class="timelines-info">
									<span>April 02, 2016</span>
								</div>
								<div class="timelines-marker"></div>
								<div class="timelines-content">
									<h3 class="timelines-title">Event Title</h3>
									<p>Nullam vel sem. Nullam vel sem. Integer ante arcu, accumsan a, consectetuer eget, posuere ut, mauris. Donec orci lectus, aliquam ut, faucibus non, euismod id, nulla. Donec vitae sapien ut libero venenatis faucibus. ullam dictum felis
										eu pede mollis pretium. Pellentesque ut neque. </p>
								</div>
							</li>
							<li class="timelines-item">
								<div class="timelines-info">
									<span>April 28, 2016</span>
								</div>
								<div class="timelines-marker"></div>
								<div class="timelines-content">
									<h3 class="timelines-title">Event Title</h3>
									<p>Nullam vel sem. Nullam vel sem. Integer ante arcu, accumsan a, consectetuer eget, posuere ut, mauris. Donec orci lectus, aliquam ut, faucibus non, euismod id, nulla. Donec vitae sapien ut libero venenatis faucibus. ullam dictum felis
										eu pede mollis pretium. Pellentesque ut neque. </p>
								</div>
							</li>
						</ul>
					</div>
				</div>
				<div class="row example-split">
					<div class="col-md-12 example-title">
						<h2>Split Timeline</h2>
						<p>Small devices (tablets, 768px and up)</p>
					</div>
					<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2">
						<ul class="timelines timelines-split">
							<li class="timelines-item">
								<div class="timelines-info">
									<span>March 12, 2016</span>
								</div>
								<div class="timelines-marker"></div>
								<div class="timelines-content">
									<h3 class="timelines-title">Event Title</h3>
									<p>Nullam vel sem. Nullam vel sem. Integer ante arcu, accumsan a, consectetuer eget, posuere ut, mauris. Donec orci lectus, aliquam ut, faucibus non, euismod id, nulla. Donec vitae sapien ut libero venenatis faucibus. ullam dictum felis
										eu pede mollis pretium. Pellentesque ut neque.</p>
								</div>
							</li>
							<li class="timelines-item">
								<div class="timelines-info">
									<span>March 23, 2016</span>
								</div>
								<div class="timelines-marker"></div>
								<div class="timelines-content">
									<h3 class="timelines-title">Event Title</h3>
									<p>Nullam vel sem. Nullam vel sem. Integer ante arcu, accumsan a, consectetuer eget, posuere ut, mauris. Donec orci lectus, aliquam ut, faucibus non, euismod id, nulla. Donec vitae sapien ut libero venenatis faucibus. ullam dictum felis
										eu pede mollis pretium. Pellentesque ut neque. </p>
								</div>
							</li>
							<li class="timelines-item period">
								<div class="timelines-info"></div>
								<div class="timelines-marker"></div>
								<div class="timelines-content">
									<h2 class="timelines-title">April 2016</h2>
								</div>
							</li>
							<li class="timelines-item">
								<div class="timelines-info">
									<span>April 02, 2016</span>
								</div>
								<div class="timelines-marker"></div>
								<div class="timelines-content">
									<h3 class="timelines-title">Event Title</h3>
									<p>Nullam vel sem. Nullam vel sem. Integer ante arcu, accumsan a, consectetuer eget, posuere ut, mauris. Donec orci lectus, aliquam ut, faucibus non, euismod id, nulla. Donec vitae sapien ut libero venenatis faucibus. ullam dictum felis
										eu pede mollis pretium. Pellentesque ut neque. </p>
								</div>
							</li>
							<li class="timelines-item">
								<div class="timelines-info">
									<span>April 28, 2016</span>
								</div>
								<div class="timelines-marker"></div>
								<div class="timelines-content">
									<h3 class="timelines-title">Event Title</h3>
									<p>Nullam vel sem. Nullam vel sem. Integer ante arcu, accumsan a, consectetuer eget, posuere ut, mauris. Donec orci lectus, aliquam ut, faucibus non, euismod id, nulla. Donec vitae sapien ut libero venenatis faucibus. ullam dictum felis
										eu pede mollis pretium. Pellentesque ut neque. </p>
								</div>
							</li>
						</ul>
					</div>
				</div>
				<div class="row example-centered">
					<div class="col-md-12 example-title">
						<h2>Centered Timeline</h2>
						<p>Medium devices (desktops, 992px and up).</p>
					</div>
					<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2">
						<ul class="timelines timelines-centered">
							<li class="timelines-item">
								<div class="timelines-info">
									<span>March 12, 2016</span>
								</div>
								<div class="timelines-marker"></div>
								<div class="timelines-content">
									<h3 class="timelines-title">Event Title</h3>
									<p>Nullam vel sem. Nullam vel sem. Integer ante arcu, accumsan a, consectetuer eget, posuere ut, mauris. Donec orci lectus, aliquam ut, faucibus non, euismod id, nulla. Donec vitae sapien ut libero venenatis faucibus. ullam dictum felis
										eu pede mollis pretium. Pellentesque ut neque.</p>
								</div>
							</li>
							<li class="timelines-item">
								<div class="timelines-info">
									<span>March 23, 2016</span>
								</div>
								<div class="timelines-marker"></div>
								<div class="timelines-content">
									<h3 class="timelines-title">Event Title</h3>
									<p>Nullam vel sem. Nullam vel sem. Integer ante arcu, accumsan a, consectetuer eget, posuere ut, mauris. Donec orci lectus, aliquam ut, faucibus non, euismod id, nulla. Donec vitae sapien ut libero venenatis faucibus. ullam dictum felis
										eu pede mollis pretium. Pellentesque ut neque. </p>
								</div>
							</li>
							<li class="timelines-item period">
								<div class="timelines-info"></div>
								<div class="timelines-marker"></div>
								<div class="timelines-content">
									<h2 class="timelines-title">April 2016</h2>
								</div>
							</li>
							<li class="timelines-item">
								<div class="timelines-info">
									<span>April 02, 2016</span>
								</div>
								<div class="timelines-marker"></div>
								<div class="timelines-content">
									<h3 class="timelines-title">Event Title</h3>
									<p>Nullam vel sem. Nullam vel sem. Integer ante arcu, accumsan a, consectetuer eget, posuere ut, mauris. Donec orci lectus, aliquam ut, faucibus non, euismod id, nulla. Donec vitae sapien ut libero venenatis faucibus. ullam dictum felis
										eu pede mollis pretium. Pellentesque ut neque. </p>
								</div>
							</li>
							<li class="timelines-item">
								<div class="timelines-info">
									<span>April 28, 2016</span>
								</div>
								<div class="timelines-marker"></div>
								<div class="timelines-content">
									<h3 class="timelines-title">Event Title</h3>
									<p>Nullam vel sem. Nullam vel sem. Integer ante arcu, accumsan a, consectetuer eget, posuere ut, mauris. Donec orci lectus, aliquam ut, faucibus non, euismod id, nulla. Donec vitae sapien ut libero venenatis faucibus. ullam dictum felis
										eu pede mollis pretium. Pellentesque ut neque. </p>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div id="tab_11" class="tab-pane">
			<div id="myTimeline">
				<ul class="timeline-events">
					<li>Not allowed event definition</li>
					<li data-timeline-node="{ start:'2017-05-29 07:55',end:'2017-05-29 08:56',content:'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis luctus tortor nec bibendum malesuada. Etiam sed libero cursus, placerat est at, fermentum quam. In sed fringilla mauris. Fusce auctor turpis ac imperdiet porttitor. Duis vel pharetra magna, ut mollis libero. Etiam cursus in leo et viverra. Praesent egestas dui a magna eleifend, id elementum felis maximus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Vestibulum sed elit gravida, euismod nunc id, ullamcorper tellus. Morbi elementum urna faucibus tempor lacinia. Quisque pharetra purus at risus tempor hendrerit. Nam dui justo, molestie quis tincidunt sit amet, eleifend porttitor mauris. Maecenas sit amet ex vitae mi finibus pharetra. Donec vulputate leo eu vestibulum gravida. Ut in facilisis dolor, vitae iaculis dui.' }">Event Label</li>
					<li data-timeline-node="{ start:'2017-5-29 10:30',end:'2017-5-29 12:15',bgColor:'#a3d6cc',content:'<p>In this way, you can include <em>HTML tags</em> in the event body.<br><i class=\'fa fa-ellipsis-v\'></i><br><i class=\'fa fa-ellipsis-v\'></i></p>' }">HTML tags is included in the event content</li>
					<li data-timeline-node="{ start:'2017-05-29 13:00',content:'For the bar type on the timeline, event blocks are displayed in minimum units unless you specify an event end time.' }">Event with undefined of end date</li>
					<li data-timeline-node="{ end:'2017-05-29 15:00',bgColor:'#e6eb94',content:'In this case, no displayed.' }">Event with undefined of start date</li>
					<li data-timeline-node="{ start:'2017-05-29 12:45',end:'2017-05-29 16:00',row:2,bgColor:'#89c997',color:'#ffffff',callback:'$(\'#myModal\').modal()',content:'Show modal window via bootstrap' }">Event having callback</li>
					<li data-timeline-node="{ start:'2017-05-29 16:03',end:'2017-05-29 19:05',row:3,bgColor:'#a1d8e6',color:'#008db7',extend:{toggle:'popover',placement:'bottom',content:'It is also possible to bind external custom events.'} }">Show popover via bootstrap</li>
					<li data-timeline-node="{ start:'2017-05-28 23:00',end:'2017-05-29 05:15',row:3,extend:{'post_id':13,'permalink':'https://www.google.com/'} }">Event having extended params</li>
					<li data-timeline-node="{ start:'2017-05-29 05:40',end:'2017-05-29 08:20',row:3,bgColor:'#ef857d',color:'#fff',content:'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis luctus tortor nec bibendum malesuada. Etiam sed libero cursus, placerat est at, fermentum quam. In sed fringilla mauris. Fusce auctor turpis ac imperdiet porttitor.' }">Lorem Ipsum</li>
					<li data-timeline-node="{ start:'2017-05-29 10:00',end:'2017-05-29 19:00',row:4,bgColor:'#942343' }">Event having image for point type</li>
					<li data-timeline-node="{ start:'2017-04-01 20:00',end:'2017-05-29 08:30',row:5 }">Long event from the past over range</li>
					<li data-timeline-node="{ start:'2017-05-29 19:00',end:'2017-06-14 01:00',row:5,bgColor:'#fbdac8' }">Long event until the future over range</li>
				</ul>
			</div>
		</div>
		<div id="tab_1" class="tab-pane <?php print $oTab1; ?>">
			<div class="page">
				<div class="page__demo">
					<div class="main-divContainer1 page__divContainer1">
						<div class="timeline">
							<div class="timeline__group">
								<span class="timeline__year">2008</span>
								<div class="timeline__box">
									<div class="timeline__date">
										<span class="timeline__day">2</span>
										<span class="timeline__month">Feb</span>
									</div>
									<div class="timeline__post">
										<div class="timeline__content">
											<p>Attends the Philadelphia Museum School of Industrial Art. Studies design with Alexey Brodovitch, art director at Harper's Bazaar, and works as his assistant.</p>
										</div>
									</div>
								</div>
								<div class="timeline__box">
									<div class="timeline__date">
										<span class="timeline__day">1</span>
										<span class="timeline__month">Sept</span>
									</div>
									<div class="timeline__post">
										<div class="timeline__content">
											<p>Started from University of Pennsylvania. This is an important stage of my career. Here I worked in the local magazine. The experience greatly affected me</p>
										</div>
									</div>
								</div>
							</div>
							<div class="timeline__group">
								<span class="timeline__year">2014</span>
								<div class="timeline__box">
									<div class="timeline__date">
										<span class="timeline__day">14</span>
										<span class="timeline__month">Jul</span>
									</div>
									<div class="timeline__post">
										<div class="timeline__content">
											<p>Travels to France, Italy, Spain, and Peru. After completing fashion editorial in Lima, prolongs stay to make portraits of local people in a daylight studio</p>
										</div>
									</div>
								</div>
							</div>
							<div class="timeline__group">
								<span class="timeline__year">2016</span>
								<div class="timeline__box">
									<div class="timeline__date">
										<span class="timeline__day">28</span>
										<span class="timeline__month">Aug</span>
									</div>
									<div class="timeline__post">
										<div class="timeline__content">
											<p>Upon moving to Brooklyn that summer, I began photographing weddings in Chicago</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="tab_2" class="tab-pane">
			<div class="demo">
				<div class="row">
					<div class="col-xs-12 col-md-12 col-sm-12 col-lg-6">
						<div class="main-timeline">
							<div class="timeline">
								<div class="timeline-icon">
									<i class="fa fa-star"></i>
								</div>
								<div class="timelines-content">
									<h2 class="title">Web Design</h2>
									<p class="description">
										Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent euismod fringilla nibh, feugiat pretium velit. Integer elit urna, maximus vitae rutrum hendrerit, pretium sed massa.
									</p>
									<a href="http://bestjquery.com/tutorial/timeline/demo1/#" class="read-more">read more</a>
								</div>
							</div>

							<div class="timeline">
								<div class="timeline-icon">
									<i class="fa fa-star"></i>
								</div>
								<div class="timelines-content right">
									<h2 class="title">Web Development</h2>
									<p class="description">
										Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent euismod fringilla nibh, feugiat pretium velit. Integer elit urna, maximus vitae rutrum hendrerit, pretium sed massa.
									</p>
									<a href="http://bestjquery.com/tutorial/timeline/demo1/#" class="read-more">read more</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="tab_3" class="tab-pane">
			<div id="divContainer1" style="min-width: auto; max-width: auto; height: auto; margin: 0 auto"></div>
		</div>
		<div id="tab_4" class="tab-pane">
			<div id="divContainer2" style="min-width: auto; max-width: auto; height: auto; margin: 0 auto"></div>
		</div>
		<div id="tab_5" class="tab-pane">
			<div id="divContainer3" class="plot">
				<?php print_r($this->session->userdata()); ?>
			</div>
		</div>
		<div id="tab_6" class="tab-pane">
			<div id="divContainer4" style="min-width: auto; max-width: auto; height: auto; margin: 0 auto"></div>
		</div>
		<div id="tab_7" class="tab-pane">
			<div id="divContainer5"></div>
		</div>
	</div>
</div>

<script>
	try {
		Typekit.load({
			async: true
		});
	} catch (e) {}
</script>
<script>
	$(function() {
		gf_init_hc_line();
		gf_init_hc_gauge();
		gf_init_hc_gauge_1();
		gf_init_plupload();
		gf_init_timeline_3();
		gf_init_table_group();
		gf_init_blur();
	});

	function gf_init_blur() {
		$("#cmdBlur").on("click", function() {
			if ($(this).attr("mode") === "0") {
				$(this).attr("mode", "1");
				$("#tab_16").css({
					"-webkit-filter": "blur(5px)",
					"filter": "blur(5px)"
				});
			} else {
				$(this).attr("mode", "0");
				$("#tab_16").removeAttr("style");
			}
		});
	}

	function gf_init_timeline_3() {
		$("#myTimeline").timeline({
			startDatetime: '2017-05-28',
			rangeAlign: 'center'
		});
		$("#myTimeline").on('afterRender.timeline', function() {
			// usage bootstrap's popover
			$('.timeline-node').each(function() {
				if ($(this).data('toggle') === 'popover') {
					$(this).attr('title', $(this).text());
					$(this).popover({
						trigger: 'hover'
					});
				}
			});
		});
	}

	function gf_init_hc_line() {
		Highcharts.chart('divContainer1', {
			title: {
				text: 'Solar Employment Growth by Sector, 2010-2016'
			},
			subtitle: {
				text: 'Source: thesolarfoundation.com'
			},
			yAxis: {
				title: {
					text: 'Number of Employees'
				}
			},
			legend: {
				layout: 'vertical',
				align: 'right',
				verticalAlign: 'middle'
			},
			plotOptions: {
				series: {
					label: {
						connectorAllowed: false
					},
					pointStart: 2010
				}
			},
			series: [{
				name: 'Installation',
				data: [43934, 52503, 57177, 69658, 97031, 119931, 137133, 154175]
			}, {
				name: 'Manufacturing',
				data: [24916, 24064, 29742, 29851, 32490, 30282, 38121, 40434]
			}, {
				name: 'Sales & Distribution',
				data: [11744, 17722, 16005, 19771, 20185, 24377, 32147, 39387]
			}, {
				name: 'Project Development',
				data: [null, null, 7988, 12169, 15112, 22452, 34400, 34227]
			}, {
				name: 'Other',
				data: [12908, 5948, 8105, 11248, 8989, 11816, 18274, 18111]
			}],
			responsive: {
				rules: [{
					condition: {
						maxWidth: 500
					},
					chartOptions: {
						legend: {
							layout: 'horizontal',
							align: 'center',
							verticalAlign: 'bottom'
						}
					}
				}]
			}
		});
	}

	function gf_init_hc_gauge() {
		Highcharts.chart('divContainer2', {
			chart: {
				type: 'gauge',
				plotBackgroundColor: null,
				plotBackgroundImage: null,
				plotBorderWidth: 0,
				plotShadow: false
			},
			title: {
				text: 'Speedometer'
			},
			pane: {
				startAngle: -150,
				endAngle: 150,
				background: [{
					backgroundColor: {
						linearGradient: {
							x1: 0,
							y1: 0,
							x2: 0,
							y2: 1
						},
						stops: [
							[0, '#FFF'],
							[1, '#333']
						]
					},
					borderWidth: 0,
					outerRadius: '109%'
				}, {
					backgroundColor: {
						linearGradient: {
							x1: 0,
							y1: 0,
							x2: 0,
							y2: 1
						},
						stops: [
							[0, '#333'],
							[1, '#FFF']
						]
					},
					borderWidth: 1,
					outerRadius: '107%'
				}, {}, {
					backgroundColor: '#DDD',
					borderWidth: 0,
					outerRadius: '105%',
					innerRadius: '103%'
				}]
			},
			// the value axis
			yAxis: {
				min: 0,
				max: 200,
				minorTickInterval: 'auto',
				minorTickWidth: 1,
				minorTickLength: 10,
				minorTickPosition: 'inside',
				minorTickColor: '#666',
				tickPixelInterval: 30,
				tickWidth: 2,
				tickPosition: 'inside',
				tickLength: 10,
				tickColor: '#666',
				labels: {
					step: 2,
					rotation: 'auto'
				},
				title: {
					text: 'km/h'
				},
				plotBands: [{
						from: 0,
						to: 120,
						color: '#55BF3B' /* green */
					},
					{
						from: 120,
						to: 160,
						color: '#DDDF0D' /* yellow */
					},
					{
						from: 160,
						to: 200,
						color: '#DF5353' /* red */
					}
				]
			},
			series: [{
				name: 'Speed',
				data: [20],
				tooltip: {
					valueSuffix: ' km/h'
				}
			}]
		});
	}

	function gf_init_hc_gauge_1() {
		$(function() {
			var chart_10001;
			chart_10001 = new Highcharts.Chart({
				"chart": {
					"animation": false,
					"events": {
						"click": function() {
							window.location = '#'
						}
					},
					"height": 300,
					"renderTo": "divContainer4",
					"style": {
						"cursor": "pointer"
					},
					"width": 500
				},
				"pane": {
					"background": [{
							"backgroundColor": {
								"linearGradient": {
									"x1": 0,
									"y1": 0,
									"x2": 0,
									"y2": 1
								},
								"stops": [
									[0, "#FFF"],
									[1, "#333"]
								]
							},
							"borderWidth": 0,
							"outerRadius": "109%"
						}, {
							"backgroundColor": {
								"linearGradient": {
									"x1": 0,
									"y1": 0,
									"x2": 0,
									"y2": 1
								},
								"stops": [
									[0, "#333"],
									[1, "#FFF"]
								]
							},
							"borderWidth": 1,
							"outerRadius": "107%"
						},
						[], {
							"backgroundColor": "#DDD",
							"borderWidth": 0,
							"outerRadius": "105%",
							"innerRadius": "103%"
						}, {
							"backgroundColor": {
								"radialGradient": {
									"cx": 0.5,
									"cy": 0.52,
									"r": 0.2
								},
								"stops": [
									[0, "rgba(0,0,0,0.1)"],
									[1, "rgba(255,255,255,0)"]
								]
							},
							"outerRadius": "90%",
							"innerRadius": "5%",
							"borderWidth": 0
						}
					],
					"endAngle": 150,
					"startAngle": -150
				},
				"plotOptions": {
					"gauge": {
						"dial": {
							"backgroundColor": "#000000",
							"baseWidth": 7,
							"borderColor": {
								"linearGradient": {
									"x1": 0,
									"y1": 0,
									"x2": 0,
									"y2": 1
								},
								"stops": [
									[0, "#333"],
									[1, "#BBB"]
								]
							},
							"borderWidth": 2
						},
						"pivot": {
							"backgroundColor": "#f0f0f0",
							"borderColor": {
								"linearGradient": {
									"x1": 0,
									"y1": 0,
									"x2": 0,
									"y2": 1
								},
								"stops": [
									[0, "#EEE"],
									[1, "#333"]
								]
							},
							"borderWidth": 2,
							"radius": 4
						},
						"stickyTracking": false
					}
				},
				"series": [{
					"data": [{
						"y": 5,
						"name": "Target",
						"color": "#000",
						"dial": {
							"backgroundColor": "#3a54bf",
							"borderWidth": 0,
							"radius": "70%"
						},
						"dataLabels": {
							"enabled": false
						},
						"events": {
							"mouseOver": function() {
								if (typeof this.originalColor == 'undefined') this.originalColor = this.graphic.fill;
								this.graphic.attr('fill', Highcharts.Color(this.originalColor).brighten(0.2).get('rgb'));
							},
							"mouseOut": function() {
								this.graphic.attr('fill', this.originalColor);
							},
							"click": function() {
								window.location = '#'
							}
						}
					}, {
						"y": 0.3072,
						"name": "Sales per Person",
						"color": "#000",
						"events": {
							"mouseOver": function() {
								if (typeof this.originalColor == 'undefined') this.originalColor = this.graphic.fill;
								this.graphic.attr('fill', Highcharts.Color(this.originalColor).brighten(0.2).get('rgb'));
							},
							"mouseOut": function() {
								this.graphic.attr('fill', this.originalColor);
							},
							"click": function() {
								window.location = '#'
							}
						}
					}],
					"name": "Sales per Person",
					"type": "gauge",
					"dataLabels": {
						"backgroundColor": {
							"linearGradient": {
								"x1": 0,
								"y1": 0,
								"x2": 0,
								"y2": 1
							},
							"stops": [
								[0, "#555"],
								[1, "#000"]
							]
						},
						"borderColor": {
							"linearGradient": {
								"x1": 0,
								"y1": 0,
								"x2": 0,
								"y2": 1
							},
							"stops": [
								[0, "#333"],
								[1, "#BBB"]
							]
						},
						"color": "#cfd",
						"y": 74,
						"borderRadius": 2,
						"borderWidth": 3,
						"padding": 4,
						"formatter": function() {
							return Highcharts.numberFormat(this.y, 1);
						},
						"style": {
							"fontSize": "11px"
						}
					}
				}],
				"subtitle": {
					"text": " April 2013"
				},
				"title": {
					"text": "Sales per Person"
				},
				"tooltip": {
					"enabled": true,
					"formatter": function() {
						return '<div class="tooltip"><span style="font-weight:bold;color:#91ccff">' + this.point.name + ':</span> ' + Highcharts.numberFormat(this.y, 1) + '%</div>'
					},
					"useHTML": true,
					"valueDecimals": 2,
					"followPointer": true
				},
				"yAxis": {
					"labels": {
						"rotation": 0,
						"step": 1,
						"style": {
							"fontFamily": "Tahoma",
							"fontWeight": "bold",
							"fontSize": "12px"
						},
						"distance": -30
					},
					"max": 11,
					"min": 0,
					"minorTickColor": "#666",
					"minorTickInterval": 0.55,
					"minorTickLength": 10,
					"minorTickPosition": "inside",
					"minorTickWidth": 1,
					"plotBands": [{
						"color": "#FF4040",
						"from": 0,
						"to": 4.3989
					}, {
						"color": "#F6EA82",
						"from": 4.4,
						"to": 8.7989
					}, {
						"color": "#88D888",
						"from": 8.8,
						"to": 11
					}],
					"tickColor": "#666",
					"tickInterval": 2.75,
					"tickLength": 10,
					"tickPosition": "inside",
					"tickWidth": 2
				}
			});
		});
	}

	function gf_tree() {
		$('#tree1').treed();
		$('#tree2').treed({
			openedClass: 'glyphicon-folder-open',
			closedClass: 'glyphicon-folder-close'
		});
		$('#tree3').treed({
			openedClass: 'glyphicon-chevron-right',
			closedClass: 'glyphicon-chevron-down'
		});
	}

	function gf_init_plupload() {
		var sArrayFile = Array(),
			sArraySize = Array(),
			oJSONObj = [],
			oLength = 25,
			oAddPath = "uploads";
		var uploader = new plupload.Uploader({
			runtimes: 'html5,flash,silverlight,html4',
			browse_button: 'aUploadImage',
			divUploadContainer: $("#divUploadContainer"),
			url: "<?php print site_url(); ?>c_core_upload/gf_upload/",
			chunk_size: '500kb',
			multiple_queues: true,
			multi_selection: false,
			unique_names: true,
			filters: {
				max_file_size: '50mb',
				mime_types: [{
					title: "Image files",
					extensions: "jpg,gif,png,jpeg"
				}]
			},
			multipart_params: {
				"oAddPath": oAddPath
			},
			flash_swf_url: '<?php print site_url(); ?>plugins/jPLUpload/plupload/js/Moxie.swf',
			silverlight_xap_url: '<?php print site_url(); ?>plugins/jPLUpload/plupload/js/Moxie.xap',
			init: {
				PostInit: function() {},
				FilesAdded: function(up, files) {
					uploader.start();
				},
				UploadProgress: function(up, file) {
					$("#spanProgress").html('<span><b>' + file.percent + "</b>%</span>");
				},
				Error: function(up, err) {
					$("<p>Error: " + err.code + ": " + err.message + "</p>").insertAfter($("#aUploadImage").prev());
				},
				BeforeUpload: function(up, file) {
					$("#aUploadImage").prev().attr("src", "<?php print site_url(); ?>img/loading.gif").css("max-width", "50px");
					$("p").remove();
				},
				UploadComplete: function(uploader, files) {
					var objForm = $("#form_5938b5bb933d2");
					var sSingleFileName = "";
					objForm.append("<input type=\"hidden\" name=\"hidePath\" id=\"hidePath\" value=\"" + $.trim(oAddPath) + "\" />");
					objForm.find("input[id='hideFileName']").remove();
					$.each(oJSONObj, function(i, n) {
						var JSON = $.parseJSON(n.oFile);
						objForm.append("<input type=\"hidden\" name=\"hideFileName[]\" id=\"hideFileName\" value=\"" + $.trim(JSON.fnameoriginal) + "\" />");
						sSingleFileName = $.trim(JSON.fnameoriginal);
					});
					//$("button#button-submit:eq(0)").trigger("click")
					$("#aUploadImage").prev().attr("src", "<?php print site_url(); ?>uploads/uploads/" + sSingleFileName).css("max-width", "200px");
					$("<p>The path this image is: <?php print site_url(); ?>uploads/uploads/" + sSingleFileName + "</p>").insertAfter($("#aUploadImage").prev());
				},
				FileUploaded: function(upldr, file, object) {
					var JSON = $.parseJSON(object.response);
					item = {}
					item["oFile"] = object.response;
					oJSONObj.push(item);
				}
			}
		});
		uploader.init();
	}

	function gf_init_table_group() {
		$.gf_group_table({
			rows: $("#myTable tr:has(td)"),
			startIndex: 0,
			total: 4
		})
		$('#myTable .deleted').remove();
	}
</script>