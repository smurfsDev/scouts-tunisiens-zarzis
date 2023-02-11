<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Demande</title>
	<style>
		html,
		body {
			height: 297mm;
			width: 210mm;
			/* to centre page on screen*/
			margin-left: auto;
			margin-right: auto;
			display: flex;
			justify-content: center;
			align-items: center;
			border: 1px solid black !important;
		}

		* {
			font-family: 'Times New Roman', Times, serif;
		}

		.content {
			position: relative;
			/* height: 90%;
			width: 90%; */
			padding: 10px;
		}

		.logo {
			position: absolute;
			top: 0;
			right: 0;
			display: flex;
			justify-content: center;
			align-items: center;
			flex-direction: column;
			height: auto;
			width: 100px;
		}

		.logo-text {
			font-size: 16px;
			font-weight: bold;
			text-align: center;
			color: #e12228;
		}

		.spacedateto {
			font-size: 22px;
			font-weight: bold;
			display: flex;
			align-items: start;
			flex-direction: column;
			height: auto;
			width: 100%;
			margin-top: 60px;
		}

		.subject {
			display: block;
			text-align: right;
			margin-right: 40px;
			margin-top: 20px;
		}

		.subject-title {
			font-size: 22px;
			font-weight: bold;
			text-align: right;
		}

		.subject-content {
			font-size: 22px;
			font-weight: 500;
			text-align: right;
		}

		.content {
			text-align: right;
		}

		.salute {
			font-size: 22px;
			font-weight: bold;
			text-align: right;
		}

		.content-text {
			font-size: 24px;
			font-weight: 500;
			text-align: right;
			line-height: 2.5;
		}

		.myfooter {
			position: absolute;
			align-self: flex-end;
			width: 210mm;
			display: flex;
			flex-direction: column;
			margin-left: auto;
			margin-right: auto;
			justify-content: flex-start;
			align-items: flex-start;
		}

		.myfooterimg {
			width: 210mm;
		}

		.humansignature {
			position: relative;
			margin-left: 40px;
			display: flex;
			flex-direction: column;
			justify-content: center;
			align-items: center;
			margin-bottom: 50px;
		}
		.humansignature span {
			font-size: 22px;
			font-weight: bold;
			text-align: center;
		}
		.humansignature img {
			position: absolute;
			top: 0;
			left: 60mm;
			width: 150px;
			height: 150px;
		}
	</style>
</head>

<body>
	<div class="content">
		<div class="logo">
			<img src="{{URL::asset('/image/logo.jpg')}}" alt="logo" width="100px" height="100px">
			<span class="logo-text">الكشافة التونسية</span>
			<span class="logo-text">جهة مدنين</span>
			<span class="logo-text">فوج جرجيس</span>
			<span class="logo-text">{{$troupe_name}}</span>
		</div>

		<div class="title">
			<h1 style="text-align: center;">{{ $requestDocument->title }}</h1>
		</div>

		<div class="spacedateto">
			<div class="spacedate">
				<span>{{ $requestDocument->location }}</span>
				<span>في</span>
				<span>{{ $requestDocument->date }}</span>
			</div>
			<div class="to">
				<span>الى</span>
				<span>{{ $requestDocument->to }}</span>
			</div>
		</div>

		<div class="subject">
			<span class="subject-title">الموضوع:</span>
			<span class="subject-content">{{ $requestDocument->subject }}</span>
		</div>

		<div class="content">
			<p class="salute" style="font-weight: bold;">تحية كشفية و بعد</p>
			<p class="content-text">
				{{ $requestDocument->body }}}
			</p>
		</div>




	</div>

	<footer class="myfooter">
		<div class="humansignature">
			<div class="signature">
				<img src="{{URL::asset('/image/sig.jpg')}}" alt="signature" width="200px" height="200px">
			</div>
			<span>
				قائد الفرقة
			</span>
			<span>
				{{ $user->first_name }} {{ $user->last_name }}
			</span>
		</div>
		<img class="myfooterimg" src="{{URL::asset('/image/footer.jpg')}}" alt="footer">
	</footer>
</body>

</html>