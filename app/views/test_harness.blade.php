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
                    width:30%;
                }
                
                .clear {
                    clear: both;
                }
                
	</style>
        
        {{ HTML::script("https://code.jquery.com/jquery-2.1.1.min.js") }}
        
        
</head>
<body>
    
    <div id="get_airports" class="call_box">
        <h2>GET /airports</h2>
        {{ Form::open(array('method' => 'get', 'url' => 'airports')) }}
        {{ Form::submit('Call') }}
        {{ Form::close() }}
    </div>
    
    <div id="post_trips" class="call_box">
        <h2>POST /trips</h2>
        {{ Form::open(array('method' => 'post', 'url' => 'trips')) }}
            <h3>Request Body</h3>
            {{ Form::label('name', 'Trip Name') }}
            {{ Form::text('name') }}
            <br />
            {{ Form::submit('Call') }}
        {{ Form::close() }}
    </div>
    
    <div id="get_trips" class="call_box">
        <h2>GET /trips/{trip-id}</h2>
        
        <h3>URL Builder</h3>
        {{ Form::label('get_trips_id', 'Trip ID') }}
        {{ Form::text('get_trips_id') }}
        <br />
        
        {{ Form::open(array('method' => 'get', 'url' => 'trips/{id}')) }}
            {{ Form::submit('Call') }}
        {{ Form::close() }}
    </div>
    
    <div id="put_trips" class="call_box">
        <h2>PUT /trips/{trip-id}</h2>
        
        <h3>URL Builder</h3>
        {{ Form::label('put_trips_id', 'Trip ID') }}
        {{ Form::text('put_trips_id') }}
        <br />
        
        {{ Form::open(array('method' => 'put', 'url' => 'trips/{id}')) }}
            <h3>Request Body</h3>
            {{ Form::label('name', 'Trip Name') }}
            {{ Form::text('name') }}
            <br />
            {{ Form::submit('Call') }}
        {{ Form::close() }}
    </div>
    
    
    <div id="put_flights" class="call_box">
        <h2>PUT /trips/{trip-id}/flights/{src},{trg}</h2>
        
        <h3>URL Builder</h3>
        {{ Form::label('put_flights_id', 'Trip ID') }}
        {{ Form::text('put_flights_id') }}
        <br />
        {{ Form::label('put_flights_src', 'Flight Source (Airport Code)') }}
        {{ Form::text('put_flights_src') }}
        <br />
        {{ Form::label('put_flights_trg', 'Flight Target (Airport Code)') }}
        {{ Form::text('put_flights_trg') }}
        <br />
        
        {{ Form::open(array('method' => 'put', 'url' => 'trips/{id}/flights/{src},{trg}')) }}
            {{ Form::submit('Call') }}
        {{ Form::close() }}
    </div>
    
    
    <div id="rm_flights" class="call_box">
        <h2>DELETE /trips/{trip-id}/flights/{src},{trg}</h2>
        
        <h3>URL Builder</h3>
        {{ Form::label('rm_flights_id', 'Trip ID') }}
        {{ Form::text('rm_flights_id') }}
        <br />
        {{ Form::label('rm_flights_src', 'Flight Source (Airport Code)') }}
        {{ Form::text('rm_flights_src') }}
        <br />
        {{ Form::label('rm_flights_trg', 'Flight Target (Airport Code)') }}
        {{ Form::text('rm_flights_trg') }}
        <br />
        
        {{ Form::open(array('method' => 'delete', 'url' => 'trips/{id}/flights/{src},{trg}')) }}
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
        
        formURL = buildUrl($(this).parent().attr('id'), formURL);
        
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
                var err = eval("(" + jqXHR.responseText + ")");
                var str = JSON.stringify(err, undefined, 2);
                $('#results').html(str);
            }
        });
        e.preventDefault();
    });
    
    function buildUrl(formId, formURL) {
        
        switch(formId) {
            case 'put_trips':
                tripId = $('#'+formId+' #put_trips_id').val();
                formURL = formURL.replace('{id}', tripId);
                break;
            case 'get_trips':
                tripId = $('#'+formId+' #get_trips_id').val();
                formURL = formURL.replace('{id}', tripId);
                break;
            case 'put_flights':
                tripId = $('#'+formId+' #put_flights_id').val();
                flightSrc = $('#'+formId+' #put_flights_src').val();
                flightTrg = $('#'+formId+' #put_flights_trg').val();
                formURL = formURL.replace('{id}', tripId);
                formURL = formURL.replace('{src}', flightSrc);
                formURL = formURL.replace('{trg}', flightTrg);
                break;
            case 'rm_flights':
                tripId = $('#'+formId+' #rm_flights_id').val();
                flightSrc = $('#'+formId+' #rm_flights_src').val();
                flightTrg = $('#'+formId+' #rm_flights_trg').val();
                formURL = formURL.replace('{id}', tripId);
                formURL = formURL.replace('{src}', flightSrc);
                formURL = formURL.replace('{trg}', flightTrg);
                break;
        }
        
        return formURL;
    }
    

</script></body>
</html>
