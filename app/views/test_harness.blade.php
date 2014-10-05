<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Trip Builder Test Harness</title>
	<style>
		@import url(//fonts.googleapis.com/css?family=Lato:700);

		body {
                    font-family:'Lato', sans-serif;
		}
                
                .call_box {
                    border: dashed #555 2px;
                    float: left;
                    padding: 5px;
                    margin: 5px;
                }
                
                .clear {
                    clear: both;
                }
                
                h2 {
                    
                }
                
	</style>
        
        {{ HTML::script("https://code.jquery.com/jquery-2.1.1.min.js") }}
        
        
</head>
<body>
    
    <div class="call_box">
        <h2>GET /airports</h2>
        {{ Form::open(array('method' => 'get', 'url' => 'airports')) }}
        {{ Form::submit('Call') }}
        {{ Form::close() }}
    </div>
    
    <div class="call_box">
        <h2>POST /trips</h2>
        {{ Form::open(array('method' => 'post', 'url' => 'trips')) }}
        {{ Form::label('name', 'Trip Name') }}
        {{ Form::text('name') }}
        <br />
        {{ Form::submit('Call') }}
        {{ Form::close() }}
    </div>
    
    <div class="clear"></div>
    
    <p><strong>HTTP Status: </strong> <span id="status"></span></p>
    
    <pre id="results">
        
    </pre>
    

<script>

    $("form").submit(function(e)
    {
        $('#results').html('Loading...');
        
        var postData = $(this).serializeArray();
        var formURL = $(this).attr("action");
        var type = $(this).attr("method");
        $.ajax(
        {
            url : formURL,
            type: type,
            data : postData,
            success: function(data, textStatus, jqXHR) {
                $('#status').html(jqXHR.status);
                var str = JSON.stringify(data, undefined, 2);
                $('#results').html(str);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#status').html(jqXHR.status);
            }
        });
        e.preventDefault();
    });

</script></body>
</html>
