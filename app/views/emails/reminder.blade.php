<!DOCTYPE html>
<html lang="en-GB">
  <head>
    <meta charset="utf-8">
  </head>
  <body>
    <h2>Your {{ $details->make . ' ' . $details->model }} need servicing</h2>
    <div>
      Hello {{ $details->customer->name }}
      <br />
      This is a courtesy reminder letting you know that the machine stated above is due for its annual health check.<br />
      Please contact us either via return email or telephone to book in your machine.
      
    </div>
	
  </body>
</html>