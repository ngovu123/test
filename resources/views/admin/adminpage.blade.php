@extends('layouts.admincontent')
@section('title')
	Admin page
@stop
@section('content')
	<div class="content contentAdmin">
		<div class="container">
			<div class="row">
				<div class="cntadmin">
					<h3><i class="glyphicon glyphicon-dashboard"></i> Admin Dashboard</h3>					
					<div style="clear:both"></div>
					<div class="adminpage">
						<?php 
						if(!empty($_GET['message'])) {
    						$message = ucfirst($_GET['message']) . ', Tài khoản <span style="color:red;"> <strong> '.Auth::user()->name.'</strong></span> không được thực hiện thao tác này !.';
    						echo "<div class='alert alert-danger'><h3>" . $message . "</h3></div>";
    					} ?>
						<a href="{!!url('/admin/media')!!}" class="col-sm-6 mediadownload">
							<div class="headadmin">
								<i class="glyphicon glyphicon-download-alt" aria-hidden="true"></i><b>Sản phẩm</b>&nbsp;<span>(<?= $media ;?>)</span>
							</div>
							<div class="linkadmin">
								Thêm/Xóa/Sửa các mục tải về&nbsp;&nbsp;<i class="glyphicon glyphicon-play" aria-hidden="true"></i>
							</div>
						</a>
						<a href="{!!url('/admin/media/check')!!}" class="col-sm-6 aboutadmin">
							<div class="headadmin">
								<i class="glyphicon glyphicon-ok-sign" aria-hidden="true"></i><b> Kiểm Duyệt &nbsp;<span >(<?= $media_c ;?>)</span> </b>
							</div>
							<div class="linkadmin">
								 Kiểm duyệt member upload &nbsp;&nbsp;<i class="glyphicon glyphicon-play" aria-hidden="true"></i>
							</div>
						</a>
						<a href="{!!url('/admin/categories')!!}" class="col-sm-4 categoriesadmin">
							<div class="headadmin">
								<i class="glyphicon glyphicon-folder-open" aria-hidden="true"></i><b>Danh mục</b>
							</div>
							<div class="linkadmin">
								Danh mục &nbsp;&nbsp;<i class="glyphicon glyphicon-play" aria-hidden="true"></i>
							</div>
						</a>						
						<a href="{!!url('/admin/members')!!}" class="col-sm-4 aboutadmin">
							<div class="headadmin">
								<i class="glyphicon glyphicon-user" aria-hidden="true"></i><b> Thành viên</b>
							</div>
							<div class="linkadmin">
								Danh sách member &nbsp;&nbsp;<i class="glyphicon glyphicon-play" aria-hidden="true"></i>
							</div>
						</a>				
						
						<a href="{!!url('admin/report')!!}" class="col-sm-4 settingadmin">
							<div class="headadmin">
								<i class="glyphicon glyphicon-flag" aria-hidden="true"></i><b>Report ({!!$r!!})</b>
							</div>
							<div class="linkadmin">
								Báo cáo - Gắn cờ &nbsp;&nbsp;<i class="glyphicon glyphicon-play" aria-hidden="true"></i>
							</div>
						</a>
						<a href="{!!url('admin/msg')!!}" class="col-sm-4 settingadmin" >
							<div class="headadmin">
								<i class="glyphicon glyphicon-comment" aria-hidden="true"></i><b><i> messagers ({!!$m!!})</i></b>
							</div>
							<div class="linkadmin" >
								Tin nhắn&nbsp;&nbsp;<i class="glyphicon glyphicon-play" aria-hidden="true"></i>
							</div>
						</a>
						<a href="{!!url('admin/pay')!!}" class="col-sm-4 settingadmin">
							<div class="headadmin" style="background:  #34495e;">
								<i class="glyphicon glyphicon-retweet" aria-hidden="true"></i><b>Yêu cầu <i> ({!!$pay!!})</i></b>
							</div>
							<div class="linkadmin">
								Yêu cầu thanh toán &nbsp;&nbsp;<i class="glyphicon glyphicon-play" aria-hidden="true"></i>
							</div>
						</a>
						<a href="#{!!url('admin/banner')!!}" class="col-sm-4 settingadmin">
							<div class="headadmin">
								<i class="glyphicon glyphicon-picture" aria-hidden="true"></i><b>Banner trang chủ <i></i></b>
							</div>
							<div class="linkadmin">
								Sửa banner trang chủ &nbsp;&nbsp;<i class="glyphicon glyphicon-play" aria-hidden="true"></i>
							</div>
						</a>
						<a href="{!!url('/admin/about')!!}" class="col-sm-4 settingadmin">
							<div class="headadmin">
								<i class="glyphicon glyphicon-info-sign" aria-hidden="true"></i><b>About</b>
							</div>
							<div class="linkadmin">
								Sửa trang giới thiệu&nbsp;&nbsp;<i class="glyphicon glyphicon-play" aria-hidden="true"></i>
							</div>
						</a>
						<a href="{!!url('/admin/rules')!!}" class="col-sm-4 settingadmin">
							<div class="headadmin">
								<i class="glyphicon glyphicon-info-sign" aria-hidden="true"></i><b>Rules</b>
							</div>
							<div class="linkadmin">
								Điều khoản&nbsp;&nbsp;<i class="glyphicon glyphicon-play" aria-hidden="true"></i>
							</div>
						</a>
						<a href="{!!url('/admin/settings')!!}" class="col-sm-4 settingadmin">
							<div class="headadmin">
								<i class="glyphicon glyphicon-cog" aria-hidden="true"></i><b>Cài đặt trang web</b>
							</div>
							<div class="linkadmin">
								Thay đổi thiết lập trang web&nbsp;&nbsp;<i class="glyphicon glyphicon-play" aria-hidden="true"></i>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop
