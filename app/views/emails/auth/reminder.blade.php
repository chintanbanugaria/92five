<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>{{trans('92five.passwordReset')}}</h2>

		<div>
			{{trans('92five.resetPassword')}}: {{ URL::to('password/reset', array($link)) }}.
		</div>
	</body>
</html>